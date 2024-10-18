<?php
    session_start();
    include '../db.php';

    if (!isset($_SESSION['username']) || $_SESSION['role'] != 'user') {
        header("Location: login.php");
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $check_sql = "SELECT * FROM users WHERE username = '$username'";
        $check_result = $conn->query($check_sql);
        
        if ($check_result->num_rows > 0) {
            $error = "Username already exists!";
        } else {
            $sql = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', 'user')";

            if ($conn->query($sql) === TRUE) {
                header("Location: user.php");
            } else {
                $error = "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add user</title>
    <?php require '../links.php'; ?>
    <link rel="stylesheet" href="../css/style1.css">
</head>
<body>
    <div class="header">
        <div class="employee text-white">
            <h3>USERS SIDE</h3>
        </div>
        <div class="d-flex">
            <a href="../logout.php">
                <button type="button" class="btn btn-outline-dark shadow-none me-lg-3 me-2" >
                    Logout
                </button>
            </a>
        </div>
    </div>
    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body">
                <div class="div d-flex align-items-center justify-content-between mt-2 mx-2">
                    <h4 class="card-title m-0">ADD NEW USER ACCOUNT</h4>
                    <a href="user.php">
                        <button type="button" class="backtn">
                            <i class="bi bi-arrow-90deg-left"></i> Back
                        </button>
                    </a>
                </div>
        </div>
        <div>
            <form action="" method="POST">
                <div class="px-5 ">
                    <div class="form-group row mb-2">
                        <label for="contactNumber" class="col-sm-2 col-form-label">Username:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="username" required>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label for="contactNumber" class="col-sm-2 col-form-label">Password:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="password" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-10 offset-sm-2">
                            <button type="submit" class="btnn mb-5" name="update">Add User Account</button>
                        </div>
                    </div>
                    <?php if (isset($error)) { echo "<p style='color:red;'>$error</p>"; } ?>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
