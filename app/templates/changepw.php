<!DOCTYPE html>
<html lang="en">
<head>
	<title>VogLog_ChangePw</title>
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
				<form name="changepw" class="login100-form validate-form" method="post" onsubmit="requestChangePw()">
					<span class="login100-form-title p-b-26">
						Set a new password!
					</span>
					<span class="login100-form-title p-b-48">
					</span>

					<div class="wrap-input100 validate-input" data-validate="Enter current password">
						<span class="btn-show-pass">
							<i class="zmdi zmdi-eye"></i>
						</span>
						<span class="txt3"> Current Password </span>
						<input class="input100" type="password" name="currentpw">
						<span class="focus-input100"></span>
					</div>


					<div class="wrap-input100 validate-input" data-validate="Enter new password">
						<span class="btn-show-pass">
							<i class="zmdi zmdi-eye"></i>
						</span>
						<span class="txt3"> New Password </span>
						<input class="input100" type="password" name="newpw">
						<span class="focus-input100"></span>
					</div>
					

					<div class="wrap-input100 validate-input" data-validate="Enter new password">
						<span class="btn-show-pass">
							<i class="zmdi zmdi-eye"></i>
						</span>
						<span class="txt3"> Repeat New Password Repeat </span>
						<input class="input100" type="password" name="repeatnewpw">
						<span class="focus-input100"></span>
					</div>

					<div class="container-login100-form-btn">
						<div class="wrap-login100-form-btn">
							<div class="login100-form-bgbtn"></div>
							<button class="login100-form-btn">
								Confirm
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
		function requestChangePw(){
			var fchangepw = document.changepw;
			var request = new XMLHttpRequest();

			if(fchangepw.newpw.value != fchangepw.repeatnewpw.value){
				alert("Password isn't match!");
				return;
			}



			// Create JSON Object
			var obj = new Object();
			obj.currentPassword = fchangepw.currentpw.value;
			obj.newPassword = fchangepw.newpw.value;
			obj.tokenWeb = localStorage.getItem('tokenWeb');
			obj.client = "web";

			var jsonData = JSON.stringify(obj);
			console.log(jsonData);

            request.onload = function () {
               var response = this.responseText;
               console.log(response);
               var json = JSON.parse(response);

               if(json.type == "success") {
               	  alert("Your password is successfully changed.\nGo to main page.");
                  location.href = "http://<?php echo SERVER_IP ?>/dashboard";
               }
               else {
               		alert(json.value);
               		return;
           		}

            };
            request.open("PUT", "http://<?php echo SERVER_IP ?>/accounts/changepassword", true);
            request.setRequestHeader("Content-type", "application/json");
            request.send(jsonData);
		}

	</script>

</body>
</html>