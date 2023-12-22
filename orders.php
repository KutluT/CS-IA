<?php

include "config.php"; include "access.php";

if($_GET['action']=="delete"){
    $order_id = $_GET['id'];
    $sql = "UPDATE orders SET status=-1 WHERE order_id=:order_id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':order_id', $order_id);
    $stmt->execute();
    header("Location: orders.php?deleted=yes");
    exit();
}

if($_GET['action']=="approve"){
    $order_id = $_GET['id'];
    $sql = "UPDATE orders SET status=2 WHERE order_id=:order_id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':order_id', $order_id);
    $stmt->execute();
    header("Location: orders.php?approved=yes");
    exit();
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
                <a href="/orders.php" class="nav-link active" aria-current="page">Orders</a>
            </li>
            <li>
                <a href="/e-mails.php" class="nav-link text-white">E-mails</a>
            </li>
            <li>
                <a href="/users.php" class="nav-link text-white">Users</a>
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

                <?php if($_GET['deleted']=="yes"){ ?>
                    <div class="row">
                        <div class="col-md-12 mt-3">
                            <div class="alert alert-danger" role="alert">
                                Order has been removed successfully.
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <?php if($_GET['approved']=="yes"){ ?>
                    <div class="row">
                        <div class="col-md-12 mt-3">
                            <div class="alert alert-success" role="alert">
                                Order has been approved successfully.
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <h1>Orders <a href="/order.php" class="btn btn-success btn-lg m-2 btn-sm float-end">Create New Order</a></h1>
                <div class="col-12 col-md-12">
                    <table class="table w-100">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Customer</th>
                            <th>Created</th>
                            <th>Updated</th>
                            <th>Document</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $query = $db->prepare("SELECT * FROM `orders` WHERE status>0 ORDER BY order_id DESC");
                        $query->execute();
                        $orders = $query->fetchAll(\PDO::FETCH_ASSOC);
                        foreach ($orders as $order) {
                        ?>
                        <tr>
                            <td><?=$order['order_id']?></td>
                            <td><?=$order['customer_name']?></td>
                            <td><?=date("d.m.Y H:i:s",strtotime($order['created_at']))?></td>
                            <td><?=date("d.m.Y H:i:s",strtotime($order['updated_at']))?></td>
                            <td>
                                <?php if(null!==$order['document']){
                                    ?>
                                    View Document
                                    <?php
                                } else { ?>
                                    No Document
                                <?php } ?>
                            </td>
                            <td>
                                <?php
                                if($order['status']==1){
                                    echo "Waiting";
                                } else if($order['status']==2){
                                    echo "Approved";
                                }
                                else if($order['status']==3){
                                    echo "Completed";
                                }else {
                                    echo "Cancelled";
                                }
                                ?>
                            </td>
                            <td>
                                <a href="/order.php?id=<?=$order['order_id']?>&action=edit" class="btn btn-sm btn-info">Edit</a>
                                <?php if(($u['role']=="logistic" || $u['role']=="admin") && $order['status']==1){ ?>
                                <a href="/orders.php?id=<?=$order['order_id']?>&action=approve" class="btn btn-sm btn-success">Approve</a>
                                <?php } ?>
                                <a href="/orders.php?id=<?=$order['order_id']?>&action=delete" class="btn btn-sm btn-danger">Delete</a>
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
