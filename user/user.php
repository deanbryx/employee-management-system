<?php
    session_start();
    include('../db.php');

    if (!isset($_SESSION['username']) || $_SESSION['role'] != 'user') {
        header("Location: login.php");
        exit();
    }

    $sql = "SELECT * FROM users WHERE role = 'user'";
    $result = $conn->query($sql);
?>

<!DOCTYPE html>
 <html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User page</title>
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
    <div class="container-fluid">
        <div class="row">
            <div class="ms-auto p-3">
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <h4 class="card-title m-0">USER ACCOUNTS</h4>
                            <a href="add_user.php">
                                <button type="button" class="btnn">
                                    <i class="bi bi-plus-square"></i> Add
                                </button>
                            </a>
                        </div>
                        <div class="table-responsive-md">
                            <table class="table table-hover table-bordered table-striped table-sm">
                                <thead>
                                    <tr class="thead text-light">
                                        <th>#</th>
                                        <th>Username</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $counter = 1;
                                    while ($row = $result->fetch_assoc()) { ?>
                                        <tr>
                                            <td><?php echo $counter++; ?></td>
                                            <td><?php echo $row['username']; ?></td>
                                            <td class="d-flex align-items-center justify-content-start p-2">
                                                <div class="editbtn mx-2">
                                                    <a href="edit_user.php?id=<?php echo $row['id']; ?>" class="text-decoration-none d-flex text-align-center">
                                                        <i class="bi bi-pencil-square mx-1"></i> Edit
                                                    </a> 
                                                </div>
                                                <div class="delbtn">
                                                    <a href="delete_user.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this user?');" class="text-decoration-none d-flex text-align-center">
                                                        <i class="bi bi-trash mx-1"></i> Delete
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
