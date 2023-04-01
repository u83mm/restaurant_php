<?php
	declare(strict_types=1);

	use Controller\MenuController;

	require_once($_SERVER['DOCUMENT_ROOT'] . "/../model/aplication_fns.php");

	model\classes\Loader::init($_SERVER['DOCUMENT_ROOT'] . "/..");		

	$action = strtolower($_POST['action'] ?? $_GET['action'] ?? $action = "index");	
	
    $menuController = new MenuController($dbcon);

	switch ($action) {
		case 'index':
			$menuController->index();
			break;
		
		case 'aperitivos':
			$menuController->showDishesByTheirCategory($action);
			break;
			
		case 'entrantes':			
			$menuController->showDishesByTheirCategory($action);
			break;
		
		case 'ensaladas':			
			$menuController->showDishesByTheirCategory($action);
			break;

		case 'carnes':
			$menuController->showDishesByTheirCategory($action);
			break;
		
		case 'pescados':
			$menuController->showDishesByTheirCategory($action);
			break;
		
		case 'arroces':
			$menuController->showDishesByTheirCategory($action);
			break;
			
		case 'postres':
			$menuController->showDishesByTheirCategory($action);
			break;
			
		case 'cafés':
			$menuController->showDishesByTheirCategory($action);
			break;
			
		case 'tintos':
			$menuController->showDishesByTheirCategory($action);
			break;
		
		case 'blancos':
			$menuController->showDishesByTheirCategory($action);
			break;
		
		case 'rosados':
			$menuController->showDishesByTheirCategory($action);
			break;
		
		case 'cavas':
			$menuController->showDishesByTheirCategory($action);
			break;
			
		case 'champagne':
			$menuController->showDishesByTheirCategory($action);
			break;
		
		case 'bebidas':
			$menuController->showDishesByTheirCategory($action);
			break;
			
		case 'licores':
			$menuController->showDishesByTheirCategory($action);
			break;

		case 'menu_pdf':
			$menuController->menu();
			break;
				
		default:
			# code...
			break;
	}

    
?>