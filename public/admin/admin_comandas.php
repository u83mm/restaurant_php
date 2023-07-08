<?php
	declare(strict_types=1);
    
    use Controller\admin\ComandasController;
	use Controller\orders\OrderController;
	use model\classes\Language;

	require_once($_SERVER['DOCUMENT_ROOT'] . "/../model/aplication_fns.php");

	model\classes\Loader::init($_SERVER['DOCUMENT_ROOT'] . "/..");

	$action = strtolower($_POST['action'] ?? $_GET['action'] ?? $action = "");
    $comandasController = new ComandasController($dbcon);
	$orderController = new OrderController($dbcon);

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