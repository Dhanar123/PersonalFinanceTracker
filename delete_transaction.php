<?php
include 'db.php';
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit;
}

$id = intval($_GET['id']);
$user_id = $_SESSION['user_id'];

$sql = "DELETE FROM transactions WHERE txn_id=$id AND user_id=$user_id";

$conn->query($sql);

header("Location: transactions.php");
exit;
?>
