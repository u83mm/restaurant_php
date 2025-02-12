<?php
	declare(strict_types=1);

    use Application\model\classes\App;    

	require_once($_SERVER['DOCUMENT_ROOT'] . "/../Application/aplication_fns.php");	    

    /** Test page language */
	$_SESSION['language'] = $_POST['language'] ?? $_SESSION['language'] ?? "spanish";                   
  
    $app = new App();
    $app->router();
?>