<?php

include "config.php"; include  "access.php";

if($_GET['action']=="delete"){
    $user_id = $_GET['id'];
    $sql = "DELETE FROM users WHERE user_id=:user_id AND role!=='admin'";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    header("Location: users.php");
    exit();
}

if(isset($_POST['save'])){
    $first_name = $_POST['first-name'];
    $last_name = $_POST['last-name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $status = $_POST['status'];

    $user_id = $_POST['user-id'];

    if($user_id>0){
        #pdo update
        $sql = "UPDATE users SET first_name=:first_name, last_name=:last_name, email=:email, password=:password, role=:role, status=:status WHERE user_id=:user_id";
        $stmt = $db->prepare($sql);
        #use bindParam to prevent sql injection
        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();

    } else {
        #pdo insert
        $sql = "INSERT INTO users (first_name, last_name, email, password, role, status) 
                    VALUES (:first_name, :last_name, :email, :password, :role, :status)";
        $stmt = $db->prepare($sql);
        #use bindParam to prevent sql injection
        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':status', $status);
        $stmt->execute();

        #get last inserted id
        $user_id = $db->lastInsertId();
    }


    #redirect
    header("Location: users.php?id=".$user_id."&saved=yes");
}

if(isset($_GET['id']) && $_GET['id']>0){
    $user_id = $_GET['id'];
    $query = $db->prepare("SELECT * FROM `users` WHERE user_id=:user_id");
    $query->bindParam(":user_id", $user_id, PDO::PARAM_INT);
    $query->execute();
    $user = $query->fetch(PDO::FETCH_ASSOC);
}

?>
<!doctype html>
<html lang="en" data-bs-theme="auto">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Home</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        .b-example-divider {
            width: 100%;
            height: 3rem;
            background-color: rgba(0, 0, 0, .1);
            border: solid rgba(0, 0, 0, .15);
            border-width: 1px 0;
            box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
        }

        .b-example-vr {
            flex-shrink: 0;
            width: 1.5rem;
            height: 100vh;
        }

        .bi {
            vertical-align: -.125em;
            fill: currentColor;
        }

        .nav-scroller {
            position: relative;
            z-index: 2;
            height: 2.75rem;
            overflow-y: hidden;
        }

        .nav-scroller .nav {
            display: flex;
            flex-wrap: nowrap;
            padding-bottom: 1rem;
            margin-top: -1px;
            overflow-x: auto;
            text-align: center;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
        }

        .btn-bd-primary {
            --bd-violet-bg: #712cf9;
            --bd-violet-rgb: 112.520718, 44.062154, 249.437846;

            --bs-btn-font-weight: 600;
            --bs-btn-color: var(--bs-white);
            --bs-btn-bg: var(--bd-violet-bg);
            --bs-btn-border-color: var(--bd-violet-bg);
            --bs-btn-hover-color: var(--bs-white);
            --bs-btn-hover-bg: #6528e0;
            --bs-btn-hover-border-color: #6528e0;
            --bs-btn-focus-shadow-rgb: var(--bd-violet-rgb);
            --bs-btn-active-color: var(--bs-btn-hover-color);
            --bs-btn-active-bg: #5a23c8;
            --bs-btn-active-border-color: #5a23c8;
        }

        .bd-mode-toggle {
            z-index: 1500;
        }

        .bd-mode-toggle .dropdown-menu .active .bi {
            display: block !important;
        }
    </style>


    <!-- Custom styles for this template -->
    <link href="sidebars.css" rel="stylesheet">
</head>

<body>

<main class="d-flex flex-nowrap w-100">

    <div class="d-flex flex-column flex-shrink-0 p-3 text-bg-dark" style="width: 280px;">
        <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none"><span class="fs-4">Company</span></a>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                <a href="/" class="nav-link text-white">Home</a>
            </li>
            <li>
                <a href="/orders.php" class="nav-link text-white">Orders</a>
            </li>
            <li>
                <a href="/e-mails.php" class="nav-link text-white">E-mails</a>
            </li>
            <li>
                <a href="/users.php" class="nav-link active" aria-current="page">Users</a>
            </li>
        </ul>
        <hr>
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
               data-bs-toggle="dropdown" aria-expanded="false">
                <strong><?=$u["first_name"]?></strong>
            </a>
            <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                <li><a class="dropdown-item" href="/order.php">New order...</a></li>
                <li><a class="dropdown-item" href="/profile.php">Profile</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="/logout.php">Sign out</a></li>
            </ul>
        </div>
    </div>


    <div class="d-flex flex-column" style="width:calc(100% - 200px)">
        <div class="container-fluid">
            <div class="row">

                <div class="col-3 col-md-3">
                    <form action="" method="post">

                        <div class="row">
                            <h1><?=$_GET['id']>0 ? "Edit" : "Add New" ?> User</h1>
                            <div class="col-md-6">
                                <label for="first-name" class="form-label">First Name</label>
                                <input type="text" class="form-control" value="<?=null!==$user ? $user['first_name'] : ''?>" name="first-name" id="customer-name" placeholder=""
                                       required>
                                <small class="text-body-secondary">First Name</small>
                                <div class="invalid-feedback">
                                    First Name is required.
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="last-name" class="form-label">Last Name</label>
                                <input type="text" class="form-control" value="<?=null!==$user ? $user['last_name'] : ''?>" name="last-name" id="product-code" placeholder=""
                                       required>
                                <small class="text-body-secondary">Last Name</small>
                                <div class="invalid-feedback">
                                    Last Name is required
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">E-mail</label>
                                <input type="email" class="form-control" value="<?=null!==$user ? $user['email'] : ''?>" name="email" id="email" placeholder=""
                                       required>
                                <small class="text-body-secondary">E-mail</small>
                                <div class="invalid-feedback">
                                    E-mail is required.
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="password" class="form-label">Password</label>
                                <input type="text" class="form-control" name="password" value="<?=null!==$user ? $user['password'] : ''?>" id="password" placeholder=""
                                       required>
                                <small class="text-body-secondary">Password</small>
                                <div class="invalid-feedback">
                                    Password is required
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="role" class="form-label">User Role</label>
                                <select name="role" id="role" class="form-control" required>
                                    <option value=""></option>
                                    <option value="admin" <?php if(null!==$user && $user['role']=="admin"){ echo "selected"; } ?> >Admin</option>
                                    <option value="sales" <?php if(null!==$user && $user['role']=="sales"){ echo "selected"; } ?> >Sales</option>
                                    <option value="logistic" <?php if(null!==$user && $user['role']=="logistic"){ echo "selected"; } ?> >Logistic</option>
                                </select>
                                <small class="text-body-secondary">User Role</small>
                                <div class="invalid-feedback">
                                    User role is required.
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="status" class="form-label">Status</label>
                                <select name="status" id="status" class="form-control" required>
                                    <option value="1" <?php if(null!==$user && $user['status']==1){ echo "selected"; } ?>>Active</option>
                                    <option value="0" <?php if(null!==$user && $user['status']==0){ echo "selected"; } ?> >Passive</option>
                                </select>
                                <small class="text-body-secondary">Status</small>
                                <div class="invalid-feedback">
                                    Status is required.
                                </div>
                            </div>
                            <div class="col-md-12">
                                <hr/>
                                <button type="submit" name="save" class="btn btn-lg btn-success">Save User</button>
                            </div>
                        </div>
                        <input type="hidden" name="user-id" value="<?=null!==$user ? $user['user_id'] : ''?>" />
                    </form>

                </div>

                <div class="col-9 col-md-9">

                    <?php if($_GET['saved']=="yes"){ ?>
                        <div class="row">
                            <div class="col-md-12 mt-3">
                                <div class="alert alert-success" role="alert">
                                    User has been saved successfully.
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                    <h1>All Users <a href="/users.php" class="btn btn-success btn-lg m-2 btn-sm float-end">Create New User</a></h1>
                    <table class="table w-100">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Fullname</th>
                            <th>E-mail</th>
                            <th>Role</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $query = $db->prepare("SELECT * FROM `users` WHERE status>=0 ORDER BY first_name ASC, last_name ASC");
                        $query->execute();
                        $users = $query->fetchAll(\PDO::FETCH_ASSOC);
                        foreach ($users as $user) {
                            ?>
                            <tr>
                                <td><?=$user['user_id']?></td>
                                <td><?=$user['first_name'] . " " . $user['last_name']?></td>
                                <td><?=$user['email']?></td>
                                <td><?=$user['role']?></td>
                                <td>
                                    <a href="/users.php?id=<?=$user['user_id']?>&action=edit" class="btn btn-sm btn-info">Edit</a>
                                    <a href="/users.php?id=<?=$user['user_id']?>&action=delete" class="btn btn-sm btn-danger">Delete</a>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</main>

<script src="js/bootstrap.bundle.min.js"></script>

<script src="sidebars.js"></script>
</body>
</html>
