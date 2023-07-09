<?php
	declare(strict_types=1);

    use Controller\admin\AdminController;
	use model\classes\Language;	

	require_once($_SERVER['DOCUMENT_ROOT'] . "/../model/aplication_fns.php");

	model\classes\Loader::init($_SERVER['DOCUMENT_ROOT'] . "/..");

	$action = strtolower($_POST['action'] ?? $_GET['action'] ?? $action = "");
    $adminController = new AdminController($dbcon);

	/** Test page language */
	$_SESSION['language'] = isset($_POST['language']) ? $_POST['language'] : $_SESSION['language'];
	$languageObject = new Language();
	$language = $_SESSION['language'] == "spanish" ? $languageObject->spanish() : $languageObject->english();

	/** Check for user`s sessions */	
	if($_SESSION['role'] !== "ROLE_ADMIN") {				
		$error_msg = "<p class='alert alert-danger text-center container'>" . ucfirst($language['hi']) . " <strong>" . ucfirst($_SESSION['user_name']) . "</strong>, " . $language['alert_access'] . "</p>";
		include(SITE_ROOT . "/../view/database_error.php");		
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