<?php
	declare(strict_types=1);	

	require_once($_SERVER['DOCUMENT_ROOT'] . "/../Application/aplication_fns.php");	

	model\classes\Loader::init(SITE_ROOT . "/..");

    /** Test page language */
	$_SESSION['language'] = $_POST['language'] ?? $_SESSION['language'] ?? "spanish";                   

    $uri = explode("/", PATH);
    array_shift($uri);           

    router($uri);      
?>
