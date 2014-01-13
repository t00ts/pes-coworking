<?php

require_once ($_SERVER['DOCUMENT_ROOT'] . "/coworking/data/paths.config.php");
require_once (SQL_PATH . "coworking.sql.class.php");


/**
* Clase:       Country
* Autor:       Abel Elbaile
*
* Descripcion: 
*              
*              
* Atributos:   id: 
*              name: 
*              alpha_2: 
*              alpha_3: 
*/

class Country {

  private $_id;
  private $_name;
  private $_alpha_2;
  private $_alpha_3;

  public function __construct ($id, $name, $alpha_2, $alpha_3) {
    is_null($id) or $id === "" or $id === 0 ? $this->_id = "" : $this->_id = $id;
    is_null($name) or $name === "" or $name === 0 ? $this->_name = "" : $this->_name = $name;
    is_null($alpha_2) or $alpha_2 === "" or $alpha_2 === 0 ? $this->_alpha_2 = "" : $this->_alpha_2 = $alpha_2;
    is_null($alpha_3) or $alpha_3 === "" or $alpha_3 === 0 ? $this->_alpha_3 = "" : $this->_alpha_3 = $alpha_3;
  }

  public function get_id () {
    return $this->_id;
  }

  public function get_name () {
    return $this->_name;
  }

  public function get_alpha_2 () {
    return $this->_alpha_2;
  }

  public function get_alpha_3 () {
    return $this->_alpha_3;
  }


  public function set_name ($name) {
    $this->_name = $name;
  }

  public function set_alpha_2 ($alpha_2) {
    $this->_alpha_2 = $alpha_2;
  }

  public function set_alpha_3 ($alpha_3) {
    $this->_alpha_3 = $alpha_3;
  }


}


class CountryDataMapper {

  public static function insert ($c) {
    if ($c->get_id() > 0) {
      throw new Exception ("No puede insertarse el elemento de tipo Country con id = " . $c->get_id() . ".");
    }

    $query = "INSERT INTO country VALUES ('" . $c->get_id() . "', '"
                                             . $c->get_name() . "', '"
                                             . $c->get_alpha_2() . "', '"
                                             . $c->get_alpha_3(). "')";

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
      throw new Exception ("No puede actualizarse el elemento de tipo Country con identificadores nulos.");
    }

    $query = "UPDATE country SET name = '" . $c->get_name() . "', " .
                                "alpha_2 = '" . $c->get_alpha_2() . "', " .
                                "alpha_3 = '" . $c->get_alpha_3() . "' WHERE (id = " . $c->get_id() . ")";


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
      throw new Exception ("No se puede eliminar el elemento de tipo Country con identificadores nulos.");
    }

    $query = "DELETE FROM country WHERE (id = " . $c->get_id() . ")";

    $con = new CoworkingSQL ();
    if ($con->conectar()) {
      if (!$con->ejecutar($query))
        throw new Exception ("Ha ocurrido un error al eliminar el elemento de la base de datos.");
      $con->desconectar();
    }
    else
      throw new Exception ("Ha ocurrido un error al conectar a la base de datos.");

  }

  public static function getCountryById ($id) {
    if ($id == 0) {
      throw new Exception ("No existe el elemento de tipo Country con identificadores nulos.");
    }

    $query = "SELECT * FROM country WHERE id = " . $id;
    $con = new CoworkingSQL ();
    if ($con->conectar()) {
      $res = $con->obtener_elemento ($query);
      $con->desconectar();
    }
    else
      throw new Exception ("Ha ocurrido un error al conectar a la base de datos.");

    $c = null;
    if ($res !== 0) {
      $c = new Country ($res['id'], $res['name'], $res['alpha_2'], $res['alpha_3']);
    }

    return $c;

  }

  public static function getAllCountries () {
  	
  	$query = "SELECT * FROM countries";
  	
  	$con = new CoworkingSQL ();
  	if ($con->conectar()) {
  		$res = $con->consultar ($query);
  		$con->desconectar();
  	}
  	
  	$countries = array();
  	if ($res[0] > 0) {
  		for ($i = 1; $i <= $res[0]; ++$i) array_push ($countries, new Country ($res[$i]['id'], $res[$i]['name'], $res[$i]['alpha_2'], $res[$i]['alpha_3'])); 
  	}
  	
  	return $countries;
  	
  }
  
}

?>