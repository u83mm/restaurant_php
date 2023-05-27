<?php
	declare(strict_types=1);

	use Controller\MenuController;

	require_once($_SERVER['DOCUMENT_ROOT'] . "/../model/aplication_fns.php");

	model\classes\Loader::init($_SERVER['DOCUMENT_ROOT'] . "/..");		

	$action = strtolower($_POST['action'] ?? $_GET['action'] ?? $action = "");	
	
    $menuController = new MenuController($dbcon);	

    match($action) {
		default		 => $menuController->index(),
		'aperitivos' => $menuController->showDishesByTheirCategory($action),
		'entrantes'	 => $menuController->showDishesByTheirCategory($action),
		'ensaladas'	 => $menuController->showDishesByTheirCategory($action),
		'carnes'	 => $menuController->showDishesByTheirCategory($action),
		'pescados'	 => $menuController->showDishesByTheirCategory($action),
		'arroces'	 => $menuController->showDishesByTheirCategory($action),
		'postres'	 => $menuController->showDishesByTheirCategory($action),
		'cafés'		 => $menuController->showDishesByTheirCategory($action),
		'tintos'	 => $menuController->showDishesByTheirCategory($action),
		'blancos'	 => $menuController->showDishesByTheirCategory($action),
		'rosados'	 => $menuController->showDishesByTheirCategory($action),
		'cavas'		 => $menuController->showDishesByTheirCategory($action),
		'champagne'	 => $menuController->showDishesByTheirCategory($action),
		'bebidas'	 => $menuController->showDishesByTheirCategory($action),
		'licores'	 => $menuController->showDishesByTheirCategory($action),
		'menu_pdf'	 => $menuController->menu(),
	};
?>