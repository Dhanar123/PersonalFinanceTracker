<?php
session_start();
include 'db.php';

if(isset($_POST['email']) && isset($_POST['password'])){
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];
    
    $sql = "SELECT * FROM users WHERE email='$email' LIMIT 1";
    $result = $conn->query($sql);
    
    if($result->num_rows == 1){
        $user = $result->fetch_assoc();
        // For demo, password is plain text. In production use password_hash and password_verify
        if($user['password'] == $password){
            $_SESSION['loggedin'] = true;
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['name'] = $user['name'];
            header("Location: users.php");
            exit;
        } else {
            $error = "Incorrect password";
        }
    } else {
        $error = "Email not found";
    }
}
?>

<!DOCTYPE html>
<html>
<head><title>Login</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<h2>Login</h2>
<?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
<form method="post">
  <label>Email</label><br>
  <input type="text" name="email" required><br>
  <label>Password</label><br>
  <input type="password" name="password" required><br>
  <input type="submit" value="Login">
</form>
</body>
</html>
