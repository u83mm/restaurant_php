"use strict"; 

/** Función que crea objeto XMLHttpRequest para todos los navegadores */

function getXMLHTTPRequest() {
	var peticion = false;
	try {
		/* for Firefox */
		peticion = new XMLHttpRequest();
	} catch (err) {
		try {
			/* for some versions of IE */
			peticion = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (err) {
			try {
				/* for some other versions of IE */
				peticion = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (err) {
				peticion = false;
			}
		}
	}
	return peticion;
}


/** Test page language */
/*function testLanguage() {	
	let languageValue = this.value;	

	let peticion = getXMLHTTPRequest();
	let url = "/../end_points/test_language.php";
	let params = new FormData();	
				
	params.append("language", languageValue);
	
	peticion.onreadystatechange = consulta;
	peticion.open('POST', url, true);	
	peticion.send(params);    

	function consulta() {
		if(peticion.readyState == 1) {
			//muestraGif();
			alert("no funciona");
		}
		else if(peticion.readyState == 4 && peticion.status == 200) {
			alert("Funciona");
		} 
	}	
}*/