<?php
	declare(strict_types=1);

	use Controller\IndexController;

	require_once($_SERVER['DOCUMENT_ROOT'] . "/../model/aplication_fns.php");

	model\classes\Loader::init($_SERVER['DOCUMENT_ROOT'] . "/..");	

	$action = strtolower($_POST['action'] ?? $_GET['action'] ?? "");		
	$indexController = new IndexController($dbcon);		

	/** Test page language */
	$_SESSION['language'] = $_POST['language'] ?? $_SESSION['language'] ?? "spanish";

	match($action) {
		default			=>	$indexController->showCaptcha(),
		'test_captcha'	=>	$indexController->testCaptcha(),
	};
?>
