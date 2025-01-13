<?php
error_reporting(E_ALL);
include('includes/dbconnection.php');
require "vendor/autoload.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

session_start();

if (isset($_POST['submit'])) {
    // Strengthen password requirements
    if (strlen($_POST['password']) < 8) {
        echo '<script>alert("Password must be at least 8 characters long")</script>';
        echo "<script>window.location.href = 'registration.php';</script>";
        exit;
    }

    // Retrieve form data with stronger sanitization
    $fullname = htmlspecialchars(trim($_POST['fullname']), ENT_QUOTES, 'UTF-8');
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo '<script>alert("Invalid email address.")</script>';
        echo "<script>window.location.href = 'registration.php';</script>";
        exit;
    }
    
    // Validate type is only 2 or 3
    $type = filter_var($_POST['type'], FILTER_VALIDATE_INT);

    if ($type === false || !in_array($type, [2, 3], true)) {
        echo '<script>alert("Invalid user type selected.");</script>';
        echo "<script>window.location.href = 'registration.php';</script>";
        exit;
    }

    // Use password_hash instead of md5
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Add CSRF protection
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        echo '<script>alert("Invalid request")</script>';
        exit;
    }

    // Get all staff_id values from staff_information
    $staffSQL = "SELECT staff_id FROM staff_information";
    $staffQuery = $dbh->prepare($staffSQL);
    $staffQuery->execute();
    $staffIds = $staffQuery->fetchAll(PDO::FETCH_ASSOC);

    // Check if staff_id 100005 is already assigned to a supervisor
    if ($type == 2) { // Supervisor role
        $checkSupervisorSQL = "SELECT COUNT(*) AS supervisorCount FROM users WHERE staff_id = 100005";
        $checkSupervisorQuery = $dbh->prepare($checkSupervisorSQL);
        $checkSupervisorQuery->execute();
        $supervisorAssigned = $checkSupervisorQuery->fetch(PDO::FETCH_ASSOC);

        if ($supervisorAssigned['supervisorCount'] > 0) {
            // If staff_id 100005 is already assigned, show an error message
            echo '<script>alert("The Supervisor is already assigned. Please contact the administrator for add new account.")</script>';
            echo "<script>window.location.href = 'registration.php';</script>";
            exit; // Stop further execution
        }
    }

    // For Baker, check if 4 Bakers are already assigned
    if ($type == 3) { // Baker role
        $checkBakerSQL = "SELECT COUNT(*) AS bakerCount FROM users WHERE type = 3";
        $checkBakerQuery = $dbh->prepare($checkBakerSQL);
        $checkBakerQuery->execute();
        $bakerAssigned = $checkBakerQuery->fetch(PDO::FETCH_ASSOC);

        if ($bakerAssigned['bakerCount'] >= 5) {
            // If 4 Bakers are already assigned, show an error message
            echo '<script>alert("Maximum of 4 Bakers have been assigned. Please contact the administrator to add more.")</script>';
            echo "<script>window.location.href = 'registration.php';</script>";
            exit; // Stop further execution
        }
    }

    // Proceed with the registration if staff_id 100005 is not assigned or user is not a supervisor
    $sql = "INSERT INTO users (fullname, email, password, type) VALUES (:fullname, :email, :password, :type)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':fullname', $fullname, PDO::PARAM_STR);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':password', $password, PDO::PARAM_STR);
    $query->bindParam(':type', $type, PDO::PARAM_STR);
    $query->execute();

    $LastInsertId = $dbh->lastInsertId(); // Get the last inserted ID in the users table

    if ($LastInsertId > 0) {
        if ($type == 2) { // Supervisor
            // Assign staff_id = 100005 to the supervisor
            $updateSQL = "UPDATE users SET staff_id = 100005 WHERE id = :user_id";
            $updateQuery = $dbh->prepare($updateSQL);
            $updateQuery->bindParam(':user_id', $LastInsertId, PDO::PARAM_INT);
            $updateQuery->execute();

            // Update the staff_information table with the user_id for staff_id = 100005
            $updateStaffSQL = "UPDATE staff_information SET user_id = :user_id WHERE staff_id = 100005";
            $updateStaffQuery = $dbh->prepare($updateStaffSQL);
            $updateStaffQuery->bindParam(':user_id', $LastInsertId, PDO::PARAM_INT);
            $updateStaffQuery->execute();
        } else { // Baker
            // Assign any available staff_id other than 100005
            foreach ($staffIds as $staff) {
                if ($staff['staff_id'] != 100005) {
                    $staff_id = $staff['staff_id'];
                    // Check if this staff_id is already assigned to a user
                    $checkStaffSQL = "SELECT COUNT(*) AS count FROM users WHERE staff_id = :staff_id";
                    $checkStaffQuery = $dbh->prepare($checkStaffSQL);
                    $checkStaffQuery->bindParam(':staff_id', $staff_id, PDO::PARAM_INT);
                    $checkStaffQuery->execute();
                    $staffAssigned = $checkStaffQuery->fetch(PDO::FETCH_ASSOC);

                    if ($staffAssigned['count'] == 0) {
                        // Assign the first available staff_id to the baker
                        $updateSQL = "UPDATE users SET staff_id = :staff_id WHERE id = :user_id";
                        $updateQuery = $dbh->prepare($updateSQL);
                        $updateQuery->bindParam(':staff_id', $staff_id, PDO::PARAM_INT);
                        $updateQuery->bindParam(':user_id', $LastInsertId, PDO::PARAM_INT);
                        $updateQuery->execute();

                        // Update the staff_information table with the user_id for the assigned staff_id
                        $updateStaffSQL = "UPDATE staff_information SET user_id = :user_id WHERE staff_id = :staff_id";
                        $updateStaffQuery = $dbh->prepare($updateStaffSQL);
                        $updateStaffQuery->bindParam(':user_id', $LastInsertId, PDO::PARAM_INT);
                        $updateStaffQuery->bindParam(':staff_id', $staff_id, PDO::PARAM_INT);
                        $updateStaffQuery->execute();

                        break; // Exit the loop once we've assigned an available staff_id
                    }
                }
            }
        }

        // Send registration email
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->Username = "eazysurvey123@gmail.com";
        $mail->Password = "cqlprqrgtttssphq";
        $mail->setFrom($email, "EazySurvey | Survey Management System");
        $mail->addAddress($_POST["email"], $_POST['fullname']);
        $mail->Subject = "Welcome onboard with us, EazySurvey";
        $mail->Body = "Dear $fullname,

We would like to thank you for choosing us as your choice to manage your survey with us.
Your role (1-Supervisor, 2-Baker): $type.
Your Username: $email, 
Your Password: $password.

Your Sincerely,
EazySurvey Team
easysurvey123@gmail.com";

        $mail->send();

        echo '<script>alert("Successfully Registered. Thank You for joining us")</script>';
        echo "<script>window.location.href ='login.php'</script>";
    } else {
        echo '<script>alert("Something Went Wrong. Please try again")</script>';
    }
}

// Add CSRF token to form
$csrf_token = bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $csrf_token;

?>

<!doctype html>
<html>
<head>
<title>Production System | Registration </title>
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
<!--header-->
		<?php include_once('includes/header.php');?>

<!-- Top Navigation -->
<div class="banner banner5">
	<div class="container">
	<h2>Registration</h2>
	</div>
</div>
<!--header-->
		<!-- contact -->
		<div class="contact">
			<!-- container -->
			<div class="container">
				<div class="contact-info">
				<h3 class="c-text">Register Here</h3>
				</div>
				
				<div class="contact-grids">
                <form class="forms-sample" method="post" enctype="multipart/form-data">
                <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                <h3>Information details</h3>
                      <div class="form-group">
                        <label for="exampleInputName1">Full Name</label>
                        <input style="width:50%;" type="text" name="fullname" value="" class="form-control" required='true'>
                      </div>
					  <div class="form-group">
                        <label for="exampleInputName1">Role</label>
                        <select style="width:50%;" name="type" value="" class="form-control" required='true'>
                          <option value="">Choose your Role</option>
                          <option value="3">Baker</option>
                          <option value="2">Supervisor</option>
                        </select>
                      </div>
					  <h3>Login details</h3>
                      <div class="form-group">
                        <label for="exampleInputName1">Email</label>
                        <input style="width:50%;" type="email" name="email" value="" class="form-control" required='true'>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Password</label>
                        <input  style="width:50%;" type="password" name="password" value="" class="form-control" required='true'>
                      </div>
                      <button type="submit" class="btn btn-primary mr-2" name="submit">Register</button>
                      
  
					<div class="clearfix"> </div>
				</div>
			</div>
			<!-- //container -->
		</div>
		<!-- //contact -->
<?php include_once('includes/footer.php');?>
	</body>
</html>
