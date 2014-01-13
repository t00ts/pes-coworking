<?php

  require_once ($_SERVER['DOCUMENT_ROOT'] . "/coworking/data/paths.config.php");
  require_once (API_PATH . "auth.class.php");
  require_once (DATA_PATH . "feature.class.php");
 
  /**
  *
  * Operacion:  Alta nueva feature.
  * Semantica:  Da de alta una nueva feature en el sistema.
  */

  /* Preparacion XML */
  header ("Content-type: text/xml");
  $errors = array();

  /* Manejo de excepciones */
  $throw_exception = isset($_GET['e']) ? $_GET['e'] : false;
  
  // Comprobaciones iniciales
  if (!isset($_POST['name']))
    if ($throw_exception) throw new Exception ("Faltan datos para efectuar la operacion.", 3);
    else {
      $err = new APIError (3, "Faltan datos para efectuar la operacion.");
      array_push ($errors, $err);
    }

  // Obtenemos las variables del formulario
  $name        = ucwords($_POST['name']);
  $description = isset($_POST['description']) ? $_POST['description'] : null;
  
  // Finalmente, damos de alta la nueva feature
  $feature = new Feature (0, $name, $description);
  $fid = FeatureDataMapper::insert ($feature);
  $feature = FeatureDataMapper::getFeatureById ($fid);

  // Devolvemos la informacion de la nueva feature
  header ("Content-type: text/xml");
  echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\" ?>";
  echo "<xml>";
  foreach ($errors as $err) {
    echo $err->toXML();
  }
  echo $feature->toXML();
  echo "</xml>";

?>
