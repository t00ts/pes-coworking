<?php

  require_once ($_SERVER['DOCUMENT_ROOT'] . "/coworking/data/paths.config.php");
  require_once (DATA_PATH . "country.class.php");
  require_once (DATA_PATH . "session.class.php");
  require_once (DATA_PATH . "coworker.class.php");
  require_once (DATA_PATH . "feature.class.php");
  
  $countries = CountryDataMapper::getAllCountries();

  $availableFeatures = FeatureDataMapper::getAllFeatures ();
  
  $session_id = $_SESSION['session_id'];
  $owner = SessionDataMapper::getUserFromSession ($session_id);

?>
    <style type="text/css">
      ul.feature-list > li {
        margin-top: 10px;
      }
      p.desks {
        font-size: 16px;
      }
    </style>

		<form class="form-horizontal" action="api/spaces/new.php" method="post" onsubmit="NewSpace.serializeFeatures(); return true;">
		  <fieldset>
		  
		    <div id="legend">
		      <legend class="">Basic information</legend>
		    </div>
		    <div class="form-group">
		      <!-- Name -->
		      <label class="col-sm-1 control-label"  for="name">Name</label>
		      <div class="col-sm-11">
		        <input type="text" id="name" name="name" placeholder="Give your space a name" class="form-control" required autofocus>
		      </div>
		    </div>
		    
		    <div class="form-group">
		      <!-- Description -->
		      <label class="col-sm-1 control-label"  for="description">Description</label>
		      <div class="col-sm-11">
		        <textarea id="description" name="description" class="form-control"></textarea>
            <p class="help-block">Use this space to provide a brief description of your place that will make it atractive for fellow coworkers and site visitors.</p>
		      </div>
		    </div>
		    
		    
		    <div id="legend" class="form-legend">
		      <legend class="">Location</legend>
		    </div>
		    
		    <div class="form-group">
		      <!-- Address -->
		      <label class="col-sm-1 control-label" for="address">Address</label>
		      <div class="col-sm-11">
		        <input type="text" id="address" name="address" placeholder="142 W 49th St." class="form-control">
		      </div>
		    </div>
		    
		    <div class="form-group">
		      <!-- Zip Code -->
		      <label class="col-sm-1 control-label" for="zip">Zip code</label>
		      <div class="col-sm-11">
		        <input type="text" id="zip" name="zip" placeholder="10019" class="form-control">
		      </div>
		    </div>
		    
		    <div class="form-group">
		      <!-- City -->
		      <label class="col-sm-1 control-label" for="city">City</label>
		      <div class="col-sm-11">
		        <input type="text" id="city" name="city" placeholder="New York" class="form-control">
		      </div>
		    </div>

		    <div class="form-group">
		      <!-- Country -->
		      <label class="col-sm-1 control-label" for="country">Country</label>
		      <div class="col-sm-11">
		        <select id="country" name="country" class="form-control">
		        <?php 
            foreach ($countries as $c) {
              echo "<option value=\"". $c->get_id() . "\">" . $c->get_name() . "</option>";	
            }
		        ?>
		        </select>
		      </div>
		    </div>
		    
		    <!-- Desks -->		    
		    <div id="legend" class="form-legend">
		      <legend class="">Desks</legend>
		    </div>
        <p>Please fill out the following form with information regarding the number of desks in your space together with their corresponding price.</p>
		    <br /><br />
		    <div class="form-group">
		      <!-- Permanent desks -->
		      <label class="col-sm-2 control-label"  for="dpQty">Permanent desks</label>
		      <div class="col-sm-1">
				    <input type="text" name="dpQty" class="form-control" placeholder="Qty.">
		      </div>
		      <div class="col-sm-2">
				    <div class="input-group">
						  <input type="text" class="form-control" name="dpPrice">
						  <span class="input-group-addon">€/hr.</span>
						</div>
		      </div>
		    </div>
		    <div class="form-group">
		      <!-- Flexible desks -->
		      <label class="col-sm-2 control-label"  for="dfQty">Flexible desks</label>
		      <div class="col-sm-1">
				    <input type="text" name="dfQty" class="form-control" placeholder="Qty.">
		      </div>
		      <div class="col-sm-2">
				    <div class="input-group">
						  <input type="text" class="form-control" name="dfPrice">
						  <span class="input-group-addon">€/hr.</span>
						</div>
		      </div>
		    </div>
		    <div class="form-group">
		      <!-- Meeting room -->
		      <label class="col-sm-2 control-label"  for="dmQty">Meeting rooms</label>
		      <div class="col-sm-1">
				    <input type="text" name="dmQty" class="form-control" placeholder="Qty.">
		      </div>
		      <div class="col-sm-2">
				    <div class="input-group">
						  <input type="text" class="form-control" name="dmPrice">
						  <span class="input-group-addon">€/hr.</span>
						</div>
		      </div>
		    </div>
		    
		    
		    <div id="legend" class="form-legend">
		      <legend class="">Features</legend>
		    </div>
        <p>Please check all the services and commodities your space offers. Feel free to add any aditional ones if you don't find them on the list.</p>
        <div class="form-group">
		      <!-- Features -->
		      <div class="row">
		        <div class="col-lg-6">
			        <ul id="featureList" style="margin-left: 15px;" class="list-group nav nav-list feature-list">
			          
			          <?php 
			          foreach ($availableFeatures as $f) {
			          ?>
			          <li>
				          <div class="input-group">
							      <span class="input-group-addon">
							        <input type="checkbox" class="chkFeature" value="<?php echo $f->get_id(); ?>">
							      </span>
							      <input type="text" class="form-control" disabled="disabled" value="<?php echo $f->get_name(); ?>" />
							    </div><!-- /input-group -->
							  </li>
			          
			          <?php 
			          }
			          ?>
			          
			          <!-- Add new feature -->
			          <li>
				          <div class="input-group">
							      <span class="input-group-addon">
							        <input type="checkbox" checked="checked" disabled="disabled">
							      </span>
							      <input type="text" class="form-control" name="newFeature" id="newFeature">
							      <span class="input-group-btn">
                      <button id="btnAddFeature" class="btn btn-default" type="button" >Add</button>
                     </span>
							    </div><!-- /input-group -->
							  </li>
							  
			        </ul>
		        </div>
		      </div>
		    </div>
		    
		    <!-- Photos -->		    
		    <div id="legend">
		      <legend class="">Photos</legend>
		    </div>
        <p>Upload pictures of your space. (Max. 4)</p>
        <p class="alert alert-warning">This feature is only available for premium users.</p>
		    <br /><br />
		    
		    <!-- Contact -->
		    		    
		    <div id="legend">
		      <legend class="">Contact information</legend>
		    </div>
		    
		    <div class="form-group">
		      <!-- phoneNumber -->
		      <label class="col-sm-1 control-label"  for="phoneNumber">Phone number</label>
		      <div class="col-sm-11">
		        <input type="text" id="phoneNumber" name="phoneNumber" placeholder="Phone number" class="form-control">
            <p class="help-block">Your space's phone number will only displayed to registered users.</p>
		      </div>
		    </div>
		    
		    <div class="form-group">
		      <!-- Website-->
		      <label class="col-sm-1 control-label"  for="website">Website</label>
		      <div class="col-sm-11">
		        <input type="text" id="website" name="website" placeholder="Does your space have a website?" class="form-control">
		      </div>
		    </div>
		    
		    
		    
		    
		    

		    <div class="form-group">
		      <!-- Button -->
		      
		      <div class="btn-separator">
		        &nbsp;
		      </div>
		      
		      <center>
		      <div class="col-sm-11">
		        <span class="help-block">This is your moment of glory<br /></span>
		        <input type="submit" value="Create new space" id="btnSend" class="btn btn-success btn-lg" />
		      </div>
		      </center>
		    </div>

		    <!--  stuff -->
		    <input type="hidden" name="features" id="features" value="" />
		    <input type="hidden" name="auth_type" value="SESSION" />
		    <input type="hidden" name="ownerId" value="<?php echo $owner->get_id(); ?>" />
		    
		  </fieldset>
		</form>
		
		
		<script type="text/javascript" src="js/new-space.js"></script>