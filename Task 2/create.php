<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $id = $_POST['id'];
  $name = $_POST['name'];
  $position = $_POST['position'];
  $department = $_POST['department'];
  $mobile = $_POST['mobile'];

  // Validate mobile number
  if (!preg_match('/^[0-9]{10}$/', $mobile)) {
    echo "<div class='message error'>Invalid mobile number. Please enter a 10-digit number.</div>";
  } else {
    $sql = "INSERT INTO employees (id, name, position, department, mobile) VALUES ('$id', '$name', '$position', '$department', '$mobile')";
    if ($conn->query($sql) === TRUE) {
      echo "<div class='message success'>New employee created successfully</div>";
    } else {
      echo "<div class='message error'>Error: " . $sql . "<br>" . $conn->error . "</div>";
    }
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Create Employee</title>
  <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
  <div class="container">
    <h2>Create New Employee</h2>
    <form method="post" action="">
      <label for="id">Id:</label>
      <input type="text" name="id" id="id" required><br>
      <label for="name">Name:</label>
      <input type="text" name="name" id="name" required><br>
      <label for="position">Position:</label>
      <input type="text" name="position" id="position" required><br>
      <label for="department">Department:</label>
      <input type="text" name="department" id="department" required><br>
      <label for="mobile">Mobile Number:</label>
      <input type="text" name="mobile" id="mobile" required pattern="[0-9]{10}" title="Please enter a 10-digit mobile number"><br>
      <input type="submit" value="Create">
    </form>
  </div>
</body>
</html>
