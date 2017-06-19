<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- for internet explorer compatibality-->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!--first mobile meta-->
        <!--[if lt IE 9]>
         <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
         <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
       <![endif]-->  
        <link rel="stylesheet" type="text/css" href="../css/mina_css/body&footer.css">

        <link rel="stylesheet" type="text/css" href="../css/mina_css/studentNavbar.css">
    </head>
    <body>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#" style="margin-top: -10px; margin-right: 380px;"><img src="../images/mina_images/logo.png" alt="Hassala"></a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav" style="padding-left: 20px;">
                        <li style="padding-left: 20px;"><a href="../home.php">Home</a></li>
                        <li style="padding-left: 20px;"><a href=" <?php
                            if (isset($_SESSION['student'])) {
                                echo '../student courses.php';
                            } else
                                echo '../add_course_inst.php';
                            ?>
                                                           ">Courses</a></li>
                        <li style="padding-left: 20px;"><a href="../problemset.php">Problemset</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $_SESSION['instructor_fname']; ?><span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="<?php
                                    if (isset($_SESSION['student'])) {
                                        echo '../student_profile.php';
                                    } else
                                        echo '../instructor_profile.php';
                                    ?>   ">My Profile</a></li>
                                <li><a href="#">Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>
