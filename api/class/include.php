<?php


session_start();
date_default_timezone_set('Europe/Paris');
include "vendor/autoload.php";
include 'Config.php';
if($GLOBALS['devmode']){
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}
include 'Database.php';
include 'Logs.php';
include 'Account.php';
include 'Servers.php';
include 'Scripts.php';
include 'Payments.php';
include 'Announces.php';
include 'SoundsHost.php';


$GLOBALS['DB'] = new Database($GLOBALS['mysql_host'], $GLOBALS['mysql_database'], $GLOBALS['mysql_username'], $GLOBALS['mysql_password'], $GLOBALS['mysql_port']);
