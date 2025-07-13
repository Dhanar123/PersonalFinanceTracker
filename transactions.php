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

<h2>Transactions</h2>

<table>
<tr>
  <th>Type</th><th>Amount</th><th>Category</th><th>Date</th><th>Actions</th>
</tr>

<?php
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM transactions WHERE user_id=$user_id ORDER BY txn_date DESC";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    echo "<tr>
        <td>" . htmlspecialchars($row['txn_type']) . "</td>
        <td>" . htmlspecialchars($row['amount']) . "</td>
        <td>" . htmlspecialchars($row['category']) . "</td>
        <td>" . htmlspecialchars($row['txn_date']) . "</td>
        <td>
          <a href='edit_transaction.php?id=" . $row['txn_id'] . "'>Edit</a> | 
          <a href='delete_transaction.php?id=" . $row['txn_id'] . "' onclick='return confirm(\"Are you sure?\");'>Delete</a>
        </td>
      </tr>";
}
?>

</table>
