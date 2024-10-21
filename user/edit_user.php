<?php
    session_start();
    include '../db.php';

    if (!isset($_SESSION['username']) || $_SESSION['role'] != 'user') {
        header("Location: index.php");
        exit();
    }

    $user_id = $_GET['id'];
    $sql = "SELECT * FROM users WHERE id = $user_id AND role = 'user'";
    $result = $conn->query($sql);
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
        $check_sql = "SELECT * FROM users WHERE username = '$username'";
        $check_result = $conn->query($check_sql);
        
        if ($check_result->num_rows > 0) {
            $_SESSION['error'] = "Error: Username already exists!";
            header("Location: user.php");
        } else {
            $sql = "UPDATE users SET username = '$username', password = '$password' WHERE id = $user_id AND role = 'user'";
    
            if ($conn->query($sql) === TRUE) {
                $_SESSION['success'] = "User updated successfully!";
                header("Location: user.php");
            } else {
                echo "Error updating record: " . $conn->error;
            }
        }
    }
?>



<!-- <?php
session_start();
include('../db.php');

// Check if the form is submitted
if (isset($_POST['update'])) {
    $userId = $_GET['id'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Update query (use password hash if you update the password)
    if (!empty($password)) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $sql = "UPDATE users SET username = '$username', password = '$hashedPassword' WHERE id = $userId";
    } else {
        $sql = "UPDATE users SET username = '$username' WHERE id = $userId";
    }

    if ($conn->query($sql) === TRUE) {
        // Set a success message in the session
        $_SESSION['success'] = "User updated successfully!";
    } else {
        // Set an error message if something goes wrong
        $_SESSION['error'] = "Error updating user: " . $conn->error;
    }

    // Redirect back to the user page
    header("Location: user.php");
    exit();
}
?> -->