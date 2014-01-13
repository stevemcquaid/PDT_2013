<? ob_start(); ?>
<?php
require("common.php");

if (empty($_SESSION['user']))
{
    header("Location: login.php");  
    // Remember that this die statement is absolutely critical.  Without it, 
    // people can view your members-only content without logging in. 
    die("Redirecting to login.php"); 
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Permission Error</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Add custom CSS here -->
    <link href="css/modern-business.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet">
  </head>

  <body>
    <div id = "includedNav"> </div>
	
	<!-- INSERT HTML HERE -->
	
	
	<img class = "img-responsive" src = "images/graphics/lock.png"/>
	
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
<? ob_flush(); ?>