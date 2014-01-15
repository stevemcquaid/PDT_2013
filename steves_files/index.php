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
  <script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-47177860-1', 'phideltcmu.com');
    ga('send', 'pageview');

  </script>
</body>
</html>