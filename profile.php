<?php

include "config.php"; include  "access.php";

if(isset($_POST['save'])){
    $first_name = $_POST['first-name'];
    $last_name = $_POST['last-name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user_id = $u['user_id'];

        #pdo update
        $sql = "UPDATE users SET first_name=:first_name, last_name=:last_name, email=:email, password=:password WHERE user_id=:user_id";
        $stmt = $db->prepare($sql);
        #use bindParam to prevent sql injection
        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();

        $_SESSION["user"]["first_name"] = $first_name;
        $_SESSION["user"]["last_name"] = $last_name;
        $_SESSION["user"]["email"] = $email;
        $_SESSION["user"]["password"] = $password;
        $u = $_SESSION["user"];

    #redirect
    header("Location: profile.php?saved=yes");
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
        <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none"><span class="fs-4">Arpon</span></a>
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
                <div class="col-6 col-md-6">

                    <?php if($_GET['saved']=="yes"){ ?>
                        <div class="row">
                            <div class="col-md-12 mt-3">
                                <div class="alert alert-success" role="alert">
                                    User has been saved successfully.
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                    <form action="" method="post">

                        <div class="row">
                            <h1>My Profile</h1>
                            <div class="col-md-6">
                                <label for="first-name" class="form-label">First Name</label>
                                <input type="text" class="form-control" value="<?=$u['first_name']?>" name="first-name" id="customer-name" placeholder=""
                                       required>
                                <small class="text-body-secondary">First Name</small>
                                <div class="invalid-feedback">
                                    First Name is required.
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="last-name" class="form-label">Last Name</label>
                                <input type="text" class="form-control" value="<?=$u['last_name']?>" name="last-name" id="product-code" placeholder=""
                                       required>
                                <small class="text-body-secondary">Last Name</small>
                                <div class="invalid-feedback">
                                    Last Name is required
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label for="email" class="form-label">E-mail</label>
                                <input type="text" class="form-control" value="<?=$u['email']?>" name="email" id="email" placeholder=""
                                       required>
                                <small class="text-body-secondary">E-mail</small>
                                <div class="invalid-feedback">
                                    E-mail is required.
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label for="password" class="form-label">Password</label>
                                <input type="text" class="form-control" name="password" value="<?=$u['password']?>" id="password" placeholder=""
                                       required>
                                <small class="text-body-secondary">Password</small>
                                <div class="invalid-feedback">
                                    Password is required
                                </div>
                            </div>

                            <div class="col-md-12">
                                <hr/>
                                <button type="submit" name="save" class="btn btn-lg btn-success">Update</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

</main>

<script src="js/bootstrap.bundle.min.js"></script>

<script src="sidebars.js"></script>
</body>
</html>
