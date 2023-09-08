<!doctype html>
<html>

<head>
	<meta charset="utf-8">
	<title>Finance Login</title>

	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="shortcut icon" href="<?php echo base_url("/assets/login_page/images/favicon.png"); ?>" type="image/x-icon">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("/assets/login_page/css/bootstrap.css"); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("/assets/login_page/css/font-awesome.css"); ?>">

	<link rel="stylesheet" type="text/css" href="<?php echo base_url("/assets/login/css/apps_login.css") ?>">

	<!--Exist File Start Use this file for display Login Popup-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("/assets/login/css/apps_login.css") ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("/assets/login/css/main.css") ?>">
	<!--Exist File End Use this file for display Login Popup-->

	<link rel="stylesheet" type="text/css" href="<?php echo base_url("/assets/login_page/css/apps.css"); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("/assets/login_page/css/apps_inner.css"); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("/assets/login_page/css/res.css"); ?>">

	<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

	<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
	<!--    font-family: 'Roboto', sans-serif;-->

	<link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200;300;400;500;600;700&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
	<!--font-family: 'Oswald', sans-serif;-->

</head>

<body>
	<header class="headerTop_DashLogin">
		<div class="wrapper_Dash">
			<div class="col-sm-3 float-left logo_Dash" onclick="location.href = 'https://benfed.in/';"><img src="<?php echo base_url("/assets/front_page/images/logo.png"); ?>" alt="" /></div>
			<div class="col-sm-9 float-left rightTxt_Dash">
				<h2>Barrackpore Central Zone Wholesale Consumers' Cooperaive Society Ltd. <br>
					<span>Welcome To Samavayeeka ePortal</span>
				</h2>
			</div>
		</div>
	</header>
	<div class="navigationSecLogin">
		<div class="wrapper_Dash">
			<div class="col-sm-12">
				<ul>
					<li><a href="#">Home</a></li>
				<!--	<li><a href="#">Old KMS</a></li>
					<li><a href="<?php //echo base_url(); ?>index.php/User_Login/notice">Notice</a></li> -->
					<li><a href="#">Contacts</a></li>
				</ul>
			</div>
		</div>
	</div>

	<div class="daseboardContentArea_DashLogin daseboardPading_DashLogin">
		<div class="wrapper_Dash">

			<!--Take this area from developed code Div Classs Name "wrap-login100" (Start Point)-->
			<div class="wrap-login100">
				<form class="login100-form validate-form flex-sb flex-w" id="login" method="POST" action="<?php echo site_url("login/login_check") ?>">
					<!--<div class="login100_logo">
					<h2><img src="https://www.benfed.in/benfed.png" alt="logo"></h2>
					<h3>The West Bengal  State Co-Operative Marketing Federation Ltd (Benfed)</h3>	
					</div>-->
					<div class="login100_logo">
						<h2>Login</h2>
					</div>
					<span class="login100-form-title p-b-10" style="color:red">
						<?php echo $this->session->flashdata('login_error'); ?>
					</span>

					<span class="txt1 p-b-11">
						Username
					</span>
					<div class="wrap-input100 validate-input m-b-36" data-validate="Please supply a valid User Id">
						<input class="input100" type="text" name="user_id" id="user_id">
						<span class="focus-input100"></span>
					</div>
					<span class="txt1 p-b-11">
						Password
					</span>
					<div class="wrap-input100 validate-input m-b-12" data-validate="Please supply password">
						<span class="btn-show-pass">
							<i class="fa fa-eye"></i>
						</span>
						<input class="input100" type="password" name="user_pwd">
						<span class="focus-input100"></span>
					</div>
					<div class="select_main">
						<div class="select_1">

							<select class="form-control" name="fin_yr" id="fin_yr">

								<option value="">Please Select FIN Year</option>

								<?php

								foreach ($fin_yr as $row) { ?>

									<option value="<?php echo $row->sl_no ?>"><?php echo $row->fin_yr; ?></option>

								<?php
								}
								?>

							</select>

						</div>


						<div class="select_2">

							<select class="form-control" name="branch_id" id="test" style="display: none;">
								<option value="">Please Select Branch Name</option>
								<option value="337">North 24 paragnas</option>
							<!--	<?php //foreach ($branch_data as $branch) { ?>
									<option value="<?php //echo $branch->id; ?>"><?php //echo $branch->branch_name; ?></option>
								<?php //} ?>  -->
							</select>

						</div>
					</div>


					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							Login
						</button>
					</div>

				</form>
			</div>
			<!--Take this area from developed code Div Classs Name "wrap-login100" (End Point)-->
		</div>
	</div>

	<footer class="footerSec_Dash">
		<div class="wrapper_Dash">
			<div class="col-sm-6 float-left mapSec"><iframe src="" width="100%" height="175" style="border:0;" allowfullscreen="" loading="lazy"></iframe></div>
			<div class="col-sm-6 float-left addressSec">
				<h2>Location</h2>
				<p>35/Madhupandit Road, Talpukur,Barrackpore,24 Pgs(N) <br>
					Kolkata - 700 123</p>
				<ul>
					<li><i class="fa fa-phone" aria-hidden="true"></i> 033-71482290</li>
					<li><i class="fa fa-fax" aria-hidden="true"></i> Phone Number</li>
					<li><i class="fa fa-envelope" aria-hidden="true"></i> <a href="mailto:bkpczwccsltd@gmail">bkpczwccsltd@gmail.com</a></li>
				</ul>

			</div>
		</div>
	</footer>

	<!--===============================================================================================-->
	<script src="<?php echo base_url("/assets/login/vendor/jquery/jquery-3.2.1.min.js") ?>"></script>
	<!--===============================================================================================-->
	<script src="<?php echo base_url("/assets/login/vendor/animsition/js/animsition.min.js") ?>"></script>
	<!--===============================================================================================-->
	<script src="<?php echo base_url("/assets/login/vendor/bootstrap/js/popper.js") ?>"></script>
	<script src="<?php echo base_url("/assets/login/vendor/bootstrap/js/bootstrap.min.js") ?>"></script>
	<!--===============================================================================================-->
	<script src="<?php echo base_url("/assets/login/vendor/select2/select2.min.js") ?>"></script>
	<!--===============================================================================================-->
	<script src="<?php echo base_url("/assets/login/") ?>vendor/daterangepicker/moment.min.js"></script>
	<script src="<?php echo base_url("/assets/login/vendor/daterangepicker/daterangepicker.js") ?>"></script>
	<!--===============================================================================================-->
	<script src="<?php echo base_url("/assets/login/vendor/countdowntime/countdowntime.js") ?>"></script>
	<!--===============================================================================================-->
	<script src="<?php echo base_url("/assets/login/js/main.js") ?>"></script>

	<script>
		$(document).ready(function() {
			$('.select2').select2();
		});
		//$('#user_id').change(function() {
	  $('#user_id').on("keyup change", function(e) {
			$.get("<?= site_url() ?>/login/check_user", {
				user_id: $(this).val()
			}).done(function(data) {
				if (data) {
					if (data == 'A' || data == 'O') {
						$('#test').show();
					} else {
						$('#test').hide();
					}
				} else {
					$('#test').hide();
					//alert('No userId found');
				}
				// $(".result").html(data);
				// alert("Load was performed.");
			});
		})

		$("#login").on('submit', function() {

			var kmyr = $("#fin_yr").val();

			if (kmyr == "") {
				alert("Please select FIN year");
				return false;
			}
		});
	</script>

	<script>

	</script>

</body>

</html>