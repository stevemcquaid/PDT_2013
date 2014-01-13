<? ob_start(); ?>
<?php
	require("common.php");
	$query = "SELECT *
			  FROM users
			  WHERE position = :pos";
				 
	$e_board_names = array();
	$e_board_positions = array();
	$e_board_pictures = array();

	for ($i = 0; $i < count($e_board); $i++)
	{
		$query_params = array( ':pos' => $e_board[$i] );
	  	try
	  	{
	  		$stmt = $db->prepare($query);
	  		$result = $stmt->execute($query_params);
	  	}
	    catch(PDOException $ex) 
	    {
			die("Failed to run query: ". $e_board[$i]); 
	    }
		$row = $stmt->fetch();
	  	if ($row)
	  	{
	  		array_push($e_board_names,$row['first_name'] . " " . $row['last_name']);
			array_push($e_board_positions,$row['position']);
			array_push($e_board_pictures,$row['picture']);
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

    <title>E-board</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Add custom CSS here -->
    <link href="css/modern-business.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet">
  </head>

  <body>

    <div id = "includedNav"> </div>

    <div class="container">
		
      <!-- Team Member Profiles -->

      <div class="row" id = "e_board_row">

        <div class="col-lg-12">
          <h2 class="page-header">Executive Board</h2>
        </div>

      </div>

      <!-- Our Customers -->


    </div><!-- /.container -->


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
		
		var js_names =<?php echo json_encode($e_board_names );?>;
		var js_pos =<?php echo json_encode($e_board_positions );?>;
		var js_pics =<?php echo json_encode($e_board_pictures );?>;
		
		for (var i = 0; i < js_names.length; i++)
		{
			var inner_html = '<div class="col-sm-3" style = "text-align:center;"><img class="img-responsive" src="' + js_pics[i] +'"> <h3>'+js_names[i]+'</h3><h5><small>' + js_pos[i] + '</small></h5></div>';
			$("#e_board_row").append(inner_html);
		}
		
	</script>
  </body>
</html>
<? ob_flush(); ?>