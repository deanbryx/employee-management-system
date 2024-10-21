<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            if ($user['role'] == 'user') {
                header("Location: user/user.php");
            } elseif ($user['role'] == 'employee') {
                header("Location: employee/employee.php");
            }
        } else {
            $error = "Invalid username or password.";
        }
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login form</title>
    <?php require 'links.php'; ?>
</head>
<body>
    <!-- Background & animion & navbar & title -->
    <div class="container-fluid">
        <!-- Background animtion-->
        <div class="background">
        <div class="cube"></div>
        <div class="cube"></div>
        <div class="cube"></div>
        <div class="cube"></div>
        <div class="cube"></div>
    </div>
    <div id="loginForm" class="login-form text-center rounded shadow overflow-hidden">
        <form action="" method="POST">
            <div class="form-header px-1">
                <h4 class="text-white py-3">
                    <i class="bi bi-person-circle fs-3 me-2"></i>SIGN IN FORM
                </h4>
            </div>
            <div class="form-body p-4">
                <div class="mb-3">
                    <input name="username" type="text" class="form-control shadow-none text-center" placeholder="Username" required>
                </div>
                <div class="mb-3">
                    <input name="password" type="password" class="form-control shadow-none text-center" placeholder="Password" required>
                </div>
                <div id="loginbtn" class="loginbtn text-center rounded">
                    <button name="login" type="submit" class="btn text-white shadow-none" value="Login">LOGIN</button>
                </div>
            </div>
            <?php if (isset($error)) { echo "<p style='color:red;'>$error</p>"; } ?>
        </form>
    </div>
</body>
</html>
