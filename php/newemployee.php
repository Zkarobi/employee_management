<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Employee</title>
</head>
<body>
    <a href="logout.php">Logout</a>

    <h1>Add New Employee</h1>

    <?php
        session_start();
        // Enable error reporting
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
    
        // Check if the user is authenticated
        if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
            header('Location: login.php');
            exit();
        }
        // Connect to database
        //$conn = new mysqli('localhost', 'root', '', 'Company');
        // Include the configuration file
        include 'config.php';
        
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } else {
            echo "Database connected successfully!<br>";
        }

        // Fetch departments from Department table
        $result = $conn->query("SELECT dept_id, name FROM Department");

        if ($result->num_rows > 0) {
            echo "Departments fetched successfully!<br>";
        } else {
            echo "No departments found!<br>";
        }

        $conn->close();
    ?>

    <form action="viewemployee.php" method="POST">
        <label for="emp_name">Employee Name:</label><br>
        <input type="text" id="emp_name" name="emp_name" required><br>

        <label for="job_title">Job Title:</label><br>
        <input type="text" id="job_title" name="job_title" required><br>

        <label for="hire_date">Hire Date:</label><br>
        <input type="date" id="hire_date" name="hire_date" required><br>

        <label for="salary">Salary:</label><br>
        <input type="number" id="salary" name="salary" step="0.01" required><br>

        <label for="dept_id">Department:</label><br>
        <select id="dept_id" name="dept_id" required>
            <?php
                // Connect to database again to fetch the dropdown options
                $conn = new mysqli('localhost', 'root', '', 'company'); // Adjust credentials if needed

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Fetch departments from Department table
                $result = $conn->query("SELECT dept_id, name FROM Department");

                if ($result->num_rows > 0) {
                    // Debug: Print fetched department rows
                    while ($row = $result->fetch_assoc()) {
                        echo "Department: " . $row['name'] . "<br>"; // Debugging line to ensure data is fetched correctly
                        echo "<option value='" . $row['dept_id'] . "'>" . $row['name'] . "</option>";
                    }
                } else {
                    echo "<option value=''>No departments available</option>";
                }

                $conn->close();
            ?>
        </select><br><br>

        <input type="submit" value="Add Employee">
    </form>
</body>
</html>
