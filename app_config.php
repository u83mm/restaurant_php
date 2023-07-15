<?php	

	/** Define el directorio raiz */
	define("SITE_ROOT", $_SERVER['DOCUMENT_ROOT']);

	/** Establece número máximo de dígitos para numerar las mesas y las personas por mesa */
	define("MAX_DIGITS_TO_TABLE_NUMBERS", 2);
	define("MAX_DIGITS_TO_PEOPLE_QTY", 2);

	session_start();
	session_regenerate_id();
?>
