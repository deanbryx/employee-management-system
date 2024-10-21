<?php
    session_start();
    include '../db.php';

    if (!isset($_SESSION['username']) || $_SESSION['role'] != 'employee') {
        header("Location: index.php");
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $check_sql = "SELECT * FROM users WHERE username = '$username'";
        $check_result = $conn->query($check_sql);
        
        if ($check_result->num_rows > 0) {
            $_SESSION['error'] = "Error: Username already exists!";
            header("Location: employee.php");
        } else {
            $sql = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', 'employee')";

            if ($conn->query($sql) === TRUE) {
                $_SESSION['success'] = "Employee added successfully!";
                header("Location: employee.php");
            } else {
                $error = "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }
?>
