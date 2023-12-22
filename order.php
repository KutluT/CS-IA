<?php

include "config.php";

if (isset($_POST['save'])) {
    $customer_name = $_POST['customer-name'];
    $product_code = $_POST['product-code'];
    $product_description = $_POST['product-description'];
    $order_number = $_POST['order-number'];
    $order_date = $_POST['order-date'];
    $delivery_date = $_POST['delivery-date'];
    $status = $_POST['status'];

    $file_name = date("Ymd-His") . "-" . $_FILES['document']['name']; // 20231201-155542-file-name.jpg
    $file_size = $_FILES['document']['size']; // 2048*1024 byte.
    $file_tmp = $_FILES['document']['tmp_name']; // /tmp/adskgjbhgsdkghjwekghusdıgh.tmp
    $file_type = $_FILES['document']['type']; // .jpg

    if ($file_size > 0) {
        move_uploaded_file($file_tmp, "uploads/" . $file_name); // /tmp/adskgjbhgsdkghjwekghusdıgh.tmp => uploads/20210901-123456-file.jpg
        $document = "uploads/" . $file_name;
        $document_selector = ":document";
    } else {
        $document_selector = "document";
    }

    $order_id = $_POST['order-id'];

    if ($order_id > 0) {
        $sql = "UPDATE orders SET customer_name=:customer_name, product_code=:product_code, 
                  product_description=:product_description, order_number=:order_number, 
                  order_date=:order_date, delivery_date=:delivery_date, document=$document_selector, 
                  status=:status, user_id=:user_id 
              WHERE order_id=:order_id";



        $stmt = $db->prepare($sql);
        $stmt->bindParam(':customer_name', $customer_name);
        $stmt->bindParam(':product_code', $product_code);
        $stmt->bindParam(':product_description', $product_description);
        $stmt->bindParam(':order_number', $order_number);
        $stmt->bindParam(':order_date', $order_date);
        $stmt->bindParam(':delivery_date', $delivery_date);
        if ($file_size > 0) {
            $stmt->bindParam(':document', $document);
        }
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':user_id', $u['user_id']);
        $stmt->bindParam(':order_id', $order_id);
        $stmt->execute();
    } else {
        $sql = "INSERT INTO orders 
        (customer_name, product_code, product_description, order_number, order_date, delivery_date, document, user_id) 
        VALUES (:customer_name, :product_code, :product_description, :order_number, :order_date, :delivery_date, :document, :user_id)";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':customer_name', $customer_name);
        $stmt->bindParam(':product_code', $product_code);
        $stmt->bindParam(':product_description', $product_description);
        $stmt->bindParam(':order_number', $order_number);
        $stmt->bindParam(':order_date', $order_date);
        $stmt->bindParam(':delivery_date', $delivery_date);
        $stmt->bindParam(':document', $document);
        $stmt->bindParam(':user_id', $u['user_id']);
        $stmt->execute();

        $order_id = $db->lastInsertId();
    }


    header("Location: order.php?id=" . $order_id . "&saved=yes");
}

if (isset($_GET['id']) && $_GET['id'] > 0) {
    $order_id = $_GET['id'];
    $sql = "SELECT * FROM orders WHERE order_id=:order_id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':order_id', $order_id);
    $stmt->execute();
    $order = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    $order = null;
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

<main class="d-flex flex-nowrap">

    <div class="d-flex flex-column flex-shrink-0 p-3 text-bg-dark" style="width: 280px;">
        <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none"><span
                    class="fs-4">Company</span></a>
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
                <strong><?= $u["first_name"] ?></strong>
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

    <div class="d-flex flex-column">

        <div class="container-fluid">

            <?php if($_GET['saved']=="yes"){ ?>
            <div class="row">
                <div class="col-md-12 mt-3">
                    <div class="alert alert-success" role="alert">
                        Order has been saved successfully.
                    </div>
                </div>
            </div>
            <?php } ?>

            <form action="" method="post" enctype="multipart/form-data">

                <div class="row">
                    <h1><?=$_GET['id']>0 ? "Edit" : "Add New" ?> Order</h1>
                    <div class="col-md-12">
                        <label for="customer-name" class="form-label">Customer Name</label>
                        <input type="text" class="form-control"
                               value="<?= null !== $order ? $order['customer_name'] : '' ?>" name="customer-name"
                               id="customer-name" placeholder=""
                               required>
                        <small class="text-body-secondary">Customer Name</small>
                        <div class="invalid-feedback">
                            Customer Name is required.
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label for="product-code" class="form-label">Product Code</label>
                        <input type="text" class="form-control"
                               value="<?= null !== $order ? $order['product_code'] : '' ?>" name="product-code"
                               id="product-code" placeholder=""
                               required>
                        <small class="text-body-secondary">Product Code</small>
                        <div class="invalid-feedback">
                            Product Code is required
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label for="product-description" class="form-label">Product Description</label>
                        <input type="text" class="form-control"
                               value="<?= null !== $order ? $order['product_description'] : '' ?>"
                               name="product-description" id="product-description"
                               placeholder="" required>
                        <small class="text-body-secondary">Product Description</small>
                        <div class="invalid-feedback">
                            Product Description is required.
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="order-date" class="form-label">Order Date</label>
                        <input type="date" class="form-control" name="order-date"
                               value="<?= null !== $order ? $order['order_date'] : '' ?>" id="order-date" placeholder=""
                               required>
                        <small class="text-body-secondary">Order Date</small>
                        <div class="invalid-feedback">
                            Order Date is required.
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="delivery-date" class="form-label">Delivery Date</label>
                        <input type="date" class="form-control" name="delivery-date"
                               value="<?= null !== $order ? $order['delivery_date'] : '' ?>" id="delivery-date"
                               placeholder=""
                               required>
                        <small class="text-body-secondary">Delivery Date</small>
                        <div class="invalid-feedback">
                            Delivery Date is required.
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="order-number" class="form-label">Order Number</label>
                        <input type="text" class="form-control" name="order-number"
                               value="<?= null !== $order ? $order['order_number'] : '' ?>" id="order-date"
                               placeholder="" required>
                        <small class="text-body-secondary">Order Number</small>
                        <div class="invalid-feedback">
                            Order Number is required.
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-control" required>
                            <option value="1" <?php
                            if (null !== $order && $order['status'] == 1) {
                                echo "selected";
                            } ?> >Waiting
                            </option>
                            <option value="2" <?php
                            if (null !== $order && $order['status'] == 2) {
                                echo "selected";
                            } ?> >Approved
                            </option>
                            <option value="3" <?php
                            if (null !== $order && $order['status'] == 3) {
                                echo "selected";
                            } ?> >Completed
                            </option>
                        </select>
                        <small class="text-body-secondary">Status</small>
                        <div class="invalid-feedback">
                            Status is required.
                        </div>
                    </div>

                    <?php if($order['status']>=2){ ?>
                    <div class="col-md-12">
                        <hr/>
                        <label for="delivery-date" class="form-label">Customer Confirmation Document</label><br/>
                        <input type="file" name="document"/>
                    </div>
                    <?php } ?>

                    <div class="col-md-12">
                        <hr/>
                        <button type="submit" name="save" class="btn btn-lg btn-success">Save Order</button>
                    </div>
                </div>
                <input type="hidden" name="order-id" value="<?= null !== $order ? $order['order_id'] : '' ?>"/>
            </form>
        </div>
    </div>

</main>

<script src="js/bootstrap.bundle.min.js"></script>

<script src="sidebars.js"></script>
</body>
</html>
