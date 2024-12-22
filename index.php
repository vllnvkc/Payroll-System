<?php
$timezone = 'Asia/Manila';
date_default_timezone_set($timezone);
?>
<!doctype html>
<html lang="en" dir="ltr">
	<head>
		<?php require_once('admin/includes/script.php') ?>
		  <link rel="icon" href="./admin/angular/img/a.png" type="image/png">
		<title>PayXpert: Payroll Processing System</title>
		<!-- Dashboard Core -->
		<link href="./assets/css/dashboard.css" rel="stylesheet" />
		<!-- Google Fonts -->
		<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
		<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
		<style>
			body {
				font-family: 'Poppins', sans-serif;
				background-color: #ffffff; /* White background */
				color: #333; /* Dark text for readability */
			}
			.card-title {
				font-weight: 600;
			}
			.btn {
				font-weight: 500;
			}
			.text-center h1 {
				color: #444; /* Slightly lighter dark color for headers */
			}
			/* Dashboard Button Styling */
			.btn-dashboard {
				display: inline-block;
				margin: 20px auto;
				background-color: #007bff; /* Bootstrap Primary */
				color: #fff;
				padding: 10px 20px;
				font-size: 16px;
				font-weight: 600;
				border-radius: 5px;
				text-decoration: none;
				transition: background-color 0.3s ease;
			}
			.btn-dashboard:hover {
				background-color: #0056b3; /* Darker blue on hover */
			}
			.btn-dashboard:active {
				background-color: #004494; /* Even darker when active */
			}
			.container {
				padding-top: 30px;
			}
			.btn-dashboard {
				display: block;
				margin: 20px auto;
				padding: 12px 30px;
				background-color: #007bff; /* Bootstrap Primary */
				color: #ffffff; /* White text */
				font-size: 18px;
				font-weight: 600;
				text-align: center;
				text-decoration: none;
				border-radius: 5px;
				transition: all 0.3s ease-in-out;
				box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
			}

			.btn-dashboard:hover {
				background-color: #0056b3; /* Darker Blue */
				color: #ffffff;
				transform: scale(1.05); /* Slightly larger on hover */
			}

			.btn-dashboard:active {
				background-color: #003f7f; /* Even darker Blue */
				box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.2);
			}
.logo {
            flex: 1;
            text-align: center;
        }

        .logo img {
            height: 100px;
        }

		</style>
	</head>
	<body class="">
		<div class="page">
			<div class="page-single">
				<div class="container">
				<div class="logo">
                <img src="./admin/angular/img/a.png" alt="System Logo">
            </div>
					<div class="text-center">
						<h1 id="date"></h1>
						<h1 class="text" id="time"></h1>
					</div>
					
					<div class="row">
						<div class="col-lg-6">
							<div class="card">
								<div class="card-header">
									<h3 class="card-title"><b>Morning Attendance</b><i class="fa-solid fa-sun"></i></h3>
									<div class="card-options">
										<a href="time-in-morning.php" class="btn btn-primary btn-sm" >Time In</a>
										<a href="time-out-morning.php" class="btn btn-warning btn-sm ml-2">Time Out</a>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="card">
								<div class="card-header">
									<h3 class="card-title"><b>Afternoon Attendance</b> <i class="fa-solid fa-mountain-sun"></i></h3>
									<div class="card-options">
										<a href="time-in-afternoon.php" class="btn btn-primary btn-sm">Time In</a>
										<a href="time-out-afternoon.php" class="btn btn-warning btn-sm ml-2">Time Out</a>
									</div>
								</div>
							</div>
						</div>
						</center>
					</div>
					
					<!-- Dashboard Panel Button -->
					<div class="text-center">
					<a href="admin" target="_blank" class="btn-dashboard">Go to Login Panel</a>

					</div>
				</div>
			</div>
		</div>
	
		<!-- jQuery 3 -->
		<script src="bower_components/jquery/dist/jquery.min.js"></script>
		<!-- Bootstrap 3.3.7 -->
		<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
		<!-- Moment JS -->
		<script src="bower_components/moment/moment.js"></script>
		<script type="text/javascript">
		$(function() {
			var interval = setInterval(function() {
				var momentNow = moment();
				$('#date').html(momentNow.format('dddd').substring(0,3).toUpperCase() + ' - ' + momentNow.format('MMMM DD, YYYY'));
				$('#time').html(momentNow.format('hh:mm:ss A'));
			}, 100);

			$('#attendance').submit(function(e){
				e.preventDefault();
				var attendance = $(this).serialize();
				$.ajax({
					type: 'POST',
					url: 'attendance.php',
					data: attendance,
					dataType: 'json',
					success: function(response){
						if(response.error){
							$('.alert').hide();
							$('.alert-danger').show();
							$('.message').html(response.message);
						} else {
							$('.alert').hide();
							$('.alert-success').show();
							$('.message').html(response.message);
							$('#employee').val('');
						}
					}
				});
			});
		});
		</script>
	</body>
</html>
