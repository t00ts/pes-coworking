<?php

require_once ($_SERVER['DOCUMENT_ROOT'] . "/coworking/data/paths.config.php");

require_once (DATA_PATH . "coworker.class.php");
require_once (DATA_PATH . "session.class.php");


class AuthValidTypes {

	const LOGIN   = "LOGIN";         // Autenticaci�n por login (Web)
	const SESSION = "SESSION";       // Autenticacion por sesion activa (Web)
	
	public static function get_array () {
	  return array ("LOGIN", "SESSION");
	}
	
}

/**
* Clase:       Auth
* Autor:       Abel Elbaile
*
* Descripcion: Gestiona la autenticacion de usuarios en el sistema.
*
*/

class Auth {

  private $_usrid;
  private $_pwd;
  private $_session_id;
  private $_type;

  public function __construct ($type) {
  
    $a = AuthValidTypes::get_array();
    if (array_search($type, $a) === false) throw new Exception ("auth_type INVALIDO", 10);
    $this->_type = $type;

  }
  
  public function addLoginDetails ($id, $pwd) {

    if (!empty($id) && !empty($pwd)) {
      $this->_usrid = $id;
      $this->_pwd   = $pwd;
    }
    else throw new Exception ("Credenciales no validas.");
  }
  
  public function addSessionDetails ($session_id) {
    
      $this->_session_id = $session_id;

  }
  
  
  
  
  private static function generate_new_session ($usr_id, $session_type) {
  
    // Si ya existe una sesion para $usr_id la eliminamos.
    $existing = SessionDataMapper::getSessionByUser ($usr_id, $session_type);
    if (!is_null ($existing)) SessionDataMapper::delete($existing);
    
    // Generamos la nueva sesion
    $s = new Session (0, $usr_id, (time() + T_SESSION * 60 * 60), time(), $session_type);
    return SessionDataMapper::insert($s);

  }
  
  
  
  
  public function authenticate () {


  	/* --------- Autenticaci�n por login --------------------- */
    if ($this->_type == AuthValidTypes::LOGIN) {
      $usr = CoworkerDataMapper::getCoworkerByUsername ($this->_usrid);
      if (is_null($usr)) return false;
      if ($usr->get_password() == md5($this->_pwd)) {

        $session_id = self::generate_new_session ($usr->get_id(), SessionValidTypes::USER);
        return $session_id;

      }
      
    }
        
    /* ----------- Autenticacion por sesion activa (Web) ----------- */
    
    elseif ($this->_type == AuthValidTypes::SESSION) {

      $s = SessionDataMapper::getSessionById ($this->_session_id);
      if (is_null($s)) return false;
      
      if ($s->isActive()) {
        $s->set_expires (time() + T_SESSION * 60 * 60);
        SessionDataMapper::update ($s);
        return true;
      }
      else {
        SessionDataMapper::delete($s);
        return false;
      }
    
    }

    return false;
    
  }

}

?>
