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
				  <img class = "image-responsive" src = "images/pdt_crest.png" alt = "">
			  </div>
			  
		  	</div>
		  
  		  </div>
		  <div class = 'col-sm-3'> </div>
      </div>
	  </fieldset>
	  </form>
	  <div id="fb-root"></div>
	  <fb:login-button show-faces="true" width="200" max-rows="1"></fb:login-button>
    <!-- FOOTER -->
   	<div id = "includedFooter"> </div>

    <!-- JavaScript -->
    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/modern-business.js"></script>
	<script>
	  window.fbAsyncInit = function() {
	  FB.init({
	    appId      : '1390820001176399',
	    status     : true, // check login status
	    cookie     : true, // enable cookies to allow the server to access the session
	    xfbml      : true  // parse XFBML
	  });

	  // Here we subscribe to the auth.authResponseChange JavaScript event. This event is fired
	  // for any authentication related change, such as login, logout or session refresh. This means that
	  // whenever someone who was previously logged out tries to log in again, the correct case below 
	  // will be handled. 
	  FB.Event.subscribe('auth.authResponseChange', function(response) {
	    // Here we specify what we do with the response anytime this event occurs. 
	    if (response.status === 'connected') {
	      // The response object is returned with a status field that lets the app know the current
	      // login status of the person. In this case, we're handling the situation where they 
	      // have logged in to the app.
	      testAPI();
	    } else if (response.status === 'not_authorized') {
	      // In this case, the person is logged into Facebook, but not into the app, so we call
	      // FB.login() to prompt them to do so. 
	      // In real-life usage, you wouldn't want to immediately prompt someone to login 
	      // like this, for two reasons:
	      // (1) JavaScript created popup windows are blocked by most browsers unless they 
	      // result from direct interaction from people using the app (such as a mouse click)
	      // (2) it is a bad experience to be continually prompted to login upon page load.
	      FB.login();
	    } else {
	      // In this case, the person is not logged into Facebook, so we call the login() 
	      // function to prompt them to do so. Note that at this stage there is no indication
	      // of whether they are logged into the app. If they aren't then they'll see the Login
	      // dialog right after they log in to Facebook. 
	      // The same caveats as above apply to the FB.login() call here.
	      FB.login();
	    }
	  });
	  };

	  // Load the SDK asynchronously
	  (function(d){
	   var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
	   if (d.getElementById(id)) {return;}
	   js = d.createElement('script'); js.id = id; js.async = true;
	   js.src = "//connect.facebook.net/en_US/all.js";
	   ref.parentNode.insertBefore(js, ref);
	  }(document));

	  // Here we run a very simple test of the Graph API after login is successful. 
	  // This testAPI() function is only called in those cases. 
	  function testAPI() {
	    console.log('Welcome!  Fetching your information.... ');
	    FB.api('/me', function(response) {
	      console.log('Good to see you, ' + response.name + '.');
	    });
	  }
	</script>
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