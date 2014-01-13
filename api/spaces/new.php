<?php

require_once ($_SERVER['DOCUMENT_ROOT'] . "/coworking/data/paths.config.php");
require_once (API_PATH . "auth.class.php");
require_once (DATA_PATH . "space.class.php");
require_once (DATA_PATH . "desk.class.php");
require_once (DATA_PATH . "feature.class.php");
require_once (DATA_PATH . "error.class.php");

/**
 *
 * Operacion:  Alta nuevo espacio.
 * Semantica:  Da de alta un nuevo espacio en el sistema.
*/

/* Preparacion XML */
//header ("Content-type: text/xml");
$errors = array();

/* Manejo de excepciones */
$throw_exception = isset($_GET['e']) ? $_GET['e'] : false;

// Comprobaciones iniciales
if (!isset($_POST['name']) || !isset($_POST['country']) || !isset($_POST['ownerId']))
	if ($throw_exception) throw new Exception ("Faltan datos para efectuar la operacion.", 3);
	else {
		$err = new APIError (3, "Faltan datos para efectuar la operacion.");
		array_push ($errors, $err);
	}

// Obtenemos las variables del formulario
$name        = $_POST['name'];
$description = $_POST['description'];
$phoneNumber = $_POST['phoneNumber'];
$website     = $_POST['website'];
$address     = $_POST['address'];
$zip         = $_POST['zip'];
$city        = $_POST['city'];
$country     = $_POST['country'];
$ownerId     = $_POST['ownerId'];

// Desks
$dpQty       = $_POST['dpQty'];
$dpPrice     = $_POST['dpPrice'];
$dfQty       = $_POST['dfQty'];
$dfPrice     = $_POST['dfPrice'];
$dmQty       = $_POST['dmQty'];
$dmPrice     = $_POST['dmPrice'];

// Features
$features    = explode (',', $_POST['features']);

//$foto       = isset($_POST['foto']) ? $_POST['foto'] : null;

// Finalmente, damos de alta el nuevo espacio
$space = new Space (0, $name, $description, $phoneNumber, $website, $address, $zip, $city, $country, $ownerId);
$sid = SpaceDataMapper::insert ($space);
$space = SpaceDataMapper::getSpaceById ($sid);

// Y sus desks
$deskNo = 1;
while ($deskNo < $dpQty) {
	$desk = new Desk ($sid, $deskNo++, 0, $dpPrice);
	DeskDataMapper::insert ($desk);
}
while ($deskNo < $dpQty + $dfQty) {
	$desk = new Desk ($sid, $deskNo++, 1, $dfPrice);	
	DeskDataMapper::insert ($desk);
}
while ($deskNo < $dpQty + $dfQty + $dmQty) {
	$desk = new Desk ($sid, $deskNo++, 2, $dmPrice);	
	DeskDataMapper::insert ($desk);
}

// Y sus features
foreach ($features as $f) {
	SpaceDataMapper::addFeatureToSpace ($sid, $f);
}

// Foto del espacio - TODO

// Devolvemos la informacion del nuevo espacio
/*echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\" ?>";
echo "<xml>";
foreach ($errors as $err) {
  echo $err->toXML();
}
echo $space->toXML();
echo "</xml>";*/

  if (count($errors) > 0) {
  	echo "The following errors occured, please go back and try to fix them: <br /><ul>";
  	foreach ($errors as $err) {
      echo "<li>" . $err->getMessage() . "</li>";
  	}
  	echo "</ul>";
  }
  else header ("Location: ../../index.php?s=view-space&id=" . $sid);

?>
