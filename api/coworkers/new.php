<?php

  require_once ($_SERVER['DOCUMENT_ROOT'] . "/coworking/data/paths.config.php");
  require_once (API_PATH . "auth.class.php");
  require_once (DATA_PATH . "coworker.class.php");
  require_once (DATA_PATH . "error.class.php");
 
  /**
  *
  * Operacion:  Alta nuevo usuario.
  * Semantica:  Da de alta un nuevo usuario en el sistema.
  */

  /* Preparacion XML */
  //header ("Content-type: text/xml");
  $errors = array();

  /* Manejo de excepciones */
  $throw_exception = isset($_GET['e']) ? $_GET['e'] : false;
  
  // Comprobaciones iniciales
  if (!isset($_POST['name']) || !isset($_POST['lastName']) || !isset($_POST['mail']) || !isset($_POST['username']) || !isset($_POST['password']))
    if ($throw_exception) throw new Exception ("Faltan datos para efectuar la operacion.", 3);
    else {
      $err = new APIError (3, "Faltan datos para efectuar la operacion.");
      array_push ($errors, $err);
    }

  // Obtenemos las variables del formulario
  $name       = ucfirst($_POST['name']);
  $lastName   = ucwords($_POST['lastName']);
  $mail       = $_POST['mail'];
  $username   = $_POST['username'];
  $password   = isset($_POST['password']) ? md5($_POST['password']) : "";
  $occupation = isset($_POST['occupation']) ? $_POST['occupation'] : "";
  $interest   = isset($_POST['interest']) ? $_POST['interest'] : "";
  $foto       = isset($_POST['foto']) ? $_POST['foto'] : null;
  
  // Finalmente, damos de alta el nuevo usuario
  $coworker = new Coworker (0, $name, $lastName, $mail, $username, $password, $occupation, $interest);
  $cid = CoworkerDataMapper::insert ($coworker);
  $coworker = CoworkerDataMapper::getCoworkerById ($cid);

  // Foto del coworker - TODO

  
  // Devolvemos la informacion del nuevo usuario
  /*header ("Content-type: text/xml");
  echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\" ?>";
  echo "<xml>";
  foreach ($errors as $err) {
    echo $err->toXML();
  }
  echo $coworker->toXML();
  echo "</xml>";*/
  
  if (count($errors) > 0) {
  	echo "The following errors occured, please go back and try to fix them: <br /><ul>";
  	foreach ($errors as $err) {
      echo "<li>" . $err->getMessage() . "</li>";
  	}
  	echo "</ul>";
  }
  else header ("Location: ../../index.php?s=login")

?>
