<?php
require_once 'constants.php';
require_once 'functions.php';
require_once "system/model.class.php";
require_once "system/system.class.php";
error_reporting(E_ALL);
session_start();
spl_autoload_register('class_autoloader');
