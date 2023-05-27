<?php
	declare(strict_types=1);

	use Controller\LoginController;	

	require_once($_SERVER['DOCUMENT_ROOT'] . "/../model/aplication_fns.php");

	model\classes\Loader::init($_SERVER['DOCUMENT_ROOT'] . "/..");		

	$action = strtolower($_POST['action'] ?? $_GET['action'] ?? $action = "");
	$loginController = new LoginController($dbcon);	

	match($action) {
		default  => $loginController->login(),
		'logout' => $loginController->logout(),
	};
?>