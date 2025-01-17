<!DOCTYPE html>
<html lang="en">
<?php 
session_start();
include('./db_connect.php');
?>
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Login | Online Survey System</title>
 	

<?php include('./header.php'); ?>
<?php 
if(isset($_SESSION['login_id']))
header("location:index.php?page=home");

?>

</head>
<style>
	body{
		width: 100%;
	    height: calc(100%);
	    position: fixed;
	    top:0;
	    left: 0;
		background-image: url('images/backgoundtry.jpg');
		background-repeat: no-repeat;
		background-attachment: fixed;
		background-size: 100% 100%;

	}
	main#main{
		width:100%;
		height: calc(100%);
		display: flex; 
	
	}

</style>

<body >


  <main id="main" >
  	
			<div class="align-self-center w-100" style="display: flex; justify-content: center; align-items: center; height: 100vh; padding: 10px;">
			<div class="card col-12 col-md-6 col-lg-4">
				<div class="card-body">
				<!-- Login Label -->
				<h3 class="text-center text-dark mb-4">Login System</h3>
				<!-- Form -->
				<form id="login-form">
					<div class="form-group">
					<label for="email" class="control-label text-dark">Email</label>
					<input type="text" id="email" name="email" class="form-control form-control-sm">
					</div>
					<div class="form-group">
					<label for="password" class="control-label text-dark">Password</label>
					<input type="password" id="password" name="password" class="form-control form-control-sm">
					</div>
					<center>
					<button class="btn-sm btn-block btn-wave col-md-4 btn-primary">Login</button>
					</center>
					<a href="forgot-password.php" class="auth-link text-black">Forgot password?</a>
				</form>
				</div>
			</div>
			</div>

  </main>

  <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>


</body>
<script>
$('#login-form').submit(function(e){
        e.preventDefault();
        $('#login-form button[type="button"]').attr('disabled', true).html('Logging in...');
        if ($(this).find('.alert-danger').length > 0) {
            $(this).find('.alert-danger').remove();
        }
        $.ajax({
            url: 'ajax.php?action=login',
            method: 'POST',
            data: $(this).serialize(),
            error: err => {
                console.log(err);
                $('#login-form button[type="button"]').removeAttr('disabled').html('Login');
            },
            success: function(resp) {

                if (resp != 1) {
                    window.location.reload();
                } else {
                    // Login failed, show alert and reload page
                    alert("Succesful login.");
// Reload the page
                }
            }
        });
    });



// Restrict input for elements with class "number" to only numbers and commas
$('.number').on('input', function () {
    var val = $(this).val();
    val = val.replace(/[^0-9,]/g, ''); // Allow only numbers and commas
    $(this).val(val);
});
</script>

</html>