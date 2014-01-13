<?php

require_once ($_SERVER['DOCUMENT_ROOT'] . "/coworking/data/paths.config.php");
require_once (SQL_PATH . "coworking.sql.class.php");


/**
* Clase:       Feature
* Autor:       Abel Elbaile
*
* Descripcion: 
*              
*              
* Atributos:   id: 
*              name: 
*              description: 
*/

class Feature {

  private $_id;
  private $_name;
  private $_description;

  public function __construct ($id, $name, $description) {
    is_null($id) or $id === "" or $id === 0 ? $this->_id = "" : $this->_id = $id;
    is_null($name) or $name === "" or $name === 0 ? $this->_name = "" : $this->_name = $name;
    is_null($description) or $description === "" or $description === 0 ? $this->_description = "" : $this->_description = $description;
  }

  public function get_id () {
    return $this->_id;
  }

  public function get_name () {
    return $this->_name;
  }

  public function get_description () {
    return $this->_description;
  }


  public function set_name ($name) {
    $this->_name = $name;
  }

  public function set_description ($description) {
    $this->_description = $description;
  }

  public function toXML () {
  	$xml  = "<feature id=\"". $this->_id . "\">";
  	$xml .= "  <name>" . $this->_name . "</name>";
  	$xml .= "  <description>" . $this->_description . "</description>";
  	$xml .= "</feature>";
  	return $xml;
  }
  
}


class FeatureDataMapper {

  public static function insert ($f) {
    if ($f->get_id() > 0) {
      throw new Exception ("No puede insertarse el elemento de tipo Feature con id = " . $f->get_id() . ".");
    }

    $query = "INSERT INTO features VALUES ('" . $f->get_id() . "', '"
                                              . $f->get_name() . "', '"
                                              . $f->get_description(). "')";

    $con = new CoworkingSQL ();
    if ($con->conectar()) {
      if (!$con->ejecutar($query))
        throw new Exception ("Ha ocurrido un error al insertar el elemento en la base de datos.");
      $fid = mysql_insert_id();
      $con->desconectar();
    }
    else
      throw new Exception ("Ha ocurrido un error al conectar a la base de datos.");

    return $fid;

  }

  public static function update ($f) {
    if ($f->get_id() == 0) {
      throw new Exception ("No puede actualizarse el elemento de tipo Feature con identificadores nulos.");
    }

    $query = "UPDATE features SET name = '" . $f->get_name() . "', " .
                                 "description = '" . $f->get_description() . "' WHERE (id = " . $f->get_id() . ")";


    $con = new CoworkingSQL ();
    if ($con->conectar()) {
      if (!$con->ejecutar($query))
        throw new Exception ("Ha ocurrido un error al actualizar el elemento en la base de datos.");
      $con->desconectar();
    }
    else
      throw new Exception ("Ha ocurrido un error al conectar a la base de datos.");

  }

  public static function delete ($f) {
    if ($f->get_id() == 0) {
      throw new Exception ("No se puede eliminar el elemento de tipo Feature con identificadores nulos.");
    }

    $query = "DELETE FROM features WHERE (id = " . $f->get_id() . ")";

    $con = new CoworkingSQL ();
    if ($con->conectar()) {
      if (!$con->ejecutar($query))
        throw new Exception ("Ha ocurrido un error al eliminar el elemento de la base de datos.");
      $con->desconectar();
    }
    else
      throw new Exception ("Ha ocurrido un error al conectar a la base de datos.");

  }

  public static function getFeatureById ($id) {
    if ($id == 0) {
      throw new Exception ("No existe el elemento de tipo Feature con identificadores nulos.");
    }

    $query = "SELECT * FROM features WHERE id = " . $id;
    $con = new CoworkingSQL ();
    if ($con->conectar()) {
      $res = $con->obtener_elemento ($query);
      $con->desconectar();
    }
    else
      throw new Exception ("Ha ocurrido un error al conectar a la base de datos.");

    $f = null;
    if ($res !== 0) {
      $f = new Feature ($res['id'], $res['name'], $res['description']);
    }

    return $f;

  }
  
  public static function getFeaturesBySpaceId ($id) {
  	if ($id == 0) {
  		throw new Exception ("No existe el elemento de tipo Space con identificadores nulos.");
  	}
  
  	$query = "SELECT f.id AS id, f.name AS name, f.description AS description FROM features f, space_features sf WHERE f.id = sf.featureId AND sf.spaceId = " . $id;
  	
  	$con = new CoworkingSQL ();
  	if ($con->conectar()) {
  		$res = $con->consultar ($query);
  		$con->desconectar();
  	}
  	else
  		throw new Exception ("Ha ocurrido un error al conectar a la base de datos.");
  
  	$features = array();
  	if ($res[0] > 0) {
  		for ($i = 1; $i <= $res[0]; ++$i)
  		  array_push ($features, new Feature ($res[$i]['id'], $res[$i]['name'], $res[$i]['description'])); 
  	}
  
  	return $features;
  }
  
  public static function getAllFeatures () {
  
  	$query = "SELECT * FROM features";
  	$con = new CoworkingSQL ();
  	if ($con->conectar()) {
  		$res = $con->consultar ($query);
  		$con->desconectar();
  	}
  	else
  		throw new Exception ("Ha ocurrido un error al conectar a la base de datos.");
  
  	$features = array();
  	if ($res[0] > 0) {
  		for ($i = 1; $i <= $res[0]; ++$i)
  		  array_push ($features, new Feature ($res[$i]['id'], $res[$i]['name'], $res[$i]['description'])); 
  	}
  
  	return $features;
  
  }
}

?>