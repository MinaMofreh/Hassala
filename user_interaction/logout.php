<?php
session_start();
include_once '../classes/Admin.php';
    $Admin =new Admin();
    $Admin->logout();
?>