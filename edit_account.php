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

    <title>Edit Account</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Add custom CSS here -->
    <link href="css/modern-business.css" rel="stylesheet">
	 <link href="css/bootstrap-lightbox.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet">
  </head>

  <body>
    <div id = "includedNav"> </div>
	
    <div class="container">

      <div class="row">

        <div class="col-lg-12">
          <h1 class="page-header"> Account Settings <small> Update Account Details </small></h1>
          <ol class="breadcrumb">
            <li><a href="index.php">Home</a></li>
            <li class="active">Account Settings</li>
          </ol>
        </div>

      </div>

      <div class="row">

        <div class="col-lg-12">

          <div class="panel-group" id="accordion">

            <div class="panel panel-default"> <!-- Start of Update Email -->
              <div class="panel-heading">
                <h4 class="panel-title">
                  <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
					   Email Address 
                  </a>
					  <?php
						if(isset($_SESSION['user']['email']))
						{
							echo "<small>Currently " . $_SESSION['user']['email'] . "</small>";
						} else {
							echo "Email not set";
						}
	  				  ?>
                </h4>
              </div>
              <div id="collapseOne" class="panel-collapse collapse">
                <div class="panel-body">
			  	  <form class="form-horizontal" action = "update_email.php" method = "post">
			  	  <fieldset>
					  <div class = "row">
						<div class = 'col-sm-10'>
			  			  <div class="control-group">
			  			    <label class="control-label" for="email">
							   <?php
							   if (isset($_SESSION['update_email_message']))
							   {
								   echo $_SESSION['update_email_message'];
							   } else {
							   	   echo "Primary Email Address";
							   }
								
			  			 	   ?>
							</label>
			  			    <div class="controls">
			  			      <input id="email_inp" name="email" type="text" placeholder="Enter new email" class="input-xlarge" required="">
    
			  			    </div>
			  			  </div>
					    </div>
						
			  			<div class = 'col-sm-2'>
  			  			  <div class="control-group">
  			  			    <label class="control-label" for="submit"></label>
  			  			    <div class="controls">
  			  			      <button type="submit" class="btn btn-primary">Submit</button>
  			  			    </div>
  			  			  </div>
			  			</div>
			        </div>
			  	  </fieldset>
			  	  </form>
                </div>
              </div> <!-- End of Update Email -->
			  
			  
              <div class="panel panel-default">  <!-- Start of Change Password -->
                <div class="panel-heading">
                  <h4 class="panel-title">
                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
  					   Change Password
                    </a>
					<small> 6 to 20 characters</small>
                  </h4>
                </div>
                <div id="collapseTwo" class="panel-collapse collapse">
                  <div class="panel-body">
  			  	  <form class="form-horizontal" action = "update_pwd.php" method = "post">
  			  	  <fieldset>
					  <div class = "row">
						<div class = 'col-sm-12'>
  			  			  <div class="control-group">
  			  			    <label class="control-label" for="old_pwd">
   							   <?php
 							   echo "<h5>";
   							   if (isset($_SESSION['update_old_pwd_message']))
   							   {
   								   echo $_SESSION['update_old_pwd_message'];
   							   } else {
   							   	   echo "Enter Old Password";
   							   }
							   echo "</h5>";
   			  			 	   ?>
							</label>
							<br>
  			  			    <div class="controls">
  			  			      <input id="old_pwd" name="old_pwd" type="text" placeholder="Enter Old Password" class="input-xlarge" required="">
  			  			    </div>
						</div>
					  </div>
					  
  						<div class = 'col-sm-10'>
  			  			  <div class="control-group">
  			  			    <label class="control-label" for="pwd">
  							   <?php
							   echo "<h5>";
  							   if (isset($_SESSION['update_pwd_message']))
  							   {
  								   echo $_SESSION['update_pwd_message'];
  							   } else {
  							   	   echo "Enter New Password";
  							   }
							   echo "<small> Spaces are Removed </small></h5>"
  			  			 	   ?>
  							</label>
							<div class = "row">
								<div class = 'col-sm-5'>
	  			  			    <div class="controls">
	  			  			      <input id="pwd" name="pwd" type="text" placeholder="Enter New Password" class="input-xlarge" required="">
	  			  			    </div>
								</div>
								<div class = 'col-sm-5'>
	  			  			    <div class="controls">
	  			  			      <input id="check_pwd" name="check_pwd" type="text" placeholder="Reenter Password" class="input-xlarge" required="">
	  			  			    </div>
								</div>
							</div>
							
  			  			  </div>
					    </div>
						
  			  			<div class = 'col-sm-2'>
    			  			  <div class="control-group">
    			  			    <label class="control-label" for="submit"></label>
    			  			    <div class="controls">
    			  			      <button type="submit" class="btn btn-primary">Submit</button>
    			  			    </div>
    			  			  </div>
  			  			</div>
						
						
  			        </div>
  			  	  </fieldset>
  			  	  </form>
                  </div>
                </div> <!-- End of Change Password -->
			  
			  
            </div>

          </div>

        </div>

      </div>

    </div><!-- /.container -->
	
	<!-- Use lighboxes for all of the different sections -->
	
    <div id = "includedFooter"> </div>

    <!-- JavaScript -->
    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/bootstrap.js"></script>
	<script src="js/bootstrap-lightbox.js"></script>
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