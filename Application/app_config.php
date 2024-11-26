<?php			
	/** Define el directorio raiz */
	define("SITE_ROOT", $_SERVER['DOCUMENT_ROOT']);

	/** Establece número máximo de dígitos para numerar las mesas y las personas por mesa */
	define("MAX_DIGITS_TO_TABLE_NUMBERS", 2);
	define("MAX_DIGITS_TO_PEOPLE_QTY", 2);	

	/** Define connection */
	require_once(SITE_ROOT . "/../Application/connect.php");
	define('DB_CON', $dbcon);

	/** Define current URL */
	define('PATH', rtrim($_SERVER['REQUEST_URI'], "/"));	

	/** Configure directories to load their classes */
	model\classes\Loader::init(SITE_ROOT . "/../Application/Controller/admin");

	session_start();
	session_regenerate_id();
?>
