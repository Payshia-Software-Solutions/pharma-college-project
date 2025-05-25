<!DOCTYPE html>
<html lang="en">

<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Initialize the session
session_start();
date_default_timezone_set("Asia/Colombo");
// Database Connection & Other Configuration
require_once './include/configuration.php';
$PageName = "Login";

// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: index");
    exit;
}

$getUsername = $getPassword = '';
if (isset($_GET['UserName'])) {
    $getUsername = $_GET['UserName'];
}

if (isset($_GET['TempPassword'])) {
    $getPassword = $_GET['TempPassword'];
}


// Define variables and initialize with empty values
$username = $password = $status = "";
$username_err = $password_err = "";
$error = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if username is empty
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter your username.";
    } else {
        $username = trim($_POST["username"]);
    }

    // Check if password is empty
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if (empty($username_err) && empty($password_err)) {
        // Prepare a select statement
        $sql = "SELECT id, username, status, password, `batch_lock`, `temp_password` FROM users WHERE username = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {

            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
            $param_username = $username;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Store result
                mysqli_stmt_store_result($stmt);

                // Check if username exists, if yes then verify password
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $status, $hashed_password, $batch_lock, $temp_password);
                    if (mysqli_stmt_fetch($stmt)) {
                        // Check if temp_password is null
                        if ($temp_password === null) {
                            // Password is correct and other conditions are met
                            if (password_verify($password, $hashed_password)) {
                                if ($status == "Active") {
                                    if ($batch_lock == "Active") {
                                        // Check if the password is still "defaultpassword"
                                        if (password_verify("defaultpassword", $hashed_password)) {
                                            // Redirect to change password page if the password is still "defaultpassword"
                                            session_start();
                                            $_SESSION["id"] = $id;
                                            header("location: change-password.php");
                                            exit;
                                        } else {
                                            // Password is correct, so start a new session
                                            session_start();
                                            $_SESSION["loggedin"] = true;
                                            $_SESSION["id"] = $id;
                                            $_SESSION["username"] = $username;

                                            // Redirect to the index page
                                            header("location: index?user=$username");
                                            exit;
                                        }
                                    } else {
                                        // Batch is locked
                                        $error = "Your Batch is Closed";
                                    }
                                } else {
                                    // Account is deactivated
                                    $error = "Due to an unfinished payment, your account has been immediately deactivated.";
                                }
                            } else {
                                // Invalid password
                                $error = "Wrong Password! Please enter correct Password.";
                            }
                        } else {
                            // Redirect to change password page if the password is still "defaultpassword"
                            session_start();
                            $_SESSION["id"] = $id;
                            header("location: change-password.php");
                            exit;
                        }
                    } else {
                        $error = "Due to an unfinished payment, your account has been immediately deactivated.";
                    }
                } else {
                    // Display an error message if username doesn't exist
                    $error = "No account found with that username.";
                }
            } else {
                $error = "Oops! Something went wrong. Please try again later.";
            }
            // Close statement
            mysqli_stmt_close($stmt);
        } else {
            $error = "Statement Not Working Please Contact System Administator" . $password . $sql;
        }
    } else {
        $error = "Statement Not Working Please Contact System Administator";
    }
    // Close connection
    mysqli_close($link);
}

?>
<input type="hidden" name="getUsername" id="getUsername" value="<?= $getUsername ?>">
<input type="hidden" name="getPassword" id="getPassword" value="<?= $getPassword ?>">

<head>
    <!-- Meta Description -->
    <?php include './include/meta-description.php' ?>
    <!-- End of  Meta Description -->

    <title><?= $PageName ?> | <?= $SiteTitle ?></title>

    <!-- Common CSS -->
    <?php include './include/common-css.php' ?>
    <!-- End of Common CSS -->
</head>

<body>
    <div class="container">

        <?php
        if ($error != "") {
        ?>
            <div class="row">
                <div class="col-12 col-md-6 offset-md-3">
                    <div class="alert alert-warning">
                        <?= $error ?>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>


        <!-- Page Content -->
        <div id="root"></div>
        <!-- End of Page Content -->


        <!-- Footer -->
        <?php include './include/footer.php' ?>
        <!-- End of Footer -->

    </div>

    <!-- Common scripts -->
    <?php include './include/common-scripts.php' ?>
    <!-- End of Common scripts -->

    <!-- Custom Scripts -->
    <script src="./lib/login/assets/js/login-1.0.1.js"></script>
    <!-- End of Custom Scripts -->
</body>

</html>