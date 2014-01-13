<? ob_start(); ?>
<?php
require("common.php");
if (!empty($_POST))
{
  	$usr_inp = $_POST['user'];
  	$usr_pass = $_POST['pass'];

  	$query = '
  		SELECT
  			*
  		FROM users
  		WHERE
  		    username = :username
  	';

  	$query_params = array(
  		':username' => $usr_inp 
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

  	$login_okay = false;
  	$row = $stmt->fetch();
  	if ($row)
  	{
  		$check_password = $usr_pass;
  	    for($round = 0; $round < $num_hashes; $round++) 
  	    { 
  	        $check_password = hash('sha256', $check_password . $row['salt']); 
  	    }
  		if (strcmp($check_password,$row['password']) == 0)
  		{
  			$login_okay = true;
  		}
  	}
  	if ($login_okay)
  	{
  		unset($row['salt']);
  		unset($row['password']);

		$_SESSION["login_entry"] = "Please Log In";
  		$_SESSION['user'] = $row;
		
		if (isset($_SESSION['curr_page_req']))
		{
			header("Location: " . $_SESSION['curr_page_req']);
		} else {
			header("Location: index.php");
		}
		
		
  		die("Redirecting");
  	} else {
  		$_SESSION["login_entry"] = "Please try again";
  	} 
} else {
	$_SESSION["login_entry"] = "Please Log In";
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Login Page</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/modern-business.css" rel="stylesheet">
  </head>

  <body>
	  <!-- PHP CODE -->
	  
	  <!-- END PHP -->
	  <div id = "includedNav" style = "margin-bottom:100px;"> </div>
	  <form class="form-horizontal" action = "login.php" method = "post">
	  <fieldset>
	  <div class = "row">
		  <div class = 'col-sm-3'> </div>
		  <div class = 'col-sm-6'>
		  <!-- Form Name -->
		  <legend><?php echo $_SESSION["login_entry"]; ?></legend>
		  <div class = "row">
			  <div class = 'col-sm-3'>
			  <!-- Text input-->
			  <div class="control-group">
			    <label class="control-label" for="user_inp">User Name</label>
			    <div class="controls">
			      <input id="user_inp" name="user" type="text" placeholder="Enter your username" class="input-xlarge" required="">
    
			    </div>
			  </div>

			  <!-- Password input-->
			  <div class="control-group">
			    <label class="control-label" for="pass_inp">Password</label>
			    <div class="controls">
			      <input id="pass_inp" name="pass" type="password" placeholder="Enter your password" class="input-xlarge" required="">
			    </div>
			  </div>

			  <!-- Button -->
			  <div class="control-group">
			    <label class="control-label" for="submit"></label>
			    <div class="controls">
			      <button type="submit" class="btn btn-primary">Submit</button>
			    </div>
			  </div>
		      </div>
			  
			  <div class = 'col-sm-3'>
				  <img class = "image-responsive" src = "images/pdt_Crest.png" alt = "">
			  </div>
			  
		  	</div>
		  
  		  </div>
		  <div class = 'col-sm-3'> </div>
      </div>
	  </fieldset>
	  </form>
    <!-- FOOTER -->
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