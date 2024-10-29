<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the user is authenticated
if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Employees</title>
</head>
<body>
    <!-- Logout Link -->
    <a href="logout.php">Logout</a>

    <?php
    // Connect to database
    //$conn = new mysqli('localhost', 'root', '', 'company');
    // Include the configuration file
    include 'config.php';
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert employee data
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $emp_name = $_POST['emp_name'];
        $job_title = $_POST['job_title'];
        $hire_date = $_POST['hire_date'];
        $salary = $_POST['salary'];
        $dept_id = $_POST['dept_id'];

        $sql = "INSERT INTO Employee (emp_name, job_title, hire_date, salary, dept_id) 
                VALUES ('$emp_name', '$job_title', '$hire_date', '$salary', '$dept_id')";

        if ($conn->query($sql) === TRUE) {
            echo "New employee added successfully!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    // Fetch all employees with their department
    $sql = "SELECT emp_name, job_title, hire_date, salary, name AS department
            FROM Employee
            JOIN Department ON Employee.dept_id = Department.dept_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<h2>Employee List</h2>";
        echo "<table border='1'>
                <tr>
                    <th>Employee Name</th>
                    <th>Job Title</th>
                    <th>Hire Date</th>
                    <th>Salary</th>
                    <th>Department</th>
                </tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row['emp_name'] . "</td>
                    <td>" . $row['job_title'] . "</td>
                    <td>" . $row['hire_date'] . "</td>
                    <td>" . $row['salary'] . "</td>
                    <td>" . $row['department'] . "</td>
                </tr>";
        }
        echo "</table>";
    } else {
        echo "No employees found.";
    }

    $conn->close();
    ?>
</body>
</html>
