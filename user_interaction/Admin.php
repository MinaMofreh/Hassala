<?php
session_start();
if (isset($_SESSION['Admin'])) {
    header('Location: Adminpage.php');
}
include_once 'includes.html';
include_once realpath(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'initialize.inc.php');
$admin = new Admin();
$query = new Admin_Queries();
if (isset($_POST['login'])) {
    $var = True;
    $username = $_POST['username'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $admin->set_adminName($username);
    $admin->set_adminPassword($password);
    if ($admin->login()) {
        ?>
        <style>
            .alert{width:300px;margin: 10px auto;}
        </style>
        <div class="alert alert-success" role="alert">
            <strong>Login Success!</strong><a href="Adminpage.php" class="alert-link">Click Here</a>.
        </div>
        <?php
    } else {
        ?>
        <style>
            .alert{width:300px;margin: 10px auto;}
        </style>
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Sorry</strong> Login Fail !
        </div>
        <?php
    }
}
?>
<!DOCTYPE html>
<html>
    <title>Admin Login</title>
    <head>
        <link rel="stylesheet" href="<?php echo $css ?>fonts/font-awesome.min.css" />
        <link rel="stylesheet" href="<?php echo $css ?>mina_css/login.css" />
        <link rel="stylesheet" href="<?php echo $css ?>mina_css/AddStudent.css" />  
    </head>
    <form class="login" action="Admin.php" method="POST">
        <h2> Admin Login </h2>
        <input class="form-control" type="text" name="username" placeholder="userName..." />
        <input class="form-control" type="password" name="password" placeholder="password..." />
        <input class="btn btn-primary btn-block" type="submit" value="login" name="login"/>
    </form>
</html>
<script src='<?php echo $js?>mina_js/backend.js'></script>
<style>

    .login{
        width: 400px;
        margin : 50px auto;
    }
    .h2{
        color:black;
    }
    .login input{
        margin-bottom: 10px;
    }
    .login .form-control{
        background-color: #EAEAEA;
    }
</style>