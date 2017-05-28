<?php
Class SanitizeHelper
{
	public static function clean($value, $db_type = 'varchar')
	{
		if($value === NULL)
			return NULL;
		
		$value = mysqli_real_escape_string(Model::get_db(), $value);
		
		if ($db_type === 'int')
		{
			$value = (int) $value;
		}
		 
		return $value;
	}

    public static function sanitize($string)
    {
        return htmlentities(mysql_fix_string($string));
    }

    public static function mysql_fix_string($string)
    {
        if (get_magic_quotes_gpc())
            $string = stripslashes($string);
        return mysqli_real_escape_string($string);
    }

    public static function html_fix_string($string) {
        if (get_magic_quotes_gpc())
            $string = stripslashes($string);
        return htmlentities($string);
    }

    public static function  POST_value($param)
    {
        $result = 'NULL';

        if (!empty($param) && isset($_POST[$param]))
            $result = self::html_fix_string($_POST[$param]);

        if (strlen($result) === 0)
            $result = 'NULL';

        return $result;
    }

    public static function  GET_value($param)
    {
        $result = 'NULL';

        if (!empty($param) && isset($_GET[$param]))
            $result = self::html_fix_string($_GET[$param]);
             //$result = ($_GET[$param]);

        if (strlen($result) === 0)
            $result = 'NULL';

        return $result;
    }
}