<?php
 
  $error_html = "";
  if (isset($_GET['e']) && $_GET['e'] == "1") {
  	$error_html = "<div class=\"error_message\">Incorrect username or password. Please try again.</div>";
  }

?>

<form class="form-signin" role="form" action="login.php?auth=1" method="post">
  <h2 class="form-signin-heading">Please sign in</h2>
  <?php echo $error_html; ?>
  <input type="text" class="form-control" name="cow_usr" placeholder="Username" required autofocus />
  <input type="password" class="form-control" name="cow_pwd" placeholder="Password" required />
  <label class="checkbox">
    <input type="checkbox" value="remember-me" /> Remember me
  </label>
  <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
</form>
