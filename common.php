<?php

    //Database variables
	$username = "root"; //not in use anymore
	$password = "morrison"; //not in use anymore
	$host = "localhost"; //not in use anymore
	$dbname = "nitelit1_pdt2014"; //not in use anymore

	//This is a file outside of the git repo for security reasons.
	//This file OVERWRITES THE DB VARS!!!!!
    if(file_exists('secret.php')){
    	// Include the file if on prod || dev
	    include('secret.php'); 
	}

	
	$num_hashes = 1337;
	$max_image_size = 20000;
	
	$e_board = array(  "President",
					   "Vice President",
				   	   "Secretary",
					   "Recruitment Chair",
				   	   "Social Chair",
				   	   "Scholarship Chair",
				   	   "Phikeia Ed Chair",
				   	   "Treasurer",
				   	   "Warden",
				   	   "Member At Large"
				     );
					   
	$special_pos = array("Webmaster");
	
	$positions = array("President",
					   "Vice President",
				   	   "Secretary",
					   "Recruitment Chair",
				   	   "Social Chair",
				   	   "Scholarship Chair",
				   	   "Phikeia Ed Chair",
				   	   "Treasurer",
				   	   "Warden",
				   	   "Member At Large",
					   "Webmaster",
					   "Assistant Treasurer",
					   "Public Relations Chair",
				   	   "Chaplain",
				   	   "Bylaws Officer",
				       "Philanthropy Officer",
					   "Brotherhood Officer",
				   	   "Historian",
				       "Risk Management Officer",
				   	   "Community Service OFficer",
				   	   "Athletics Officer",
					   "Alumni Relations Officer",
					   "Fundraising Chair",
					   "Chorister",
					   "House Manager",
					   "Professional Development Officer",
					   "Greek Sing Chair",
					   "General Member"
				   	   );
					   
    $chairs = array("Greek Sing Chair",
					"Social Chair",
					"Scholarship Chair",
			   	    "Bylaws Officer",
			        "Philanthropy Officer",
					"Phikea Ed Chair",
					"Fundraising Chair",
				    );
		
	$options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
    try 
    { 
           // This statement opens a connection to your database using the PDO library 
           // PDO is designed to provide a flexible interface between PHP and many 
           // different types of database servers.  For more information on PDO: 
           // http://us2.php.net/manual/en/class.pdo.php 
           $db = new PDO("mysql:host={$host};dbname={$dbname};charset=utf8", $username, $password, $options); 
    } 
    catch(PDOException $ex) 
    { 
           // If an error occurs while opening a connection to your database, it will 
           // be trapped here.  The script will output an error and stop executing. 
           // Note: On a production website, you should not output $ex->getMessage(). 
           // It may provide an attacker with helpful information about your code 
           // (like your database username and password). 
        die("Failed to connect to the database: " . $ex->getMessage()); 
    } 
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); 
     
       // This block of code is used to undo magic quotes.  Magic quotes are a terrible 
       // feature that was removed from PHP as of PHP 5.4.  However, older installations 
       // of PHP may still have magic quotes enabled and this code is necessary to 
       // prevent them from causing problems.  For more information on magic quotes: 
       // http://php.net/manual/en/security.magicquotes.php 
   if(function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc()) 
   { 
      function undo_magic_quotes_gpc(&$array) 
      { 
          foreach($array as &$value) 
              { 
                  if(is_array($value)) 
                  { 
                      undo_magic_quotes_gpc($value); 
                  } 
                  else 
                  { 
                  $value = stripslashes($value); 
               	  } 
              } 
      } 
     
      undo_magic_quotes_gpc($_POST); 
      undo_magic_quotes_gpc($_GET); 
      undo_magic_quotes_gpc($_COOKIE); 
   } 
     
       // This tells the web browser that your content is encoded using UTF-8 
       // and that it should submit content back to you using UTF-8 
   header('Content-Type: text/html; charset=utf-8'); 
     
   session_start(); 
   $_SESSION['gallery_page_limit'] = 16;
   $_SESSION['gallery_start'] = 0;
   $_SESSION['gallery_end'] = $_SESSION['gallery_start'] + $_SESSION['gallery_page_limit'];
   $_SESSION['gallery_curr'] = 0;
   
   $table_count_query = 'SELECT
	   						COUNT(*)
					     AS total
						 FROM
					 	    gallery';
							
   $gallery_count_params = array();
 	try
 	{
 		$stmt = $db->prepare($table_count_query);
 		$result = $stmt->execute($gallery_count_params);
 	}
   catch(PDOException $ex) 
   {
 	    die("Failed to run query"); 
   }
   $result = $stmt->fetch();
   $_SESSION['gallery_count'] = $result['total'];
