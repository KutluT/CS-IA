<?php
try {
    $db = new PDO('mysql:host=localhost;dbname=cs_ia;charset=utf8mb4', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
} catch (Exception $e) {
    echo $e->getMessage();
}
?>
