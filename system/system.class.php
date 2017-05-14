<?php

Class System
{
    protected static $user;

    public function __get($field)
    {
        if ($field === 'user')
        {
            if (self::$user === NULL)
            {
                self::$user = new User();
                self::$user->auth_flow();
            }
            return self::$user;
        }
    }

    public static function get_dir_content($dir)
    {
        if (!$dir)
            return NULL;

        $arr_dir_content = @scandir($dir);
        if (!$arr_dir_content)
            return NULL;

        $arr_dir_content = array_diff($arr_dir_content, ['.','..']);

        if(PHP_OS === WINDOWS_SERVER)
        {
            array_walk($arr_dir_content, 'convert_win2utf8');
        }

        if(empty($arr_dir_content))
        {
            return NULL;
        }
        return $arr_dir_content;
    }

    public static function convert_win2utf8(&$item, $key)
    {
        $item = iconv("windows-1251", "utf-8", $item);
    }
}