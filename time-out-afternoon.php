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
    $current_month = date('F');
    $current_year = date('Y');

    // Fetch the `id` and `schedule_id` corresponding to the entered `employee_id`
    $get_employee_query = "SELECT id, schedule_id, email FROM employees WHERE employee_id = '$employee_id_input'";
    $employee_result = mysqli_query($connection, $get_employee_query);

    if (mysqli_num_rows($employee_result) > 0) {
        $employee_data = mysqli_fetch_assoc($employee_result);
        $employee_id = $employee_data['id']; // Get the unique `id` for database operations
        $schedule_id = $employee_data['schedule_id']; // Get the schedule_id for fetching schedule
        $employee_email = $employee_data['email']; // Get the employee email

        // Fetch the employee's schedule using `schedule_id`
        $schedule_query = "SELECT time_out_afternoon FROM schedules WHERE id = '$schedule_id'";
        $schedule_result = mysqli_query($connection, $schedule_query);

        if (mysqli_num_rows($schedule_result) > 0) {
            $schedule = mysqli_fetch_assoc($schedule_result);
            $end_time = $schedule['time_out_afternoon'];

            // Determine status (0 = Late, 1 = On Time)
            $status_afternoon = (strtotime($current_time) > strtotime($end_time)) ? 0 : 1;

            // Check if an attendance record exists for today
            $attendance_check_query = "SELECT * FROM attendance WHERE employee_id = '$employee_id' AND date = '$current_date'";
            $attendance_result = mysqli_query($connection, $attendance_check_query);

            if (mysqli_num_rows($attendance_result) > 0) {
                // Update attendance if record exists
                $attendance_row = mysqli_fetch_assoc($attendance_result);

                if (is_null($attendance_row['time_out_afternoon'])) {
                    // Calculate afternoon hours if time-in already exists
                    $time_in_afternoon = $attendance_row['time_in_afternoon'];
                    if (!is_null($time_in_afternoon)) {
                        $hours_worked = (strtotime($current_time) - strtotime($time_in_afternoon)) / 3600;
                    } else {
                        $hours_worked = 0; // Default if no time-in available
                    }

                    $update_attendance_query = "
                        UPDATE attendance 
                        SET time_out_afternoon = '$current_time', num_hr_afternoon = '$hours_worked', status_afternoon = '$status_afternoon'
                        WHERE employee_id = '$employee_id' AND date = '$current_date'
                    ";
                    mysqli_query($connection, $update_attendance_query);

                    // Send confirmation email
                    sendEmail($employee_email, "Afternoon Time-out", $current_time, $current_date);
                    echo "<script>alert('Afternoon Time-out recorded successfully and confirmation email sent. Total hours worked: $hours_worked.');</script>";
                } else {
                    echo "<script>alert('Time-out already logged for this afternoon.');</script>";
                }
            } else {
                // Get the highest attendance_id to increment it manually
                $get_max_id_query = "SELECT MAX(attendance_id) AS max_id FROM attendance";
                $max_id_result = mysqli_query($connection, $get_max_id_query);
                $max_id_data = mysqli_fetch_assoc($max_id_result);
                $next_attendance_id = $max_id_data['max_id'] + 1; // Increment by 1

                // Insert new attendance record
                $insert_attendance_query = "
                    INSERT INTO attendance (attendance_id, employee_id, date, month, year, time_out_afternoon, status_afternoon) 
                    VALUES ('$next_attendance_id', '$employee_id', '$current_date', '$current_month', '$current_year', '$current_time', '$status_afternoon')
                ";
                mysqli_query($connection, $insert_attendance_query);

                // Send confirmation email
                sendEmail($employee_email, "Afternoon Time-out", $current_time, $current_date);
                echo "<script>alert('Time-out recorded successfully for afternoon.');</script>";
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
        $mail->Body = "Dear Employee,\n\nYour $operation has been successfully recorded at $time on $date.\n\nThank you.";

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
                    <h4 class="timein">Time Out Afternoon</h4>
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
