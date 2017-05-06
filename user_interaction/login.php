
<?php
include_once realpath(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'initialize.inc.php');
$appUser = new ApplicationUser();
$var = new Validator(); // included in application user which is extended
if(isset($_POST['login'])){
 $userName = $_POST['username'];
 $password = $var->hashData($_POST['password']);

 if($appUser->login($userName, $password)){
     echo 'login successs';
 }else{
     echo 'fail';
 }

 if(strlen($userName) < 5 || empty($userName)){ ?>
   <style>
  .alert{width:500px;margin: 10px auto; margin-top: 50px; position: absolute; margin-left: 400px; z-index: 99; color:red;}
 </style>
  <div class="alert alert-danger alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
  <strong>Login Fail!</strong> Check username must be more than 5 charcaters.
</div>
<?php } ?>
<?php
 if(strlen($password) < 5 || empty($password)){ ?>
   <style>
  .alert{width:500px;margin: 10px auto; margin-top:50px; position: absolute; margin-left: 400px; z-index: 999; color:red;}
 </style>
  <div class="alert alert-danger alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
  <strong>Login Fail!</strong> Check <strong>password</strong> must be more than 5 charcaters.
</div>

<?php } ?>
<?php

   
}
//check data and redirect
?>