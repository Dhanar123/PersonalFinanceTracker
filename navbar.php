<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if(!isset($_SESSION['loggedin'])){
    header("Location: login.php");
    exit;
}
?>
<nav>
  <a href="users.php">Users</a> | 
  <a href="transactions.php">Transactions</a> | 
  <a href="add_transaction.php">Add Transaction</a> | 
  <a href="monthly_expense.php">Monthly Expense</a> | 
  <a href="logout.php">Logout</a>
</nav>
<hr>
