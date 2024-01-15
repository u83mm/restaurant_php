<?php	
	require_once($_SERVER['DOCUMENT_ROOT'] . "/../Application/my_functions.php");
	require_once($_SERVER['DOCUMENT_ROOT'] . "/../model/classes/Loader.php");
	require_once($_SERVER['DOCUMENT_ROOT'] . "/../app_config.php");
	require_once($_SERVER['DOCUMENT_ROOT'] . "/../Application/connect.php"); //Descomentar si vamos a usar consultas a DB.	
	require_once($_SERVER['DOCUMENT_ROOT'] . "/../Application/Cron_jobs/clean_access_log.php");
	require_once($_SERVER['DOCUMENT_ROOT'] . "/../Application/Cron_jobs/clean_error_log.php");	
?>
