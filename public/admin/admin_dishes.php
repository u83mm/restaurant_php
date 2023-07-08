<?php
	declare(strict_types=1);

    use Controller\admin\DishesController;
	use model\classes\Language;

	require_once($_SERVER['DOCUMENT_ROOT'] . "/../model/aplication_fns.php");

	model\classes\Loader::init($_SERVER['DOCUMENT_ROOT'] . "/..");

	$action = strtolower($_POST['action'] ?? $_GET['action'] ?? $action = "listado");	
    $dishesController = new DishesController($dbcon);
	
	/** Test page language */
	$_SESSION['language'] = isset($_POST['language']) ? $_POST['language'] : $_SESSION['language'];
	$languageObject = new Language();
	$language = $_SESSION['language'] == "spanish" ? $languageObject->spanish() : $languageObject->english();
	

	/** Check for user`s sessions */	
	if($_SESSION['role'] !== "ROLE_ADMIN") {		
		$error_msg = $language['alert_access'];
		include(SITE_ROOT . "/../view/database_error.php");		
	}
	else {		
		match ($action) {
			default		=> $dishesController->index(),
			"volver"	=> $dishesController->index(),
			"show_form"	=> $dishesController->showForm(),
			"new"		=> $dishesController->new(),
			"edit"		=> $dishesController->edit(),
			"update"	=> $dishesController->update(),
			"delete"	=> $dishesController->delete(),
			"search"	=> $dishesController->search(),
		};
	}	
?>