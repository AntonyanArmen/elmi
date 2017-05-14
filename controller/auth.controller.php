<?php

include_once 'system/BaseController.php';

class AuthController extends BaseController
{
    public  function __construct()
    {
            $this->layout = "login.php";
    }

    function login()
    {
        global  $system;
        if ($system->user->id !== NULL)
        {
            // already logged
            header("Location: index.php");
            exit();
        }

        if (count($_POST)) 
        {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $user = new User();

            if ($user->auth($username,$password)) 
            {
                redirect_after_auth();
            }
            else
            {
                header("Location: index.php?cat=auth&operation=login");
            }
            exit(); 
        }
        return $this->render('auth/login', []);	
    }
}