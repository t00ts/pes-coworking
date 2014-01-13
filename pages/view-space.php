<?php

  require_once (DATA_PATH . "country.class.php");
  require_once (DATA_PATH . "space.class.php");
  require_once (DATA_PATH . "feature.class.php");
  require_once (DATA_PATH . "coworker.class.php");
  
  $space = SpaceDataMapper::getSpaceById ($_GET['id']);
  if (is_null($space)) die ("<div class=\"panel-body\"><p class=\"alert alert-danger\">There is no space with this id.</p></div>");
  $owner = CoworkerDataMapper::getCoworkerById ($space->get_ownerId());

  //$freeDesks = DeskDataMapper::getFreeDesks ($space->get_id());
  $prices = SpaceDataMapper::getPrices($space->get_id());
  $features = FeatureDataMapper::getFeaturesBySpaceId ($space->get_id());
 //  if (!is_null ($space->get_website()) && !empty($space->get_website()) && $space->get_website != "") echo "(<a href=\"". $space->get_website() . "\">" . $space->get_website() . "</a>)";  
?>

     <div class="row>
        <div class="col-md-8">
          <p class="pull-left visible-xs">
            <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle nav</button>
          </p>
          <h2><?php echo $space->get_name(); ?></h2>
          <p><?php echo $space->get_address() . ", " . $space->get_city(); ?></p>
          <div class="row">
            <div class="col-md-5">
              <img src="img/spaces/<?php echo $space->get_id(); ?>.jpg" width="450" height="300" />
            </div><!--/span-->
            <div class="col-md-7">
              <p><?php echo $space->get_description(); ?></p>
              <ul id="features">
              <?php 
              foreach ($features as $f) {
                echo "<li>" . $f->get_name() . "</li>";
              }
              ?>
              </ul>
            </div><!--/span-->
          </div><!--/row-->
          <div class="row">
            <div class="col-md-12">
              <p><a class="btn-lg btn-primary btn-success pull-right" href="#" rel="button" data-toggle="modal" data-target="#book-modal">Book now! &raquo;</a></p>
            </div>
          </div>
        </div><!--/span-->

      </div><!--/row-->
			
			<!-- Modal -->
			<div class="modal fade" id="book-modal" tabindex="-1" role="dialog" aria-labelledby="bookmodalLabel" aria-hidden="true">
			  <div class="modal-dialog">
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			        <h4 class="modal-title" id="bookmodalLabel">Book your desk now!</h4>
			      </div>
			      <div class="modal-body">
			        <?php 
			          if (!is_null($usr)) {
			        ?>
			        <p>Use the following date pickers to specify the dates you want to book</p>
			        <label>Start date: <input type="date" class="form-control" /></label>
			        <label>End date: <input type="date" class="form-control" /></label>
			        <br /><br />
			        <h4>Select the type of desk you want to book:</h4>
			        <ul class="nav nav-list">
			          <?php if (isset($prices[0])) { ?><li><label><input type="radio" name="deskType" value="0" /> Permanent </label> <span class="badge"><?php echo $prices[0]*4*4; ?> €/week</span></li><?php } ?>
			          <?php if (isset($prices[1])) { ?><li><label><input type="radio" name="deskType" value="1" /> Flexible </label> <span class="badge"><?php echo $prices[1]; ?> €/hour</span></li><?php } ?>
			          <?php if (isset($prices[2])) { ?><li><label><input type="radio" name="deskType" value="2" /> Meeting Room </label> <span class="badge"><?php echo $prices[2]; ?> €/hour</span></li><?php } ?>
			        </ul>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			        <button type="button" class="btn btn-primary">Send book request</button>
			      </div>
			      <?php } else { ?>
			      <p class="alert alert-warning">You must sign in in order to book a desk.</p>
			      <?php } ?>
			    </div><!-- /.modal-content -->
			  </div><!-- /.modal-dialog -->
			</div><!-- /.modal -->