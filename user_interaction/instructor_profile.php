<?php
session_start();
if (isset($_SESSION['instructor'])){
include_once 'includes.html';
include_once realpath(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'initialize.inc.php');
$instructor = new Instructor();
$instructor->set_firstName($_SESSION['instructor_fname']);
$instructor->set_email($_SESSION['email']);
$instructor->set_username($_SESSION['username']);

$instructor_first_name = $instructor->get_fullName();
$instructor_email = $instructor->get_email();
$instructor_username = $instructor->get_username();

?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- for internet explorer compatibality-->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!--first mobile meta-->
        <title>Instructor Profile</title>
        <!--[if lt IE 9]>
     <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
     <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
   <![endif]-->


        <!-- bootstrap -->
        <link rel="stylesheet" type="text/css" href="<?php echo $css; ?>eyad_css/instructor_profile_styleSheet.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Josefin+Sans">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Gentium+Basic|Josefin+Sans">


    </head>
    <body>
        <!-- start instructor profile page -->
        <br>
        <div class="container profileContainer">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12 lead"><h1 style="padding-left: 70px;">Instructor Profile</h1><hr></div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 text-center">
                                    <img class="profilePhoto" style="display:block; margin:auto;" src="<?php echo $_SESSION['profile_photo'] ?>png" alt="profile photo">
                                </div>
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h2 class="only-bottom-margin"><?php echo $instructor_first_name; ?></h2><br>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 information">
                                            <h3 style="color: #337ab7; font-weight: bold;">Basic Information</h3>
                                            <span class="text-muted">Email:</span> <?php echo $instructor_email; ?><br>
                                            <span class="text-muted">Username:</span> <?php echo $instructor_username; ?><br>
                                            <h3 style="color: #337ab7; font-weight: bold;">Education</h3>
                                            <span class="text-muted">University:</span> Helwan<br>         

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <hr>
                                    <a href="edit_instructor_profile.php"><button class="btn btn-default pull-right"><i class="glyphicon glyphicon-pencil"></i> Edit Profile</button></a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>


    </body>
</html>
<?php } else {
    header ("Location: home.php");
}
?>