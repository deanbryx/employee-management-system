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
    $current_user = $result->fetch_assoc();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $isUsernameChanged = ($username !== $current_user['username']);
        $isPasswordChanged = (!empty($password));

        $update_sql = "UPDATE users SET username = '$username'";

        if ($isPasswordChanged) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $update_sql .= ", password = '$hashed_password'";
        }

        $update_sql .= " WHERE id = $user_id AND role = 'user'";

        if ($conn->query($update_sql) === TRUE) {
            if ($isUsernameChanged || $isPasswordChanged) {
                $_SESSION['success'] = "User updated successfully!";
            } else {
                $_SESSION['error'] = "User didn't change anything!";
            }
            header("Location: user.php");
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }
?>