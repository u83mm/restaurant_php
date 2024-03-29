<?php
	declare(strict_types=1);

    use model\classes\App;

	require_once($_SERVER['DOCUMENT_ROOT'] . "/../Application/aplication_fns.php");		

    /** Test page language */
	$_SESSION['language'] = $_POST['language'] ?? $_SESSION['language'] ?? "spanish";                   

    /* $uri = explode("/", PATH);
    array_shift($uri);          

    router($uri); */
    
    $app = new App();
    $app->router();
?>
