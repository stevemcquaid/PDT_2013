<?php
	require("common.php");
	if (!empty($_POST))
	{
        if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) 
        {
			$_SESSION['update_email_message'] = "Please enter a valid email address";
        } else {
			$_SESSION['update_email_message'] = "Primary Email Address";
		
			$query = 'UPDATE users
					  SET email = :email
					  WHERE username = :user';
		
			$query_params = array (
									':email' => $_POST['email'],
									':user' => $_SESSION['user']['username']
								  );
	  	
			try
		  	{
		  		$stmt = $db->prepare($query);
		  		$stmt->execute($query_params);
		  	}
		    catch(PDOException $ex) 
		    {
		  	    die("Failed to run query: "); 
		    }	

			$_SESSION['user']['email'] = $_POST['email'];
        }
		
		header("Location: edit_account.php");
		die("Redirecting to account settings");
	}


