<?php

  session_name ("coworking");
  session_start ();

  require_once ($_SERVER['DOCUMENT_ROOT'] . "/coworking/data/paths.config.php");
  require_once (DATA_PATH . "session.class.php");
  
  if (isset($_SESSION['session_id'])) {
    $session = SessionDataMapper::getSessionById ($_SESSION['session_id']);
    SessionDataMapper::delete ($session);
  }
  
  session_destroy ();
  
  header ("Location: index.php");
  
?>