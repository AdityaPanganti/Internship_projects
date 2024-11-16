<?php
include 'config.php';

if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $sql = "DELETE FROM employees WHERE id=$id";
  if ($conn->query($sql) === TRUE) {
    echo "<div class='message success'>Employee deleted successfully</div>";
  } else {
    echo "<div class='message error'>Error: " . $sql . "<br>" . $conn->error . "</div>";
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Delete Employee</title>
  <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
  <div class="container">
    <a href="read.php">Back to Employee List</a>
  </div>
</body>
</html>
