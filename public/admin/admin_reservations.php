<?php
	declare(strict_types=1);

    use Controller\reservations\ReservationController;
    use model\classes\Language;	

	require_once($_SERVER['DOCUMENT_ROOT'] . "/../Application/aplication_fns.php");

	model\classes\Loader::init($_SERVER['DOCUMENT_ROOT'] . "/..");

	$action = strtolower($_POST['action'] ?? $_GET['action'] ?? $action = "");  
    $reservationController = new ReservationController($dbcon); 

	if(isset($_SESSION['action'])) unset($_SESSION['action']);
    
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
	else {		
		match ($action) {
			default			=>	$reservationController->showAllReservations(),
			"search_panel"	=>	$reservationController->showSearchPanel(),
			"search"		=>	$reservationController->searchReservationsByDateAndTime(),			
		};
	}	
?>