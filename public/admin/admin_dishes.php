<?php
	declare(strict_types=1);

    use Controller\admin\DishesController;      

	require_once($_SERVER['DOCUMENT_ROOT'] . "/../model/aplication_fns.php");

	model\classes\Loader::init($_SERVER['DOCUMENT_ROOT'] . "/..");

	$action = strtolower($_POST['action'] ?? $_GET['action'] ?? $action = "listado");
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
		switch($action) {			
			case "listado":
				$dishesController->index($message, $p, $s);	
				break;
			
			case "volver":
				$dishesController->index();	
				break;
			
			case "show form":
				$dishesController->showForm();
				break;
					
			case "new":
				$dishesController->new();			
				break;
			
			case "show":
				$dishesController->show();							
				break;
	
			case "update":
				$dishesController->update();	
				break;
	
			case "change password":
				$dishesController->changePassword();
				break;
	
			case "delete":
				$dishesController->delete();
				break;
		}	
	}	
?>