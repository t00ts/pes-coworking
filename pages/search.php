<?php 


require_once ($_SERVER['DOCUMENT_ROOT'] . "/coworking/data/paths.config.php");
require_once (DATA_PATH . "feature.class.php");

// Obtenemos las variables del formulario
$q = isset($_POST['q']) ? $_POST['q'] : null;

// Busqueda
if (!is_null($q))
	$results = SpaceDataMapper::search ($q, null);

// Features
$features = FeatureDataMapper::getAllFeatures ();

?>
<style type="text/css">
@import url('css/table.css');

.borderRight1
{
	border-top: 0px;
	border-bottom: 0px;
	border-left: 0px;
	border-right: 2px solid #ddd;
}

.price
{
	position: relative;
	float: right;
	top: 0px;
	right: 0px;
}

div.search-feature-list {
  background-color: red;
	margin-left: 10px;
	font-family: 'Helvetica';
	font-size: 14px;
	font-weight: normal;
}

</style>

<div class="row">
  <div class="col-md-3">
    <h4>Selected features</h4> 
    <!-- Filters -->
    <div class="search-feature-list">
      <!-- Features -->
      <ul class="nav nav-list" id="feature-list">
		    <?php 
		    foreach ($features as $f) {
		    ?>
		    <li><label><input class="feature-filter" type="checkbox" value="<?php echo $f->get_id(); ?>" /> <?php echo $f->get_name (); ?></label>
		    <?php 
		    }
		    ?>
      </ul>
    
    </div> <!-- /feature-list --> 
  </div> <!-- /col-md-3 -->
  <div class="col-md-9">
  
		<table id="searchTable" class="table">
			<thead>
				<tr>
					<th></th>
				</tr>
			</thead>
			<tbody id="results">
				<?php 
				if (is_null($q)) {
				?>
			 	  <p class="alert alert-info">Please use the search bar on the top or check some filters on the left panel to browse spaces.</p>
				<?php 
				}
				else {
					foreach ($results as $r) {
				?>
				<tr>
					<td>
						<ul class="media-list">
						  <li class="media">
						    <a class="pull-left thumbnail" href="index.php?s=view-space&id=<?php echo $r->get_id(); ?>">
						      <img class="media-object" src="img/spaces/<?php echo $r->get_id(); ?>.jpg" alt="" style="width: 170px; height: 130px;">
						    </a>
						    <div class="media-body">
						      <span class="badge price"><?php echo $r->get_ownerId (); ?> &euro; / hr</span>
						      <h4 class="media-heading"><?php echo $r->get_name(); ?></h4>
					      </div>
						    <p><?php echo $r->get_description(); ?></p>  
						    <br><br><a class="btn btn-info btn-xs" role="button" href="index.php?s=view-space&id=<?php echo $r->get_id(); ?>">Visit profile</a>
						  </li>
						</ul>
					</td>
				</tr>
  		  <?php 
					}
				}
				?>

			</tbody>
		</table>
  
  </div><!-- /col-md-9 -->
</div>
</div>



<script type="text/javascript">

	
	
	var en = {
					"sLengthMenu": "Display _MENU_ records per page",
					"sZeroRecords": "Nothing found - sorry",
					"sInfo": "Showing _START_ to _END_ of _TOTAL_ records",
					"sInfoEmpty": "Showing 0 to 0 of 0 records",
					"sInfoFiltered": "(filtered from _MAX_ total records)",
				     "sProcessing": "Processing...",
				     "sInfoPostFix": "",
				     "sSearch": "",
				     "sUrl": "",
					"oPaginate": {
					"sFirst":    "First",
					"sPrevious": "Back",
					"sNext":     "Next",
					"sLast":     "Last"
					}
				};	

	$(document).ready(function(){	
		$("#searchTable").dataTable( {"oLanguage": en} );
	}); 

</script>
<script type="text/javascript" src="js/search.js"></script>