<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <!-- Font Awesome CDN -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <style>
  /* Apply Poppins font globally */
/* Apply Poppins font globally */
body, .nav-link, .dropdown-item, .avatar span, .text-dark, .text-muted {
    font-family: 'Poppins', sans-serif;
    font-weight: 16px; /* Default font weight */
}

/* Default text color for nav links */
.nav-link {
    color: black; /* Black color for the text */
}

/* Change the text color to orange when hovering */
.nav-link:hover {
    color: orange; /* Orange color on hover */
}

/* Styles for the logo */
.navbar-logo {
    height: 60px; /* Adjust the size of the logo */
    margin-right: 20px; /* Space between logo and menu items */
}

/* Flex container for the navbar */
.navbar-container {
    display: flex;
    align-items: center;
    padding: 10px 20px;
}

/* Styles for the navigation links */
.nav-tabs {
    display: flex;
    flex-direction: row;
    list-style-type: none;
    margin: 0;
    padding: 0;
}

.nav-item {
    margin-right: 20px; /* Space between nav items */
}

  </style>
</head>

<body>
  <!-- Header with Logo Outside the ul -->
  <div class="navbar-container">
    <!-- Add your logo here -->
    <img src="./angular/img/a.png" alt="Logo" class="navbar-logo">
    
    <!-- Navigation Links -->
    <ul class="nav nav-tabs border-0 flex-column flex-lg-row" style="font-family: 'Poppins', sans-serif;">

      <?php if ($type == "Administrator") { ?>
        <li class="nav-item">
          <a href="index.php" class="nav-link"><i class="fas fa-money-check"></i> Payroll</a>
      </li>
          <li class="nav-item">
              <a href="attendance.php?filter=<?php echo date("Y-m-d"); ?>" class="nav-link"><i class="fas fa-calendar-alt"></i> Attendance</a>
          </li>
          <li class="nav-item">
              <a href="javascript:void(0)" class="nav-link" data-toggle="dropdown"><i class="fas fa-users"></i> Employees</a>
              <div class="dropdown-menu dropdown-menu-arrow">
                  <a href="overtime.php" class="dropdown-item"><i class="fas fa-clock"></i> Overtime</a>
                  <a href="advance.php" class="dropdown-item"><i class="fas fa-hand-holding-usd"></i> Cash Advance</a>
                  <a href="schedule.php" class="dropdown-item"><i class="fas fa-calendar-check"></i> Schedule</a>
              </div>
          </li>
          <li class="nav-item">
              <a href="profile.php" class="nav-link"><i class="fas fa-user"></i> Profiling</a>
          </li>
          <li class="nav-item">
              <a href="position.php" class="nav-link"><i class="fas fa-list-alt"></i> Positions</a>
          </li>
          <li class="nav-item">
              <a href="scheduling.php" class="nav-link"><i class="fas fa-calendar"></i> Employee Schedule</a>
          </li>
      <?php } elseif ($type == "Secretary") { ?>
        <li class="nav-item">
          <a href="index.php" class="nav-link"><i class="fas fa-money-check"></i> Payroll</a>
      </li>
        <li class="nav-item">
              <a href="attendance.php?filter=<?php echo date("Y-m-d"); ?>" class="nav-link"><i class="fas fa-calendar-alt"></i> Attendance</a>
          </li>
          <li class="nav-item">
              <a href="profile.php" class="nav-link"><i class="fas fa-user"></i> Profiling</a>
          </li>
      <?php } elseif ($type == "Timekeeper") { ?>
        <li class="nav-item">
              <a href="attendance.php?filter=<?php echo date("Y-m-d"); ?>" class="nav-link"><i class="fas fa-calendar-alt"></i> Attendance</a>
          </li>
        <li class="nav-item">
              <a href="../index.php" class="nav-link"><i class="fas fa-calendar-alt"></i>Attendance Log</a>
          </li>
      <?php } ?>
    </ul>
  </div>
</body>
</html>
