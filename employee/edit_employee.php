<?php
    session_start();
    include '../db.php';

    if (!isset($_SESSION['username']) || $_SESSION['role'] != 'employee') {
        header("Location: index.php");
        exit();
    }

    $employee_id = $_GET['id'];
    $sql = "SELECT * FROM users WHERE id = $employee_id AND role = 'employee'";
    $result = $conn->query($sql);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $check_sql = "SELECT * FROM users WHERE username = '$username'";
        $check_result = $conn->query($check_sql);

        if ($check_result->num_rows > 0) {
            $_SESSION['error'] = "Error: Username already exists!";
            header("Location: employee.php");
        } else {
            $sql = "UPDATE users SET username = '$username', password = '$password' WHERE id = $employee_id AND role = 'employee'";
    
            if ($conn->query($sql) === TRUE) {
                $_SESSION['success'] = "Employee updated successfully!";
                header("Location: employee.php");
            } else {
                echo "Error updating record: " . $conn->error;
            }
        }
    }
?>
