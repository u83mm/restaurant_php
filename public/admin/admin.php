<?php
	declare(strict_types=1);

    use Controller\admin\AdminController;
	use model\classes\Language;	

	require_once($_SERVER['DOCUMENT_ROOT'] . "/../Application/aplication_fns.php");

	model\classes\Loader::init($_SERVER['DOCUMENT_ROOT'] . "/..");

	$action = strtolower($_POST['action'] ?? $_GET['action'] ?? $action = "");
    $adminController = new AdminController();

	if(isset($_SESSION['action'])) unset($_SESSION['action']);

	/** Test page language */
	$_SESSION['language'] = isset($_POST['language']) ? $_POST['language'] : $_SESSION['language'];
	$languageObject = new Language();
	$language = $_SESSION['language'] == "spanish" ? $languageObject->spanish() : $languageObject->english();	

	/** Check for user`s sessions */
	!isset($_SESSION['role']) ? header("Location: /") : null;	

	if($_SESSION['role'] !== "ROLE_ADMIN") {						
		header("Location: /login.php");
	}
	else {		
		match ($action) {
			default				=>	$adminController->adminMenus(),
			"listado"			=>	$adminController->index(),
			"volver"			=>	$adminController->index(),
			"new"				=>	$adminController->new(),
			"show"				=>	$adminController->show(),
			"update"			=>	$adminController->update(),
			"change password"	=>	$adminController->changePassword(),
			"delete"			=>	$adminController->delete(),
		};
	}	
?>