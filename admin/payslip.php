<?php
require '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once('includes/script.php');  
require_once('session/Login.php'); 

$model = new Dashboard();
$session = new AdministratorSession();
$session->LoginSession();

date_default_timezone_set('Asia/Manila');

if (!isset($_SESSION['official_username']) || !isset($_SESSION['official_password']) || !isset($_SESSION['official_id'])) {
    header("location:index.php?utm_campaign=expired");
    exit;
}

$username = $_SESSION['official_username'];
$password = $_SESSION['official_password'];
$uid = $_SESSION['official_id'];

$connection = $model->TemporaryConnection();

$query = $model->GetAdministrator($username, $password);
$admin = mysqli_fetch_assoc($query);
$firstname = $admin['firstname'];
$lastname = $admin['lastname'];

$to = date('Y-m-d');
$from = date('Y-m-d', strtotime('-6 day', strtotime($to)));

$id = $_GET['id'];

$select = "SELECT `id`, `email` FROM `employees` WHERE `employee_id` = '$id';";
$thisQuery = mysqli_query($connection, $select);

if (!$thisQuery || mysqli_num_rows($thisQuery) == 0) {
    die("Employee not found.");
}

$row = mysqli_fetch_assoc($thisQuery);
$myId = $row['id'];
$employeeEmail = $row['email'] ?? '';

$number = substr(str_shuffle('0123456789'), 0, 9);

$sql = "SELECT employees.employee_id AS employee_id,
                attendance.employee_id AS empid, 
                employees.fullname, 
                position.description AS position_name, 
                position.rate AS rate, 
                SUM(num_hr_morning) AS morning, 
                SUM(num_hr_afternoon) AS afternoon 
        FROM attendance 
        LEFT JOIN employees ON employees.id = attendance.employee_id 
        LEFT JOIN position ON position.id = employees.position_id 
        WHERE attendance.employee_id = '$myId' AND date BETWEEN '$from' AND '$to' 
        GROUP BY attendance.employee_id, employees.fullname, position.rate, position.description 
        ORDER BY employees.fullname ASC";

$overtime = "SELECT employee_id, SUM(hours) AS hour, SUM(rate_hour) AS rate_h, COUNT(employee_id) AS tot
             FROM overtime 
             WHERE employee_id='$myId' AND date_overtime BETWEEN '$from' AND '$to'
             GROUP BY employee_id;";

$ot = 0;
$otresult = mysqli_query($connection, $overtime);
if ($otresult && mysqli_num_rows($otresult) > 0) {
    $otrow = mysqli_fetch_assoc($otresult);
    $total_ot = $otrow['tot'] > 0 ? $otrow['tot'] : 1;
    $gross = ($otrow['rate_h'] / $total_ot) * round($otrow['hour'], 1);
    $ot = $gross;
}

$sqlPayroll = mysqli_query($connection, $sql);
?>

<!doctype html>
<html lang="en" dir="ltr">
<head>
<link rel="icon" href="./angular/img/a.png" type="image/png">
    <title>PayXpert: Payroll Processing System</title>
</head>
<body>
    <div class="page" id="app">
        <div class="page-main">
            <div class="header collapse d-lg-flex p-0" id="headerMenuCollapse">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="d-flex">
                            <?php require_once('includes/header.php') ?>
                        </div>
                        <div class="col-lg order-lg-first">
                            <?php require_once('includes/subheader.php') ?> 
                        </div>
                    </div>
                </div>
            </div>
            <div class="my-3 my-md-5">
                <div class="container">
                    <div class="page-header">
                        <h1 class="page-title">
                            <a href="home.php" class="text-primary">Dashboard</a> 
                            <i style="font-size: 20px;" class="fa-solid fa-greater-than"></i> Payslip
                        </h1>
                    </div>
                    <div style="padding-left: 0; padding-bottom: 25px;" class="dropdown">
                        <button type="button" class="btn btn-secondary" onclick="printPage()">
                            <i class="fa-solid fa-print"></i> Print Payslip
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="sendPayslip()">
                            <i class="fa-solid fa-envelope"></i> Send Payslip
                        </button>
                    </div>             
                    <div class="row row-cards">
                        <div class="col-12" id="printDataHolder">
                            <div class="card">
                                <?php 
                                if ($sqlPayroll && mysqli_num_rows($sqlPayroll) > 0) {
                                    while ($row = mysqli_fetch_assoc($sqlPayroll)) {
                                        $employee_id = $row['empid'];
                                        $total_hr = $row['morning'] + $row['afternoon'];

                                        $casql = "SELECT employee_id, SUM(amount) AS cashamount 
                                                  FROM cashadvance 
                                                  WHERE employee_id='$employee_id' AND date_advance BETWEEN '$from' AND '$to'
                                                  GROUP BY employee_id";

                                        $cashadvance = 0;
                                        $caquery = mysqli_query($connection, $casql);
                                        if ($caquery && mysqli_num_rows($caquery) > 0) {
                                            $carow = mysqli_fetch_assoc($caquery);
                                            $cashadvance = $carow['cashamount'];
                                        }

                                        $gross = $row['rate'] * $total_hr;
                                        $net_pay = $gross - $cashadvance;
                                        ?>
                                        <div class="table-responsive push">
                                            <table class="table table-bordered table-hover">
                                                <tr>
                                                    <th colspan="8">Payroll #<?php echo $row['empid'] ?></th>
                                                </tr>
                                                <tr>
                                                    <td colspan="4">Pay Period</td>
                                                    <td colspan="4" class="text-right">
                                                        <?php echo date('F d, Y', strtotime($from)) ?> - <?php echo date('F d, Y', strtotime($to)) ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4">Employee Name</td>
                                                    <td colspan="4" class="text-right"><?php echo $row['fullname'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4">Employee Number</td>
                                                    <td colspan="4" class="text-right">ID <?php echo $row['employee_id'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4">Rate</td>
                                                    <td class="text-right">PHP <?php echo number_format($row['rate'], 2) ?> </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4">Total Hours</td>
                                                    <td class="text-right"><?php echo round($total_hr, 2) ?> Hours</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4">Gross Income</td>
                                                    <td class="text-right">PHP <?php echo number_format($gross, 2) ?></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4">Cash Advance</td>
                                                    <td class="text-right">PHP <?php echo number_format($cashadvance, 2) ?> </td>
                                                </tr>  
                                                <tr>
                                                    <td colspan="4">Overtime</td>
                                                    <td class="text-right">PHP <?php echo number_format($ot, 2) ?> </td>
                                                </tr>   
                                                <tr>
                                                    <td colspan="4">Net Income (Gross Income - Cash Advance)</td>
                                                    <td class="text-right">PHP <?php echo number_format($net_pay, 2) ?> </td>
                                                </tr>                                    
                                                <tr>
                                                    <td colspan="4">NET PAY (Net Income + Overtime)</td>
                                                    <td class="text-right">PHP <?php echo number_format($net_pay + $ot, 2) ?> </td>
                                                </tr>
                                            </table>
                                        </div>
                                    <?php 
                                    }
                                } else {
                                    echo "<p>No payroll data available.</p>";
                                }
                                ?>                    
                            </div>
                        </div>
                    </div>           
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
    function printPage() {
        var divElements = document.getElementById('printDataHolder').innerHTML;
        var oldPage = document.body.innerHTML;
        document.body.innerHTML="<link rel='stylesheet' href='css/common.css' type='text/css' /><body class='bodytext'><div class='padding'><b style='font-size: 16px;'><p class=''>Payslip generated on <?php echo date("m/d/Y") ?> <?php echo date("G:i A") ?> by <?php echo $firstname ?> <?php echo $lastname ?></p></b>" + divElements + "</div>";
        window.print();
        document.body.innerHTML = oldPage;
    }

    function sendPayslip() {
        var payslipData = document.getElementById('printDataHolder').innerHTML;
        var subject = "Payslip for the Period <?php echo date('F d, Y', strtotime($from)) ?> - <?php echo date('F d, Y', strtotime($to)) ?>";
        var date = "Thursday, December 12, 2024";
        var body = "<html><body>Dear Employee,<br><br>This is your payslip for the period <?php echo date('F d, Y', strtotime($from)) ?> - <?php echo date('F d, Y', strtotime($to)) ?>.<br><br>" + payslipData + "</body></html>";

        
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "send_email.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    alert("Payslip sent successfully!");
                } else {
                    alert("Error sending email: " + xhr.statusText);
                }
            }
        };
        xhr.send("employeeEmail=<?php echo $employeeEmail; ?>&subject=" + encodeURIComponent(subject) + "&body=" + encodeURIComponent(body));
    }
    </script>
</body>
</html>
