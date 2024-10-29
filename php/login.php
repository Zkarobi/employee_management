<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Connect to database
//$conn = new mysqli('localhost', 'root', '', 'company');
// Include the configuration file
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = md5($_POST['password']); // Use md5 to hash the password

    // Check if the user exists
    $sql = "SELECT * FROM Users WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // Authentication successful
        $_SESSION['authenticated'] = true;
        $_SESSION['username'] = $username;
        header('Location: newemployee.php');
        exit();
    } else {
        // Authentication failed
        echo "Invalid username or password. <a href='login.php'>Try again</a>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <form method="POST" action="login.php">
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" required><br>
        
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>
        
        <input type="submit" value="Login">
    </form>
    <!-- Link to the Sign-Up Page -->
    <p>Don't have an account? <a href="signup.php">Sign up here</a></p>
</body>
</html>
