<?php
	declare(strict_types=1);

    use Controller\RegisterController;
	use model\classes\Language;

	require_once($_SERVER['DOCUMENT_ROOT'] . "/../model/aplication_fns.php");

	model\classes\Loader::init($_SERVER['DOCUMENT_ROOT'] . "/..");		
	
	$registerController = new RegisterController($dbcon);

	/** Test page language */
	$_SESSION['language'] = isset($_POST['language']) ? $_POST['language'] : $_SESSION['language'];
	$languageObject = new Language();
	$language = $_SESSION['language'] == "spanish" ? $languageObject->spanish() : $languageObject->english();

	if($_SESSION['role'] === "ROLE_WAITER") {		
		$error_msg = $language['alert_access'];
		include(SITE_ROOT . "/../view/database_error.php");
		return;	
	}

    $registerController->register();
?>