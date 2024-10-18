<?php
    session_start();
    include '../db.php';

    if (!isset($_SESSION['username']) || $_SESSION['role'] != 'employee') {
        header("Location: login.php");
        exit();
    }

    $employee_id = $_GET['id'];
    $sql = "SELECT * FROM users WHERE id = $employee_id AND role = 'employee'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $employee = $result->fetch_assoc();
    } else {
        header("Location: employee.php");
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : $employee['password'];

        $sql = "UPDATE users SET username = '$username', password = '$password' WHERE id = $employee_id AND role = 'employee'";

        if ($conn->query($sql) === TRUE) {
            header("Location: employee.php");
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit employee</title>
    <?php require '../links.php'; ?>
    <link rel="stylesheet" href="../css/style1.css">
</head>
<body>
    <div class="header">
        <div class="employee text-white">
            <h3>EMPLOYEE SIDE</h3>
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
                    <h4 class="card-title m-0">EDIT EMPLOYEE ACCOUNT</h4>
                    <a href="employee.php">
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
                            <input type="text" class="form-control" name="username" value="<?php echo $employee['username']; ?>" required>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label for="contactNumber" class="col-sm-2 col-form-label">Password:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="password" placeholder="Leave blank to keep current password">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-10 offset-sm-2">
                            <button type="submit" class="btnn mb-5" name="update">Update Information</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
