<?php
	declare(strict_types=1);

	use Controller\MenuController;

	require_once($_SERVER['DOCUMENT_ROOT'] . "/../model/aplication_fns.php");

	model\classes\Loader::init($_SERVER['DOCUMENT_ROOT'] . "/..");		

	$action = strtolower($_POST['action'] ?? $_GET['action'] ?? $action = "index");	
	
    $menuController = new MenuController($dbcon);

    $menuController->starts();
?>