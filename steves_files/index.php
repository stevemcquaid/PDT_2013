<!DOCTYPE html>
<html lang="en">

<?php include('app/layout_partials/header.php'); ?>

<body style="">
  <?php include('app/layout_partials/navbar.php'); ?>

  <?php
  //simple routing 
  $the_get_request = $_GET['p'];
  if (!empty($the_get_request) && in_array($the_get_request . ".php", scandir("app/pages/", 1)) ) {
    $page = $the_get_request;
  } else {
    $page = 'home';
  }
  ?>
  
  <?php include('app/pages/' . $page . '.php'); //yield page ?>

  <?php include('app/layout_partials/footer.php'); ?>
  
  <!-- Bootstrap core JavaScript
  ================================================== -->
  <!-- Placed at the end of the document so the pages load faster -->
  <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="dist/js/bootstrap.min.js"></script>
  <script src="dist/js/holder.js"></script>
</body>
</html>