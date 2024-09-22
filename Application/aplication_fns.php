<?php	
	require_once($_SERVER['DOCUMENT_ROOT'] . "/../Application/my_functions.php");
	require_once($_SERVER['DOCUMENT_ROOT'] . "/../Application/model/classes/Loader.php");
	require_once($_SERVER['DOCUMENT_ROOT'] . "/../Application/app_config.php");
	require_once($_SERVER['DOCUMENT_ROOT'] . "/../Application/connect.php"); 

	### API KEYS
	require_once($_SERVER['DOCUMENT_ROOT'] . "/../Application/api_keys.php");
	
	### Crons
	require_once($_SERVER['DOCUMENT_ROOT'] . "/../Application/Cron_jobs/clean_access_log.php");
	require_once($_SERVER['DOCUMENT_ROOT'] . "/../Application/Cron_jobs/clean_error_log.php");
	require_once($_SERVER['DOCUMENT_ROOT'] . "/../Application/Cron_jobs/clean_xdebug_log.php");
?>
