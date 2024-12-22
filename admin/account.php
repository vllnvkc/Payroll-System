<?php
// Include necessary files
require '../vendor/autoload.php';
require_once('includes/script.php');
require_once('session/Login.php');

// Initialize session and model
$model = new Dashboard();
$session = new AdministratorSession();
$session->LoginSession();

// Check if user is logged in
if (!isset($_SESSION['official_username']) || !isset($_SESSION['official_password']) || !isset($_SESSION['official_id'])) {
    header("location:index.php?utm_campaign=expired");
    exit;
}

$username = $_SESSION['official_username'];
$password = $_SESSION['official_password'];
$uid = $_SESSION['official_id'];

$connection = $model->TemporaryConnection();

// Fetch the current user data (admin's profile)
$query = $model->GetAdministrator($username, $password);
$admin = mysqli_fetch_assoc($query);
$firstname = $admin['firstname'];
$lastname = $admin['lastname'];
$type = $admin['type']; // Get user type (Admin, Timekeeper, Siteboss)

// Handle form submission for modifying user info
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];
    $new_username = $_POST['username'];
    $new_password = $_POST['password'];
    $new_firstname = $_POST['firstname'];
    $new_lastname = $_POST['lastname'];
    
    // Update the user info based on the type
    $update_query = "UPDATE admin SET 
                        username = '$new_username', 
                        password = '$new_password',
                        firstname = '$new_firstname', 
                        lastname = '$new_lastname'
                     WHERE id = '$user_id'";

    $result = mysqli_query($connection, $update_query);

    if ($result) {
        echo "<script>alert('User details updated successfully');</script>";
    } else {
        echo "<script>alert('Error updating user details:');</script> . mysqli_error($connection)";
    }
}

// Fetch all users for admin, timekeeper, and siteboss roles
$admin_query = "SELECT * FROM admin WHERE type = 'Administrator'";
$admin_result = mysqli_query($connection, $admin_query);
$timekeeper_query = "SELECT * FROM admin WHERE type = 'Timekeeper'";
$timekeeper_result = mysqli_query($connection, $timekeeper_query);
$siteboss_query = "SELECT * FROM admin WHERE type = 'Secretary'";
$siteboss_result = mysqli_query($connection, $siteboss_query);
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
                            <i style="font-size: 20px;" class="fa-solid fa-greater-than"></i> Modify Account
                        </h1>
                    </div>

                    <!-- Admin User Modification Container -->
                    <div class="row">
                        <div class="col-12 col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Modify Admin Account</h3>
                                </div>
                                <div class="card-body">
                                    <?php while ($admin_data = mysqli_fetch_assoc($admin_result)): ?>
                                        <form method="POST" action="">
                                            <input type="hidden" name="user_id" value="<?= $admin_data['id'] ?>">
                                            <div class="form-group">
                                                <label for="username">Username</label>
                                                <input type="text" class="form-control" name="username" value="<?= $admin_data['username'] ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="password">Password</label>
                                                <input type="password" class="form-control" name="password" value="<?= $admin_data['password'] ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="firstname">First Name</label>
                                                <input type="text" class="form-control" name="firstname" value="<?= $admin_data['firstname'] ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="lastname">Last Name</label>
                                                <input type="text" class="form-control" name="lastname" value="<?= $admin_data['lastname'] ?>" required>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Update Admin</button>
                                        </form>
                                    <?php endwhile; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Timekeeper User Modification Container -->
                        <div class="col-12 col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Modify Timekeeper Account</h3>
                                </div>
                                <div class="card-body">
                                    <?php while ($timekeeper_data = mysqli_fetch_assoc($timekeeper_result)): ?>
                                        <form method="POST" action="">
                                            <input type="hidden" name="user_id" value="<?= $timekeeper_data['id'] ?>">
                                            <div class="form-group">
                                                <label for="username">Username</label>
                                                <input type="text" class="form-control" name="username" value="<?= $timekeeper_data['username'] ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="password">Password</label>
                                                <input type="password" class="form-control" name="password" value="<?= $timekeeper_data['password'] ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="firstname">First Name</label>
                                                <input type="text" class="form-control" name="firstname" value="<?= $timekeeper_data['firstname'] ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="lastname">Last Name</label>
                                                <input type="text" class="form-control" name="lastname" value="<?= $timekeeper_data['lastname'] ?>" required>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Update Timekeeper</button>
                                        </form>
                                    <?php endwhile; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Siteboss User Modification Container -->
                        <div class="col-12 col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Modify Siteboss Account</h3>
                                </div>
                                <div class="card-body">
                                    <?php while ($siteboss_data = mysqli_fetch_assoc($siteboss_result)): ?>
                                        <form method="POST" action="">
                                            <input type="hidden" name="user_id" value="<?= $siteboss_data['id'] ?>">
                                            <div class="form-group">
                                                <label for="username">Username</label>
                                                <input type="text" class="form-control" name="username" value="<?= $siteboss_data['username'] ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="password">Password</label>
                                                <input type="password" class="form-control" name="password" value="<?= $siteboss_data['password'] ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="firstname">First Name</label>
                                                <input type="text" class="form-control" name="firstname" value="<?= $siteboss_data['firstname'] ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="lastname">Last Name</label>
                                                <input type="text" class="form-control" name="lastname" value="<?= $siteboss_data['lastname'] ?>" required>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Update Siteboss</button>
                                        </form>
                                    <?php endwhile; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</body>
</html>
