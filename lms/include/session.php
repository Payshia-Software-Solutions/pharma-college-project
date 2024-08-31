<?php
session_start(); // Initialize the session

// Check if the 'username' index is not set in the $_SESSION array
if (!isset($_SESSION['username'])) {
  // Redirect to logout.php
  header("Location: logout");
  exit(); // Make sure to stop the script after the redirect
}



$sessionid = $_SESSION["username"];
$session = htmlspecialchars($_SESSION["username"]);

$get_fullname = "SELECT fname, lname, username, userlevel, userid, batch_id FROM users WHERE username LIKE '$session'";
$get_fullname_result = $link->query($get_fullname);
while ($row = $get_fullname_result->fetch_assoc()) {
  $first_name = $row['fname'];
  $last_name = $row['lname'];
  $session_user_name = $row['username'];
  $session_user_level = $row['userlevel'];
  $userid = $row['userid'];
  $session_batch_id = $row['batch_id'];
}

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
  header("location: login");
  exit;
}
