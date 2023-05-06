<?php
	declare(strict_types=1);

	use Controller\IndexController;

	require_once($_SERVER['DOCUMENT_ROOT'] . "/../model/aplication_fns.php");

	model\classes\Loader::init($_SERVER['DOCUMENT_ROOT'] . "/..");	

	$action = strtolower($_POST['action'] ?? $_GET['action'] ?? "");
	$phrase = strtolower($_POST['phrase'] ?? $_GET['phrase'] ?? "");
	$captcha = strtolower($_POST['captcha'] ?? $_GET['captcha'] ?? "");
	
	$indexController = new IndexController($dbcon);	

	match($action) {
		default			=>	$indexController->showCaptcha(),
		'test_captcha'	=>	$indexController->testCaptcha($phrase, $captcha),
	};
?>
