<?php 

require_once ($_SERVER['DOCUMENT_ROOT'] . "/coworking/data/paths.config.php");
require_once (DATA_PATH . "session.class.php");
require_once (DATA_PATH . "space.class.php");

session_name ("coworking");
session_start ();

$promotedSpaces = array (
	SpaceDataMapper::getSpaceById (100),
	SpaceDataMapper::getSpaceById (101),
	SpaceDataMapper::getSpaceById (102)
);

$usr = null;
if (isset($_SESSION['session_id'])) {
  $usr = SessionDataMapper::getUserFromSession ($_SESSION['session_id']);
	if (!is_null($usr)) $spaces = SpaceDataMapper::getSpacesByOwnerId ($usr->get_id());
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Abel Elbaile">

    <title>Coworking Network</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

    <!-- Custom styles -->
    <link href="css/carousel.css" rel="stylesheet">
    <link href="css/login.css" rel="stylesheet">
    
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>

    </head>
<!-- NAVBAR
================================================== -->
  <body>
    
    <!-- Fixed navbar -->
    <div class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="container">
        
        <!-- Brand -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="?s=home">Coworking Network</a>
        </div>
        
        <!--  Search box -->
        <form class="navbar-form navbar-left" role="search" method="post" action="index.php?s=search">
    			<div class="form-group">
            <input type="text" class="form-control" id="search-q" name="q" placeholder="Your new workspace is one search away..." style="width:500px" <?php if (isset($_POST['q'])) echo "value=\"" . $_POST['q'] . "\"" ?> />
    			</div>
    			<button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span></button>
				</form>
        
        <!-- My account -->
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav pull-right">
            <li class="dropdown">
              <?php if (is_null($usr)) { ?>
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">My account<b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="?s=login">Sign in</a></li>
                <li><a href="?s=register">Register</a></li>
              </ul>
              <?php } else { ?>
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $usr->get_username(); ?><b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li class="dropdown-header">Your spaces</li>
                <?php 
                foreach ($spaces as $s) {
                  echo "<li><a href=\"?s=view-space&id=" . $s->get_id() . "\">" . $s->get_name() . "</a></li>";
                } 
                ?>
                <li><a href="?s=new-space">Add new space</a></li>
                <li class="divider"></li>
                <li><a href="logout.php">Log out</a></li>
              </ul>
              <?php } ?>
            </li>
          </ul>
        
        </div>
        
      </div>
    </div>
  
    <div class="container" style="margin-top:10px !important; margin-bottom: 50px; padding-top: 40px;">
    <?php 
    if (isset($_GET['s'])) {
      if (empty($_GET['s']) || $_GET['s'] === "") include ("pages/home.php");
      elseif (file_exists("pages/" . $_GET['s'] . ".php")) include ("pages/" . $_GET['s'] . ".php");
      else echo "The page you're looking for doesn't exist. Please go <a href=\"?=home\">home</a>";
    }
    else include ("pages/home.php");
    ?>
    </div>
    
    <!-- FOOTER -->
    <div class="container">
	    <footer>
	      <p class="pull-right"><a href="#">Back to top</a></p>
	      <p>&copy; 2014 Coworking Network, Inc. &middot; <a href="#">Privacy</a> &middot; <a href="#">Terms</a></p>
	    </footer>
    </div>
    
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.dataTables.js"></script>
  </body>
</html>