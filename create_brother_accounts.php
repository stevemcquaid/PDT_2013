<?php
	require("common.php");
	$handle = fopen("Brothers_list.tsv","r");
	if ($handle)
	{
		$inc = 0;
		while (($line = fgets($handle)) !== false)
		{
			$student_data = explode("\t", $line);
			$first_name = $student_data[0];
			$last_name = $student_data[1];
			$email = $student_data[2];
			$email_data = explode("@",$email);
			$user_name = str_replace(" ","",$email_data[0]);
			$email_address = $user_name . "@" . $email_data[1];
			
			$picture = "images/profiles/default.jpg";
			$position = "General Member";
			$password = "morrison" . $inc;
			$salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647));
			 
	        for($round = 0; $round < $num_hashes; $round++) 
	        { 
	            $password = hash('sha256', $password . $salt); 
	        }
			
			$inc ++;
			
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
			
	        $query_params = array( 
	            ':username' => $user_name, 
	            ':password' => $password, 
				':first_name' => $first_name,
				':last_name' => $last_name,
				':picture' => $picture,
	            ':salt' => $salt, 
	            ':email' => $email_address,
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
	            die("Failed to run query: " . $ex->getMessage()); 
	        }
		}
		fclose($handle); 
	} else {
		fclose($handle);
		die("Failed to execute");
	}