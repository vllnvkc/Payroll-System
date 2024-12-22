<!doctype html>
<?php 
  include "includes/script.php";
  include "session/Login.php";

  $session = new AdministratorSession();
  $session->LoginSession();

  if (isset($_SESSION['official_username']) && isset($_SESSION['official_password']) && isset($_SESSION['official_id'])) {
      header("location:home.php");
  }  
?>
<html lang="en" dir="ltr">
  <head>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <script src="scripts/vue.js"></script>
    <link rel="icon" href="./angular/img/a.png" type="image/png">
    <title>PayXpert: Payroll Processing System</title>
    <style>
      body {
        font-family: 'Poppins', sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f8f9fa;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
      }
      .container {
        display: flex;
        align-items: center;
        background: #fff;
        padding: 40px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
      }
      .logo {
        flex: 1;
        text-align: center;
      }
      .logo img {
        height: 500px;
      }
      .form-container {
        flex: 1;
      }
      .form-container form {
        width: 100%;
      }
      .card-body {
        padding: 20px;
      }
      .card-title {
        font-size: 20px;
        font-weight: 600;
        margin-bottom: 20px;
        text-align: center;
      }
      .form-group {
        margin-bottom: 15px;
      }
      .form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: 500;
      }
      .form-control {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
      }
      .btn-primary {
        background-color: #007bff;
        color: #fff;
        border: none;
        padding: 10px;
        width: 100%;
        border-radius: 4px;
        cursor: pointer;
      }
      .btn-primary:hover {
        background-color: #0056b3;
      }
    </style>
  </head>
  <body>
    <div class="container">
      <div class="logo">
        <img src="./angular/img/a.png" alt="System Logo">
        <div class="system-name"><b>PayXpert: Payroll Processing System</b></div>
      </div>
      <div class="form-container">
        <form class="card" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
          <div class="card-body">
            <div class="card-title">Login to your account</div>
            <?php echo $session->Validate() ?>
            <div class="form-group">
              <label for="username">Username</label>
              <input type="text" class="form-control login" id="username" name="username" placeholder="Enter username" v-model="election" data-toggle="popover" data-content="Username is required" data-placement="left">
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" class="form-control login" id="password" name="password" placeholder="Enter password" v-model="election" data-toggle="popover" data-content="Password is required" data-placement="left">
            </div>
            <div class="form-footer">
              <button type="submit" name="login" class="btn btn-primary">Log in</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </body>
</html>
