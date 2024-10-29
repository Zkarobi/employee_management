<?php
// Check if the script is running on the local XAMPP environment or the CODD server
if ($_SERVER['HTTP_HOST'] == 'localhost') {
    // Local XAMPP environment settings
    $db_host = 'localhost';
    $db_user = 'root';
    $db_password = '';
    $db_name = 'company';
} else {
    // CODD server settings
    $db_host = 'localhost';
    $db_user = 'jdoe1';
    $db_password = 'YOUR_CODD_DB_PASSWORD';
    $db_name = 'jdoe1';
}

// Create a new connection using the correct settings
$conn = new mysqli($db_host, $db_user, $db_password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
