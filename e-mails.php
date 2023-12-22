<?php

include "config.php";
include "access.php";

if (isset($_POST['save'])) {
    $name = $_POST['name'];
    $content = $_POST['content'];
    $status = $_POST['status'];

    $email_id = $_POST['email-id'];

    if ($email_id > 0) {
        #pdo update
        $sql = "UPDATE emails SET name=:name, content=:content status=:status WHERE email_id=:email_id";
        $stmt = $db->prepare($sql);
        #use bindParam to prevent sql injection
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':email_id', $email_id);
        $stmt->execute();

    } else {
        #pdo insert
        $sql = "INSERT INTO emails (name, content, status) VALUES (:name, :content, :status)";
        $stmt = $db->prepare($sql);
        #use bindParam to prevent sql injection
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':status', $status);
        $stmt->execute();

        #get last inserted id
        $email_id = $db->lastInsertId();
    }


    #redirect
    header("Location: e-mails.php?id=" . $email_id . "&saved=yes");
}

if (isset($_GET['id']) && $_GET['id'] > 0) {
    $email_id = $_GET['id'];
    $query = $db->prepare("SELECT * FROM `emails` WHERE email_id=:email_id");
    $query->bindParam(":email_id", $email_id, PDO::PARAM_INT);
    $query->execute();
    $email = $query->fetch(PDO::FETCH_ASSOC);
}

?>
<!doctype html>
<html lang="en" data-bs-theme="light">

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
            <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none"><span
                    class="fs-4">Company</span></a>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="/" class="nav-link text-white">Home</a>
                </li>
                <li>
                    <a href="/orders.php" class="nav-link text-white">Orders</a>
                </li>
                <li>
                    <a href="/e-mails.php" class="nav-link active" aria-current="page">E-mails</a>
                </li>
                <li>
                    <a href="/users.php" class="nav-link text-white">Users</a>
                </li>
            </ul>
            <hr>
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <strong>
                        <?= $u["first_name"] ?>
                    </strong>
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
                                <h1>Add - Edit E-mail</h1>
                                <div class="col-md-12">
                                    <label for="name" class="form-label">E-mail Title</label>
                                    <input type="text" class="form-control"
                                        value="<?= null !== $email ? $email['name'] : '' ?>" name="name" id="name"
                                        placeholder="" required>
                                    <small class="text-body-secondary">Name</small>
                                    <div class="invalid-feedback">
                                        E-mail title is required.
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="content" class="form-label">Content</label>
                                    <textarea class="form-control" name="content" id="content"
                                        required><?= null !== $email ? $email['content'] : '' ?></textarea>
                                    <small class="text-body-secondary">Content</small>
                                    <div class="invalid-feedback">
                                        Content is required.
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="status" class="form-label">Status</label>
                                    <select name="status" id="status" class="form-control" required>
                                        <option value="1" <?php if (null !== $email && $email['status'] == 1) {
                                            echo "selected";
                                        } ?>>Active</option>
                                        <option value="0" <?php if (null !== $email && $email['status'] == 0) {
                                            echo "selected";
                                        } ?>>Passive</option>
                                    </select>
                                    <small class="text-body-secondary">Status</small>
                                    <div class="invalid-feedback">
                                        Status is required.
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <hr />
                                    <button type="submit" name="save" class="btn btn-lg btn-success">Save
                                        E-mail</button>
                                </div>
                            </div>
                            <input type="hidden" name="email-id"
                                value="<?= null !== $email ? $email['email_id'] : '' ?>" />
                        </form>

                    </div>

                    <div class="col-9 col-md-9">

                        <?php if ($_GET['saved'] == "yes") { ?>
                            <div class="row">
                                <div class="col-md-12 mt-3">
                                    <div class="alert alert-success" role="alert">
                                        E-mail has been saved successfully.
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                        <h1>All Users</h1>
                        <table class="table w-100">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = $db->prepare("SELECT * FROM `emails` WHERE status>=0 ORDER BY name ASC");
                                $query->execute();
                                $emails = $query->fetchAll(\PDO::FETCH_ASSOC);
                                foreach ($emails as $email) {
                                    ?>
                                    <tr>
                                        <td>
                                            <?= $email['email_id'] ?>
                                        </td>
                                        <td>
                                            <?= $email['name'] ?>
                                        </td>
                                        <td>
                                            <a href="/e-mails.php?id=<?= $email['email_id'] ?>&action=edit"
                                                class="btn btn-sm btn-info">Edit</a>
                                            <a href="/e-mails.php?id=<?= $email['email_id'] ?>&action=delete"
                                                class="btn btn-sm btn-danger">Delete</a>
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