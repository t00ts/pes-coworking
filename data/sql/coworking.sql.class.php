<?php

require_once ("conexionDB.MySQL.class.php");

class CoworkingSQL extends ConexionDB_MySQL
{

    protected $user = "coworker";
    protected $pwd  = "c0w0rk1ng";
    protected $host = "localhost";
    protected $dbname = "greenhou_coworking";

    public function __construct () 
    {
        parent::__construct ($this->user, $this->pwd, $this->host, $this->dbname);
    }

}


?>
