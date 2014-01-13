<?php

require_once ($_SERVER['DOCUMENT_ROOT'] . "/coworking/data/paths.config.php");
require_once (SQL_PATH . "coworking.sql.class.php");


/**
* Clase:       Space
* Autor:       Abel Elbaile
*
* Descripcion: 
*              
*              
* Atributos:   id: 
*              name: 
*              description: 
*              phoneNumber: 
*              website: 
*              address: 
*              zip: 
*              country: 
*              ownerId: 
*/

class Space {

  private $_id;
  private $_name;
  private $_description;
  private $_phoneNumber;
  private $_website;
  private $_address;
  private $_zip;
  private $_city;
  private $_country;
  private $_ownerId;

  public function __construct ($id, $name, $description, $phoneNumber, $website, $address, $zip, $city, $country, $ownerId) {
    is_null($id) or $id === "" or $id === 0 ? $this->_id = "" : $this->_id = $id;
    is_null($name) or $name === "" or $name === 0 ? $this->_name = "" : $this->_name = $name;
    is_null($description) or $description === "" or $description === 0 ? $this->_description = "" : $this->_description = $description;
    is_null($phoneNumber) or $phoneNumber === "" or $phoneNumber === 0 ? $this->_phoneNumber = "" : $this->_phoneNumber = $phoneNumber;
    is_null($website) or $website === "" or $website === 0 ? $this->_website = "" : $this->_website = $website;
    is_null($address) or $address === "" or $address === 0 ? $this->_address = "" : $this->_address = $address;
    is_null($zip) or $zip === "" or $zip === 0 ? $this->_zip = "" : $this->_zip = $zip;
    is_null($city) or $city === "" or $city === 0 ? $this->_city = "" : $this->_city = $city;
    is_null($country) or $country === "" or $country === 0 ? $this->_country = "" : $this->_country = $country;
    is_null($ownerId) or $ownerId === "" or $ownerId === 0 ? $this->_ownerId = "" : $this->_ownerId = $ownerId;
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

  public function get_phoneNumber () {
    return $this->_phoneNumber;
  }

  public function get_website () {
    return $this->_website;
  }

  public function get_address () {
    return $this->_address;
  }

  public function get_zip () {
    return $this->_zip;
  }

  public function get_city () {
    return $this->_city;
  }

  public function get_country () {
    return $this->_country;
  }

  public function get_ownerId () {
    return $this->_ownerId;
  }


  public function set_name ($name) {
    $this->_name = $name;
  }

  public function set_description ($description) {
    $this->_description = $description;
  }

  public function set_phoneNumber ($phoneNumber) {
    $this->_phoneNumber = $phoneNumber;
  }

  public function set_website ($website) {
    $this->_website = $website;
  }

  public function set_address ($address) {
    $this->_address = $address;
  }

  public function set_zip ($zip) {
    $this->_zip = $zip;
  }

  public function set_city ($city) {
    $this->_city = $city;
  }

  public function set_country ($country) {
    $this->_country = $country;
  }

  public function set_ownerId ($ownerId) {
    $this->_ownerId = $ownerId;
  }

  public function toXML () {
  	$xml = "<space id=\"" . $this->_id . "\">";
  	$xml .= "<name>" . $this->_name . "</name>";
  	$xml .= "<description>" . $this->_description . "</description>";
  	$xml .= "<phoneNumber>" . $this->_phoneNumber . "</phoneNumber>";
  	$xml .= "<website>" . $this->_website . "</website>";
  	$xml .= "<address>" . $this->_address . "</address>";
  	$xml .= "<zip>" . $this->_zip . "</zip>";
  	$xml .= "<city>" . $this->_city . "</city>";
  	$xml .= "<country>" . $this->_country . "</country>";
  	$xml .= "<ownerId>" . $this->_ownerId . "</ownerId>";
  	$xml .= "</space>";
  	return $xml;
  }

  public function toXMLwPrice () {
  	$xml = "<space id=\"" . $this->_id . "\">";
  	$xml .= "<name>" . $this->_name . "</name>";
  	$xml .= "<description>" . $this->_description . "</description>";
  	$xml .= "<minPrice>" . $this->_ownerId . "</minPrice>";
  	$xml .= "</space>";
  	return $xml;
  }
  
}


class SpaceDataMapper {

  public static function insert ($s) {
    if ($s->get_id() > 0) {
      throw new Exception ("No puede insertarse el elemento de tipo Space con id = " . $s->get_id() . ".");
    }

    $query = "INSERT INTO spaces VALUES ('" . $s->get_id() . "', '"
                                            . $s->get_name() . "', '"
                                            . $s->get_description() . "', '"
                                            . $s->get_phoneNumber() . "', '"
                                            . $s->get_website() . "', '"
                                            . $s->get_address() . "', '"
                                            . $s->get_zip() . "', '"
                                            . $s->get_city() . "', '"
                                            . $s->get_country() . "', '"
                                            . $s->get_ownerId(). "')";

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
    if ($s->get_id() == 0) {
      throw new Exception ("No puede actualizarse el elemento de tipo Space con identificadores nulos.");
    }

    $query = "UPDATE spaces SET name = '" . $s->get_name() . "', " .
                               "description = '" . $s->get_description() . "', " .
                               "phoneNumber = '" . $s->get_phoneNumber() . "', " .
                               "website = '" . $s->get_website() . "', " .
                               "address = '" . $s->get_address() . "', " .
                               "zip = '" . $s->get_zip() . "', " .
                               "country = '" . $s->get_city() . "', " .
                               "country = '" . $s->get_country() . "', " .
                               "ownerId = '" . $s->get_ownerId() . "' WHERE (id = " . $s->get_id() . ")";


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
    if ($s->get_id() == 0) {
      throw new Exception ("No se puede eliminar el elemento de tipo Space con identificadores nulos.");
    }

    $query = "DELETE FROM spaces WHERE (id = " . $s->get_id() . ")";

    $con = new CoworkingSQL ();
    if ($con->conectar()) {
      if (!$con->ejecutar($query))
        throw new Exception ("Ha ocurrido un error al eliminar el elemento de la base de datos.");
      $con->desconectar();
    }
    else
      throw new Exception ("Ha ocurrido un error al conectar a la base de datos.");

  }

  public static function getSpaceById ($id) {
    if ($id == 0) {
      throw new Exception ("No existe el elemento de tipo Space con identificadores nulos.");
    }

    $query = "SELECT * FROM spaces WHERE id = " . $id;
    $con = new CoworkingSQL ();
    if ($con->conectar()) {
      $res = $con->obtener_elemento ($query);
      $con->desconectar();
    }
    else
      throw new Exception ("Ha ocurrido un error al conectar a la base de datos.");

    $s = null;
    if ($res !== 0) {
      $s = new Space ($res['id'], $res['name'], $res['description'], $res['phoneNumber'], $res['website'], $res['address'], $res['zip'], $res['city'], $res['country'], $res['ownerId']);
    }

    return $s;

  }

  public static function getSpacesByOwnerId ($id) {
  	if ($id == 0) {
  		throw new Exception ("No existe el elemento de tipo Space con identificadores nulos.");
  	}
  
  	$query = "SELECT * FROM spaces WHERE ownerId = " . $id;
  	$con = new CoworkingSQL ();
  	if ($con->conectar()) {
  		$res = $con->consultar ($query);
  		$con->desconectar();
  	}
  	else
  		throw new Exception ("Ha ocurrido un error al conectar a la base de datos.");
  
  	$spaces = array();
  	if ($res[0] > 0) {
  		for ($i = 1; $i <= $res[0]; ++$i)
  		  array_push ($spaces, new Space ($res[$i]['id'], $res[$i]['name'], $res[$i]['description'], $res[$i]['phoneNumber'], $res[$i]['website'], $res[$i]['address'], $res[$i]['zip'], $res[$i]['city'], $res[$i]['country'], $res[$i]['ownerId']));
  	}
  
  	return $spaces;
  
  }
  
  public static function addFeatureToSpace ($spaceId, $featureId) {
  	if ($spaceId == 0 || $featureId == 0)
  		throw new Exception ("Either spaceId or featureId missing");
  	
  	$query = "INSERT INTO space_features VALUES (" . $spaceId . ", " . $featureId . ")";
  	
  	$con = new CoworkingSQL ();
  	if ($con->conectar()) {
  		if (!$con->ejecutar($query))
  			throw new Exception ("Ha ocurrido un error al insertar el elemento en la base de datos.");
  		$con->desconectar();
  	}
  	else
  		throw new Exception ("Ha ocurrido un error al conectar a la base de datos.");
  	 
  }
  

  public static function search ($q, $features) {

  		$query  = "SELECT s.id AS id, s.name AS name, s.description AS description, MIN(d.price) AS minPrice ";
  		$query .= "FROM spaces s, space_features sf, desks d WHERE ";
  		if ($q != "") {
  			$query .= "(name LIKE '%" . $q . "%' OR description LIKE '%" . $q . "%' OR city LIKE '%" . $q . "%') AND ";
  		} 
  		if (isset($_POST['city']) && $_POST['city'] != "") {
  			$query .= "s.city LIKE '%". $_POST['city'] ."%' AND ";
  		}
  		$query .= " s.id = sf.spaceId AND ";
  		$query .= " s.id = d.spaceId ";
  		if (!is_null($features) && !empty($features)) {
  			$query .= "AND ";
	  		foreach ($features as $fid) {
	  			$query .= " EXISTS (SELECT sf.featureId FROM space_features sf WHERE sf.featureId = ". $fid . " AND sf.spaceId = s.id) AND ";
	  	  }
	  	  $query .= "1 ";
  		}
	  	$query .= "GROUP BY s.id";
	  	
	  	$con = new CoworkingSQL ();
  	  if ($con->conectar ()) {
  	  	$res = $con->consultar ($query);
  	  	$con->desconectar();
  	  }
  	   
  	  $results = array();
  	  if ($res[0] > 0) {
  	  	for ($i = 1; $i <= $res[0]; ++$i)
  	  		array_push ($results, new Space ($res[$i]['id'], $res[$i]['name'], $res[$i]['description'], null, null, null, null, null, null, $res[$i]['minPrice']));
  	  }
  	   
  	  return $results;
  	
  }
  
  public static function getPrices ($spaceId) {
  	if ($spaceId == 0)
  		throw new Exception ("Either spaceId or featureId missing");
  	 
  	$query = "SELECT DISTINCT type, price FROM desks WHERE spaceId = " . $spaceId;
  
  	$con = new CoworkingSQL ();
  	if ($con->conectar ()) {
  		$res = $con->consultar ($query);
  		$con->desconectar();
  	}
  	
  	$results = array();
  	if ($res[0] > 0) {
  		for ($i = 1; $i <= $res[0]; ++$i)
  		  $results[$res[$i]['type']] = $res[$i]['price'];
  	}
  	return $results;
  }
}

?>