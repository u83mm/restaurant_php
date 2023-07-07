<?php
	declare(strict_types=1);

	use Controller\MenuController;

	require_once($_SERVER['DOCUMENT_ROOT'] . "/../model/aplication_fns.php");

	model\classes\Loader::init($_SERVER['DOCUMENT_ROOT'] . "/..");				
	
    $menuController = new MenuController($dbcon);

	/** Test page language */
	$_SESSION['language'] = isset($_POST['language']) ? $_POST['language'] : $_SESSION['language'];

    $menuController->showDisheInfo();
?>