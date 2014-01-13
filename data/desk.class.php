<?php

require_once ($_SERVER['DOCUMENT_ROOT'] . "/coworking/data/paths.config.php");


/**
* Clase:       Desk
* Autor:       Abel Elbaile
*
* Descripcion: 
*              
*              
* Atributos:   spaceId: 
*              number: 
*              type: 
*              price: 
*/

class Desk {

  private $_spaceId;
  private $_number;
  private $_type;
  private $_price;

  public function __construct ($spaceId, $number, $type, $price) {
    is_null($spaceId) or $spaceId === "" or $spaceId === 0 ? $this->_spaceId = "" : $this->_spaceId = $spaceId;
    is_null($number) or $number === "" or $number === 0 ? $this->_number = "" : $this->_number = $number;
    is_null($type) or $type === "" or $type === 0 ? $this->_type = "" : $this->_type = $type;
    is_null($price) or $price === "" or $price === 0 ? $this->_price = "" : $this->_price = $price;
  }

  public function get_spaceId () {
    return $this->_spaceId;
  }

  public function get_number () {
    return $this->_number;
  }

  public function get_type () {
    return $this->_type;
  }

  public function get_price () {
    return $this->_price;
  }


  public function set_type ($type) {
    $this->_type = $type;
  }

  public function set_price ($price) {
    $this->_price = $price;
  }


}


class DeskDataMapper {

  public static function insert ($d) {
    if ($d->get_spaceId() == 0 or $d->get_number() == 0) {
      throw new Exception ("No puede insertarse el elemento de tipo Desk con id = " . $d->get_spaceId() . ".");
    }

    $query = "INSERT INTO desks VALUES ('" . $d->get_spaceId() . "', '"
                                           . $d->get_number() . "', '"
                                           . $d->get_type() . "', '"
                                           . $d->get_price(). "')";

    $con = new CoworkingSQL ();
    if ($con->conectar()) {
      if (!$con->ejecutar($query))
        throw new Exception ("Ha ocurrido un error al insertar el elemento en la base de datos.");
      $did = mysql_insert_id();
      $con->desconectar();
    }
    else
      throw new Exception ("Ha ocurrido un error al conectar a la base de datos.");

    return $did;

  }

  public static function update ($d) {
    if ($d->get_spaceId() == 0 or $d->get_number() == 0) {
      throw new Exception ("No puede actualizarse el elemento de tipo Desk con identificadores nulos.");
    }

    $query = "UPDATE desks SET type = '" . $d->get_type() . "', " .
                              "price = '" . $d->get_price() . "' WHERE (spaceId = " . $d->get_spaceId() . " AND number = " . $d->get_number() . ")";


    $con = new CoworkingSQL ();
    if ($con->conectar()) {
      if (!$con->ejecutar($query))
        throw new Exception ("Ha ocurrido un error al actualizar el elemento en la base de datos.");
      $con->desconectar();
    }
    else
      throw new Exception ("Ha ocurrido un error al conectar a la base de datos.");

  }

  public static function delete ($d) {
    if ($d->get_spaceId() == 0 or $d->get_number() == 0) {
      throw new Exception ("No se puede eliminar el elemento de tipo Desk con identificadores nulos.");
    }

    $query = "DELETE FROM desks WHERE (spaceId = " . $d->get_spaceId() . " AND number = " . $d->get_number() . ")";

    $con = new CoworkingSQL ();
    if ($con->conectar()) {
      if (!$con->ejecutar($query))
        throw new Exception ("Ha ocurrido un error al eliminar el elemento de la base de datos.");
      $con->desconectar();
    }
    else
      throw new Exception ("Ha ocurrido un error al conectar a la base de datos.");

  }

  public static function getDeskById ($spaceId, $number) {
    if ($spaceId == 0 or $number == 0) {
      throw new Exception ("No existe el elemento de tipo Desk con identificadores nulos.");
    }

    $query = "SELECT * FROM desks WHERE spaceId = " . $spaceId . " AND number = " . $number;
    $con = new CoworkingSQL ();
    if ($con->conectar()) {
      $res = $con->obtener_elemento ($query);
      $con->desconectar();
    }
    else
      throw new Exception ("Ha ocurrido un error al conectar a la base de datos.");

    $d = null;
    if ($res !== 0) {
      $d = new Desk ($res['spaceId'], $res['number'], $res['type'], $res['price']);
    }

    return $d;

  }
  
  public static function getAllDesksBySpaceId ($spaceId) {
    if ($spaceId == 0)
    	throw new Exception ("No existe el elemento de tipo Space con identificadores nulos.");	

    $query = "SELECT * FROM desks WHERE spaceId = " . $spaceId;
    $con = new CoworkingSQL();
    if ($con->conectar()) {
    	$res = $con->consultar ($query);
    	$con->desconectar();
    }
    
    $desks = array();
    if ($res[0] > 0) {
    	for ($i = 1; $i <= $res[0]; ++$i)
    		array_push ($desks, new Desk ($res[$i]['spaceId'], $res[$i]['number'], $res[$i]['type'], $res[$i]['price']));
    }
  }

  public static function getFreeDesks ($spaceId) {
  	if ($spaceId == 0)
  		throw new Exception ("No existe el elemento de tipo Space con identificadores nulos.");
  	
  	$query = "SELECT COUNT(*) FROM desks WHERE spaceId = " . $spaceId . " AND NOT EXISTS (SELECT * FROM reservation WHERE)";
  	$con = new CoworkingSQL();
  	if ($con->conectar()) {
  		$res = $con->consultar ($query);
  		$con->desconectar();
  	}
  	
  	$desks = array();
  	if ($res[0] > 0) {
  		for ($i = 1; $i <= $res[0]; ++$i)
  			array_push ($desks, new Desk ($res[$i]['spaceId'], $res[$i]['number'], $res[$i]['type'], $res[$i]['price']));
  	}	
  }
}

?>