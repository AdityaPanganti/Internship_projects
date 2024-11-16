<?php
include 'config.php';

$sql = "SELECT * FROM employees";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
  <title>View Employees</title>
  <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
  <div class="container">
    <h2>Employee List</h2>
    <table border="1">
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Position</th>
        <th>Department</th>
        <th>Mobile Number</th>
        <th>Actions</th>
      </tr>
      <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
          <td><?php echo $row['id']; ?></td>
          <td><?php echo $row['name']; ?></td>
          <td><?php echo $row['position']; ?></td>
          <td><?php echo $row['department']; ?></td>
          <td><?php echo $row['mobile']; ?></td>
          <td class="actions">
            <a href="update.php?id=<?php echo $row['id']; ?>">Update</a>
            <a href="delete.php?id=<?php echo $row['id']; ?>">Delete</a>
          </td>
        </tr>
      <?php } ?>
    </table>
  </div>
</body>
</html>
