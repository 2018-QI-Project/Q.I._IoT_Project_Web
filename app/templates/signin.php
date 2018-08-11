<!DOCTYPE html>
<html lang="en">
<head>
	<title>VogLog_SignIn</title>
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
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<!-- VOGLOG LOGO -->
				<div class="login100-pic" data-tilt>
					<img src="images/logo.png" alt="IMG">
				</div>

				<!-- LOGIN FORM -->
				<form name="signin" class="login100-form validate-form" method="post">


					<!-- Title -->
					<span class="login100-form-title">
						Member Login
					</span>


					<!-- Email -->
					<div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
						<input class="input100" type="email" name="email" placeholder="Email">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
					</div>


					<!-- Password -->
					<div class="wrap-input100 validate-input" data-validate = "Password is required">
						<input class="input100" type="password" name="password" placeholder="Password">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>

					<!-- Login Btn -->
					<div class="container-login100-form-btn">
						<button class="login100-form-btn" onclick="requestSignIn()">
							Login
						</button>
					</div>

					<!-- Go to Reset Password -->
					<div class="text-center p-t-12">
						<span class="txt1">
							Forgot Your Password?
						</span>
						<a class="txt2" href="/resetpassword">
							Click!
						</a>
					</div>

					<!-- Go to Signup -->
					<div class="text-center p-t-136">
						<a class="txt2" href="/signup">
							Create your Account
							<i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>
	
	

	
<!--===============================================================================================-->	
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================
	<script src="vendor/tilt/tilt.jquery.min.js"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>-->
<!--===============================================================================================
	<script src="js/main.js"></script>-->


	<script>

		/*var input = $('.validate-input .input100');

	    $('.validate-form .input100').each(function(){
	        $(this).focus(function(){
	           hideValidate(this);
	        });
	    });

	    function validate (input) {
	        if($(input).attr('type') == 'email' || $(input).attr('name') == 'email') {
	            if($(input).val().trim().match(/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{1,5}|[0-9]{1,3})(\]?)$/) == null) {
	                return false;
	            }
	        }
	        
	        // password
	        else if($(input).attr('name') == 'password') {
	            // password
	            if($(input).val().trim().match(/^[a-zA-Z0-9]{4,10}$/) == null) {
	                return false;
	            } 
	            // repassword
	            //if($(input).val().trim() != $(this).attr('name') == 'repassword'.val().trim()) {
	            //    return false;
	            //}
	        }
	        else {
	            if($(input).val().trim() == ''){
	                return false;
	            }
	        }
	    }

	    function showValidate(input) {
	        var thisAlert = $(input).parent();

	        $(thisAlert).addClass('alert-validate');
	    }

	    function hideValidate(input) {
	        var thisAlert = $(input).parent();

	        $(thisAlert).removeClass('alert-validate');
	    }*/

	    



		function requestSignIn(){
			/*var check = true;
			for(var i=0; i<input.length; i++) {
            	if(validate(input[i]) == false){
                	showValidate(input[i]);
                	check = false;
            	}
        	}
			
			if(!check) return;*/

			var fsignin = document.signin;
			var request = new XMLHttpRequest();

			//var fsignin = document.signin;

			if(fsignin.email.value.match(/^[a-zA-Z0-9_\-]+@[a-zA-Z0-9]+\.+[a-zA-Z0-9]+$/) == null){
				alert("Enter a valid email address!");
				return;
			}
			if(fsignin.password.value.match(/^[a-zA-Z0-9]{4,10}$/) == null){
				alert("Password must between 4 and 10 alphanumeric characters!");
				return;
			}







			// Create JSON Object
			var obj = new Object();

			obj.client = "web";
			obj.email = fsignin.email.value;
			obj.password = fsignin.password.value;

			var jsonData = JSON.stringify(obj);
			console.log(jsonData);

            request.onload = function () {
               var response = this.responseText;
               console.log(response);
               var json = JSON.parse(response);

               localStorage.setItem('tokenWeb',json.token_web);
               console.log(localStorage.getItem('tokenWeb'));

               if(json.type == "success") {
               	  alert("Login Success!");
                  location.href = "http://<?php echo SERVER_IP ?>/dashboard";
               }
               else {
               		alert(json.value);
               		return;
           		}

            };
            request.open("POST", "http://<?php echo SERVER_IP ?>/accounts/authenticate", true);
            request.setRequestHeader("Content-type", "application/json");
            request.send(jsonData);
		}
	</script>



</body>
</html>