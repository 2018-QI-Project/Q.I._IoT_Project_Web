<!DOCTYPE html>
<html lang="en">
<head>
	<title>VogLog_SignUp</title>
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
	<link rel="stylesheet" type="text/css" href="css/signup_util.css">
	<link rel="stylesheet" type="text/css" href="css/signup_main.css">
<!--===============================================================================================-->
	<script src="http://code.jquery.com/jquery-latest.js"></script>
</head>
<body>

	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<!-- SignUp FORM -->
				<form name="signup" class="login100-form validate-form" method="post" >
					<!-- SignUp Title -->
					<span class="login100-form-title p-b-16">
						Sign Up
					</span><br>

					<!-- Email -->
					<span class="txt3"> Email </span>
					<div class="wrap-input100 validate-input" data-validate = "Valid email is :a@b.c">
						<input class="input100" type="email" name="email">
						<span class="focus-input100"></span>
					</div>

					<!-- Password -->
					<span class="txt3"> Password </span>
					<div class="wrap-input100 validate-input" data-validate="Password must be 4 and 10 new alphanumeric characters">
						<span class="btn-show-pass">
							<i class="zmdi zmdi-eye"></i>
						</span>
						<input class="input100" type="password" name="password">
						<span class="focus-input100"></span>
					</div>

					<!-- Repeat Password -->
					<span class="txt3"> Repeat Password </span>
					<div class="wrap-input100 validate-input" data-validate="Enter password">
						<span class="btn-show-pass">
							<i class="zmdi zmdi-eye"></i>
						</span>
						<input class="input100" type="password" name="repassword">
						<span class="focus-input100"></span>
					</div>

					<!-- Full Name -->
					<span class="txt3"> Full Name </span>
					<div class="wrap-input100 validate-input" data-validate = "Enter Full Name">
						<input class="input100" type="text" name="name">
						<span class="focus-input100"></span>
					</div>

					<!-- Age -->
					<span class="txt3"> Age </span>
					<div class="wrap-input100">
						<input class="input100" type="text" name="age">
						<span class="focus-input100"></span>
					</div>

					<!-- Gender Radio Btn Form -->
					<form>
						<span class="txt4"> Gender &nbsp;&nbsp;&nbsp;&nbsp; </span>

						<input type="radio" id="female" name="gender" value="F" checked />
						<label>Female &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
						<input type="radio" id="male" name="gender" value="M" />
						<label>Male</label>
					</form><br>

					<!-- Disease Checkbox Btn -->
					<div class="txt5"> Existing Health Condition </div><br>
					<div>
						<form action="/action_page.php">
							<input type="checkbox" name="respir" value="" id="res"> Respiratory Disease <br>
							<input type="checkbox" name="cardio" value="" id="car"> Cardiovascular Disease
						</form>
					</div>

					<!-- Submit Btn -->
					<div class="container-login100-form-btn">
						<div class="wrap-login100-form-btn">
							<div class="login100-form-bgbtn"></div>
							<button class="login100-form-btn" onclick="requestSignUp()">
								Submit
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
		function requestSignUp(){
			var fsignup = document.signup;

			if(fsignup.email.value.match(/^[a-zA-Z0-9_\-]+@[a-zA-Z0-9]+\.+[a-zA-Z0-9]+$/) == null){
				alert("Enter a valid email address!");
				return;
			}
			if(fsignup.password.value.match(/^[a-zA-Z0-9]{4,10}$/) == null){
				alert("Password must between 4 and 10 alphanumeric characters!");
				return;
			}
			if(fsignup.password.value != fsignup.repassword.value){
				alert("Password isn't match!");
				return;
			}
			if(fsignup.name.value.match(/^[[a-zA-Z]*\s?]*[a-zA-Z]+$/) == null){
				alert("Name is incorrect!");
				return;
			}
			if(fsignup.age.value.match(/^[0-9]+$/) == null){
				alert("Age is incorrect!");
				return;
			}

			var request = new XMLHttpRequest();

			var res_check = $('input:checkbox[id="res"]').is(':checked');
			var car_check = $('input:checkbox[id="car"]').is(':checked');
			
			// Create JSON Object
			var obj = new Object();

			obj.email = fsignup.email.value;
			obj.password = fsignup.password.value;
			obj.name = fsignup.name.value;
			obj.gender = fsignup.gender.value;
			obj.age = fsignup.age.value;

			// Diease CheckBox
			if(res_check == true) {
				obj.respiratoryDisease = 1;
			}
			else {
				obj.respiratoryDisease = 0;
			}

			if(car_check == true) {
				obj.cardiovascularDisease =  1;
			}
			else {
				obj.cardiovascularDisease = 0;
			}	
			
			var jsonData = JSON.stringify(obj);
			console.log(jsonData);
            request.onload = function () {
               var response = this.responseText;
               console.log(this.responseText);
               var json = JSON.parse(response);

               console.log(json.type);
               console.log(json.value);

               if(json.type == "success") {
               	  alert("Signup request success!\nCheck your email to verify.");
                  location.href = "http://<?php echo SERVER_IP ?>";
               }
               else
               	alert("The email address is " + json.value + "!");

            };
            request.open("POST", "http://<?php echo SERVER_IP ?>/accounts/signup", true);
            request.setRequestHeader("Content-type", "application/json");
            request.send(jsonData);
		}
	</script>

</body>
</html>