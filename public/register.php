<?php
	declare(strict_types=1);

    use Controller\RegisterController;
	use model\classes\Language;

	require_once($_SERVER['DOCUMENT_ROOT'] . "/../Application/aplication_fns.php");

	model\classes\Loader::init($_SERVER['DOCUMENT_ROOT'] . "/..");		
	
	$registerController = new RegisterController($dbcon);

	if(isset($_SESSION['action'])) unset($_SESSION['action']);

	/** Check for user`s sessions */
	!isset($_SESSION['role']) ? header("Location: /") : null;

	/** Test page language */
	$_SESSION['language'] = isset($_POST['language']) ? $_POST['language'] : $_SESSION['language'];
	$languageObject = new Language();
	$language = $_SESSION['language'] == "spanish" ? $languageObject->spanish() : $languageObject->english();

	if($_SESSION['role'] === "ROLE_WAITER") {		
		$error_msg = "<p class='alert alert-danger text-center'>{$language['alert_access']}</p>";
		include(SITE_ROOT . "/../view/database_error.php");
		return;	
	}

    $registerController->register();
?>