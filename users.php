<?php
include 'db.php';
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit;
}
include 'navbar.php';
?>
<link rel="stylesheet" href="style.css">
<h2>Users</h2>
<table>
<tr><th>Name</th><th>Email</th></tr>
<?php
$result = $conn->query("SELECT name, email FROM users");
while ($row = $result->fetch_assoc()) {
    echo "<tr><td>{$row['name']}</td><td>{$row['email']}</td></tr>";
}
?>
</table>