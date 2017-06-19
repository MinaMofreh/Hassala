<?php
session_start();
if (isset($_SESSION['student'])) {
    include_once 'includes.html';
    include_once realpath(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'initialize.inc.php');
    /*
      I will assume that there is an open session and it will be passed to me with the student object which has his information,
      now i'll simulate (create studnet object and give it it's values and i will show them in the design).
     */

    $student = new Student();

    $student->set_firstName($_SESSION['first_name']);
    $student->set_lastName($_SESSION['last_name']);
    $student->set_email($_SESSION['email']);
    $student->set_gender($_SESSION['gender']);
    $student->set_username($_SESSION['username']);
    $student->set_codeForces_handle($_SESSION['codeforces_handle']);
    $student->set_univeristy($_SESSION['university']);
    $student->set_college_id(_SESSION['college_id']);
    $student->set_rate(5);
    $student->increment_solvedProblems();
//kol da hytms7 b3d ma nzbot el sessions
    $student_first_name = $student->get_firstName();
    $student_last_name = $student->get_lastName();
    $student_email = $student->get_email();
    $student_gender = $student->get_gender();
    $student_username = $student->get_username();
    $student_codeforces_handle = $student->get_codeForces_handle();
    $student_university = $student->get_univeristy();
    $student_college_id = $student->get_college_id();
    $student_rate = $student->get_rate();
    $student_solved_problems = $student->get_solvedProblems();
    ?>

    <!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <!-- for internet explorer compatibality-->
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <!--first mobile meta-->
            <title><?php echo $student->first_name . ' Profile'; ?></title>

            <!--[if lt IE 9]>
         <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
         <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
       <![endif]-->

            <link rel="stylesheet" type="text/css" href="<?php echo $css; ?>eyad_css/student_profile_styleSheet.css">
            <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Josefin+Sans">
            <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Gentium+Basic|Josefin+Sans">


        </head>
        <body style="overflow-x: hidden;">
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
                                        <img class="profilePhoto" style="display:block; margin:auto;" src="<?php echo $_SESSION['profile_photo'] ?>" alt="profile photo">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h2 class="only-bottom-margin"><?php echo $student->first_name . " " . $student->last_name; ?></h2><br>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 information">
                                                <h3 style="color: #337ab7; font-weight: bold;">Basic Information</h3>
                                                <span class="text-muted">Email:</span> <?php
                                                echo $student->get_email();
                                                ;
                                                ?><br>
                                                <span class="text-muted">Gender:</span> <?php echo $student->get_gender(); ?><br>
                                                <span class="text-muted">Username:</span> <?php echo $student->get_username(); ?><br> <!--htzbot fl session "mafesh error" -->
                                                <span class="text-muted">Codeforces Handle:</span> <?php echo $student->get_codeForces_handle(); ?><br>
                                                <h3 style="color: #337ab7; font-weight: bold;">Education</h3>
                                                <span class="text-muted">University:</span> <?php echo $student->get_univeristy(); ?><br>
                                                <span class="text-muted">College ID:</span> <?php echo $student->get_college_id(); ?> <br>
                                                <span class="text-muted">Rate:</span> <a href="#">#<?php echo $student->get_rate(); ?></a><br>
                                                <span class="text-muted">Solved Problems:</span> <?php echo $student->get_solvedProblems(); ?> <br>
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

            <script type="text/javascript" src="jquery-1.12.4.min.js"></script>

        </body>
    </html>
    <?php
} else {
    header('location: home.php'); //it will be edited to be directed to index.php
}
?>