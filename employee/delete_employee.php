<?php
    session_start();
    include '../db.php';
    
    if (!isset($_SESSION['username']) || $_SESSION['role'] != 'employee') {
        header("Location: index.php");
        exit();
    }

    $employee_id = $_GET['id'];

    $sql = "DELETE FROM users WHERE id = $employee_id AND role = 'employee'";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['success'] = "User deleted successfully!";
    } else {
        $_SESSION['error'] = "Error deleting user: " . $conn->error;
    }
    header("Location: employee.php");
    exit();
?>