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
}