<?php
include 'config.php';
session_start();

if (!isset($_SESSION['username'])) {
  header("Location: login.php");
  exit();
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Employee Management</title>
  <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
  <div class="container">
    <h1>Employee Management System</h1>
    <div class="button-container">
      <a href="create.php" class="button">Add New Employee</a>
      <a href="read.php" class="button">View Employees</a>
    </div>
  </div>
</body>
</html>
