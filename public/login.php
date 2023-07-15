<?php
	declare(strict_types=1);

	use Controller\LoginController;
	use model\classes\Language;

	require_once($_SERVER['DOCUMENT_ROOT'] . "/../Application/aplication_fns.php");

	model\classes\Loader::init($_SERVER['DOCUMENT_ROOT'] . "/..");		

	$action = strtolower($_POST['action'] ?? $_GET['action'] ?? $action = "");
	$loginController = new LoginController($dbcon);	

	/** Test page language */
	$_SESSION['language'] = isset($_POST['language']) ? $_POST['language'] : $_SESSION['language'];
	$languageObject = new Language();
	$language = $_SESSION['language'] == "spanish" ? $languageObject->spanish() : $languageObject->english();

	match($action) {
		default  => $loginController->login($language),
		'logout' => $loginController->logout(),
	};
?>