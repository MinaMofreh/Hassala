<?php
session_start();
include_once dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'includes.html';
include_once dirname(dirname(dirname(__FILE__))).DIRECTORY_SEPARATOR.'initialize.inc.php';
$admin = new Admin();
$result = $admin->GenerateStatistics();
include_once '../includes/instructornav.inc.php';
include_once '../includes/body&footer.php';
?>