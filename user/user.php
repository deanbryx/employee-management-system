<?php
    session_start();
    include('../db.php');

    if (!isset($_SESSION['username']) || $_SESSION['role'] != 'user') {
        header("Location: index.php");
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
            <h3>EMPLOYEE MANAGEMENT SYSTEM</h3>
        </div>
        <div class="d-flex">
            <button type="button" class="btn btn-outline-dark shadow-none me-lg-3 me-2" data-bs-toggle="modal" data-bs-target="#logoutModal">
                Logout
            </button>
        </div>
    </div>
    <!-- Success or Error Alert Messages -->
    <?php if (isset($_SESSION['success'])) { ?>
        <div class="alert alert-success alert-dismissible fade show float-alert" role="alert">
            <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php } ?>

    <?php if (isset($_SESSION['error'])) { ?>
        <div class="alert alert-danger alert-dismissible fade show float-alert" role="alert">
            <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php } ?>
    <div class="container-fluid">
        <div class="row">
            <div class="ms-auto p-3">
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <h4 class="card-title m-0">USER ACCOUNTS</h4>
                            <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#addUserModal">
                                <i class="bi bi-plus-square"></i> Add
                            </button>
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
                                                    <button type="button" class="btn btn-link text-decoration-none" data-bs-toggle="modal" data-bs-target="#editUserModal<?php echo $row['id']; ?>">
                                                        <i class="bi bi-pencil-square mx-1"></i>Edit
                                                    </button>
                                                </div>
                                                <div class="delbtn">
                                                    <button type="button" class="btn btn-link text-decoration-none bg-danger" data-bs-toggle="modal" data-bs-target="#deleteUserModal<?php echo $row['id']; ?>">
                                                        <i class="bi bi-trash mx-1"></i>Delete
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <!-- Edit user -->
                                        <div class="modal fade" id="editUserModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="editUserModalLabel<?php echo $row['id']; ?>" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title mx-2" id="editUserModalLabel<?php echo $row['id']; ?>">
                                                            <i class="bi bi-person-circle"></i> Edit User
                                                        </h5>
                                                        <button type="button" class="btn-close mx-2" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="edit_user.php?id=<?php echo $row['id']; ?>" method="POST">
                                                            <div class="px-5">
                                                                <div class="col-md-12 p-0 mb-2">
                                                                    <label for="username" class="form-label">Username:</label>
                                                                    <div>
                                                                        <input type="text" class="form-control" name="username" value="<?php echo $row['username']; ?>" required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12 p-0 mb-2">
                                                                    <label for="password" class="form-label">Password:</label>
                                                                    <div>
                                                                        <input type="text" class="form-control" name="password" placeholder="Leave blank to keep current password">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row mt-4">
                                                                    <div class="col-md-12 text-end">
                                                                        <button type="submit" class="btn btn-primary mb-2" name="update">Update Information</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Confirming deletion -->
                                        <div class="modal fade" id="deleteUserModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="deleteUserModalLabel<?php echo $row['id']; ?>" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteUserModalLabel<?php echo $row['id']; ?>">
                                                            <i class="bi bi-trash-fill mx-1"></i>Confirm Deletion
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body mt-3">
                                                        <p>Are you sure you want to delete user <strong><?php echo $row['username']; ?></strong>?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <!-- Cancel Button -->
                                                        <button type="button" class="text-decoration-none border-0 bg-transparent" data-bs-dismiss="modal">Cancel</button>

                                                        <!-- Confirm Deletion Button -->
                                                        <form action="delete_user.php?id=<?php echo $row['id']; ?>" method="POST">
                                                            <button type="submit" class="btn btn-link text-decoration-none bg-danger">Delete</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Adding user -->
                                        <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title mx-2" id="addUserModalLabel">
                                                            <i class="bi bi-person-plus-fill"></i> Add New User
                                                        </h5>
                                                        <button type="button" class="btn-close mx-2" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="add_user.php?id=<?php echo $row['id']; ?>" method="POST">
                                                            <div class="px-5">
                                                                <div class="col-md-12 p-0 mb-2">
                                                                    <label for="username" class="form-label">Username:</label>
                                                                    <div>
                                                                        <input type="text" class="form-control" name="username" required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12 p-0 mb-2">
                                                                    <label for="password" class="form-label">Password:</label>
                                                                    <div>
                                                                        <input type="password" class="form-control" name="password" required>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row mt-4">
                                                                    <div class="col-md-12 text-end">
                                                                        <button type="submit" class="btn btn-primary mb-2" name="update">Add User Account</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Logout Confirmation Modal -->
                                        <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="logoutModalLabel">
                                                            <i class="bi bi-person-fill-exclamation"></i> Logout
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Are you sure you want to log out your account?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <!-- Cancel Button -->
                                                        <button type="button" class="text-decoration-none border-0 bg-transparent" data-bs-dismiss="modal">No</button>
                                                        
                                                        <!-- Confirm Logout Button -->
                                                        <a href="../logout.php" class="btn btn-link text-decoration-none bg-danger">Yes</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        window.setTimeout(function() {
            var alert = document.querySelector('.alert');
            if (alert) {
                alert.classList.remove('show');
                alert.classList.add('fade');
            }
        }, 2000);
    </script>
</body>
</html>
