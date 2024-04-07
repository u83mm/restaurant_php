<?php	

	/** Define el directorio raiz */
	define("SITE_ROOT", $_SERVER['DOCUMENT_ROOT']);

	/** Establece número máximo de dígitos para numerar las mesas y las personas por mesa */
	define("MAX_DIGITS_TO_TABLE_NUMBERS", 2);
	define("MAX_DIGITS_TO_PEOPLE_QTY", 2);

	/** API KEY to send emails with Resend API */
	define('RESEND_API_KEY', 're_8E64TxAJ_2Ft8a1HqTdLiKdonsvtdB6QG');

	/** Define connection */
	require_once(SITE_ROOT . "/../Application/connect.php");
	define('DB_CON', $dbcon);

	/** Define current URL */
	define('PATH', rtrim($_SERVER['REQUEST_URI'], "/"));

	session_start();
	session_regenerate_id();

	/** Configure directories to load their classes */
	model\classes\Loader::init(SITE_ROOT . "/../Application/Controller/admin");
?>
