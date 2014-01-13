<? ob_start(); ?>
<?php 

    // First we execute our common code to connection to the database and start the session 
    require("common.php"); 
     
    // This if statement checks to determine whether the registration form has been submitted 
    // If it has, then the registration code is run, otherwise the form is displayed 
    if(!empty($_POST)) 
    { 
        
        // Make sure the user entered a valid E-Mail address 
        // filter_var is a useful PHP function for validating form input, see: 
        // http://us.php.net/manual/en/function.filter-var.php 
        // http://us.php.net/manual/en/filter.filters.php 
        if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) 
        {
			$_SESSION["register_tag"] = "Invalid Email Address";
			header("Location: register.php");
            die("Invalid Email Address"); 
        } 
		
		
		$allowedExts = array("gif","jpeg","jpg","png");
		$temp = explode(".",$_FILES["file"]["name"]);
		$extension = end($temp);
		
		if ((($_FILES["file"]["type"] == "image/gif")
		|| ($_FILES["file"]["type"] == "image/jpeg")
		|| ($_FILES["file"]["type"] == "image/jpg")
		|| ($_FILES["file"]["type"] == "image/pjpeg")
		|| ($_FILES["file"]["type"] == "image/x-png")
		|| ($_FILES["file"]["type"] == "image/png"))
		&& ($_FILES["file"]["size"] < 20000)
		&& in_array($extension, $allowedExts))
		{
			if ($_FILES["file"]["error"] > 0)
			{
				echo "Error: " . $_FILES["file"]["error"] . "<br>";
			}
			else
			{
				$image_name = "profile_" + $user_inp;
				if (!file_exists("images/profiles/" . $image_name))
				{
					move_uploaded_file($_FILES["file"]["tmp_name"],
									   "images/profiles/" + $image_name);
				}
				$image_link = "images/profiles/" + $image_name;
			}
		} else {
			$image_link = "images/profiles/default.jpg";
		}
		
        // We will use this SQL query to see whether the username entered by the 
        // user is already in use.  A SELECT query is used to retrieve data from the database. 
        // :username is a special token, we will substitute a real value in its place when 
        // we execute the query. 
        
		$query = " 
            SELECT 
                1 
            FROM users 
            WHERE 
                username = :username 
        "; 
         
        // This contains the definitions for any special tokens that we place in 
        // our SQL query.  In this case, we are defining a value for the token 
        // :username.  It is possible to insert $_POST['username'] directly into 
        // your $query string; however doing so is very insecure and opens your 
        // code up to SQL injection exploits.  Using tokens prevents this. 
        // For more information on SQL injections, see Wikipedia: 
        // http://en.wikipedia.org/wiki/SQL_Injection 
        $query_params = array( 
            ':username' => $_POST['user_name'] 
        ); 
         
        try 
        { 
            // These two statements run the query against your database table. 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex) 
        { 
            // Note: On a production website, you should not output $ex->getMessage(). 
            // It may provide an attacker with helpful information about your code.  
            die("Failed to run query: "); 
        } 
		
        // The fetch() method returns an array representing the "next" row from 
        // the selected results, or false if there are no more rows to fetch. 
        $row = $stmt->fetch(); 
         
        // If a row was returned, then we know a matching username was found in 
        // the database already and we should not allow the user to continue. 
        if($row) 
        { 
			$_SESSION["register_tag"] = "This Username is Already Registered";
			header("Location: register.php");
            die("This username is already registered"); 
        } 
         
        // Now we perform the same type of check for the email address, in order 
        // to ensure that it is unique. 
        $query = " 
            SELECT 
                1 
            FROM users 
            WHERE 
                email = :email 
        "; 
         
        $query_params = array( 
            ':email' => $_POST['email'] 
        ); 
         
        try 
        { 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex) 
        { 
            die("Failed to run query: " . $ex->getMessage()); 
        } 
         
        $row = $stmt->fetch(); 
         
        if($row) 
        { 
			$_SESSION["register_tag"] = "This Email is Already Registered";
			header("Location: register.php");
            die("This email is already registered");
        } 
		
		// Process the Position and Chair positions for permissions sake
        $query = " 
            SELECT 
                1 
            FROM users 
            WHERE 
                position = :position
        "; 
		
        $query_params = array( 
            ':position' => $_POST['position'] 
        ); 
         
        try 
        { 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex) 
        { 
            die("Failed to run query: " . $ex->getMessage()); 
        } 
         
        $row = $stmt->fetch();  
		 
        if($row && $_POST['position'] != "General Member") 
        { 
			$_SESSION["register_tag"] = "This Position is Already Registered";
            die("This position is already registered"); 
			header("Location: register.php");
        }  
		
		$position = $_POST['position'];
		
        // An INSERT query is used to add new rows to a database table. 
        // Again, we are using special tokens (technically called parameters) to 
        // protect against SQL injection attacks. 
        $query = " 
            INSERT INTO users ( 
				username, 
                password, 
				first_name,
				last_name,
				picture,
                salt, 
                email,
				position
            ) VALUES ( 
                :username, 
                :password, 
				:first_name,
				:last_name,
				:picture,
                :salt, 
                :email,
				:position
            ) 
        "; 
		
        // A salt is randomly generated here to protect again brute force attacks 
        // and rainbow table attacks.  The following statement generates a hex 
        // representation of an 8 byte salt.  Representing this in hex provides 
        // no additional security, but makes it easier for humans to read. 
        // For more information: 
        // http://en.wikipedia.org/wiki/Salt_%28cryptography%29 
        // http://en.wikipedia.org/wiki/Brute-force_attack 
        // http://en.wikipedia.org/wiki/Rainbow_table 
        $salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647)); 
         
        // This hashes the password with the salt so that it can be stored securely 
        // in your database.  The output of this next statement is a 64 byte hex 
        // string representing the 32 byte sha256 hash of the password.  The original 
        // password cannot be recovered from the hash.  
        $password = $_POST['password'];
         
        // Next we hash the hash value 65536 more times.  The purpose of this is to 
        // protect against brute force attacks.  Now an attacker must compute the hash 65537 
        // times for each guess they make against a password, whereas if the password 
        // were hashed only once the attacker would have been able to make 65537 different  
        // guesses in the same amount of time instead of only one. 
        for($round = 0; $round < $num_hashes; $round++) 
        { 
            $password = hash('sha256', $password . $salt); 
        } 
		 	 
        // Here we prepare our tokens for insertion into the SQL query.  We do not 
        // store the original password; only the hashed version of it.  We do store 
        // the salt (in its plaintext form; this is not a security risk). 
        $query_params = array( 
            ':username' => $_POST['user_name'], 
            ':password' => $password, 
			':first_name' => $_POST['first_name'],
			':last_name' => $_POST['last_name'],
			':picture' => $image_link,
            ':salt' => $salt, 
            ':email' => $_POST['email'],
			':position' => $position
        ); 
         
        try 
        { 
            // Execute the query to create the user 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex) 
        { 
            // Note: On a production website, you should not output $ex->getMessage(). 
            // It may provide an attacker with helpful information about your code.  
            die("Failed to run query: " . $ex->getMessage()); 
        } 
        
		$_SESSION["register_tag"] = "Register a User";
		
		if (isset($_SESSION['curr_page_req']))
		{
			header("Location: " . $_SESSION['curr_page_req']);
		} else {
			header("Location: index.php");
		}
		
		unset($password);
  		die("Redirecting");
    } else {
    	if (!isset($_SESSION["register_tag"]))
		{
			$_SESSION["register_tag"] = "Register a User";
		}
    }
?> 
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Registration</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/modern-business.css" rel="stylesheet">
  </head>

  <body>
	  <!-- PHP CODE -->
	  
	  <!-- END PHP -->


	  <div id = "includedNav" style = "margin-bottom:100px;"> </div>
	  
	  <form class="form-horizontal" action = "register.php" method = "post" enctype="multipart/form-data">
	  <fieldset>
	  <div class = "row">
		  <div class = 'col-sm-3'> </div>
		  <div class = 'col-sm-6'>
		  <!-- Form Name -->
		  <legend><?php echo $_SESSION['register_tag']?></legend>
		  <div class = "row">
			  <div class = 'col-sm-3'>
			  <!-- Text input-->
			  <div class="control-group">
			    <label class="control-label" for="first_inp">First Name</label>
			    <div class="controls">
			      <input id="first_inp" name="first_name" type="text" placeholder="Enter your first name" class="input-xlarge" required="">
    
			    </div>
			  </div>
			  
			  <div class="control-group">
			    <label class="control-label" for="last_inp">Last Name</label>
			    <div class="controls">
			      <input id="last_inp" name="last_name" type="text" placeholder="Enter your last name" class="input-xlarge" required="">
    
			    </div>
			  </div>
			  
			  <div class="control-group">
			    <label class="control-label">Position</label>
			    <div class="controls">
					<select name = "position" id = "pos_selection">
						<option value="General Member">General Member</option>
						<option value="President">President</option>
						<option value="Vice Presidet">Vice President</option>
						<option value="Secretary">Secretary</option>
						<option value="Treasurer">Treasurer</option>
						<option value="Social Chair">Social Chair</option>
						<option value="Scholarship Chair">Scholarship Chair</option>
						<option value="Phikea Ed Chair">Phikea Ed Chair</option>
						<option value="Treasurer">Treasurer</option>
						<option value="Warden">Warden</option>
						<option value="Member At Large">Member At Large</option>
						<option value="Webmaster">Webmaster</option>
						<option value="Assistant Treasurer">Assistant Treasurer</option>
						<option value="Public Relations Chair">Public Relations Chair</option>
						<option value="Chaplain">Chaplain</option>
						<option value="Bylaws Chair">Bylaws Chair</option>
						<option value="Philanthropy Chair">Philanthropy Chair</option>
						<option value="Historian">Historian</option>
						<option value="Risk Manager">Risk Manager</option>
						<option value="Community Service">Community Service</option>
						<option value="Athletics Chair">Athletics Chair</option>
						<option value="Alumni Relations Officer">Alumni Relations Officer</option>
						<option value="Fundraising Chair">Fundraising Chair</option>
						<option value="Choruster">Choruster</option>
						<option value="House Manager">House Manager</option>
						<option value="Professional Development Chair">Professional Development Chair</option>
						<option value="Greek Sing Chair">Greek Sing Chair</option>
					</select>
			    </div>
			  </div>
			  
			  <div class="control-group">
			    <label class="control-label" for="email_inp">Email</label>
			    <div class="controls">
			      <input id="email_inp" name="email" type="text" placeholder="Enter username" class="input-xlarge" required="">
    
			    </div>
			  </div>
			  
			  <div class="control-group">
			    <label class="control-label" for="user_inp">Username</label>
			    <div class="controls">
			      <input id="user_inp" name="user_name" type="text" placeholder="Enter username" class="input-xlarge" required="">
    
			    </div>
			  </div>
			  

			  <!-- Password input-->
			  <div class="control-group">
			    <label class="control-label" for="pass_inp">Password</label>
			    <div class="controls">
			      <input id="pass_inp" name="password" type="password" placeholder="Enter your password" class="input-xlarge" required="">
			    </div>
			</br>
			 	<label class="control-label" for="pic_file">Upload a Picture</label>
			    <div class="controls">
			       <input type="file" name="file" id="file" />
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