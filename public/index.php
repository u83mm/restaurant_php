<?php
	declare(strict_types=1);
	
	use Controller\IndexController;

	require_once($_SERVER['DOCUMENT_ROOT'] . "/../Application/aplication_fns.php");	

	model\classes\Loader::init(SITE_ROOT . "/..");
	
	$uri = parse_url($_SERVER["REQUEST_URI"]);

	$action = strtolower($_POST['action'] ?? $_GET['action'] ?? $uri['path']);		
	$indexController = new IndexController();		

	/** Test page language */
	$_SESSION['language'] = $_POST['language'] ?? $_SESSION['language'] ?? "spanish";

	if(isset($_SESSION['action'])) unset($_SESSION['action']);

	//dd($_SERVER["REQUEST_METHOD"]);

	match($action) {
		default			=>	$indexController->showCaptcha(),
		'test_captcha'	=>	$indexController->testCaptcha(),
	};
?>
