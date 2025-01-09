<?php
error_reporting(E_ALL);
include('includes/dbconnection.php');
require "vendor/autoload.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

if (isset($_POST['submit'])) {
    try {
        // Start transaction
        $dbh->beginTransaction();

        // Validate and sanitize user inputs
        $fullname = htmlspecialchars(trim($_POST['fullname']), ENT_QUOTES, 'UTF-8');
        $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid email address.");
        }

        // Validate user type
        $type = filter_var($_POST['type'], FILTER_VALIDATE_INT);
        if (!in_array($type, [2, 3])) {
            throw new Exception("Invalid user type selected.");
        }

        // Use secure password hashing
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        // Check if email already exists
        $checkEmailSQL = "SELECT COUNT(*) FROM users WHERE email = :email";
        $checkEmailQuery = $dbh->prepare($checkEmailSQL);
        $checkEmailQuery->bindParam(':email', $email, PDO::PARAM_STR);
        if (!$checkEmailQuery->execute()) {
            throw new Exception("Error checking email existence.");
        }
        if ($checkEmailQuery->fetchColumn() > 0) {
            throw new Exception("Email already registered.");
        }

        // Get all staff_id values
        $staffSQL = "SELECT staff_id FROM staff_information WHERE user_id IS NULL";
        $staffQuery = $dbh->prepare($staffSQL);
        if (!$staffQuery->execute()) {
            throw new Exception("Failed to fetch available staff IDs.");
        }
        $staffIds = $staffQuery->fetchAll(PDO::FETCH_ASSOC);
        if (empty($staffIds)) {
            throw new Exception("No staff IDs available. Please contact administrator.");
        }

        // Supervisor validation
        if ($type == 2) {
            $checkSupervisorSQL = "SELECT COUNT(*) FROM users WHERE staff_id = 100005";
            $checkSupervisorQuery = $dbh->prepare($checkSupervisorSQL);
            if (!$checkSupervisorQuery->execute()) {
                throw new Exception("Failed to check supervisor status.");
            }
            if ($checkSupervisorQuery->fetchColumn() > 0) {
                throw new Exception("The Supervisor is already assigned. Please contact the administrator.");
            }
        }

        // Baker validation
        if ($type == 3) {
            $checkBakerSQL = "SELECT COUNT(*) FROM users WHERE type = 3";
            $checkBakerQuery = $dbh->prepare($checkBakerSQL);
            if (!$checkBakerQuery->execute()) {
                throw new Exception("Failed to check baker count.");
            }
            if ($checkBakerQuery->fetchColumn() >= 4) {
                throw new Exception("Maximum number of Bakers (4) has been reached.");
            }
        }

        // Insert new user
        $sql = "INSERT INTO users (fullname, email, password, type) VALUES (:fullname, :email, :password, :type)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':fullname', $fullname, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':password', $password, PDO::PARAM_STR);
        $query->bindParam(':type', $type, PDO::PARAM_INT);
        
        if (!$query->execute()) {
            throw new Exception("Failed to create user account.");
        }

        $LastInsertId = $dbh->lastInsertId();

        // Assign staff ID based on role
        if ($type == 2) {
            // Supervisor assignment
            $updateSQL = "UPDATE users SET staff_id = 100005 WHERE id = :user_id";
            $updateQuery = $dbh->prepare($updateSQL);
            $updateQuery->bindParam(':user_id', $LastInsertId, PDO::PARAM_INT);
            if (!$updateQuery->execute()) {
                throw new Exception("Failed to assign supervisor staff ID.");
            }

            // Update staff_information
            $updateStaffSQL = "UPDATE staff_information SET user_id = :user_id WHERE staff_id = 100005";
            $updateStaffQuery = $dbh->prepare($updateStaffSQL);
            $updateStaffQuery->bindParam(':user_id', $LastInsertId, PDO::PARAM_INT);
            if (!$updateStaffQuery->execute()) {
                throw new Exception("Failed to update staff information for supervisor.");
            }
        } else {
            // Baker assignment
            $staffAssigned = false;
            foreach ($staffIds as $staff) {
                if ($staff['staff_id'] != 100005) {
                    $staff_id = $staff['staff_id'];
                    
                    // Update users table
                    $updateSQL = "UPDATE users SET staff_id = :staff_id WHERE id = :user_id";
                    $updateQuery = $dbh->prepare($updateSQL);
                    $updateQuery->bindParam(':staff_id', $staff_id, PDO::PARAM_INT);
                    $updateQuery->bindParam(':user_id', $LastInsertId, PDO::PARAM_INT);
                    
                    if ($updateQuery->execute()) {
                        // Update staff_information
                        $updateStaffSQL = "UPDATE staff_information SET user_id = :user_id WHERE staff_id = :staff_id";
                        $updateStaffQuery = $dbh->prepare($updateStaffSQL);
                        $updateStaffQuery->bindParam(':user_id', $LastInsertId, PDO::PARAM_INT);
                        $updateStaffQuery->bindParam(':staff_id', $staff_id, PDO::PARAM_INT);
                        
                        if ($updateStaffQuery->execute()) {
                            $staffAssigned = true;
                            break;
                        }
                    }
                }
            }
            
            if (!$staffAssigned) {
                throw new Exception("Failed to assign staff ID to baker.");
            }
        }

        // Send registration email
        try {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->SMTPAuth = true;
            $mail->Host = "smtp.gmail.com";
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
            $mail->Username = "eazysurvey123@gmail.com";
            $mail->Password = "cqlprqrgtttssphq";
            $mail->setFrom("eazysurvey123@gmail.com", "EazySurvey | Survey Management System");
            $mail->addAddress($email, $fullname);
            $mail->Subject = "Welcome onboard with us, EazySurvey";
            $mail->Body = "Dear $fullname,

We would like to thank you for choosing us as your choice to manage your survey with us.
Your role: " . ($type == 2 ? "Supervisor" : "Baker") . "
Your Username: $email
Please login to set up your password.

Your Sincerely,
EazySurvey Team
easysurvey123@gmail.com";

            $mail->send();
        } catch (Exception $e) {
            error_log("Failed to send email: " . $e->getMessage());
            // Continue with registration even if email fails
        }

        // Commit transaction
        $dbh->commit();
        
        echo '<script>alert("Successfully Registered. Thank You for joining us")</script>';
        echo "<script>window.location.href ='login.php'</script>";
        
    } catch (Exception $e) {
        // Rollback transaction on error
        $dbh->rollBack();
        error_log("Registration error: " . $e->getMessage());
        echo '<script>alert("' . htmlspecialchars($e->getMessage(), ENT_QUOTES) . '")</script>';
        echo "<script>window.location.href = 'registration.php';</script>";
    }
}
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
