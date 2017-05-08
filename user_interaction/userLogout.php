<?php
session_start();
include_once dirname(dirname(__FILE)) . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'ApplicationUser.php';
dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'initialize.inc.php';
 $appUser = new ApplicationUser();
 $appUser->Logout();
 ?>