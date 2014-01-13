<?php
	require('common.php');
    $query = 'SELECT *
			  FROM gallery
			  WHERE id >= :start
			    AND id < :end';
			
    $query_params = array(
		':start' => $_SESSION["gallery_start"],
		':end' => $_SESSION["gallery_end"]
    );
	
  	try
  	{
  		$stmt = $db->prepare($query);
  		$result = $stmt->execute($query_params);
  	}
    catch(PDOException $ex) 
    {
  	    die("Failed to run query"); 
    }
    $row = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Gallery</title>

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
          <h1 class="page-header">Phi Delt CMU Gallery</h1>
          <ol class="breadcrumb">
            <li><a href="index.php">Home</a></li>
            <li class="active">Gallery</li>
          </ol>
        </div>

  	  </div><!-- /.row -->
	  <div class = "row">
		  
		  <!--													  -->
		  <!-- contain links to the PHIDELT CMU facebook galleries-->
		  <!--													  -->
		  
	  </div>
	  <div class = "row">
	  <?php
		for ($i = 0; $i < count($row); $i++)
		{
		    echo '<div class="col-md-3 portfolio-item">
          	   	 <img class="img-responsive" src="'.$row[$i]['image'].'">
       	 		 </div>';
		}
	  ?>
      </div>
	  
      <div class="row text-center">
        
        <div class="col-lg-12">
          <ul class="pagination">
			  <?php
			  $gallery_slides = ($_SESSION['gallery_count'] + $_SESSION['gallery_page_limit'] - 1) / $_SESSION['gallery_page_limit'];
			  
			  
			  /* PHP function, the prev arrow and next arrow move to the appropriate section
			     (with the prev not doing anything at first and next not doing anything at max)
			  
			  	 Also, each od the gallery number icons should go to the appropriate gallery images */
			  
			  echo '<li><a href="#">&laquo;</a></li>';
			  for ($i = 0; $i < $gallery_slides; $i++)
			  {
				  if ($i == $S_SESSION['gallery_curr'])
				  {
				  	 echo '<li class = "active"><a href="">'. ($i+1) .'</a></li>';
				  } else {
				  	 echo '<li><a href="#">'. ($i+1) .'</a></li>';
				  }
				  
			  }
			  echo '<li><a href="#">&raquo;</a></li>';
			  ?>
          </ul>        
        </div>

      </div>

    </div><!-- /.container -->


    <div class="container" style = "text-align:center;">

      <hr>

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