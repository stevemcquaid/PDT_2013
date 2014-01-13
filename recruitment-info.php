<?php
    $filename = "./images/recruitment/rush_calender.jpg";
	$calender_html = "";
	if (file_exists($filename))
	{
		$calender_html =  '<p>All events start at the Phi Delta Theta house on the Greek Quad. Come join us for great events and the adventure of a lifetime!.</p><img class = "img-responsive" src = "images/recruitment/rush_calender.jpg" style = "margin-left:auto;margin-right:auto;"\>';
	} else {
		$calender_html = '<p> Check Back Later as we enter our rush season </p>';
	}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Recruitment Info</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Add custom CSS here -->
    <link href="css/modern-business.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet">
  </head>

  <body>
      
	<div id = "includedNav"> </div>
	  
    <div class="container">

      <div class="row">

        <div class="col-lg-12">
          <h1 class="page-header"> Recruitment Information </h1>
          <ol class="breadcrumb">
            <li><a href="index.php">Home</a></li>
            <li class="active">Recruitment Info</li>
          </ol>
        </div>

      </div>

      <div class="row">

        <div class="col-lg-12">
          <p> The men of Phi Delta Theta share a commitment—to the intense bond of friendship between brothers, high academic achievement, and living life with integrity. A Phi Delt has high expectations of, and for, himself and his brothers. He believes that one man is no man. He believes it is his personal challenge to “Become the greatest version of yourself” in all that he does.
The Fraternity teaches men that these areas of commitment, those outlined in The Bond of Phi Delta Theta, are not to be viewed as separate ideals, but as areas of discipline for daily life. Developments intellectually, in leadership, and in human service (to name a few) are vital to the Phi Delt man. Members of Phi Delta Theta will support, and in turn have the support of, his brothers as these principles are lived out.</p>

<p>Membership in Phi Delta Theta goes beyond belonging to a social organization. The men of Phi Delta Theta tell of the tremendous support that exists between brothers and how, during their college years, they developed self-confidence, leadership qualities, and a belief in the strength of their abilities. They believe their lifetime commitment to the Fraternity is one of the most important commitments they ever made.</p>

        </div>

      </div>
	  <br>
	  <br>
	  <br>
	  
	  <div> <?php echo $calender_html ?></div>

    </div><!-- /.container -->


    <div id = "includedFooter"> </div>
    <!-- JavaScript -->
    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/modern-business.js"></script>
	<script>
		$(function(){
	      $("#includedNav").load("nav.php"); 
	    });
		$(function(){
	      $("#includedFooter").load("footer.html"); 
	    });
	</script>
  </body>
</html>