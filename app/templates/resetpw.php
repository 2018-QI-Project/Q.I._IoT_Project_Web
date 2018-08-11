<!DOCTYPE html>
<html lang="en">
<head>
	<title>VogLog_ResetPw</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php include_once('database.php'); ?>
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/voglog.ico">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">	
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/signup_main.css">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">

				<!-- RewetPassword Form -->
				<form name="resetpw" class="login100-form validate-form" method="put" onsubmit="requestResetPw()">
					<span class="login100-form-title p-b-16">
						Forgot Your Password?
					</span>
					<span class="login100-form-title p-b-28"></span>
						Please enter your email address.<br>
		    			You will receive a new password via email.
					
					<!-- Email -->
					<div class="wrap-input100 validate-input" data-validate = "Valid email is: a@b.c">
						<input class="input100" type="email" name="email" placeholder="Email">
						<span class="focus-input100"></span>
					</div>

					<!-- Submit Button -->
					<div class="container-login100-form-btn">
						<div class="wrap-login100-form-btn">
							<div class="login100-form-bgbtn"></div>
							<button class="login100-form-btn">
								Send to Email
							</button>
						</div>
					</div>

				</form>
			</div>
		</div>
	</div>
	

	<div id="dropDownSelect1"></div>
	
<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>
	
	
	<script type="text/javascript">
		function requestResetPw(){
			var fresetpw = document.resetpw;
			var request = new XMLHttpRequest();

			// Create JSON Object
			var obj = new Object();
			obj.email = fresetpw.email.value;

			var jsonData = JSON.stringify(obj);
			console.log(jsonData);

            request.onload = function () {
               var response = this.responseText;
               console.log(response);
               var json = JSON.parse(response);

               if(json.type == "success") {
               	  alert("We sended temporary password to your email.");
                  location.href = "http://<?php echo SERVER_IP ?>";
               }
               else {
               		alert(json.value);
               		return;
           		}

            };
            request.open("PUT", "http://<?php echo SERVER_IP ?>/accounts/resetpassword", true);
            request.setRequestHeader("Content-type", "application/json");
            request.send(jsonData);
		}
	</script>

</body>
</html>