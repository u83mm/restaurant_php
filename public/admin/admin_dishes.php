<?php
	declare(strict_types=1);

    use Controller\admin\DishesController;      

	require_once($_SERVER['DOCUMENT_ROOT'] . "/../model/aplication_fns.php");

	model\classes\Loader::init($_SERVER['DOCUMENT_ROOT'] . "/..");

	$action = strtolower($_POST['action'] ?? $_GET['action'] ?? $action = "");
	$message = $_POST['message'] ?? $_GET['message'] ?? $message = "";
    $dishesController = new DishesController($dbcon);


	/** Get values for pagination */

	$p = $_POST['p'] ?? $_GET['p'] ?? $p = null;
	$s = $_POST['s'] ?? $_GET['s'] ?? $s = null;

	/** Check for user`s sessions */

	$_SESSION['user_name'] ?? $_SESSION['user_name'] = "";
	$_SESSION['role'] ?? $_SESSION['role'] = "";

	if($_SESSION['role'] !== "ROLE_ADMIN") {		
		$error_msg = "<p class='alert alert-danger text-center container'>Hola <strong>{$_SESSION['user_name']}</strong>, debes tener privilegios de administrador para realizar esta acción</p>";
		include(SITE_ROOT . "/../view/database_error.php");		
	}
	else {		
		match ($action) {
			default		=> $dishesController->index($message, $p, $s),
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