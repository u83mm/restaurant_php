<?php
	declare(strict_types=1);

	use Controller\reservations\ReservationController;

	require_once($_SERVER['DOCUMENT_ROOT'] . "/../Application/aplication_fns.php");

	model\classes\Loader::init($_SERVER['DOCUMENT_ROOT'] . "/..");	

	$action = strtolower($_POST['action'] ?? $_GET['action'] ?? "");				

	/** Test page language */
	$_SESSION['language'] = $_POST['language'] ?? $_SESSION['language'] ?? "spanish";

	if(isset($_SESSION['action'])) unset($_SESSION['action']);

	/** Check for user`s sessions */
	!isset($_SESSION['role']) ? header("Location: /") : null;

    $reservationController = new ReservationController($dbcon);

	match($action) {
		default					=>	$reservationController->index(),
		'reservation'			=>	$reservationController->index(),
		'save'					=>	$reservationController->saveReservation(),
		'show_reservations'		=>	$reservationController->showReservations(),
	};
?>
