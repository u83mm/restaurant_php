<?php
	declare(strict_types=1);

    use Controller\orders\OrderController;
	use model\classes\Language;

	require_once($_SERVER['DOCUMENT_ROOT'] . "/../Application/aplication_fns.php");

	model\classes\Loader::init($_SERVER['DOCUMENT_ROOT'] . "/..");

	$action = strtolower($_POST['action'] ?? $_GET['action'] ?? $action = "new");
    $orderController = new OrderController();

	/** Test page language */
	$_SESSION['language'] = isset($_POST['language']) ? $_POST['language'] : $_SESSION['language'];
	$languageObject = new Language();
	$language = $_SESSION['language'] == "spanish" ? $languageObject->spanish() : $languageObject->english();

	if(!isset($_SESSION['role'])) {
		$error_msg = "<p class='alert alert-danger text-center'>{$language['alert_access']}</p>";
		include(SITE_ROOT . "/../view/database_error.php");	
	}

	/** Check for user`s sessions */	
	if($_SESSION['role'] !== "ROLE_ADMIN" && $_SESSION['role'] !== "ROLE_WAITER") {		
		$error_msg = $language['alert_access'];
		include(SITE_ROOT . "/../view/database_error.php");		
	}
	else {				
		match($action) {
			default			=>	$orderController->resetOrder(),
			"new"			=>	$orderController->new(),
			"reset_order"	=>	$orderController->resetOrder(),
			"save"			=>	$orderController->save(),
			"update_order"	=>	$orderController->update(),
		};
	}	
?>