<?php
if($u['user_id']<1 || $u['user_id']==null){
    header("Location: /login.php");
    exit();
}