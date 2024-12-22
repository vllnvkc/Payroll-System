<?php 

require_once('includes/script.php');  
require_once('session/Login.php'); 

 $model = new Dashboard();
 $session = new AdministratorSession();
 $session->LoginSession();

 if(!isset($_SESSION['official_username']) && !isset($_SESSION['official_password']) && !isset($_SESSION['official_id'])){
    header("location:index.php?utm_campaign=expired");
 }

 $model = new Dashboard();
 $password = $_SESSION['official_password'];
 $username = $_SESSION['official_username'];
 $uid = $_SESSION['official_id'];

 $connection = $model->TemporaryConnection();

 $query = $model->GetAdministrator($username, $password);
 $admin = mysqli_fetch_assoc($query);
        $id = $admin['id'];
        $firstname = $admin['firstname'];
        $lastname = $admin['lastname'];
        $photo = $admin['photo'];
        $create = $admin['created_on'];
        $type = $admin['type'];

$countEmployee = "SELECT COUNT(*) AS `countEmp` FROM `employees`;";
$result = mysqli_query($connection, $countEmployee);
$rowEmp = mysqli_fetch_assoc($result);


$to = date('Y-m-d');
$from = date('Y-m-d', strtotime('-6 day', strtotime($to)));

if(isset($_GET['range'])){
  $range = $_GET['range'];
  $ex = explode('-', $range);
  $from = date('Y-m-d', strtotime($ex[0]));
  $to = date('Y-m-d', strtotime($ex[1]));
}

if($type == "Timekeeper"){
  header("location:attendance.php?filter=$to");
}

?>
<!doctype html>
<html lang="en" dir="ltr">
  <head>
  <link rel="icon" href="./angular/img/a.png" type="image/png">
    <title>PayXpert: Payroll Processing System</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
      /* Apply Poppins font globally */
      body, h1, h2, h3, h4, h5, h6, p, a, table, th, td, button {
        font-family: 'Poppins', sans-serif;
      }

      /* Additional Styling */
      body {
        background-color: #f8f9fa; /* Light background */
        color: #333; /* Default text color */
        margin: 0;
        padding: 0;
      }

      .page-title {
        font-weight: 600; /* Bold for headers */
      }

      .btn {
        font-weight: 500; /* Slightly lighter font for buttons */
      }

      table {
        font-size: 16px; /* Consistent table font size */
      }
    </style>
  </head>
  <body class="">
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
               <b>Payroll Dashboard</b> 
              </h1>
            </div>
            <div class="row row-cards">
            <div class="col-sm-6 col-lg-3">
                <div class="card p-3">
                  <div class="d-flex align-items-center">
                    <span class="stamp stamp-md bg-blue mr-3">
                      <div style="padding-top: 10px;">
                      <i class="fa-solid fa-users"></i>
                      </div>
                    </span>
                    <div>
                      <h4 class="m-0"><a href="profile.php"><?php echo $rowEmp['countEmp'] ?> <small>Employee</small></a></h4>
                      <small class="text-muted">Total Employee</small>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-lg-3">
                <div class="card p-3">
                  <div class="d-flex align-items-center">
                    <span class="stamp stamp-md bg-green mr-3">
                      <div style="padding-top: 10px;">
                      <i class="fa-solid fa-percent"></i>
                      </div>
                    </span>
                    <div>
                    <?php
                      $sql = "SELECT COUNT(*) AS att  FROM attendance";
                      $query = mysqli_query($connection, $sql);
                      $row = mysqli_fetch_assoc($query);
                      $total = $row['att'];

                      $sql = "SELECT COUNT(*) AS stat FROM attendance WHERE status_morning = 1";
                      $query = mysqli_query($connection, $sql);
                      $row = mysqli_fetch_assoc($query);
                      $early = $row['stat'];

                      $percentage = round(($early/$total)*100, 2);

                   
                    ?>                      
                      <h4 class="m-0"><a href="javascript:void(0)"><?php echo $percentage.'%' ?> <small>On Time</small></a></h4>
                      <small class="text-muted">On Time Percentage</small>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-lg-3">
                <div class="card p-3">
                  <div class="d-flex align-items-center">
                    <span class="stamp stamp-md bg-red mr-3">
                      <div style="padding-top: 10px;">
                      <i class="fa-solid fa-clock"></i>
                      </div>
                    </span>
                    <div>
                    <?php
                      $toD = date('Y-m-d');

                      $sql = "SELECT COUNT(*) AS stat FROM attendance WHERE date = '$toD' AND status_morning = 1";
                      $query = mysqli_query($connection, $sql);
                      $row = mysqli_fetch_assoc($query);
                      $early = $row['stat'];

                   
                    ?>                       
                      <h4 class="m-0"><a href="javascript:void(0)"><?php echo $early ?> <small>On Time</small></a></h4>
                      <small class="text-muted">On Time Today</small>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-lg-3">
                <div class="card p-3">
                  <div class="d-flex align-items-center">
                    <span class="stamp stamp-md bg-yellow mr-3">
                      <div style="padding-top: 10px;">
                      <i class="fa-solid fa-hourglass-end"></i>
                      </div>
                    </span>
                    <div>
                                          <?php
                      $toD = date('Y-m-d');

                      $sql = "SELECT COUNT(*) AS stat FROM attendance WHERE date = '$toD' AND status_morning = 0";
                      $query = mysqli_query($connection, $sql);
                      $row = mysqli_fetch_assoc($query);
                      $early = $row['stat'];

                   
                    ?> 
                      <h4 class="m-0"><a href="javascript:void(0)"><?php echo $early ?> <small>Late Today</small></a></h4>
                      <small class="text-muted">Total Late Today</small>
                    </div>
                  </div>
                </div>
              </div> 
              <div style="padding-left: 12px; padding-bottom: 25px;" class="">
                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#modal-filter-date">
                <i class="fa-solid fa-filter"></i> Filter Payroll
                </button>
                <div class="dropdown-menu">
                </div>
              </div>    
              <div style="padding-left: 12px; padding-bottom: 25px;" class="dropdown">
                <button type="button" class="btn btn-secondary  " onclick="printPage()">
                <i class="fa-solid fa-print"></i>Print Payroll
                </button>
                <div class="dropdown-menu">
                </div>
              </div>  

              <?php require_once('modals/modal_filter_date.php') ?>
<script type="text/javascript">
function printPage(){
    var divElements = document.getElementById('printDataHolder').innerHTML;
    var oldPage = document.body.innerHTML;
    document.body.innerHTML="<link rel='stylesheet' href='css/common.css' type='text/css' /><body class='bodytext'><div class='padding'><b style='font-size: 16px;'><p class=''>Payroll generated on <?php echo date("m/d/Y") ?> <?php echo date("G:i A") ?> by <?php echo $firstname ?> <?php echo $lastname ?></p></b></div>"+divElements+"</body>";
    window.print();
    document.body.innerHTML = oldPage;
    }
</script>
              <div class="col-12" id="printDataHolder">
                
                <div class="card">
                  <div class="card-header py-3">
                    <h3 class="card-title">Payroll From <b><?php echo date('M d, Y', strtotime($from)) ?>&nbsp(<?php echo date('D', strtotime($from)) ?>) </b>To <b><?php echo date('M d, Y', strtotime($to)) ?>&nbsp(<?php echo date('D', strtotime($to)) ?>)</b></h3>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <!-- <table class="table table-hovered" id="dataTable" width="100%" cellspacing="0"> -->
                        <table class="table table-hovered" width="100%" cellspacing="0">
                        <thead>
                          <tr>
                            <th>No.</th>
                            <th class="w-1">EID</th>
                            <th>Employee Name</th>
                            <th>Position</th>
                            <th>Rate Per Day</th>
                            <th>Gross Income (PHP)</th>                          
                            <th>Cash Advance (PHP)</th>
                            <th>Total Hours</th>
                            <th>Net Income (PHP)</th>
                            <th>Payslip</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php 
                          // Calculating the payroll from SAT - FRI (7 Days)

                          $sql = "
                          SELECT 
    employees.employee_id AS empid, 
    employees.fullname, 
    position.rate, 
    position.description, 
    SUM(attendance.num_hr_morning) AS morning, 
    SUM(attendance.num_hr_afternoon) AS afternoon, 
    SUM(cashadvance.amount) AS cashadvance_amount 
FROM 
    attendance 
LEFT JOIN 
    employees ON employees.id = attendance.employee_id 
LEFT JOIN 
    position ON position.id = employees.position_id 
LEFT JOIN 
    cashadvance ON cashadvance.employee_id = employees.id 
    AND cashadvance.date_advance BETWEEN '$from' AND '$to' 
WHERE 
    attendance.date BETWEEN '$from' AND '$to' 
GROUP BY 
    attendance.employee_id, employees.fullname, position.rate, position.description 
ORDER BY 
    employees.fullname ASC";



                          $sqlPayroll = mysqli_query($connection, $sql);
                          $total = 0;

                          $numbers = 0;

                          while($row = mysqli_fetch_assoc($sqlPayroll)){

                          $numbers++;     

                              $employee_id = $row['empid'];
                              $total_hr = $row['morning'] + $row['afternoon']; // total hour

                              $casql = "
                              SELECT 
                                  SUM(cashadvance.amount) AS cashamount 
                              FROM 
                                  cashadvance 
                              LEFT JOIN 
                                  employees ON employees.id = cashadvance.employee_id 
                              WHERE 
                                  employees.employee_id = '$employee_id' 
                              AND 
                                  cashadvance.date_advance BETWEEN '$from' AND '$to'
                          ";
                          

                              $caquery = mysqli_query($connection, $casql);
                              $carow = mysqli_fetch_assoc($caquery);

                              $cashadvance = $carow['cashamount'];

                              $gross = $row['rate'] * $total_hr;
                              $net_pay = $gross - $cashadvance;


                          ?>
                          <tr>
                            <td><?php echo $numbers ?></td>
                            <td><a href="view.php?id=<?php echo $row['empid'] ?>"><?php echo $row['empid'] ?></a></td>

                            <td><a  class="text-inherit"><?php echo $row['fullname'] ?></a></td>
                            <td><a  class="text-inherit"><?php echo $row['description'] ?></a></td>
                            <td><a  class="text-inherit"><?php echo $row['rate'] ?> </a></td>
                            
                            <td>
                              <?php echo  number_format($gross) ?> 
                            </td>
                            <td>
                            <?php echo ($cashadvance ?? 0) >= 0 ? number_format($cashadvance ?? 0) : '-' . number_format(abs($cashadvance ?? 0)); ?> 
                        </td>

                            <td><?php echo  round($total_hr, 2) ?> Hours</td>
                            <td>
                              <strong><?php echo  number_format($net_pay) ?> </strong>
                            <!-- </td>
                                <td class="hidden-print">
                                                         
                              <a href="payslip.php?id=<?php echo $row['employee_id'] ?>"><button class="btn btn-success btn-sm " >View</button></a>

                            </td>  -->
                            <td class="text-center">
                            <div class="item-action dropdown">
                              <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fa-solid fa-bars"></i></a>
                              <div class="dropdown-menu dropdown-menu-right">
                                <a href="payslip.php?id=<?php echo $row['empid'] ?>" class="dropdown-item"><i class="fa-solid fa-eye"></i> View Payslip</a>
                              </div>
                            </div>
                          </td>
                          </tr>



                          <?php } ?>
                         
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div> 
            </div>           
          </div>
        </div>
      </div>
    </div>   
    <?php require_once('includes/datatables.php') ?>
  </body>
</html>