<?php
include 'db.php';
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit;
}

$id = intval($_GET['id']);
$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM transactions WHERE txn_id=$id AND user_id=$user_id LIMIT 1";
$result = $conn->query($sql);

if($result->num_rows != 1){
    die("Transaction not found or you do not have permission.");
}

$transaction = $result->fetch_assoc();

if(isset($_POST['submit'])){
    $txn_type = $conn->real_escape_string($_POST['txn_type']);
    $amount = floatval($_POST['amount']);
    $category = $conn->real_escape_string($_POST['category']);
    $txn_date = $conn->real_escape_string($_POST['txn_date']);

    $sql = "UPDATE transactions SET txn_type='$txn_type', amount=$amount, category='$category', txn_date='$txn_date' WHERE txn_id=$id AND user_id=$user_id";

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

<h2>Edit Transaction</h2>

<?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>

<form method="post">
  <label>Type</label>
  <select name="txn_type" required>
    <option value="deposit" <?php if($transaction['txn_type'] == 'deposit') echo 'selected'; ?>>Deposit</option>
    <option value="withdrawal" <?php if($transaction['txn_type'] == 'withdrawal') echo 'selected'; ?>>Withdrawal</option>
    <option value="transfer" <?php if($transaction['txn_type'] == 'transfer') echo 'selected'; ?>>Transfer</option>
  </select><br>

  <label>Amount</label>
  <input type="number" name="amount" step="0.01" min="0" value="<?php echo htmlspecialchars($transaction['amount']); ?>" required><br>

  <label>Category</label>
  <input type="text" name="category" value="<?php echo htmlspecialchars($transaction['category']); ?>" required><br>

  <label>Date</label>
  <input type="date" name="txn_date" value="<?php echo htmlspecialchars($transaction['txn_date']); ?>" required><br>

  <input type="submit" name="submit" value="Update Transaction">
</form>
