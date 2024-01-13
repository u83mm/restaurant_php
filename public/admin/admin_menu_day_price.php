<?php
	declare(strict_types=1);

    use Controller\admin\MenuDayController;
	use model\classes\Language;

	require_once($_SERVER['DOCUMENT_ROOT'] . "/../Application/aplication_fns.php");

	model\classes\Loader::init($_SERVER['DOCUMENT_ROOT'] . "/..");

	$action = strtolower($_POST['action'] ?? $_GET['action'] ?? $action = "index");
	$message = $_POST['message'] ?? $_GET['message'] ?? $message = "";
    $menuDayController = new MenuDayController();
	
	/** Test page language */
	$_SESSION['language'] = isset($_POST['language']) ? $_POST['language'] : $_SESSION['language'];
	$languageObject = new Language();
	$language = $_SESSION['language'] == "spanish" ? $languageObject->spanish() : $languageObject->english();

	/** Check for user`s sessions */
	!isset($_SESSION['role']) ? header("Location: /") : null;

	if($_SESSION['role'] !== "ROLE_ADMIN") {		
		header("Location: /login.php");	
	}
	else {
		match ($action) {
			default => $menuDayController->index(),
		};
	}	
?>