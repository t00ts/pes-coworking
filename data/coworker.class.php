<?php

require_once ($_SERVER['DOCUMENT_ROOT'] . "/coworking/data/paths.config.php");
require_once (SQL_PATH . "coworking.sql.class.php");

/**
* Clase:       Coworker
* Autor:       Abel Elbaile
*
* Descripcion: 
*              
*              
* Atributos:   id: 
*              name: 
*              lastName: 
*              mail: 
*              username: 
*              password: 
*              occupation: 
*              interest: 
*/

class Coworker {

  private $_id;
  private $_name;
  private $_lastName;
  private $_mail;
  private $_username;
  private $_password;
  private $_occupation;
  private $_interest;

  public function __construct ($id, $name, $lastName, $mail, $username, $password, $occupation, $interest) {
    is_null($id) or $id === "" or $id === 0 ? $this->_id = "" : $this->_id = $id;
    is_null($name) or $name === "" or $name === 0 ? $this->_name = "" : $this->_name = $name;
    is_null($lastName) or $lastName === "" or $lastName === 0 ? $this->_lastName = "" : $this->_lastName = $lastName;
    is_null($mail) or $mail === "" or $mail === 0 ? $this->_mail = "" : $this->_mail = $mail;
    is_null($username) or $username === "" or $username === 0 ? $this->_username = "" : $this->_username = $username;
    is_null($password) or $password === "" or $password === 0 ? $this->_password = "" : $this->_password = $password;
    is_null($occupation) or $occupation === "" or $occupation === 0 ? $this->_occupation = "" : $this->_occupation = $occupation;
    is_null($interest) or $interest === "" or $interest === 0 ? $this->_interest = "" : $this->_interest = $interest;
  }

  public function get_id () {
    return $this->_id;
  }

  public function get_name () {
    return $this->_name;
  }

  public function get_lastName () {
    return $this->_lastName;
  }

  public function get_mail () {
    return $this->_mail;
  }

  public function get_username () {
    return $this->_username;
  }

  public function get_password () {
    return $this->_password;
  }

  public function get_occupation () {
    return $this->_occupation;
  }

  public function get_interest () {
    return $this->_interest;
  }


  public function set_name ($name) {
    $this->_name = $name;
  }

  public function set_lastName ($lastName) {
    $this->_lastName = $lastName;
  }

  public function set_mail ($mail) {
    $this->_mail = $mail;
  }

  public function set_username ($username) {
    $this->_username = $username;
  }

  public function set_password ($password) {
    $this->_password = $password;
  }

  public function set_occupation ($occupation) {
    $this->_occupation = $occupation;
  }

  public function set_interest ($interest) {
    $this->_interest = $interest;
  }

  public function toXML () {
  	$xml = "<coworker id=\"" . $this->_id . "\">";
  	$xml .= "<name>" . $this->_name . "</name>";
  	$xml .= "<lastName>" . $this->_lastName . "</lastName>";
  	$xml .= "<mail>" . $this->_mail . "</mail>";
  	$xml .= "<username>" . $this->_username . "</username>";
  	$xml .= "<password>" . $this->_password . "</password>";
  	$xml .= "<occupation>" . $this->_occupation . "</occupation>";
  	$xml .= "<interest>" . $this->_interest . "</interest>";
  	$xml .= "</coworker>";
  	return $xml;
  }
  
}


class CoworkerDataMapper {

  public static function insert ($c) {
    if ($c->get_id() > 0) {
      throw new Exception ("No puede insertarse el elemento de tipo Coworker con id = " . $c->get_id() . ".");
    }

    $query = "INSERT INTO coworkers VALUES ('" . $c->get_id() . "', '"
                                               . $c->get_name() . "', '"
                                               . $c->get_lastName() . "', '"
                                               . $c->get_mail() . "', '"
                                               . $c->get_username() . "', '"
                                               . $c->get_password() . "', '"
                                               . $c->get_occupation() . "', '"
                                               . $c->get_interest(). "')";

    $con = new CoworkingSQL ();
    if ($con->conectar()) {
      if (!$con->ejecutar($query))
        throw new Exception ("Ha ocurrido un error al insertar el elemento en la base de datos.");
      $cid = mysql_insert_id();
      $con->desconectar();
    }
    else
      throw new Exception ("Ha ocurrido un error al conectar a la base de datos.");

    return $cid;

  }

  public static function update ($c) {
    if ($c->get_id() == 0) {
      throw new Exception ("No puede actualizarse el elemento de tipo Coworker con identificadores nulos.");
    }

    $query = "UPDATE coworkers SET name = '" . $c->get_name() . "', " .
                                  "lastName = '" . $c->get_lastName() . "', " .
                                  "mail = '" . $c->get_mail() . "', " .
                                  "username = '" . $c->get_username() . "', " .
                                  "password = '" . $c->get_password() . "', " .
                                  "occupation = '" . $c->get_occupation() . "', " .
                                  "interest = '" . $c->get_interest() . "' WHERE (id = " . $c->get_id() . ")";


    $con = new CoworkingSQL ();
    if ($con->conectar()) {
      if (!$con->ejecutar($query))
        throw new Exception ("Ha ocurrido un error al actualizar el elemento en la base de datos.");
      $con->desconectar();
    }
    else
      throw new Exception ("Ha ocurrido un error al conectar a la base de datos.");

  }

  public static function delete ($c) {
    if ($c->get_id() == 0) {
      throw new Exception ("No se puede eliminar el elemento de tipo Coworker con identificadores nulos.");
    }

    $query = "DELETE FROM coworkers WHERE (id = " . $c->get_id() . ")";

    $con = new CoworkingSQL ();
    if ($con->conectar()) {
      if (!$con->ejecutar($query))
        throw new Exception ("Ha ocurrido un error al eliminar el elemento de la base de datos.");
      $con->desconectar();
    }
    else
      throw new Exception ("Ha ocurrido un error al conectar a la base de datos.");

  }

  public static function getCoworkerById ($id) {
    if ($id == 0) {
      throw new Exception ("No existe el elemento de tipo Coworker con identificadores nulos.");
    }

    $query = "SELECT * FROM coworkers WHERE id = " . $id;
    $con = new CoworkingSQL ();
    if ($con->conectar()) {
      $res = $con->obtener_elemento ($query);
      $con->desconectar();
    }
    else
      throw new Exception ("Ha ocurrido un error al conectar a la base de datos.");

    $c = null;
    if ($res !== 0) {
      $c = new Coworker ($res['id'], $res['name'], $res['lastName'], $res['mail'], $res['username'], $res['password'], $res['occupation'], $res['interest']);
    }

    return $c;

  }

  public static function getCoworkerByUsername ($username) {
    if ($username == "") {
      throw new Exception ("No existe el elemento de tipo Coworker con username vacio.");
    }

    $query = "SELECT * FROM coworkers WHERE username = \"" . $username . "\"";
    $con = new CoworkingSQL ();
    if ($con->conectar()) {
      $res = $con->obtener_elemento ($query);
      $con->desconectar();
    }
    else
      throw new Exception ("Ha ocurrido un error al conectar a la base de datos.");

    $c = null;
    if ($res !== 0) {
      $c = new Coworker ($res['id'], $res['name'], $res['lastName'], $res['mail'], $res['username'], $res['password'], $res['occupation'], $res['interest']);
    }

    return $c;

  }

  public static function exists ($username) {
  	
  	return !is_null(self::getCoworkerByUsername ($username));

  }
  
}

?>