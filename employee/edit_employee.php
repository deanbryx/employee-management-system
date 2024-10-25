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
    $current_employee = $result->fetch_assoc();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $isUsernameChanged = ($username !== $current_employee['username']);
        $isPasswordChanged = (!empty($password));

        $update_sql = "UPDATE users SET username = '$username'";

        if ($isPasswordChanged) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $update_sql .= ", password = '$hashed_password'";
        }

        $update_sql .= " WHERE id = $employee_id AND role = 'employee'";

        if ($conn->query($update_sql) === TRUE) {
            if ($isUsernameChanged || $isPasswordChanged) {
                $_SESSION['success'] = "Employee updated successfully!";
            } else {
                $_SESSION['error'] = "Employee didn't change anything!";
            }
            header("Location: employee.php");
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }
?>