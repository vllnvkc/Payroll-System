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

    // Fetch the `id` and email corresponding to the entered `employee_id`
    $get_employee_query = "SELECT id, email FROM employees WHERE employee_id = '$employee_id_input'";
    $employee_result = mysqli_query($connection, $get_employee_query);

    if (mysqli_num_rows($employee_result) > 0) {
        $employee_data = mysqli_fetch_assoc($employee_result);
        $employee_id = $employee_data['id']; // Get the unique `id` for database operations
        $employee_email = $employee_data['email']; // Get employee email address

        // Fetch the employee's morning schedule using `id`
       // Fetch the schedule_id from the employees table using `employee_id`
    $schedule_id_query = "SELECT schedule_id FROM employees WHERE employee_id = '$employee_id_input'";
    $schedule_id_result = mysqli_query($connection, $schedule_id_query);

    if (mysqli_num_rows($schedule_id_result) > 0) {
        $schedule_data = mysqli_fetch_assoc($schedule_id_result);
        $schedule_id = $schedule_data['schedule_id']; // Get the schedule_id

        // Fetch the morning time-in from the schedules table using the retrieved schedule_id
        $schedule_query = "SELECT time_in_morning FROM schedules WHERE id = '$schedule_id'";
        $schedule_result = mysqli_query($connection, $schedule_query);

    if (mysqli_num_rows($schedule_result) > 0) {
        $schedule = mysqli_fetch_assoc($schedule_result);
        $start_time = $schedule['time_in_morning'];

        // Determine status (0 = Late, 1 = On Time)
        $status_morning = (strtotime($current_time) > strtotime($start_time)) ? 0 : 1;

        $attendance_check_query = "SELECT * FROM attendance WHERE employee_id = '$employee_id' AND date = '$current_date'";
        $attendance_result = mysqli_query($connection, $attendance_check_query);

        if (mysqli_num_rows($attendance_result) > 0) {
            $attendance_row = mysqli_fetch_assoc($attendance_result);

            $time_in_afternoon = $attendance_row['time_in_afternoon'];
            if (!is_null($time_in_afternoon)) {
                $hours_worked = (strtotime($current_time) - strtotime($time_in_afternoon)) / 3600;
            } else {
                $hours_worked = 0; // Default if no time-in available
            }
            // If morning time-in already exists, alert the user
            if (!is_null($attendance_row['time_in_morning'])) {
                echo "<script>alert('Attendance already exists for this morning.');</script>";
            } else {
                // Update time-in only
                $update_attendance_query = "
                    UPDATE attendance 
                    SET time_in_morning = '$current_time', status_morning = '$status_morning'
                    WHERE employee_id = '$employee_id' AND date = '$current_date'
                ";
                mysqli_query($connection, $update_attendance_query);

                // Send confirmation email
                sendEmail($employee_email, "Time-in", $current_time, $current_date);
                echo "<script>alert('Morning Time-in recorded successfully and confirmation email sent.');</script>";
            }
        } else {
            // Get the highest attendance_id to increment it manually
            $get_max_id_query = "SELECT MAX(attendance_id) AS max_id FROM attendance";
            $max_id_result = mysqli_query($connection, $get_max_id_query);
            $max_id_data = mysqli_fetch_assoc($max_id_result);
            $next_attendance_id = $max_id_data['max_id'] + 1; // Increment by 1

            // Insert new attendance record
            $insert_attendance_query = "
                INSERT INTO attendance (attendance_id, employee_id, date, month, year, time_in_morning, status_morning) 
                VALUES ('$next_attendance_id', '$employee_id', '$current_date', '$current_month', '$current_year', '$current_time', '$status_morning')
            ";
            mysqli_query($connection, $insert_attendance_query);

            // Send confirmation email
            sendEmail($employee_email, "Time-in", $current_time, $current_date);
            echo "<script>alert('Morning Time-in recorded successfully and confirmation email sent.');</script>";
        }
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
                    <h4 class="timein">Time In Morning</h4>
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
