<?php
include 'config.php';

if (isset($_GET['id'])) {
  $id = $_GET['id'];

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $position = $_POST['position'];
    $department = $_POST['department'];
    $mobile = $_POST['mobile'];

    // Validate mobile number
    if (!preg_match('/^[0-9]{10}$/', $mobile)) {
      echo "<div class='message error'>Invalid mobile number. Please enter a 10-digit number.</div>";
    } else {
      $sql = "UPDATE employees SET name='$name', position='$position', department='$department', mobile='$mobile' WHERE id=$id";
      if ($conn->query($sql) === TRUE) {
        echo "<div class='message success'>Employee updated successfully</div>";
      } else {
        echo "<div class='message error'>Error: " . $sql . "<br>" . $conn->error . "</div>";
      }
    }
  } else {
    $sql = "SELECT * FROM employees WHERE id=$id";
    $result = $conn->query($sql);
    $employee = $result->fetch_assoc();
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Update Employee</title>
  <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
  <div class="container">
    <h2>Update Employee</h2>
    <form method="post" action="">
      <label for="name">Name:</label>
      <input type="text" name="name" id="name" value="<?php echo $employee['name']; ?>" required><br>
      <label for="position">Position:</label>
      <input type="text" name="position" id="position" value="<?php echo $employee['position']; ?>" required><br>
      <label for="department">Department:</label>
      <input type="text" name="department" id="department" value="<?php echo $employee['department']; ?>" required><br>
      <label for="mobile">Mobile Number:</label>
      <input type="text" name="mobile" id="mobile" value="<?php echo $employee['mobile']; ?>" required pattern="[0-9]{10}" title="Please enter a 10-digit mobile number"><br>
      <input type="submit" value="Update">
    </form>
  </div>
</body>
</html>
