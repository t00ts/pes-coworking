<?php

require_once ($_SERVER['DOCUMENT_ROOT'] . "/coworking/data/paths.config.php");
require_once (API_PATH . "auth.class.php");
require_once (DATA_PATH . "space.class.php");

/**
 *
 * Operacion:  Buscar espacio.
 * Semantica:  Da de alta un nuevo espacio en el sistema.
*/

/* Preparacion XML */
header ("Content-type: text/xml");
$errors = array();

/* Manejo de excepciones */
$throw_exception = isset($_GET['e']) ? $_GET['e'] : false;

// Comprobaciones iniciales
if (!isset($_POST['q']))
	if ($throw_exception) throw new Exception ("Faltan datos para efectuar la operacion.", 3);
	else {
		$err = new APIError (3, "Faltan datos para efectuar la operacion.");
		array_push ($errors, $err);
	}

// Obtenemos las variables del formulario
$q = $_POST['q'];

if (isset ($_POST['features']) && $_POST['features'] != "") {
  
  // Obtenemos filtros
  $features = explode(',', $_POST['features']);
  $results = SpaceDataMapper::search ($q, $features);
  
}
else {
	
	// Busqueda solo q
	$results = SpaceDataMapper::search ($q, null);

}

echo "<?xml version='1.0' encoding='ISO-8859-1'?>";
echo "<results>";	
foreach ($results as $r) {
	echo $r->toXMLwPrice ();	
}
echo "</results>";

?>
