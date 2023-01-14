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
			$menuController->aperitifs();
			break;
			
		case 'entrantes':
			$menuController->starts();
			break;
		
		case 'ensaladas':
			$menuController->salads();
			break;

		case 'carnes':
			$menuController->meats();
			break;
		
		case 'pescados':
			$menuController->fishes();
			break;
		
		case 'arroces':
			$menuController->rices();
			break;
			
		case 'postres':
			$menuController->desserts();
			break;
			
		case 'cafés':
			$menuController->coffes();
			break;
			
		case 'tintos':
			$menuController->redsWines();
			break;
		
		case 'blancos':
			$menuController->whitesWines();
			break;
		
		case 'rosados':
			$menuController->pinkWines();
			break;
		
		case 'cavas':
			$menuController->sparklingWines();
			break;
			
		case 'champagne':
			$menuController->champagne();
			break;
		
		case 'bebidas':
			$menuController->drinks();
			break;
			
		case 'licores':
			$menuController->liquors();
			break;
				
		default:
			# code...
			break;
	}

    
?>