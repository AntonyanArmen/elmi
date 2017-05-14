<?php

class User extends Model
{
    const INCORRECT_PASSWORD = "Текущий пароль не верен.";    
    const PASSWORD_CHANGE_FAILED = "{PASSWORD_CHANGE_FAILED}";    
    const PASSWORD_CHANGE_SUCCESS = "Пароль успешно изменен.";    
    const NEW_PASSWORD_CONFIRM_FAILED = "Новый пароль и его подтверждение не совпадают.";
    const FATAL_ERROR_DUE_PASSWORD_OPERATIONS = "{FATAL_ERROR_DUE_PASSWORD_OPERATIONS}";
    
    const COOKIE_TIME = 60*60*24;

    private static $class_errors = [
        self::INCORRECT_PASSWORD,
        self::PASSWORD_CHANGE_FAILED,
        self::PASSWORD_CHANGE_SUCCESS,
        self::NEW_PASSWORD_CONFIRM_FAILED,
        self::FATAL_ERROR_DUE_PASSWORD_OPERATIONS
    ];
    private static $class_errors_added = FALSE;


    const ROLE_USER = 1;
    const ROLE_ADMIN = 2;
        
    public static $roles = [
        self::ROLE_USER => "Пользователь",
        self::ROLE_ADMIN => "Администратор"
    ];

    protected static $behaviours = [];
    protected static $fields = [];
    protected static $field_types = [];
    
    public function __construct($id = NULL) 
    {
        parent::__construct($id);
        
        if(!self::$class_errors_added)
        {
            static::$errors = Model::$errors;
            foreach (self::$class_errors as $new_error)
            {
                static::$errors[] = $new_error; 
            }
            self::$class_errors_added = TRUE;
        }
    }

    public function create_password()
    {
        $this->salt = static::generate_salt();
        $this->password = static::generate_password($this->password,$this->salt);
    }
    
    protected static function generate_salt()
    {
        $length = 32;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) 
        {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;        
    }

    protected static function generate_password($password,$salt)
    {
        return md5(md5($password).$salt);
    }
    
    public function check_password($password)
    {
        if ($this->salt === NULL) return false;
        $check_string = static::generate_password($password,$this->salt);

        return ($check_string === $this->password);
    }
    
    public function change_password($current, $new)
    {
        if(!$this->check_password($current))
        {
            return self::INCORRECT_PASSWORD;
        }
        
        $this->password = $new;
        $this->create_password();
        
        if($this->update())
        {
            return TRUE;
        }
        else
        {
            if($this->one($this->id))  // не удалось сохранить, загружаем заново данные из БД
            {
                return self::PASSWORD_CHANGE_FAILED;
            }
            else // что лучше делать в этом случае? аварийно завершать работу всего приложения?
            {
                throw new Exception(self::FATAL_ERROR_DUE_PASSWORD_OPERATIONS);
            }
        }          
    }

    public function auth_flow()
    {
        if ((isset($_SESSION['username']))&&(isset($_SESSION['password'])))
        {
            $username = $_SESSION['username'];
            $password = $_SESSION['password'];

            $this->get_username($username);

            if ($this->password === $password)
            {
                return true;
            }
            else
            {
                $this->id = NULL;
                $this->name = NULL;
                $this->password = NULL;
                $this->salt = NULL;
                return false;
            }

        }
        else
        {
            if ((isset($_COOKIE['username']))&&(isset($_COOKIE['password'])))
            {
                $username = $_COOKIE['username'];
                $password = $_COOKIE['password'];
                $this->get_username($username);

                if ($this->password === $password)
                {
                    $_SESSION['username'] = $_COOKIE['username'];
                    $_SESSION['password'] = $_COOKIE['password'];
                    return true;
                }
                else
                {
                	$this->id = NULL;
                	$this->name = NULL;
                	$this->password = NULL;
                	$this->salt = NULL;
                    return false;
                }
            }
            else
            {
                return false;
            }
        }
    }

    public function auth($username,$password,$remember = false)
    {
    	$username = SanitizeHelper::clean($username);
    	$password = SanitizeHelper::clean($password);
    	
    	$this->get_username($username);
        
        if ($this->check_password($password))
        {
            $_SESSION['username'] = $this->name;
            $_SESSION['password'] = $this->password;
            if ($remember)
            {
                setcookie("username",$this->name, self::COOKIE_TIME);
                setcookie("password",$this->password, self::COOKIE_TIME);
            }
            return true;
        }
        else
        {
            return false;
        }
    }

    public function get_username($username)
    {
    	$username = SanitizeHelper::clean($username);
    	
    	$query = "SELECT * FROM `".static::tableName()."` WHERE `name` = '{$username}' LIMIT 1";
        $result = mysqli_query(self::get_db(),$query);

        if ($row = mysqli_fetch_assoc($result))
        {
            $this->load($row);
        }
    }
    
    public static function className()
    {
        return 'User';
    }

    public static function tableName()
    {
        return 'lst_user';
    }
    
    public static function field_labels()
    {
        return [
                    'id' => 'Идентификатор',
                    'name' => 'Имя',
            ];	    
    }
}
