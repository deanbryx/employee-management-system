<?php
    session_start();
    include '../db.php';

    if (!isset($_SESSION['username']) || $_SESSION['role'] != 'employee') {
        header("Location: login.php");
        exit();
    }

    $employee_id = $_GET['id'];

    $sql = "DELETE FROM users WHERE id = $employee_id AND role = 'employee'";

    if ($conn->query($sql) === TRUE) {
        header("Location: employee.php");
    } else {
        echo "Error deleting record: " . $conn->error;
    }
?>
