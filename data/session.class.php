<?php

require_once ($_SERVER['DOCUMENT_ROOT'] . "/coworking/data/paths.config.php");

require_once (DATA_PATH . "coworker.class.php");
require_once (SQL_PATH . "coworking.sql.class.php");

define ("T_SESSION", 3);


class SessionValidTypes {
  
  const ADMIN  = "ADMIN";
  const USER  = "USER";

  public static function get_array () {
	  return array ("ADMIN", "USER");
	}
	
}



/**
* Clase:       Session
* Autor:       Abel Elbaile
*
* Descripcion: Guarda una sesion activa durante T_SESSION horas para evitar tener
*              que iniciar sesion constantemente para cada llamada.
*              
*              
* Atributos:   session_id:      Identificador de sesion
*              user_id:         Usuario autenticado en la sesion
*              expires:         Timestamp de expiracion de sesion
*              latest_activity: Timestamp del ultimo acceso a la sesion
*              type:            Tipo de sesion.
*/

class Session {

  private $_session_id;
  private $_user_id;
  private $_expires;
  private $_latest_activity;
  private $_type;

  public function __construct ($session_id, $user_id, $expires, $latest_activity, $type) {
    $a = SessionValidTypes::get_array();
    
    is_null($session_id) or $session_id === "" or $session_id === 0 ? $this->_session_id = "" : $this->_session_id = $session_id;
    is_null($user_id) or $user_id === "" or $user_id === 0 ? $this->_user_id = "" : $this->_user_id = $user_id;
    is_null($expires) or $expires === "" or $expires === 0 ? $this->_expires = T_SESSION*60*60 : $this->_expires = $expires;
    is_null($latest_activity) or $latest_activity === "" or $latest_activity === 0 ? $this->_latest_activity = time() : $this->_latest_activity = $latest_activity;
    if (array_search($type, $a) === false) throw new Exception ("Session type invalid.", 45);
    else $this->_type = $type;
  }

  public function get_session_id () {
    return $this->_session_id;
  }

  public function get_user_id () {
    return $this->_user_id;
  }

  public function get_expires () {
    return $this->_expires;
  }

  public function get_latest_activity () {
    return $this->_latest_activity;
  }

  public function get_type () {
    return $this->_type;
  }
  
  
  public function set_user_id ($user_id) {
    $this->_user_id = $user_id;
  }

  public function set_expires ($expires) {
    $this->_expires = $expires;
  }

  public function set_latest_activity ($timestamp) {
    $this->_latest_activity = $timestamp;
  }
  
  public function set_type ($type) {
    $a = SessionValidTypes::get_array();
    if (array_search($type, $a) === false) throw new Exception ("Session type invalid.", 45);
    else $this->_type = $type;
  }
  
  
  public function isActive () {
    return (time() < $this->_expires);
  }

}


class SessionDataMapper {

  public static function insert ($s) {
    if ($s->get_session_id() > 0) {
      throw new Exception ("No puede insertarse el elemento de tipo Session con id = " . $s->get_session_id() . ".");
    }
    
    $query = "INSERT INTO sessions VALUES ('" . $s->get_session_id() . "', '"
                                              . $s->get_user_id() . "', '"
                                              . $s->get_expires() . "', '"
                                              . $s->get_latest_activity() . "', '"
                                              . $s->get_type(). "')";

    $con = new CoworkingSQL ();
    if ($con->conectar()) {
      if (!$con->ejecutar($query))
        throw new Exception ("Ha ocurrido un error al insertar el elemento en la base de datos.");
      $sid = mysql_insert_id();
      $con->desconectar();
    }
    else
      throw new Exception ("Ha ocurrido un error al conectar a la base de datos.");

    return $sid;

  }

  public static function update ($s) {
    if ($s->get_session_id() == 0) {
      throw new Exception ("No puede actualizarse el elemento de tipo Session con identificadores nulos.");
    }

    $query = "UPDATE sessions SET user_id = '" . $s->get_user_id() . "', " .
                                 "expires = '" . $s->get_expires() . "', " .
                                 "latest_activity = '" . $s->get_latest_activity() . "', " .
                                 "type = '" . $s->get_type() . "' WHERE (session_id = " . $s->get_session_id() . ")";

    $con = new CoworkingSQL ();
    if ($con->conectar()) {
      if (!$con->ejecutar($query))
        throw new Exception ("Ha ocurrido un error al actualizar el elemento en la base de datos.");
      $con->desconectar();
    }
    else
      throw new Exception ("Ha ocurrido un error al conectar a la base de datos.");

  }

  public static function delete ($s) {
    if ($s->get_session_id() == 0) {
      throw new Exception ("No se puede eliminar el elemento de tipo Session con identificadores nulos.");
    }

    $query = "DELETE FROM sessions WHERE (session_id = " . $s->get_session_id() . ")";

    $con = new CoworkingSQL ();
    if ($con->conectar()) {
      if (!$con->ejecutar($query))
        throw new Exception ("Ha ocurrido un error al eliminar el elemento de la base de datos.");
      $con->desconectar();
    }
    else
      throw new Exception ("Ha ocurrido un error al conectar a la base de datos.");

  }

  public static function getSessionById ($session_id) {
    if ($session_id == 0) {
      throw new Exception ("No existe el elemento de tipo Session con identificadores nulos.");
    }

    $query = "SELECT * FROM sessions WHERE session_id = " . $session_id;
    $con = new CoworkingSQL ();
    if ($con->conectar()) {
      $res = $con->obtener_elemento ($query);
      $con->desconectar();
    }
    else
      throw new Exception ("Ha ocurrido un error al conectar a la base de datos.");

    $s = null;
    if ($res !== 0) {
      $s = new Session ($res['session_id'], $res['user_id'], $res['expires'], $res['latest_activity'], $res['type']);
    }

    return $s;

  }

  public static function getSessionByUser ($user_id, $session_type) {
    if ($user_id == 0) {
      throw new Exception ("No existe el elemento de tipo Session con identificadores de usuario nulos.");
    }

    $query = "SELECT * FROM sessions WHERE user_id = " . $user_id . " AND type = '". $session_type ."'";
    $con = new CoworkingSQL ();
    if ($con->conectar()) {
      $res = $con->obtener_elemento ($query);
      $con->desconectar();
    }
    else
      throw new Exception ("Ha ocurrido un error al conectar a la base de datos.");

    $s = null;
    if ($res !== 0) {
      $s = new Session ($res['session_id'], $res['user_id'], $res['expires'], $res['latest_activity'], $res['type']);
    }

    return $s;

  }
  
  public static function getUserFromSession ($session_id) {
    
    $session = self::getSessionById ($session_id);
    $usr = null;
    
    if (!is_null($session)) {
        
      if($session->get_type() == SessionValidTypes::ADMIN) {
        //$usr = AdminDataMapper::getAdminById ($session->get_user_id());
      }
      elseif ($session->get_type() == SessionValidTypes::USER) {
      	$usr = CoworkerDataMapper::getCoworkerById ($session->get_user_id());
      }

    }
    
    return $usr;
    
  }
  
}

?>