<?php
error_reporting(E_ALL);
include('includes/dbconnection.php');
require "vendor/autoload.php";
  
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\SMTP;
if(isset($_POST['submit']))
{
    // Sanitize inputs
    $Name = htmlspecialchars(strip_tags($_POST['name']), ENT_QUOTES, 'UTF-8');
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $Subject = htmlspecialchars(strip_tags($_POST['subject']), ENT_QUOTES, 'UTF-8');
    $message = htmlspecialchars(strip_tags($_POST['message']), ENT_QUOTES, 'UTF-8');

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo '<script>alert("Invalid email format")</script>';
        exit;
    }

    $mail = new PHPMailer(true);
  
  // $mail->SMTPDebug = SMTP::DEBUG_SERVER;
  
  $mail->isSMTP();
  $mail->SMTPAuth = true;
  
  $mail->Host = "smtp.gmail.com";
  $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
  $mail->Port = 587;
  
  $mail->Username = "eazysurvey123@gmail.com";
  $mail->Password = "cqlprqrgtttssphq";
  
  $mail->setFrom($email, "EazySurvey | Survey Management System");
  $mail->addAddress($_POST["email"]);
  
  // Set email content with sanitized data
  $mail->Subject = $Subject;
  $mail->Body = sprintf(
      "Dear %s,\n\n%s\n\nYour Sincerely\nEazySurvey Team\neasysurvey123@gmail.com",
      $Name,
      $message
  );
  
  $mail->send();
  echo '<script>alert("Email Successfully Sent ")</script>';
}
?>
<head>
<link rel="icon" href="images/icon.png" type="image/icon type">
</head>
<body>
<div class="col-lg-12">
	<div class="card">
		<div class="card-body">
			<form action="" id="manage_user" method="post">
				<input type="hidden" name="id" value="<?php echo isset($ID) ? $ID : '' ?>">
				<div class="row">
					<div class="col-md-6 border-right">
						<b class="text-muted">Message</b>
						<div class="form-group">
							<label for="" class="control-label">Name</label>
							<input type="text" name="name" class="form-control form-control-sm" required value="<?php echo htmlspecialchars(isset($Name) ? $Name : '', ENT_QUOTES, 'UTF-8'); ?>">
						</div>
                        <div class="form-group">
							<label for="" class="control-label">Email</label>
							<input type="text" name="email" class="form-control form-control-sm" required value="<?php echo htmlspecialchars(isset($Email) ? $Email : '', ENT_QUOTES, 'UTF-8'); ?>">
						</div>
						<div class="form-group">
							<label for="" class="control-label">Subject</label>
							<input type="text" name="subject" class="form-control form-control-sm" required value="<?php echo htmlspecialchars(isset($Email) ? $Email : '', ENT_QUOTES, 'UTF-8'); ?>">
						</div>
                        <div class="form-group">
							<label for="" class="control-label">Message</label>
							<textarea type="text" name="message" class="form-control form-control-sm" required value=""></textarea>
						</div>
				</div>
				<hr>
				<div class="col-lg-12 text-right justify-content-center d-flex">
					<button class="btn btn-primary mr-2" name="submit" type="submit" >Send Message</button>
					<button class="btn btn-secondary" type="button" onclick="location.href = 'index.php?page=inbox'">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>
</body>
<script>
</script>
