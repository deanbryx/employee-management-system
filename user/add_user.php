<?php
    session_start();
    include '../db.php';

    if (!isset($_SESSION['username']) || $_SESSION['role'] != 'user') {
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
            header("Location: user.php");
        } else {
            $sql = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', 'user')";

            if ($conn->query($sql) === TRUE) {
                $_SESSION['success'] = "User added successfully!";
                header("Location: user.php");
            } else {
                $error = "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }
?>
