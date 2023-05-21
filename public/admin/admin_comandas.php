<?php
	declare(strict_types=1);
    
    use Controller\admin\ComandasController;
	use Controller\orders\OrderController;

	require_once($_SERVER['DOCUMENT_ROOT'] . "/../model/aplication_fns.php");

	model\classes\Loader::init($_SERVER['DOCUMENT_ROOT'] . "/..");

	$action = strtolower($_POST['action'] ?? $_GET['action'] ?? $action = "");
    $comandasController = new ComandasController($dbcon);
	$orderController = new OrderController($dbcon);

	/** Check for user`s sessions */
	$_SESSION['user_name'] ?? $_SESSION['user_name'] = "";
	$_SESSION['role'] ?? $_SESSION['role'] = "";

	if($_SESSION['role'] !== "ROLE_ADMIN") {		
		$error_msg = "<p class='alert alert-danger text-center container'>Hola <strong>{$_SESSION['user_name']}</strong>, debes tener privilegios de administrador para realizar esta acción</p>";
		include(SITE_ROOT . "/../view/database_error.php");		
	}
	else {
		match($action) {
			default 			=> 	$comandasController->index(),
			'update_comanda'	=>	$comandasController->update(),
			'delete'			=>	$comandasController->delete(),
			'add'				=>	$orderController->new([
				'table_number'	=>	$_POST['table_number'],
				'people_qty'	=>	$_POST['people_qty'],
				'id'			=>	$_POST['id'],
			]),
			'save'				=>	$comandasController->addToOrder(),
			'reset_order'		=>	$orderController->resetOrder(),
			'update_order'		=>	$orderController->update(),
			'show'				=>	$comandasController->show(),
		};		
	}	
?>