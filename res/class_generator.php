<?php

error_reporting(E_ALL ^ E_NOTICE);

if (isset($_POST['generate'])) {

	header ("Content-type: text/plain");

	/* PHP Class Generator */
	/* Abel Elbaile        */
	
	$root_path      = $_POST['root_path'];					// root_path      -> Path desde el DOCUMENT_ROOT hasta carpeta de datos
	$require_once   = $_POST['require_once'];				// require_once   -> Lista de dependencias con la ruta absoluta desde la carpeta de datos
	$class_name			= $_POST['class_name'];					// class_name     -> Nombre de la clase
  $private_params = $_POST['private_params'];			// private_params -> Lista de los parametros privados de la clase
  
  $db_table       = $_POST['db_table'];						// db_table       -> Nombre de la tabla de la base de datos sobre la cual trabaja la clase
  $primary_key    = $_POST['primary_key'];        // primary_key    -> Valor a comprobar antes de una operacion sobre la BD.
	$default_value  = $_POST['default_value'];
	$db_class       = $_POST['db_class'];
	
  // Tratamiento de variables
  $pks = explode(',', $primary_key);
  for ($i = 0; $i < count($pks); ++$i) if ($pks[$i][0] == " ") $pks[$i] = substr ($pks[$i], 1);
	
	$def = explode(',', $default_value);
  for ($i = 0; $i < count($def); ++$i) if ($def[$i][0] == " ") $def[$i] = substr ($def[$i], 1);
  
  $par = explode (',', $private_params);
	for ($i = 0; $i < count($par); $i++) {
	  if ($par[$i][0] == " ") $par[$i] = substr ($par[$i], 1);
	}
  
  $pri = explode (',', $private_params);
	for ($i = 0; $i < count($pri); $i++) if ($pri[$i][0] == " ") $pri[$i] = substr ($pri[$i], 1);
	  
  if ($root_path != "" and substr($root_path, -1) != '/') $root_path .= '/';

  
  // Document start
  echo "<?php" . "\n\n";
  
  // Includes / Requires
  $reqs = explode (',', $require_once);
  if (count($reqs) == 1 and $reqs[0] == "") unset ($reqs[0]);
  for ($i = 0; $i < count($reqs); $i++) {
  	if ($reqs[$i][0] == " ") $reqs[$i] = substr ($reqs[$i], 1);
  	$ext = ".php";
  	if (substr ($reqs[$i], -4) == ".php") $ext = "";
    echo "require_once (\$_SERVER['DOCUMENT_ROOT'] . \"/" . $root_path . $reqs[$i] . $ext ."\")". ";" . "\n";
  }
  
	if (count($reqs) > 0) echo "\n\n";

	// Documentacion
	echo "/**" . "\n";
  echo "* Clase:       " . $class_name . "\n";
  echo "* Autor:       " . "Abel Elbaile" . "\n";
  echo "*"               . "\n";
  echo "* Descripcion: " . "\n";
  echo "*              " . "\n";
  echo "*              " . "\n";
  echo "* Atributos:   ";
  for ($i = 0; $i < count($pri); ++$i) {
    echo $pri[$i] . ": " . "\n";
  	if ($i < count($pri) - 1) echo "*              ";
  }
  echo "*/" . "\n" . "\n";


	// Class header	
	echo "class " . $class_name . " {" . "\n\n";


	// Public/private params
	for ($i = 0; $i < count($pri); $i++) {
		echo "  " . "private \$_" . $pri[$i] . ";\n";
	}
	
	echo "\n";


	// Constructor
	$c = "  " . "public function __construct (";
	for ($i = 0; $i < count($pri); $i++) {
		$c .= "\$" . $pri[$i];
		if ($i < count($pri)-1) $c .= ", ";
	}
	$c .= ')';
	
	echo $c . " {" . "\n";
	for ($i = 0; $i < count($pri); $i++) {
		echo "    " . "is_null(\$" . $pri[$i] . ") or " . "\$" . $pri[$i] . " === \"\" or " . "\$" . $pri[$i] . " === 0 ? \$this->_" . $pri[$i] . " = \"\" : \$this->_" . $pri[$i] . " = \$" . $pri[$i] . ";" . "\n";
	}
	echo "  " . '}';

	echo "\n\n";
	
	// Getters
	for ($i = 0; $i < count($pri); $i++) {
		echo "  " . "public function get_" . $pri[$i] . " () {" . "\n";
		echo "    " . "return \$this->_" . $pri[$i] . ";" . "\n";
		echo "  " . "}" . "\n\n";
	}
	
	echo "\n";
	
	// Setters
	for ($i = 0; $i < count($pri); $i++) {
	  if (array_search($pri[$i], $pks) === false) {
		  echo "  " . "public function set_" . $pri[$i] . " (\$" . $pri[$i] . ") {" . "\n";
		  echo "    " . "\$this->_" . $pri[$i] . " = $" . $pri[$i] . ";" . "\n";
		  echo "  " . "}" . "\n\n";
		}
	}


	echo "\n" . "}";
	
	
	echo "\n\n\n";
	
	/***** DATA MAPPER *****/
	
	$obj = "\$" . strtolower (substr ($class_name, 0, 1));
	
	// Class header
	echo "class " . $class_name . "DataMapper" . " {" . "\n\n";

	// Insert
	echo "  " . "public static function insert (" . $obj . ") {" . "\n";
	
	// Primary keys
	
	echo "    " . "if (";
	for ($i = 0; $i < count ($pks); $i++) {
		echo $obj . "->get_" . $pks[$i] . "() ";
		if (isset($def[$i]) && is_numeric($def[$i]) && $def[$i] != "") echo "> " . $def[$i];
		else echo "== \"".$def[$i]."\"";
		if ($i < count($pks)-1) echo " or ";
	}
	echo ") {" . "\n";
  echo "      " . "throw new Exception (\"No puede insertarse el elemento de tipo " . $class_name . " con id = \" . " . $obj . "->get_" . $pks[0] . "() . \".\");" . "\n";
	echo "    " . "}" . "\n";
	echo "\n";
	echo "    " . "\$query = \"INSERT INTO " . $db_table . " VALUES ('\" . " . $obj . "->" . "get_" . $pri[0] . "() . \"', '\"" . "\n";
	for ($i = 1; $i < count ($pri); $i++) {
		for ($j = 0; $j < 38 + strlen($db_table); ++$j) echo " ";
    echo ". " . $obj . "->get_" . $par[$i] . "()";
	  if ($i < count($pri)-1) echo " . \"', '\"";
	  else echo ". \"')\";";
	  echo "\n";
	}
	
	echo "\n";
	echo "    " . "\$con = new " . $db_class . " ();" . "\n";
  echo "    " . "if (\$con->conectar()) {" . "\n";
  echo "      " . "if (!\$con->ejecutar(\$query))" . "\n";
  echo "        " . "throw new Exception (\"Ha ocurrido un error al insertar el elemento en la base de datos.\");" . "\n";
	echo "      " . $obj . "id = mysql_insert_id();" . "\n";
	echo "      " . "\$con->desconectar();" . "\n";
	echo "    " . "}" . "\n";
	echo "    " . "else" . "\n";
	echo "      " . "throw new Exception (\"Ha ocurrido un error al conectar a la base de datos.\");" . "\n";
	echo "\n";
	echo "    " . "return " . $obj . "id;" . "\n";
	echo "\n";
	echo "  " . "}" . "\n";
	
	echo "\n";

	// Update
	echo "  " . "public static function update (" . $obj . ") {" . "\n";
	echo "    " . "if (";
	for ($i = 0; $i < count ($pks); ++$i) {
		echo $obj . "->get_" . $pks[$i] . "() == ";
		if (isset($def[$i]) && is_numeric($def[$i]) && $def[$i] != "") echo $def[$i];
		else echo "\"".$def[$i]."\"";
		if ($i < count($pks)-1) echo " or ";
	}
	echo ") {" . "\n";
  echo "      " . "throw new Exception (\"No puede actualizarse el elemento de tipo " . $class_name . " con identificadores nulos.\");" . "\n";
	echo "    " . "}" . "\n";
	echo "\n";
	
	// Obtener parametros modificables (no primary keys)

	$params;
	$j = 0;
	for ($i = 0; $i < count($par); ++$i) {
		$pos = array_search ($par[$i], $pks);
		if ($pos === false) {
			$params[$j] = $par[$i];
			$j++;
		}
	}
	
	echo "    " . "\$query = \"UPDATE " . $db_table . " SET " . $params[0] . " = '\" . " . $obj . "->get_" . $params[0] . "() . \"', \" ." . "\n";

	for ($i = 1; $i < count ($params); $i++) {
		if (!isset($params[$i])) continue;
		for ($j = 0; $j < 25 + strlen($db_table); ++$j) echo " ";
    echo "\"" . $params[$i] . " = '\" . " . $obj . "->get_" . $params[$i] . "()";
	  if ($i < count($params)-1) echo " . \"', \" .";
	  else {
	  	echo " . \"' WHERE ("; 
	  	for ($k = 0; $k < count ($pks); ++$k) {
	  		echo $pks[$k] . " = \" . " . $obj . "->get_" . $pks[$k] . "() . \"";
	  		if ($k < count ($pks)-1) echo " AND ";
	  	}
	  	echo ")\";" . "\n";;
	  }
	  echo "\n";
	}
	
	echo "\n";
	echo "    " . "\$con = new " . $db_class . " ();" . "\n";
  echo "    " . "if (\$con->conectar()) {" . "\n";
  echo "      " . "if (!\$con->ejecutar(\$query))" . "\n";
  echo "        " . "throw new Exception (\"Ha ocurrido un error al actualizar el elemento en la base de datos.\");" . "\n";
	echo "      " . "\$con->desconectar();" . "\n";
	echo "    " . "}" . "\n";
	echo "    " . "else" . "\n";
	echo "      " . "throw new Exception (\"Ha ocurrido un error al conectar a la base de datos.\");" . "\n";
	echo "\n";
	echo "  " . "}" . "\n";
	
	echo "\n";
	
	// Delete
	echo "  " . "public static function delete (" . $obj . ") {" . "\n";
	echo "    " . "if (";
	for ($i = 0; $i < count ($pks); $i++) {
		echo $obj . "->get_" . $pks[$i] . "() == ";
		if (isset($def[$i]) && is_numeric($def[$i]) && $def[$i] != "") echo $def[$i];
		else echo "\"".$def[$i]."\"";
		if ($i < count($pks)-1) echo " or ";
	}
	echo ") {" . "\n";
  echo "      " . "throw new Exception (\"No se puede eliminar el elemento de tipo " . $class_name . " con identificadores nulos.\");" . "\n";
	echo "    " . "}" . "\n";
	echo "\n";
	
	echo "    " . "\$query = \"DELETE FROM " . $db_table . " WHERE (";
	for ($k = 0; $k < count ($pks); ++$k) {
		echo $pks[$k] . " = \" . " . $obj . "->get_" . $pks[$k] . "() . \"";
		if ($k < count ($pks)-1) echo " AND ";
	}
	echo ")\";" . "\n";
	
	echo "\n";
	echo "    " . "\$con = new " . $db_class . " ();" . "\n";
  echo "    " . "if (\$con->conectar()) {" . "\n";
  echo "      " . "if (!\$con->ejecutar(\$query))" . "\n";
  echo "        " . "throw new Exception (\"Ha ocurrido un error al eliminar el elemento de la base de datos.\");" . "\n";
	echo "      " . "\$con->desconectar();" . "\n";
	echo "    " . "}" . "\n";
	echo "    " . "else" . "\n";
	echo "      " . "throw new Exception (\"Ha ocurrido un error al conectar a la base de datos.\");" . "\n";
	echo "\n";
	echo "  " . "}" . "\n";
	
	echo "\n";
	
	// getElementById
	
  echo "  " . "public static function get" . $class_name . "ById (";
  for ($i = 0; $i < count ($pks); $i++) {
		echo "$" . $pks[$i];
		if ($i < count($pks)-1) echo ", ";
	}
  echo ") {" . "\n";
  echo "    " . "if (";
	for ($i = 0; $i < count ($pks); $i++) {
		echo "$" . $pks[$i] . " == ";
		if (isset($def[$i]) && is_numeric($def[$i]) && $def[$i] != "") echo $def[$i];
		else echo "\"".$def[$i]."\"";
		if ($i < count($pks)-1) echo " or ";
	}
	echo ") {" . "\n";
  echo "      " . "throw new Exception (\"No existe el elemento de tipo " . $class_name . " con identificadores nulos.\");" . "\n";
	echo "    " . "}" . "\n";
	echo "\n";
	
	// QUERY
	echo "    " . "\$query = \"SELECT * FROM " . $db_table . " WHERE ";
	for ($i = 0; $i < count ($pks); $i++) {
		echo $pks[$i] . " = \" . $" . $pks[$i]; 
		if ($i < count($pks)-1) echo  " . \" AND ";
		else echo ";";
	}
	echo "\n";
	
	
	echo "    " . "\$con = new " . $db_class . " ();" . "\n";
  echo "    " . "if (\$con->conectar()) {" . "\n";
  echo "      " . "\$res = \$con->obtener_elemento (\$query);" . "\n";
  echo "      " . "\$con->desconectar();" . "\n";
	echo "    " . "}" . "\n";
	echo "    " . "else" . "\n";
	echo "      " . "throw new Exception (\"Ha ocurrido un error al conectar a la base de datos.\");" . "\n";
	echo "\n";
	echo "    " . $obj . " = null;" . "\n";
  echo "    " . "if (\$res !== 0) {" . "\n";
  echo "      " . $obj . " = new " . $class_name . " (";
  for ($i = 0; $i < count($pri); $i++) {
    echo "\$res['".$pri[$i]."']";
    if ($i < count($pri)-1) echo ", ";
  }
  echo ");" . "\n";
  echo "    " . "}" . "\n";
  echo "\n";
	echo "    " . "return " . $obj . ";" . "\n";
  echo "\n";
	echo "  " . "}" . "\n";

	
	
	// Fin clase y documento
	
	echo "\n";
	echo "}" . "\n";
	echo "\n";
	echo "?>";
	
}
else {

?>

<html>
  <head>
    <title>PHP Class Generator</title>
  </head>
  <body>
    <form name="classgenerator" action="class_generator.php" method="post">
    	<p><b>Class:</b></p>
      <label>Class name: <input type="text" name="class_name" /></label><br />
      <label>Require once: <input type="text" name="require_once" /></label><br />
      <label>Private params: <input type="text" name="private_params" /></label><br />
      
      <p><b>Paths:</b></p>
      <label>Root path: <input type="text" name="root_path" /></label><br />
      
      <p><b>DB:</b></p>
      <label>Database connection class: <input type="text" name="db_class" value="MySQLConnection_" /></label><br />
      <label>Primarky key(s): <input type="text" name="primary_key" /></label><br />
      <label>Default/'0' Value(s): <input type="text" name="default_value" /></label><br />
      <label>Table name: <input type="text" name="db_table" /></label><br />
      
      <input type="hidden" name="generate" value="1" />
      <input type="submit" value="Generate!" />
    </form>
  </body>
</html>

<?php
}
?>