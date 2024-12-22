<?php
// Set timezone
$timezone = 'Asia/Manila';
date_default_timezone_set($timezone);

// Database connection
$connection = mysqli_connect("localhost", "root", "", "db");

// Check connection
if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Include PHPMailer for email functionality
require 'vendor/autoload.php'; // If using Composer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['log_attendance'])) {
    $employee_id_input = $_POST['employee_id']; // User-input employee ID
    $current_time = date('H:i:s');
    $current_date = date('Y-m-d');

    // Fetch the `id`, `schedule_id`, and email corresponding to the entered `employee_id`
    $get_employee_query = "SELECT id, schedule_id, email FROM employees WHERE employee_id = '$employee_id_input'";
    $employee_result = mysqli_query($connection, $get_employee_query);

    if (mysqli_num_rows($employee_result) > 0) {
        $employee_data = mysqli_fetch_assoc($employee_result);
        $employee_id = $employee_data['id']; // Get the unique `id` for database operations
        $schedule_id = $employee_data['schedule_id']; // Get the schedule_id for fetching schedule
        $employee_email = $employee_data['email']; // Get employee email address

        // Fetch the employee's schedule using `schedule_id`
        $schedule_query = "SELECT time_out_morning FROM schedules WHERE id = '$schedule_id'";
        $schedule_result = mysqli_query($connection, $schedule_query);

        if (mysqli_num_rows($schedule_result) > 0) {
            $schedule_data = mysqli_fetch_assoc($schedule_result);
            $time_out_morning = $schedule_data['time_out_morning']; // Fetch schedule time-out

            // Check if an attendance record exists for today
            $attendance_check_query = "SELECT * FROM attendance WHERE employee_id = '$employee_id' AND date = '$current_date'";
            $attendance_result = mysqli_query($connection, $attendance_check_query);

            if (mysqli_num_rows($attendance_result) > 0) {
                $attendance_row = mysqli_fetch_assoc($attendance_result);

                // Check if time-out for the morning already exists
                if (!is_null($attendance_row['time_out_morning'])) {
                    echo "<script>alert('Morning Time-out already exists.');</script>";
                } else if (!is_null($attendance_row['time_in_morning'])) {
                    // Calculate hours worked in the morning
                    $time_in_morning = strtotime($attendance_row['time_in_morning']);
                    $time_out_morning_time = strtotime($current_time);
                    $hours_worked = ($time_out_morning_time - $time_in_morning) / 3600; // Convert seconds to hours

                    // Update the time-out for the morning
                    $update_attendance_query = "
                        UPDATE attendance 
                        SET time_out_morning = '$current_time', num_hr_morning = '$hours_worked' 
                        WHERE employee_id = '$employee_id' AND date = '$current_date'
                    ";
                    mysqli_query($connection, $update_attendance_query);

                    // Send confirmation email
                    sendEmail($employee_email, "Time-out Morning", $current_time, $current_date);
                    echo "<script>alert('Morning Time-in recorded successfully and confirmation email sent. Hours worked: $hours_worked hours.');</script>";
                } else {
                    echo "<script>alert('Morning Time-in not recorded yet. Please record Time-in first.');</script>";
                }
            } else {
                echo "<script>alert('No attendance record found for today. Please record Time-in first.');</script>";
            }
        } else {
            echo "<script>alert('Schedule not found for this employee.');</script>";
        }
    } else {
        echo "<script>alert('Employee not found.');</script>";
    }
}

function sendEmail($to, $operation, $time, $date)
{
    $mail = new PHPMailer(true);

    try {
        // SMTP configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Replace with your SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'villanuevakc13@gmail.com'; // Replace with your email
        $mail->Password = 'eqnr vxow deyd jvys'; // Replace with your email password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Sender and recipient
        $mail->setFrom('your_email@example.com', 'PayXpert System');
        $mail->addAddress($to);

        // Email subject and body
        $mail->Subject = "Attendance Confirmation - $operation";
        $mail->Body = "Dear Employee,\n\nYour $operation for the morning has been successfully recorded at $time on $date.\n\nThank you.";

        $mail->send();
    } catch (Exception $e) {
        echo "<script>alert('Email could not be sent. Error: {$mail->ErrorInfo}');</script>";
    }
}
?>



<!doctype html>
<html lang="en" dir="ltr">
<head>
<link rel="icon" href="./admin/angular/img/a.png" type="image/png">
    <title>PayXpert: Payroll Processing System</title>
    <link href="./assets/css/dashboard.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .timein {
            margin-top: 20px;
            font-size: 24px;
            font-weight: bold;
        }

        #employee-id {
            text-align: center;
        }

        .btn-success {
            font-size: 16px;
            padding: 10px 20px;
        }

        .text-center {
            margin-bottom: 30px;
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
<body>
<div class="page">
    <div class="page-single">
        <div class="container">
            <div class="logo">
                <img src="./admin/angular/img/a.png" alt="System Logo">
            </div>
            <div class="text-center">
                <h1 id="date"></h1>
                <h1 id="time"></h1>
            </div>
            <div>
                <center>
                    <h4 class="timein">Time Out Morning</h4>
                    <div class="col-md-4">
                        <form method="POST" action="">
                            <div class="form-group">
                                <input id="employee-id" type="text" name="employee_id" required class="form-control"
                                       placeholder="Employee Identification" autofocus>
                            </div>
                            <button type="submit" name="log_attendance" class="btn btn-success">Log</button>
                        </form>
                    </div>
                </center>
            </div>
        </div>
    </div>
    <a href="index.php" target="_blank" class="btn btn-secondary">Go to Dashboard Panel</a>
</div>

<script>
    // Display current date and time
    setInterval(function () {
        const now = moment();
        document.getElementById('date').textContent = now.format('dddd - MMMM DD, YYYY');
        document.getElementById('time').textContent = now.format('hh:mm:ss A');
    }, 1000);
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
