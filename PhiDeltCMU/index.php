<? ob_start(); ?>
<?php
$array_images = array_merge(glob("./images/carousel/*.jpg"),
							glob("./images/carousel/*.jpeg"),
							glob("./images/carousel/*.png"),
							glob("./images/carousel/*.gif"));
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Phi Delta Theta CMU</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Add custom CSS here -->
    <link href="css/modern-business.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet">
  </head>

  <body>
	  <div id="fb-root"></div>
	  <script>(function(d, s, id) {
	    var js, fjs = d.getElementsByTagName(s)[0];
	    if (d.getElementById(id)) return;
	    js = d.createElement(s); js.id = id;
	    js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
	    fjs.parentNode.insertBefore(js, fjs);
	  }(document, 'script', 'facebook-jssdk'));</script>
	  
	<div id = "includedNav"> </div>
	<div clas = "section" id = "logo-head">
			<h3 style = "height:inherit"> <b> CMU Phi Delta Theta </b> <img src = "images/graphics/logo.png" style = "height:inherit;padding:2px" >
					 					  <b>Pennsylvania Rho Chapter </b>
			</h3>
	
	
	</div>
	<!-- IMAGE CAROUSEL ON THE MAIN PAGE TOP -->
    <div id = "mainCaroContain">
	<div id="myCarousel" class="carousel slide">
      <!-- Indicators -->
        <ol class="carousel-indicators" id="main-indicator">
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner" id="main-carousel">
        </div>

        <!-- Controls -->
        <a class="left carousel-control" href="#myCarousel" data-slide="prev">
          <span class="icon-prev"></span>
        </a>
        <a class="right carousel-control" href="#myCarousel" data-slide="next">
          <span class="icon-next"></span>
        </a>
    </div>
	</div>
	<br>
	<br>
	<br>
	<div class = "section-colored">

 	   <div class="container">
         <div class="row">
           <div class="col-lg-4 col-md-4">
             <h3><i class="fa fa-chevron-circle-right"></i> &nbsp Events</h3>
             <p> <span style = "color:#88ddff"> Spring Rush </span></p>
 			<p>January 14 - January 30 </p>
 			<p>Our Spring Rush is starting soon. All events start at the Phi Delta Theta house on the Greek Quad. Come join us for great events and the adventure of a lifetime!. </p>
 			<a href = "recruitment-info.php"><button class="btn-custom">Learn More</button> </a>
           </div>
		   
		   
		   <div class="col-lg-4 col-md-4">
			   <br>
			   <img class = "img-responsive" src = "images/pdt_crest.png"\>
			   <br>
	   	   </div>
		   
		   <div class="col-lg-4 col-md-4">
               <h3><i class="fa fa-chevron-circle-right"></i> &nbsp About Us</h3>
               <p> <span style = "color:#88ddff"> PDT PA Rho Chapter </span></p>
			<p> We chartered at CMU in 2013 with 50+ brothers and moved into a house on the Greek Quad that same year. </p>
   			<p>Phi Delts at CMU have the advan­tage of a strong broth­er­hood, insane social events, the best intra­mu­rals, lead­er­ship oppor­tu­ni­ties, and a chef who cooks Mon­day through Fri­day.</p>
	       </div>
		   
         </div><!-- /.row -->
       </div><!-- /.container -->   
	   
	</div>
    <div class="section text-center">

      <!-- EVENT UPDATES ! -->
	  
		
   </div>
   <div class = "section-colored">




 	   <div class="container">
         <div class="row">
		   <div class="col-lg-4 col-md-6">
			   
  			   <div>
               <h3><i class="fa fa-facebook-square"></i> &nbsp Like us on Facebook</h3>
	           <div class="fb-like-box" data-href="https://www.facebook.com/CMUPhiDelt" data-width="500" data-height="400" data-colorscheme="light" data-show-faces="true" data-header="true" data-stream="true" data-show-border="true" style = "background-color:#ffffff;"></div>
	 	       </div>
               </div>   
		   <div class="col-lg-4 col-md-2"></div>
		   <div class="col-lg-4 col-md-4">
			 <div>
             <h3><i class="fa fa-twitter"></i> &nbsp Latest Tweets </h3>
			 <a class="twitter-timeline" href="https://twitter.com/PhiDeltCMU" data-widget-id="422145492793819136">Tweets by @PhiDeltCMU</a>
             </div>
	   		</div>
         </div><!-- /.row -->
       </div><!-- /.container -->
	</div>

    </div><!-- /.section -->


	<div id = "includedFooter"> </div>
    
    <!-- JavaScript -->
    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/modern-business.js"></script>
	 <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
	<script>
		$(function(){
	      $("#includedNav").load("nav.php"); 
	    });
		$(function(){
	      $("#includedFooter").load("footer.html"); 
	    });
		
		var filenames = eval(<?php echo json_encode($array_images);?>);
		console.log(filenames);
		console.log(filenames.length);
		for (var i = 0; i < filenames.length; i++)
		{
			var indic;
			var img_file;
			
			if (i == 0)
			{
				indic = '<li data-target="#myCarousel" data-slide-to="0" class="active"></li>';
				img_file = '<div class="item active"><div class="fill" style="background-image:url('+filenames[i]+');"></div></div>';
			} else {
				indic = '<li data-target="#myCarousel" data-slide-to="'+i+'"></li>';
				img_file = '<div class="item"><div class="fill" style="background-image:url('+filenames[i]+');"></div></div>';
			}
			
			console.log(indic);
			console.log(img_file);
			$("#main-indicator").append(indic);
			$("#main-carousel").append(img_file);
		}
		
		$(window).load(function(){
			var width = $(window).width(); 
			if (width < 800)
			{
				$('#logo-head').hide();
			} else {
				$('#logo-head').show();
			}
		});
		
		$(window).resize(function(){
			var width = $(window).width(); 
			if (width < 800)
			{
				$('#logo-head').hide();
			} else {
				$('#logo-head').show();
			}
		});
		
		
	</script>
  </body>
</html>
<? ob_flush(); ?>
