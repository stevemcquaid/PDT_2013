<?php
require("common.php");
$link_ref = "";
if (!isset($_SESSION['user']))
{
	$link_ref = "<a href = 'login.php'>Login?</a>";
} else {
	$link_ref = "<div><b>Hello " . $_SESSION['user']['first_name'] . ".</b>  <a href = 'logout.php'>Logout?</a></div> or view <a href = 'edit_account.php'> Account Settings </a>";
}
echo "<br><br>"
?>
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
  
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <!-- You'll want to use a responsive image option so this logo looks good on devices - I recommend using something like retina.js (do a quick Google search for it and you'll find it) -->
  <a class="navbar-brand" href="index.php">
	  Phi Delta Theta CMU <?php $_SESSION['curr_page_req'] = "index.php"?>
  </a>
  <!-- title of page in navbar -->
	  
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse navbar-ex1-collapse">
      <ul class="nav navbar-nav navbar-right">
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"> About Our Chapter <b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="mission-statement.html"> Our Mission <?php $_SESSION['curr_page_req'] = "mission-statement.html"?> </a></li>
              <li><a href="facts-figures.html"> Facts and Figures <?php $_SESSION['curr_page_req'] = "facts-figures.html"?> </a></li>
		  <li><a href="executive-board.php"> Executive Board <?php $_SESSION['curr_page_req'] = "executive-board.php"?> </a></li>
		  <li><a href="gallery.php"> Gallery <?php $_SESSION['curr_page_req'] = "gallery.php"?> </a></li>
            </ul>
          </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Recruitment <b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a href="recruitment-info.php"> Recruitment Information <?php $_SESSION['curr_page_req'] = "recruitment-info.php"?> </a></li>
            <li><a href="faq.html"> Recruitement FAQ <?php $_SESSION['curr_page_req'] = "faq.html"?> </a></li>
            <li><a href="contact.php"> Contact Us <?php $_SESSION['curr_page_req'] = "contact.php"?> </a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Activities <b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a href="#x"> Stuff <?php $_SESSION['curr_page_req'] = "index.php"?> </a></li>
            <li><a href="blog.html"> Newsletter <?php $_SESSION['curr_page_req'] = "blog.html"?> </a></li>
          </ul>
        </li> 
        <li><a href="brothers.php"> Brothers <?php $_SESSION['curr_page_req'] = "brothers.php"?> </a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container -->
</nav>
<div style = "text-align:right;margin-right:20px;">
  <a href = "login.php"><?php echo $link_ref ?></a>
</div>