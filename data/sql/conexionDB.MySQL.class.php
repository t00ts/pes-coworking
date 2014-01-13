<?php

class ConexionDB_MySQL {

    protected $user;
    protected $pwd;
    protected $host;
    protected $dbname;
    protected $dbh;

    public function __construct ($user, $pwd, $host, $dbname) {
        $this->user = $user;
        $this->pwd = $pwd;
        $this->host = $host;
        $this->dbname = $dbname;
    }

    public function conectar () {
        $this->dbh = mysql_connect ($this->host, $this->user, $this->pwd);
        if ($this->dbh) {
            mysql_select_db($this->dbname, $this->dbh);
            mysql_set_charset('utf8', $this->dbh);
        }
        else {
            return false;
        }
        return true;
    }

    public function ejecutar ($query) {
        if ($query != "") {
            $result = mysql_query ($query, $this->dbh);
            if (!$result) {
                return false;
            }
        }
        $lastid = mysql_insert_id ($this->dbh);
        if ($lastid === 0) return true;
        else return $lastid;
    }
    
    public function obtener_elemento ($query) {
    /* Pre:  Las claves externas estan incluidas en la query, con lo que solo se tratar‡ la primera y,
             en teoria unica fila. */
    /* Post: Devuelve un array asociativo con la primera fila del resultado obtenido al ejecutar $query. */
    
    	if ($query == "") return 0;
    	$result = mysql_query ($query, $this->dbh) or die (mysql_error($this->dbh));
    	$res = mysql_fetch_assoc($result);
    	if (mysql_num_rows($result) == 0) $res = 0;
    	mysql_free_result($result);
    	return $res;

    }

    public function consultar ($query)
    {
        $i = 0;
        if ($query != "") {
            $result = mysql_query ($query, $this->dbh);
            if (!$result) {
                $data = "";
            }
            else {
                $data = array();
                $data[0] = 0;
                while ($row = mysql_fetch_array($result)) {
                    ++$data[0];
                    $data[$data[0]] = $row;
                }
            }
            return $data;
        }
        return 0;
    }

    public function desconectar () {
        mysql_close ($this->dbh);
    }

}

?>
