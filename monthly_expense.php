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

<h2>Monthly Expense Report</h2>

<?php
$user_id = $_SESSION['user_id'];
$month = date('m');
$year = date('Y');

// Sum of withdrawals and transfers (considered expenses)
$sql = "SELECT category, SUM(amount) as total_amount 
        FROM transactions 
        WHERE user_id=$user_id 
          AND txn_type IN ('withdrawal','transfer') 
          AND YEAR(txn_date) = $year AND MONTH(txn_date) = $month
        GROUP BY category";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>Category</th><th>Total Amount</th></tr>";
    while($row = $result->fetch_assoc()){
        echo "<tr><td>" . htmlspecialchars($row['category']) . "</td><td>" . $row['total_amount'] . "</td></tr>";
    }
    echo "</table>";
} else {
    echo "<p>No expenses found for this month.</p>";
}
?>
