<?php

require_once('includes/script.php');
require_once('session/Login.php');

$model = new Dashboard();
$session = new AdministratorSession();
$session->LoginSession();

if (!isset($_SESSION['official_username']) && !isset($_SESSION['official_password']) && !isset($_SESSION['official_id'])) {
  header("location:index.php?utm_campaign=expired");
}

$model = new Dashboard();
$password = $_SESSION['official_password'];
$username = $_SESSION['official_username'];
$uid = $_SESSION['official_id'];

$connection = $model->TemporaryConnection();

$today = isset($_GET['filter']) && !empty($_GET['filter']) ? $_GET['filter'] : date('Y-m-d');
$formattedDate = date('F d, Y', strtotime($today));


$query = $model->GetAdministrator($username, $password);
$admin = mysqli_fetch_assoc($query);
$id = $admin['id'];
$firstname = $admin['firstname'];
$lastname = $admin['lastname'];
$photo = $admin['photo'];
$create = $admin['created_on'];

$Attendance = '';
$today = '';
$stat = '';
if (isset($_GET['status'])) {
  $Attendance = $_GET['status'];
}

if (isset($_GET['filter'])) {
  $today = $_GET['filter'];
}

if ($Attendance == '1') {
  $stat = '<div class="alert alert-danger alert-dismissible">
  <button type="button" class="close" data-dismiss="alert"></button>
  Attendance for the day already exist.
</div>';
} else { }

?>
<!doctype html>

<html lang="en" dir="ltr">

<head>
<link rel="icon" href="./angular/img/a.png" type="image/png">
<title>PayXpert: Payroll Processing System</title>
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
        font-size: 14px; /* Consistent table font size */
      }
    </style>
</head>

<body>
  <div class="page" id="app">
    <div class="page-main">
      <div class="header collapse d-lg-flex p-0" id="headerMenuCollapse">
        <div class="container">
          <div class="row align-items-center">
            <div class="d-flex">
              <?php require_once('includes/header.php') ?>

              <?php require_once('includes/bower_css.php') ?>
            </div>
            <div class="col-lg order-lg-first">
              <?php require_once('includes/subheader.php') ?>
              <?php require_once('modals/modal_filter_attendance.php') ?>
              <?php require_once('modals/modal_show_attendance.php') ?>
            </div>
          </div>
        </div>
      </div>
      <script type="text/javascript">
        function printPage() {
          var divElements = document.getElementById('printDataHolder').innerHTML;
          var oldPage = document.body.innerHTML;
          document.body.innerHTML = "<link rel='stylesheet' href='css/common.css' type='text/css' /><body class='bodytext'><div class='padding'><b style='font-size: 16px;'><p class=''>Attendance generated on <?php echo date("m/d/Y") ?> <?php echo date("G:i A") ?> by <?php echo $firstname ?> <?php echo $lastname ?></p></b></div>" + divElements + "</body>";
          window.print();
          document.body.innerHTML = oldPage;
        }
      </script>
      <div class="my-3 my-md-5">
        <div class="container">
          <?php echo $stat ?>
          <div class="page-header">

            <h1 class="page-title">
              <b>Attendance</b>
            </h1>
          </div>

          <div class="row row-cards">
            <div style="padding-left: 12px; padding-bottom: 25px;">
              <div class="dropdown  ">
                <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown">
                  <i style="padding-top: 10px;"  class="fa-solid fa-plus"></i> Add Attendance</button>

                <div style="padding-top: 10px;" class="dropdown-menu">
                  <button data-toggle="modal" data-target="#modal-add-attendance-in" class="dropdown-item ">Add Time In</button>
                  <button data-toggle="modal" data-target="#modal-add-attendance-out" class="dropdown-item ">Add Time Out</button>
                </div>

              </div>
              <div style="padding-left: 12px;" class="dropdown  ">
                <button type="button" 
                
                data-toggle="modal" data-target="#modal-filter-attendance" class="btn btn-secondary">
                  <i style="padding-top: 10px;" class="fa-solid fa-filter"></i> Filter Date</button>


              </div>
              <div style="padding-left: 12px;" class="dropdown  ">
                <button type="button" class="btn btn-secondary" onclick="printPage()">
                  <i style="padding-top: 10px;" class="fa-solid fa-print"></i> Print Attendance</button>


              </div>
              <div style="padding-left: 420px; float: right" class="dropdown ">
                <button data-toggle="modal" data-target="#modal-show-attendance" type="button" class="btn btn-secondary ">
                  <i style="padding-top: 10px;" class="fa-solid fa-eye"></i>Show All</button>


              </div>
            </div>
            <div class="col-12">
              <div class="card">
                <div class="card-header py-3">
                  <h3 class="card-title">Attendance Table for <b><?php echo date('F d, Y', strtotime($today)) ?></b></h3>
                </div>
                <?php require_once('modals/modal_add_attendance.php') ?>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-hovered" id="dataTable" cellspacing="5">
                      <thead>
                        <tr>
                          <th>Employee name</th>
                          <th>Timein AM</th>
                          <th>Timeout AM</th>
                          <th>Total Time</th>
                          <th>Timein PM</th>
                          <th>Timeout PM</th>
                          <th>Total Time</th>
                          <th>date</th>
                          <!-- <th>action</th> -->
                        </tr>
                      </thead>
                      <tbody>
                        <?php while ($row = mysqli_fetch_assoc($queryResult)) {

                          $statusMorning = ($row['status_morning']) ? '&nbsp&nbsp<span class="badge badge-info">Ontime</span>' : '&nbsp&nbsp<span class="badge badge-warning">Late</span>';

                          $statusAfternoon = ($row['status_afternoon']) ? '&nbsp&nbsp<span class="badge badge-info">Ontime</span>' : '&nbsp&nbsp<span class="badge badge-warning">Late</span>';

                          ?>
                      <tr>
                          <td><a class="text-inherit"><?php echo $row['fullname'] ?></a></td>
                          <td class="">
                              <a class="text-inherit">
                                  <?php 
                                  echo !empty($row['time_in_morning']) 
                                      ? date('h:i A', strtotime($row['time_in_morning'])) 
                                      : 'N/A'; 
                                  ?>
                              </a>
                              <?php echo $statusMorning ?>
                          </td>
                          <td>
                              <a class="text-inherit">
                                  <?php 
                                  echo !empty($row['time_out_morning']) 
                                      ? date('h:i A', strtotime($row['time_out_morning'])) 
                                      : 'N/A'; 
                                  ?>
                              </a>
                          </td>
                          <td class="text">
                              <?php 
                              echo !empty($row['num_hr_morning']) 
                                  ? round($row['num_hr_morning'], 2) 
                                  : '0.00'; 
                              ?> HRS
                          </td>
                          <td>
                              <?php 
                              echo !empty($row['time_in_afternoon']) 
                                  ? date('h:i A', strtotime($row['time_in_afternoon'])) 
                                  : 'N/A'; 
                              ?>
                              <?php echo $statusAfternoon ?>
                          </td>
                          <td>
                              <?php 
                              echo !empty($row['time_out_afternoon']) 
                                  ? date('h:i A', strtotime($row['time_out_afternoon'])) 
                                  : 'N/A'; 
                              ?>
                          </td>
                          <td class="text">
                              <?php 
                              echo !empty($row['num_hr_afternoon']) 
                                  ? round($row['num_hr_afternoon'], 2) 
                                  : '0.00'; 
                              ?> HRS
                          </td>
                          <td>
                              <a class="text-inherit">
                                  <?php 
                                  echo !empty($row['date']) 
                                      ? date('M d, Y', strtotime($row['date'])) 
                                      : 'N/A'; 
                                  ?>
                              </a>
                          </td>
                          <!-- <td>
                              <button class="btn btn-success btn-sm" data-toggle="modal" 
                                  data-target="#edit-time-<?php echo $row['attendance_id'] ?>">Edit</button>
                          </td> -->
                      </tr>
                          <!-- .modal -->
                          <div id="edit-time-<?php echo $row['attendance_id'] ?>" class="modal fade animate" data-backdrop="true">
                            <div class="modal-dialog" id="animate">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title">Edit Time</h5>
                                </div>
                                <form method="post" action="time.php?id=<?php echo $row['attendance_id'] ?>">
                                <div class="modal-body text p-lg">
                                 
                                  <div style="padding-top: 12px;" class="form-group">
                                    <label class="form-label">Timein Morning</label>
                                    <div class="bootstrap-timepicker">
                                      <input required="true" type="text"  autofocus="true"  class="form-control timepicker" name="time_in_am">
                                    </div>
                                  </div>
                                  <div style="padding-top: 12px;" class="form-group">
                                    <label class="form-label">Timeout Morning</label>
                                    <div class="bootstrap-timepicker">
                                      <input required="true" type="text" class="form-control timepicker" name="time_out_am">
                                    </div>
                                  </div>
                                  <div style="padding-top: 12px;" class="form-group">
                                    <label class="form-label">Timein Afternoon</label>
                                    <div class="bootstrap-timepicker">
                                      <input required="true" type="text" class="form-control timepicker" name="time_in_pm">
                                    </div>
                                  </div>
                                  <div style="padding-top: 12px;" class="form-group">
                                    <label class="form-label">Timeout Afternoon</label>
                                    <div class="bootstrap-timepicker">
                                      <input required="true" type="text" class="form-control timepicker" name="time_out_pm">
                                    </div>
                                  </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn dark-white p-x-md" data-dismiss="modal">No</button>
                                  <button type="submit" name="edit_time" class="btn danger p-x-md">Yes</button>
                                </div>
                                </form>
                              </div>
                            </div>
                          </div>
                          <!-- / .modal -->
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
  <?php require_once('includes/bower.php') ?>
</body>

</html>