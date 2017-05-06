<?php
session_start();
include_once 'includes.html';
include_once realpath(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'initialize.inc.php');
/*
  I will assume that there is an open session and it will be passed to me with the student object which has his information,
  now i'll simulate (create studnet object and give it it's values and i will show them in the design).
 */
$student = new Student();
$student->set_firstName("Eyad");
$student->set_lastName("Mohammad");
$student->set_email("email@test.com");
$student->set_gender("male");
$student->set_username("EyadMShokry");
$student->set_codeForces_handle("eyad_muhammad");
$student->set_univeristy("Helwan");
$student->set_college_id("20150156");
$student->set_rate(5);
$student->increment_solvedProblems();
$student_first_name =  $student->get_firstName();
$student_last_name = $student->get_lastName();
$student_email = $student->get_email();
$student_gender = $student->get_gender();
$student_username = $student->get_username();
$student_codeforces_handle = $student->get_codeForces_handle();
$student_university = $student->get_univeristy();
$student_college_id = $student->get_college_id();
$student_rate = $student->get_rate();
$student_solved_problems = $student->get_solvedProblems();


$problmes_count = $student->get_solvedProblems();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- for internet explorer compatibality-->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!--first mobile meta-->
        <title>Student Profile</title>

        <!--[if lt IE 9]>
     <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
     <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
   <![endif]-->

        <link rel="stylesheet" type="text/css" href="<?php echo $css;?>eyad_css/student_profile_styleSheet.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Josefin+Sans">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Gentium+Basic|Josefin+Sans">


    </head>
    <body>
        <!-- start student profile page -->
        <div class="container profileContainer">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12 lead"><h1 style="padding-left: 70px;">Student Profile</h1><hr></div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 text-center">
                                    <img class="profilePhoto" style="display:block; margin:auto;" src="images/eyad_images/eyad.jpg" alt="profile photo">
                                </div>
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h2 class="only-bottom-margin"><?php echo $student_first_name . " " . $student_last_name; ?></h2><br>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 information">
                                            <h3 style="color: #337ab7; font-weight: bold;">Basic Information</h3>
                                            <span class="text-muted">Email:</span> <?php echo $student_email; ?><br>
                                            <span class="text-muted">Gender:</span> <?php echo $student_gender; ?><br>
                                            <span class="text-muted">Username:</span> <?php echo $student_username; ?><br>
                                            <span class="text-muted">Codeforces Handle:</span> <?php echo $student_codeforces_handle; ?><br>
                                            <h3 style="color: #337ab7; font-weight: bold;">Education</h3>
                                            <span class="text-muted">University:</span> <?php echo $student_university; ?><br>
                                            <span class="text-muted">College ID:</span> <?php echo $student_college_id; ?> <br>
                                            <span class="text-muted">Rate:</span> <a href="#"><?php echo '#' . $student_rate; ?></a><br>
                                            <span class="text-muted">Solved Problems:</span> <?php echo $student_solved_problems; ?> <br>
                                        </div>
                                        <div class="col-md-6 solved_problems_table" style="margin-top: -70px;">
                                            <table class="table">
                                                <thead class="thead-inverse">
                                                    <tr>
                                                        <th>Problems Count</th>
                                                        <th>Online Judge</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    for ($i = 0; $i < $problmes_count; $i++) {
                                                        echo '<tr>
                              <td>' . '#' . ($i + 1) . '</td>
                              <td><a href="#">codeforces problem link</a></td>
                              </tr>';
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <hr>
                                    <a href="edit_student_profile.php"><button class="btn btn-default pull-right"><i class="glyphicon glyphicon-pencil"></i> Edit Profile</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
<?php 
include_once 'templates'.DIRECTORY_SEPARATOR.'footer'.DIRECTORY_SEPARATOR.'footer.inc.php';
?>