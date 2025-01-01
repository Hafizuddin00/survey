<?php
      session_start();
      error_reporting(0);
      include('includes/dbconnection.php');
      ?>
      <!doctype html>
      <html>
      <head>
      <title>Ryan Bakery | Welcome to Production System</title>
      <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
      <!--bootstrap-->
      <link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all">
      <!--coustom css-->
      <link href="css/style.css" rel="stylesheet" type="text/css"/>
      <link rel="icon" href="images/icon.png" type="image/icon type">
      <!--script-->
      <script src="js/jquery-1.11.0.min.js"></script>
      <!-- js -->
      <script src="js/bootstrap.js"></script>
      <!-- /js -->
      <!--fonts-->
      <link href='//fonts.googleapis.com/css?family=Open+Sans:300,300italic,400italic,400,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css'>
      <!--/fonts-->
      <!--hover-girds-->
      <link rel="stylesheet" type="text/css" href="css/default.css" />
      <link rel="stylesheet" type="text/css" href="css/component.css" />
      <script src="js/modernizr.custom.js"></script>
      <!--/hover-grids-->
      <script type="text/javascript" src="js/move-top.js"></script>
      <script type="text/javascript" src="js/easing.js"></script>
      <!--script-->
      <script type="text/javascript">
            jQuery(document).ready(function($) {
              $(".scroll").click(function(event){		
                event.preventDefault();
                $('html,body').animate({scrollTop:$(this.hash).offset().top},900);
              });
            });
      </script>
      <!--/script-->
      </head>
        <body>
      <?php include_once('includes/header.php');?>
      <div class="banner">
        <div class="container">
        <script src="js/responsiveslides.min.js"></script>
      <script>
          $(function () {
            $("#slider").responsiveSlides({
              auto: true,
              nav: true,
              speed: 500,
              namespace: "callbacks",
              pager: true,
            });
          });
        </script>
<div class="slider">
       <div class="callbacks_container">
        <ul class="rslides" id="slider">
         <li>     
          <h3>Production Management System</h3>      
           <p>Welcome to Ryan Bakery !!</p>             
          <div class="readmore">
          <a href="registration.php" class = "rounded-button">Register Here<i class="glyphicon glyphicon-menu-right"> </i></a>
          </div>
         </li>

 
        </ul>
      </div>
    </div>
</div>      
  </div>
<div class="welcome">
	<div class="container">
		<?php
$sql="SELECT * from page where PageType='aboutus'";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);

$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $row)
{               ?>
		<h2><?php  echo htmlentities($row->PageTitle);?></h2>
    <p>Welcome to our Bakery Production Management System! We are a team of dedicated software developers who have designed a platform to streamline the entire bakery production process. Our goal is to provide an efficient, easy-to-use system that simplifies production planning, inventory management, and order tracking. With our system, bakery managers can seamlessly schedule production, manage inventory levels, track batch progress, and ensure timely delivery of baked goods. The platform also allows for real-time monitoring of production status, giving you complete visibility over your operations. We understand the importance of quality control and have integrated features to ensure consistency and accuracy in every batch. Our team is committed to supporting your bakery’s success, providing exceptional customer service, and ensuring that your production runs smoothly. Thank you for choosing our Bakery Production Management System – we are here to help you enhance your bakery operations and achieve your production goals!</p> 
		<?php $cnt=$cnt+1;}} ?>
	</div>
</div>
<!--/welcome-->

<!--\testmonials-->
<!--specfication-->

<!--/specfication-->
<?php include_once('includes/footer.php');?>
<!--/copy-rights-->
	</body>
</html>
