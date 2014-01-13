<?php
	require("common.php");
	
	$default_pos = "General Member";
	
	$query = "UPDATE users
			  SET position = :generic";
	
	$query_params = array(":generic" => $default_pos);
	
    try 
    { 
        $stmt = $db->prepare($query); 
        $result = $stmt->execute($query_params); 
    } 
    catch(PDOException $ex) 
    { 
        die("Failed to run query: " . $ex->getMessage()); 
    }
	
	$handle = fopen("positions.tsv","r");
	if ($handle)
	{
		while (($line = fgets($handle)) !== false)
		{
			$student_data = explode("\t", $line);
			$position = $student_data[0];
			
			$user_name = str_replace(" ","",$student_data[1]);
			$user_name = PREG_REPLACE("/[^0-9a-zA-Z]/i", '', $user_name);
			
			echo($position . ": " . $user_name . "\n");
			
			$query = "SELECT position
					  FROM users
					  WHERE
					  	username = :user";
			
			$query_params = array ( ":user" => $user_name );
			
	        try 
	        { 
	            $stmt = $db->prepare($query); 
	            $result = $stmt->execute($query_params); 
	        } 
	        catch(PDOException $ex) 
	        { 
	            die("Failed to run query: "); 
	        }
			$row = $stmt->fetch();
			
			$query = "UPDATE users
					  SET 
						position = :position
					  WHERE
					  	username = :user";
			
			$query_params = array ( 
									":user" => $user_name,
			 						":position" => $position 
								  );
			
			if ($row)
			{
		        try 
		        { 
		            $stmt = $db->prepare($query); 
		            $result = $stmt->execute($query_params); 
		        } 
		        catch(PDOException $ex) 
		        { 
		            die("Failed to run query: " . $ex->getMessage()); 
		        }
			}
		}
		fclose($handle); 
	} else {
		fclose($handle);
		die("Failed to execute");
	}