<?php

class Model 
{
    const FIELD_NOT_EXIST = "{FIELD_NOT_EXIST}";
    const ID_ACCESS_DENIED = "{ID_ACCESS_DENIED}";
    const ID_INCORRECT = "{ID_INCORRECT}";
    const OBJECT_NOT_EXIST = "{OBJECT_NOT_EXIST}";
    const UPDATE_FAILED = "{UPDATE_FAILED}";
    const OBJECT_ALREADY_EXIST = "{OBJECT_ALREADY_EXIST}";
    const CREATE_FAILED = "{CREATE_FAILED}";
    const DELETE_FAILED = "{DELETE_FAILED}";
    const CONSTRAINTS_UPDATE_FAIL = "{CONSTRAINTS_UPDATE_FAIL}";
    const INIT_FROM_DB_FAIL = "{INIT_FROM_DB_FAIL}";

    const PRIMARY_KEY_FIELD = "id";
    const NAME_KEY_FIELD    = "name";
    
    protected static $errors = array(
        self::FIELD_NOT_EXIST,
        self::ID_ACCESS_DENIED,        
    	self::ID_INCORRECT,
        self::OBJECT_NOT_EXIST,
        self::OBJECT_ALREADY_EXIST,
        self::UPDATE_FAILED,
        self::DELETE_FAILED,
        self::CREATE_FAILED,
        self::CONSTRAINTS_UPDATE_FAIL,
    	self::INIT_FROM_DB_FAIL
    );

    protected static $behaviours = [];
    protected static $fields = [];
    protected static $field_types = [];
    protected static $related_links = [];
    protected static $db = NULL;

    protected $is_loaded_from_db;
    protected $is_changed;

    protected $data = array();
    protected $relations = array();

    public function __construct($id = NULL)
    {
        if (static::$fields === [])
        {
            static::init_fields();
        }

        if ($id !== NULL)
        {
            $id = (int) $id;
            if ($this->one($id))
            {
                $this->is_loaded_from_db = true;
            }
            else
            {
                // сообщить об ошибке
                throw new Exception(self::INIT_FROM_DB_FAIL . " id = {$id}");
            }
        }
        else
        {
            $this->is_loaded_from_db = false;
        }

        $this->is_changed = false;
    }

    public function __get($field)
    {
        if (isset($this->data[$field]))
        {
            return $this->data[$field];
        }
        else
        {
            
            if (isset($this->relations[$field]))
            {
                $related_field = $this->relations[$field];
                
                // для массивов с рилейшенами получаем список
                if (is_array($related_field)) 
                {
                    $result = '';
                    foreach ($related_field as $value) {
                        $result .= (string) $value;
                    }
                    return $result;
                }
                
                return $related_field;
            }
            else
            {
                if (in_array($field,array_keys(static::$behaviours)))
                {
                    $key = static::$behaviours[$field]['key'];
                    if (static::$behaviours[$field]['type'] === 'one')
                    {
                        $class_name = static::$behaviours[$field]['class'];
                        $value = new $class_name($this->$key);
                    }
                    else // ['type'] === 'relation'
                    {
                        $relation_key = static::$behaviours[$field]['relation_key'];
                        $class_name   = static::$behaviours[$field]['class'];
                        $value = $class_name::get_related_fields($relation_key,  $this->$key);
                    }
                    $this->relations[$field] = $value;

                    // для массивов с рилейшенами получаем список
                    if (is_array($value)) 
                    {
                        $display_val = '';
                        foreach ($value as $v) {
                            $display_val .= "$v , ";
                        }
                        return mb_substr($display_val, 0, mb_strlen($display_val) - 3) ;
                    }

                    return $value;
                }
            }
        }
        if (in_array($field,static::get_fields()))
        {
            return NULL;
        }
        else
        {
            return self::FIELD_NOT_EXIST;
        }
    }
    
    protected static function get_related_fields($field, $value)
    {        
        if ( !in_array($field, array_keys(static::$related_links)))
            return NULL;
        
        $relatedIDs = self::all([[$field => $value]], static::$related_links[$field]['relation']);
        //var_dump($relatedIDs); echo "<br/>";

        $result = [];
                
        $class_name = static::$related_links[$field]['class'];
        $result = $class_name::all([[Model::PRIMARY_KEY_FIELD => $relatedIDs]]);
        return $result;
    }

    public function __set($field, $value)
    {
        if ((!in_array($field,static::get_fields())) && (!in_array($field,$this->get_relation_fields())) && (!in_array($field,static::$behaviours)))
        {
            return self::FIELD_NOT_EXIST;
        }
        else
        {
            if ($field === 'id')
            {
                return self::ID_ACCESS_DENIED;
            }
            else
            {
                if (in_array($field,static::get_fields()))
                {
                    
                    $this->data[$field] = SanitizeHelper::clean($value, static::$field_types[$field]);

                    if ($this->is_loaded_from_db)
                    {
                        $this->is_changed = true;
                    }

                    return $this->data[$field];
                }
                else
                {
                    if (in_array($field,array_keys(static::$behaviours)))
                    {
                        $this->relations[$field] = $value;
                    }
                    else
                    {
                        return self::FIELD_NOT_EXIST;
                    }
                }
            }
        }
    }

    public static function get_db()
    {
        if (self::$db === NULL)
        {
            include("db.php");
            self::$db = $link;
        }
        return self::$db;
    }

    protected static function get_fields()
    {
        if (static::$fields === [])
        {
            static::init_fields();
        }
        return static::$fields;
    }

    protected function get_relation_fields()
    {
        return array_keys($this->relations);
    }

    protected static function init_fields()
    {
        $query = "DESCRIBE `" . static::tableName() . "`;";
        
        $result = mysqli_query(self::get_db(), $query);
        if(!$result)
        {
            die($query);
        }
        while($row = mysqli_fetch_assoc($result))
        {
            static::$fields[] = $row['Field'];

            if (strpos($row['Type'],'('))
            {
                $pie = explode('(',$row['Type'],2);
                $row['Type'] = $pie[0];
            }

            static::$field_types[$row['Field']] = $row['Type'];
        }
    }

    protected static function fields_query()
    {
        $fields = static::get_fields();

        $result = '';
        foreach($fields as $f)
        {
            if ($result !== '') $result .= ', ';

            $result .= "`{$f}`";
        }

        return $result;
    }

    protected function values_query()
    {
        $fields = static::get_fields();

        $result = '';
        foreach($fields as $f)
        {
            if ($result !== '') $result .= ', ';

            if ((isset($this->data[$f]))&&($this->data[$f]!==NULL))
            {
                $result .= "'{$this->data[$f]}'";
            }
            else
            {
                $result .= "NULL";
            }
        }

        return $result;
    }

    protected function update_query($updated_fields = array())
    {
        $fields = array();

        if ($updated_fields === array())
        {
            $fields = static::get_fields();
        }
        else
        {
            foreach($updated_fields as $uf)
            {
                if (in_array($uf,static::get_fields()))
                {
                    $fields[] = $uf;
                }
            }
        }

        $result = '';
        foreach($fields as $f)
        {
            if ($result !== '') $result .= ', ';

            if ((isset($this->data[$f]))&&($this->data[$f]!==NULL))
            {
                $result .= "`{$f}` = '{$this->data[$f]}'";
            }
            else
            {
                $result .= "`{$f}` = NULL";
            }

        }
        return $result;
    }

    public static function tableName()
    {
        return NULL;
    }

    public static function className()
    {
        return 'Model';
    }

    public function is_changed()
    {
        return $this->is_changed;
    }

    public function is_loaded_from_db()
    {
        return $this->is_loaded_from_db;
    }

    public function load($data = [])
    {
        foreach($data as $k => $v)
        {
            if (!in_array($k,static::get_fields()))
            {
                return self::FIELD_NOT_EXIST;
            }
            else
            {          	
                $this->data[$k] = SanitizeHelper::clean($v, static::$field_types[$k]);
            }
        }
        return true;
    }

    public function one($id)
    {
        $query = "SELECT * FROM `".static::tableName()."` WHERE `id` = '{$id}'";
        $result = mysqli_query(self::get_db(),$query);

        if ($row = mysqli_fetch_assoc($result))
        {
            return $this->load($row);
        }
        else
        {
            return false;
        }
    }

    public function update()
    {
        if ($this->id === NULL) return self::OBJECT_NOT_EXIST;
              
        $query = "UPDATE `".static::tableName()."` SET ".$this->update_query()." WHERE `id` = '$this->id'";
        $result = mysqli_query(self::get_db(),$query);

        if ($result)
        {
            $this->is_changed = false;
            return true;
        }
        else
        {
            return self::UPDATE_FAILED;
        }
    }

    public function add()
    {
        if ($this->id !== NULL) return self::OBJECT_ALREADY_EXIST;

        $query = "INSERT INTO `".static::tableName()."` (".static::fields_query().") VALUES (".$this->values_query().")";        
        var_dump($query );
        $result = mysqli_query(self::get_db(),$query);

        if ($result)
        {
            $this->data['id'] = mysqli_insert_id(self::get_db());
            $this->is_changed = false;
            return true;
        }
        else
        {
            return self::CREATE_FAILED;
        }
    }

    public function delete()
    {
        if ($this->id === NULL) return self::OBJECT_NOT_EXIST;

        $query = "DELETE FROM `".static::tableName()."` WHERE `id` = '{$this->id}' LIMIT 1";
        $result = mysqli_query(self::get_db(),$query);

        if ($result)
        {
            $this->data['id'] = NULL;
            $this->is_changed = false;
            $this->is_loaded_from_db = false;
            return true;
        }
        else
        {
            return self::DELETE_FAILED;
        }
    }

    /**
     * Функция обрабатывает массив из строк-условий, в котором ключ будет полем таблицы, а значение - соответствующим значением.
     * Также для большого количества строк можно (и нужно) передавать 'AND' или 'OR' для связки.
     * Пример: [['id' => 5], ['OR', 'title' = 'Готово']]
     *
     * TODO можно сделать возможность передавать еще знаки > <
     *
     * @param $array
     */
    protected static function where_condition($array)
    {
        $result = '';
        
        foreach ($array as $row)
        {
            foreach($row as $k => $v)
            {
                //echo "key = $k, val = $v <br/>";
                if ($result !== '') $result .= ' ';
                if ((in_array(@mb_strtoupper($v),["AND","OR"]))&&(is_numeric($k))) // неассоциативный ключ и ключевое слово sql - признак связки
                {
                    $result .= "{$v}";
                }
                else
                {
                    if (is_array($v)) // просто значение
                    {
                        $in = '';
                        foreach ($v as $item) // формируем запись ('1','2','4')
                        {
                            if ($in !== '') $in .= ', ';
                            $in .= "'{$item}'";
                        }
                        $in = "({$in})";

                        $result .= "(`{$k}` IN {$in})";
                    }
                    else
                    {
                        $result .= "(`{$k}` = '{$v}')";
                    }
                }
            }
        }
        return $result;
    }
    
    public static function all($condition = '1', $field = null)
    {
        if (is_array($condition))
        {
            $condition = self::where_condition($condition); // self потому
        }
        
        $query = "SELECT * FROM `" . static::tableName() . "` WHERE {$condition}";
        $result = mysqli_query(static::get_db(), $query);
                
        if (!$result) {
            return NULL;
        }

        $all = [];
        while ($row = mysqli_fetch_assoc($result))
        {
            if ($field) 
            {
                $all[] = $row[$field];
            }
            else
            {
                $class_name = static::className();
                $one = new $class_name();
                /* @var $one Model */
                if ($one->load($row))
                {
                    $all[] = $one;
                }
            }
        }
        return $all;
    }

    public static function all_list($condition = '1')
    {
        $result = NULL;
        foreach (static::all($condition) as $row) {
            $result[$row->id] = $row->name;
        }
        
        return $result;
    }
    
    public static function field_labels()
    {
    	return [
            static::PRIMARY_KEY_FIELD => 'Идентификатор'
    	];
    }
    
    public function __destruct()
    {
        /*
    	if (self::$db !== NULL)
    	{
            @mysqli_close(self::get_db());
    	}
         * */        
    }
    
    public function __toString() {
        return (string)$this->name;
    }    
}