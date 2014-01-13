<?php

require_once ("api/auth.class.php");

session_name ("coworking");
session_start ();

$error_html = "";

if (isset($_GET['auth']) and $_GET['auth'] == 1) {
	$usr = $_POST['cow_usr'];
	$pwd = $_POST['cow_pwd'];

	$auth = new Auth (AuthValidTypes::LOGIN);
	$auth->addLoginDetails ($usr, $pwd);

	$res = $auth->authenticate();
	
	if ($res !== false) {
		$_SESSION['session_id'] = $res;
		header ("Location: index.php?s=home");
		exit;
	}

	header ("Location: index.php?s=login&e=1");

}

?>