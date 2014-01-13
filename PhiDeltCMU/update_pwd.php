<?php
	require("common.php");
	if (!empty($_POST))
	{
		$new_pwd = str_replace(" ","",$_POST['pwd']);
		$check_pwd = str_replace(" ","",$_POST['check_pwd']);
		$i = strlen($new_pwd);
		if ($i < 6 || $i > 20)
		{
			$_SESSION['update_pwd_message'] = "Password must be 6 to 20 characters without spaces";
			header("edit_account.php");
			die("Redirecting to Account Settings");
			
		}
			
		if ($new_pwd != $check_pwd)
		{
			$_SESSION['update_pwd_message'] = "Both password entries must be the same";
			header("edit_account.php");
			die("Redirecting to Account Settings");
		}
		
		$_SESSION['update_pwd_message'] = "Enter New Password";
		
		$query = "SELECT
					password,
					salt
				  FROM
				  	users
				  WHERE
				    username = :user";
					
		$query_params = array (":user" => $_SESSION['user']['username']);
		
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
		
		$row = $result->fetch();
		$salt = $row['salt'];
		$old_pwd_check = $row['password'];
		unset($row);
		unset($result);
		
		if ($_POST['old_pwd'] != $old_pwd_check)
		{
			$_SESSION['update_old_pwd_message'] = "Incorrect Old Password";
			header("edit_account.php");
			die("Redirecting to Account Settings");
		}
		$_SESSION['update_old_pwd_message'] = "Enter Old Password";
		
		
		for ($round = 0; $round < $num_hashes; $round++)
		{
			$new_pwd = hash('sha256', $new_pwd . $salt); 
		}
		
		/*$query = 'UPDATE users
				  SET password = :pass
				  WHERE username = :user';
				  
		$query_params = array (
								":pass" => $new_pwd,
								":user" => $_SESSION['user']['username']
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
		
		
		$_SESSION['update_pwd_message'] = "Enter New Password";
		
		unset($salt);
		unset($new_pwd);
		unset($_POST['pwd']);
		unset($_POST['check_pwd']);
		unset($_POST['old_pwd']);
		
		header("Location: edit_account.php");
		die("Redirecting to account settings"); */
	}


