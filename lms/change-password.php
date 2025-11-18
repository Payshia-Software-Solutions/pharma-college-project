<?php
session_start();
$password_updated = 0;
$user_id = $_SESSION["id"];
// Include the database connection and configuration
require_once './include/configuration.php';

// Fetch user details
$user_info_sql = "SELECT username, email FROM users WHERE id = ?";
if ($stmt = mysqli_prepare($link, $user_info_sql)) {
    // Bind the user_id to the query
    mysqli_stmt_bind_param($stmt, "i", $user_id); // "i" => integer

    // Execute the query
    if (mysqli_stmt_execute($stmt)) {
        // Bind result variables
        mysqli_stmt_bind_result($stmt, $username, $email);

        // Fetch the result
        if (mysqli_stmt_fetch($stmt)) {
            // Store user info in session if necessary, or use directly
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;
        }
    }
    mysqli_stmt_close($stmt);
}



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the current user ID from session
    $user_id = $_SESSION["id"];
    $new_password = trim($_POST["new_password"]);
    $confirm_password = trim($_POST["confirm_password"]);

    // Check if both password fields match
    if (empty($new_password) || empty($confirm_password)) {
        $error = "Both password fields are required!";
    } elseif ($new_password !== $confirm_password) {
        $error = "Passwords do not match!";
    } else {
        // Hash the new password
        $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        // Prepare SQL to update the password and set temp_password to null
        $sql = "UPDATE users SET password = ?, temp_password = NULL WHERE id = ?";
        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind the parameters (new password, null for temp_password, and user_id)
            mysqli_stmt_bind_param($stmt, "si", $new_hashed_password, $user_id); // "si" => string and integer

            // Execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Get the number of affected rows
                $affected_rows = mysqli_stmt_affected_rows($stmt);

                if ($affected_rows > 0) {
                    // Set a success message with the affected records count
                    $_SESSION['message'] = "Your password has been successfully updated.";
                    $password_updated = 1; // Flag to indicate successful password update

                } else {
                    // In case no rows were affected (shouldn't happen for the logged-in user)
                    $error = "No changes were made to the database.";
                }
            } else {
                $error = "Oops! Something went wrong. Please try again later.";
            }
            mysqli_stmt_close($stmt);
        } else {
            $error = "Statement preparation failed!";
        }
    }
}

// Close database connection
mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Change Password</title>
    <?php include './include/common-css.php'; ?>
    <style>
        body {
            height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>

<body>
    <div class="container">



        <div class="row">
            <div class="col-12 col-md-6 offset-md-3">
                <div class="card border-0 shadow-lg rounded-4 p-4">
                    <div class="card-body">
                        <div class="row mb-2 mt-4">
                            <div class="col-12 text-center">
                                <img src="https://lms.pharmacollege.lk/assets/images/logo.png"
                                    class="w-25 pb-2 border-bottom mb-2 border-2" alt="logo" class="logo">
                                <h3 class="text-center ">Change Password for <?= $_SESSION['username'] ?></h3>
                            </div>
                        </div>

                        <?php
                        // Display success message if it exists
                        if (isset($_SESSION['message'])) {
                            echo "<div class='alert alert-success'>{$_SESSION['message']}</div>";
                            unset($_SESSION['message']); // Clear the success message after it's displayed

                            // Display the "Login" button if password update was successful
                            if ($password_updated) {
                                echo "<a href='login.php' class='btn btn-dark btn-lg w-100 mt-3'>Go to Login Page</a>";
                                unset($_SESSION['password_updated']); // Clear the flag after displaying the button
                            }
                        }
                        // Display error message if it exists
                        if (!empty($error)) {
                            echo "<div class='alert alert-danger'>{$error}</div>";
                        }

                        // Only show the form if the password was not updated successfully
                        if ($password_updated == 0) {
                        ?>

                            <form action="change-password.php" method="POST">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="new_password">New Password</label>
                                            <input type="password" name="new_password" id="new_password"
                                                class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="confirm_password">Confirm Password</label>
                                            <input type="password" name="confirm_password" id="confirm_password"
                                                class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-dark btn-lg w-100">Change Password</button>
                                    </div>
                                </div>


                            </form>

                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>


        <?php include './include/common-scripts.php'; ?>
</body>

</html>