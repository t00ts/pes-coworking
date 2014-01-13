<php

  session_name ("coworking");
  session_start ();
  
  require_once ($_SERVER['DOCUMENT_ROOT'] . "/coworking/data/paths.config.php");
  require_once (API_PATH . "auth.class.php");

  /* -------------------------- Autenticacion -------------------------- */

  $auth_type = isset ($_REQUEST['auth_type']) ? $_REQUEST['auth_type'] : "";
  $session_id = 0;
  
  if (isset($_REQUEST['session_id']) and !empty($auth_type)) {
    
    $session_id = $_REQUEST['session_id'];
    
    $auth = new Auth($auth_type);
    $auth->addSessionDetails ($session_id);
    $res = $auth->authenticate();

    if ($res === false) 
      if ($throw_exception) throw new Exception ("Session expired.", 99);
      else {
        $error = new APIError (99, "Session expired.");
        array_push ($errors, $error);
      }

  }
  else
    if ($throw_exception) throw new Exception ("Credenciales no validas.", 2);
    else {
      $error = new APIError (2, "Credenciales no validas.");
      array_push ($errors, $error);
    }

  // Si se produce uno de los dos errores detenemos la ejecucion
  if (count ($errors) > 0) {
    echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\" ?>";
    echo "<xml>";
    foreach ($errors as $err) echo $err->toXML();
    echo "</xml>";
    die();
  }
  
  /* ------------------------- /Autenticacion -------------------------- */

?>
