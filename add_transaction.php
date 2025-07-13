<?php
include 'db.php';
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit;
}

if(isset($_POST['submit'])){
    $user_id = $_SESSION['user_id'];
    $txn_type = $conn->real_escape_string($_POST['txn_type']);
    $amount = floatval($_POST['amount']);
    $category = $conn->real_escape_string($_POST['category']);
    $txn_date = $conn->real_escape_string($_POST['txn_date']);

    $sql = "INSERT INTO transactions (user_id, txn_type, amount, category, txn_date) VALUES ($user_id, '$txn_type', $amount, '$category', '$txn_date')";
    if($conn->query($sql)){
        header("Location: transactions.php");
        exit;
    } else {
        $error = "Error: " . $conn->error;
    }
}

include 'navbar.php';
?>

<link rel="stylesheet" href="style.css">

<h2>Add Transaction</h2>

<?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>

<form method="post">
  <label>Type</label>
  <select name="txn_type" required>
    <option value="deposit">Deposit</option>
    <option value="withdrawal">Withdrawal</option>
    <option value="transfer">Transfer</option>
  </select><br>

  <label>Amount</label>
  <input type="number" name="amount" step="0.01" min="0" required><br>

  <label>Category</label>
  <input type="text" name="category" required><br>

  <label>Date</label>
  <input type="date" name="txn_date" required><br>

  <input type="submit" name="submit" value="Add Transaction">
</form>
