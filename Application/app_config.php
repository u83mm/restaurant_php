<?php			
	/** Define el directorio raiz */
	define("SITE_ROOT", $_SERVER['DOCUMENT_ROOT']);

	/** Establece número máximo de dígitos para numerar las mesas y las personas por mesa */
	define("MAX_DIGITS_TO_TABLE_NUMBERS", 2);
	define("MAX_DIGITS_TO_PEOPLE_QTY", 2);
	
	/** Define número de registros por páginas de la paginación */
	CONST RECORDS_PER_PAGE = 6;

	/** Define connection */
	define('DB_CONFIG_FILE', SITE_ROOT . '/../Application/db.config.php');
	require_once(SITE_ROOT . "/../Application/connect.php");
	define('DB_CON', $dbcon);	

	/** Configure directories to load their classes */
	//Application\model\classes\Loader::init(SITE_ROOT . "/../Application/Controller/admin");

	session_start();
	session_regenerate_id();
?>
