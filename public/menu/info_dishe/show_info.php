<?php
	declare(strict_types=1);

	use Controller\MenuController;

	require_once($_SERVER['DOCUMENT_ROOT'] . "/../model/aplication_fns.php");

	model\classes\Loader::init($_SERVER['DOCUMENT_ROOT'] . "/..");		

	$id = strtolower($_POST['id'] ?? $_GET['id'] ?? $id = "");	
	
    $menuController = new MenuController($dbcon);

    $menuController->showDisheInfo($id);
?>