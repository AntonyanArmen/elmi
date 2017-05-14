<?php
include_once 'system/BaseController.php';

class UserController extends BaseController
{
    public function add()
    {
        $message = '';

        if(count($_POST) > 0)
        {
            $values = $_POST;
            
            $user = new User();
            $user->load($values);
            $user->create_password();
            //var_dump($user);
                        
            if($user->add() === Model::CREATE_FAILED)
            {
                $_SESSION['error'] =  MSG_INSERT_FAIL . get_last_db_error();
            }
            header("location: index.php?cat=user&operation=all");
            exit();
        }

        if(isset($_SESSION['error']))
        {
            $message .= $_SESSION['error'];
            unset($_SESSION['error']);
        }

        return $this->render("user/user_add",[
                        "message" => $message
        ]
                        );
    }

    public function detail() 
    {
        $message = '';

        if(isset($_POST['id']))
        {
            $id = $_POST['id'];
            $values = $_POST;
            
            $user = new User($id);
            $user->load($values);
            
            if($user->update() === Model::UPDATE_FAILED)
            {
                $_SESSION['error'] =  MSG_UPDATE_FAIL . get_last_db_error();
            }
            header("location: index.php?cat=user&operation=detail&id={$user->id}");
            exit();
        }

        if(isset($_GET['id']))
        {
            $id = (int) $_GET['id'];

            if(is_numeric($id) && $id > 0)
            {
                $user = new User($id);              
                if(!$user->is_loaded)
                {
                    $message = MSG_ID_NOT_FOUND . get_last_db_error();
                }
            }
            else
            {
                $message = MSG_BAD_ID;
            }

            if(isset($_SESSION['error']))
            {
                $message .= $_SESSION['error'];
                unset($_SESSION['error']);
            }
        }
        else
        {
            $message = MSG_EMPTY_ID;
        }

        return $this->render("user/user_detail",[
                        "message" => $message,
                        "user" => $user
        ]
                        );
    }
    
    /*
     * change password
     */
    public function password()
    {
        $message = '';
        
        if(isset($_POST['id']))
        {
            $id = $_POST['id'];
            $current_password = $_POST['current_password'];
            $new_password = $_POST['new_password'];
            $confirm_new_password = $_POST['confirm_new_password'];
            
            $user = new User($id);
            
            if(!$user->check_password($current_password))
            {
                $message = User::INCORRECT_PASSWORD;
            }
            
            if($new_password !== $confirm_new_password)
            {
                $message .= User::NEW_PASSWORD_CONFIRM_FAILED;
            }
            var_dump($user);
            
            
            if($message)
            {
                $_SESSION['error'] = $message;
                header("location: index.php?cat=user&operation=password&id={$user->id}");
                exit();
            }
            
            $result = $user->change_password($current_password, $new_password);
            if($result === TRUE)
            {
                $_SESSION['error'] = User::PASSWORD_CHANGE_SUCCESS;
                header("location: index.php?cat=user&operation=detail&id={$user->id}");
                exit();
            }
            
            $_SESSION['error'] =  MSG_UPDATE_FAIL . $result. get_last_db_error();
            header("location: index.php?cat=user&operation=password&id={$user->id}");
            exit();
        }       
        
        if(isset($_GET['id']))
        {
            $id = (int) $_GET['id'];

            if(is_numeric($id) && $id > 0)
            {
                $user = new User($id);              
                if(!$user->is_loaded)
                {
                    $message = MSG_ID_NOT_FOUND . get_last_db_error();
                }
            }
            else
            {
                $message = MSG_BAD_ID;
            }

            if(isset($_SESSION['error']))
            {
                $message .= $_SESSION['error'];
                unset($_SESSION['error']);
            }
        }
        else
        {
            $message = MSG_EMPTY_ID;
        }
        
        return $this->render("user/user_password",[
                        "message" => $message,
                        "user" => $user
        ]
                        );
        
    }

    public function delete() 
    {
        $message = '';

        if(isset($_POST['id']))
        {
            $id = (int) $_POST['id'];

            if(is_numeric($id) && $id > 0)
            {
                $user = new User($id);
                
                if($user->is_loaded)
                {
                    if($user->delete())
                    {
                        header("location: index.php?cat=user&operation=all");
                        exit();
                    }
                    else
                    {
                        $message = MSG_DELETE_FAIL . get_last_db_error();
                    }
                }
                else
                {
                    $message = MSG_ID_NOT_FOUND . get_last_db_error();
                }
            }
            else
            {
                $message = MSG_BAD_ID;
            }

            if($message)
            {
                $_SESSION['error'] = $message;
            }
        }

        if(isset($_GET['id']))
        {
            $id = (int) $_GET['id'];

            if(is_numeric($id) && $id > 0)
            {
                $user = new User($id);
                if(!$user->is_loaded)
                {
                    $message = MSG_ID_NOT_FOUND . get_last_db_error();
                }
            }
            else
            {
                $message = MSG_BAD_ID;
            }

            if(isset($_SESSION['error']))
            {
                $message .= $_SESSION['error'];
                unset($_SESSION['error']);
            }
        }
        else
        {
            $message = MSG_EMPTY_ID;
        }

        return $this->render("user/user_delete",[
                        "message" => $message,
                        "user" => $user
        ]
                        );
    }    

    public function all() 
    {
        $message = '';
        if(isset($_SESSION['error']))
        {
            $message .= $_SESSION['error'];
            unset($_SESSION['error']);
        }

        $users = User::all();

        return $this->render("user/user_list",[
                        "users" => $users,
                        "message" => $message

        ]
                        );	
    }    
}
