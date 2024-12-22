<?php 

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
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
  body, .nav-link, .dropdown-item, .avatar span, .text-dark, .text-muted {
      font-family: 'Poppins', sans-serif;
      font-weight: 16px; /* Default font weight */
  }

  .nav-link .text-dark {
      color: #212529; /* Adjust text color for better visibility */
  }

  .text-muted {
      color: #6c757d; /* Default muted text color */
  }
  </style>
<body>
  

              <div style="padding-right: 18px;" class="d-flex order-lg-2 ml-auto">
  <div class="dropdown">
    <a href="#" class="nav-link pr-0 leading-none" data-toggle="dropdown">
      <!-- Updated avatar background color to yellow-orange -->
      <span class="avatar" style="background-color: #FFB74D; background-image: url(../demo/b6.jpg)"></span> 
      <span class="ml-2 d-none d-lg-block" style="font-family: 'Poppins', sans-serif;">
        <!-- Updated text color to a darker shade for better contrast -->
        <span class="text-dark"><?php echo $firstname ?>&nbsp<?php echo $lastname ?></span>
        <small class="text-muted d-block mt-1"><?php echo $type?></small>
      </span>
    </a>
    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
    <?php if ($type == "Administrator") { ?>
      <a class="dropdown-item" href="./account.php" style="font-family: 'Poppins', sans-serif;">
      <i class="fa-solid fa-user"></i> Profile
      </a>
      <?php }  ?>
      <div class="dropdown-divider"></div>
      <a class="dropdown-item" href="../admin/signout.php" style="font-family: 'Poppins', sans-serif;">
        <i class="dropdown-icon fa-solid fa-arrow-right-from-bracket"></i> Sign out
      </a>
    </div>
  </div>
</div>
</body>
</html>
