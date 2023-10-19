<?php
	declare(strict_types=1);
    
    use Controller\admin\ComandasController;
	use Controller\orders\OrderController;
	use model\classes\Language;

	require_once($_SERVER['DOCUMENT_ROOT'] . "/../Application/aplication_fns.php");

	model\classes\Loader::init($_SERVER['DOCUMENT_ROOT'] . "/..");

	$action = strtolower($_POST['action'] ?? $_GET['action'] ?? $action = "");
    $comandasController = new ComandasController($dbcon);
	$orderController = new OrderController($dbcon);

	/** Test page language */
	$_SESSION['language'] = isset($_POST['language']) ? $_POST['language'] : $_SESSION['language'];
	$languageObject = new Language();
	$language = $_SESSION['language'] == "spanish" ? $languageObject->spanish() : $languageObject->english();	

	/** Check for user`s sessions */
	if(!isset($_SESSION['role'])) {
		$error_msg = "<p class='alert alert-danger text-center'>{$language['alert_access']}</p>";
		include(SITE_ROOT . "/../view/database_error.php");	
	}	
	
	if($_SESSION['role'] !== "ROLE_ADMIN") {		
		$error_msg = "<p class='alert alert-danger text-center'>{$language['alert_access']}</p>";
		include(SITE_ROOT . "/../view/database_error.php");		
	}	
	else if((isset($_SESSION['table_number']) || isset($_SESSION['people_qty'])) && (strlen($_SESSION['table_number']) > MAX_DIGITS_TO_TABLE_NUMBERS && strlen($_SESSION['people_qty']) > MAX_DIGITS_TO_TABLE_NUMBERS)) {			
		$action = strtolower($_POST['action'] ?? $_GET['action'] ?? $action = "add");
		$table_number = isset($_POST['table_number']) ? $_POST['table_number'] : ucfirst($language[strtolower($_SESSION['table_number'])]);	
		$people_qty = isset($_POST['people_qty']) ? $_POST['people_qty'] : ucfirst($language[strtolower($_SESSION['people_qty'])]);		
		$id = isset($_POST['id']) ? $_POST['id'] : $_SESSION['id'];
		match($action) {
			default 			=> 	$comandasController->index(),
			'update_comanda'	=>	$comandasController->update(),
			'index'				=>	$comandasController->index(),
			'delete'			=>	$comandasController->delete(),
			'add'				=>	$comandasController->add([
				'table_number'	=>	$table_number,
				'people_qty'	=>	$people_qty,
				'id'			=>	$id,
				'action'		=>	"add",				
			]),	
			'save'				=>	$comandasController->addToOrder(),					
			'show'				=>	$comandasController->show(),
		};
	}
	else {
		$table_number = isset($_POST['table_number']) ? $_POST['table_number'] : $_SESSION['table_number'] ?? "";	
		$people_qty = isset($_POST['people_qty']) ? $_POST['people_qty'] : $_SESSION['people_qty'] ?? "";		
		$id = isset($_POST['id']) ? $_POST['id'] : $_SESSION['id'] ?? "";
		match($action) {
			default 			=> 	$comandasController->index(),			
			'update_comanda'	=>	$comandasController->update(),
			'index'				=>	$comandasController->index(),
			'delete'			=>	$comandasController->delete(),
			'add'				=>	$comandasController->add([
				'table_number'	=>	$table_number,
				'people_qty'	=>	$people_qty,
				'id'			=>	$id,
				'action'		=>	"add",
			]),
			'save'				=>	$comandasController->addToOrder(),			
			'update_order'		=>	$orderController->update(),
			'show'				=>	$comandasController->show(),
		};		
	}	
?>