<?php

  require_once ($_SERVER['DOCUMENT_ROOT'] . "/coworking/data/paths.config.php");

?>
  <div class="register">
		<form class="form-horizontal" action="api/coworkers/new.php" method="post">
		  <fieldset>
		    <div id="legend">
		      <legend class="">Register</legend>
		    </div>
		    <div class="control-group">
		      <!-- Name -->
		      <label class="control-label"  for="name">Name</label>
		      <div class="controls">
		        <input type="text" id="name" name="name" placeholder="Your name" class="form-control" required autofocus>
		      </div>
		    </div>
		    <div class="control-group">
		      <!-- Last name -->
		      <label class="control-label"  for="lastName">Lastname</label>
		      <div class="controls">
		        <input type="text" id="lastName" name="lastName" placeholder="Your lastname" class="form-control" required>
		      </div>
		    </div>
		    <div class="control-group">
		      <!-- Mail -->
		      <label class="control-label"  for="mail">E-mail</label>
		      <div class="controls">
		        <input type="text" id="mail" name="mail" placeholder="Your e-mail address" class="form-control" required>
		      </div>
		    </div>
		    <div class="control-group">
		      <!-- Username -->
		      <label class="control-label"  for="username">Username</label>
		      <div class="controls">
		        <input type="text" id="username" name="username" placeholder="" class="form-control">
		        <p class="help-block">Username can contain any letters or numbers, without spaces</p>
		      </div>
		    </div>
		 
		    <div class="control-group">
		      <!-- Password-->
		      <label class="control-label" for="password">Password</label>
		      <div class="controls">
		        <input type="password" id="password" name="password" placeholder="" class="form-control">
		        <p class="help-block">Password should be at least 4 characters</p>
		      </div>
		    </div>
		 
		    <div class="control-group">
		      <!-- Button -->
		      <div class="controls">
		        <button class="btn btn-success">Register</button>
		      </div>
		    </div>
		  </fieldset>
		</form>
  </div>