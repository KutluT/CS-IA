<?php
ob_start();
session_start();
error_reporting(0);

include "connection.php";
include "functions.php";

$u = $_SESSION['user'] ?? null;
?>
