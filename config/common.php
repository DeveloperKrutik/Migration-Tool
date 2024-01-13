<?php

date_default_timezone_set("Asia/Calcutta");

@session_start();

@ob_start();

include_once("class.MySQLCN.php");

$obj = new MySQLCN();

$appname = "Migration";

$title = $appname;

$tdate = date("Y-m-d");

$tdatetime = date("Y-m-d H:i:s");

$infoEmailId = "info@project.com"; 

$_DEBUG = 0;

if($_DEBUG == 1){

	error_reporting( E_ALL );

	ini_set('display_errors', 1);

	ini_set('display_startup_errors', 1);

	error_reporting(-1);

}
?>