
    <!-- Carousel
    ================================================== -->
    <div id="promotedSpaces" class="carousel slide" data-ride="carousel">
      <!-- Indicators -->
      <ol class="carousel-indicators">
        <?php 
        for ($i = 0; $i < count ($promotedSpaces); ++$i) {
          if ($i == 0) echo "<li data-target=\"#promotedSpaces\" data-slide-to=\"" . $i . "\" class=\"active\"></li>";
          else echo "<li data-target=\"#promotedSpaces\" data-slide-to=\"" . $i . "\"></li>";
        }
        ?>
      </ol>
      <div class="carousel-inner">
        <?php 
        for ($i = 0; $i < count ($promotedSpaces); ++$i) {
        ?>
        <div class="item <?php if ($i == 0) echo "active"; ?>">
          <img width="900" height="500" src="img/spaces/<?php echo $promotedSpaces[$i]->get_id(); ?>.jpg" alt="First slide">
          <div class="container">
            <div class="carousel-caption">
              <h1><?php echo $promotedSpaces[$i]->get_name(); ?></h1>
              <p><?php echo $promotedSpaces[$i]->get_description (); ?></p>
              <p><a class="btn btn-lg btn-primary" href="?s=view-space&id=<?php echo $promotedSpaces[$i]->get_id(); ?>" role="button">View profile</a></p>
            </div>
          </div>
        </div>
        <?php
        }
        ?>
      </div>
      <a class="left carousel-control" href="#promotedSpaces" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
      <a class="right carousel-control" href="#promotedSpaces" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
    </div><!-- /.carousel -->

    <!-- Marketing messaging and featurettes
    ================================================== -->
    <!-- Wrap the rest of the page in another container to center all the content. -->

    <div class="container marketing">

      <!-- Three columns of text below the carousel -->
      <div class="row">
        <div class="col-lg-4">
          <img class="img-circle" width="140" height="140" alt="More than 100 spaces" src="img/mkt1.jpg">
          <h2>More than 100 spaces</h2>
          <p>Donec sed odio dui. Etiam porta sem malesuada magna mollis euismod. Nullam id dolor id nibh ultricies vehicula ut id elit. Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Praesent commodo cursus magna.</p>
          <p><a class="btn btn-default" href="#" role="button">Browse spaces &raquo;</a></p>
        </div><!-- /.col-lg-4 -->
        <div class="col-lg-4">
          <img class="img-circle" width="140" height="140" alt="In 22 different cities" src="img/mkt2.jpg">
          <h2>In 22 different cities</h2>
          <p>Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Cras mattis consectetur purus sit amet fermentum. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh.</p>
          <p><a class="btn btn-default" href="#" role="button">Find yours &raquo;</a></p>
        </div><!-- /.col-lg-4 -->
        <div class="col-lg-4">
          <img class="img-circle" width="140" height="140" alt="With 1200 coworkers!" src="img/mkt3.jpg">
          <h2>With 1200+ coworkers</h2>
          <p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
          <p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
        </div><!-- /.col-lg-4 -->
      </div><!-- /.row -->
      
    </div> <!-- /container marketing -->