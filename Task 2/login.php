<?php
include 'config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $username = $_POST['username'];
  $password = $_POST['password'];

  $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    $_SESSION['username'] = $username;
    header("Location: index.php");
  } else {
    echo "<div class='message error'>Invalid username or password</div>";
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
  <div class="container">
    <h2>Login</h2>
    <form method="post" action="">
      <label for="username">Username:</label>
      <input type="text" name="username" id="username" required><br>
      <label for="password">Password:</label>
      <input type="password" name="password" id="password" required><br>
      <input type="submit" value="Login">
    </form>
  </div>
</body>
</html>
