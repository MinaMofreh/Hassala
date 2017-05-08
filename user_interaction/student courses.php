<?php
include_once 'includes.html';
include_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'initialize.inc.php';
session_start();
if (isset($_SESSION['student'])) {
    $student = new Student();
    if (isset($_POST['Add'])) {
        $course_data = explode(":", $_POST['taskOption']);
        $course_id = $course_data[0];
        $student->PartcipateCourse($course_id, $_SESSION['student_id']);
    }
    $student->set_firstName($_SESSION['first_name']);
    $student->set_lastName($_SESSION['last_name']);
    $student->set_email($_SESSION['email']);
    $student->set_gender($_SESSION['gender']);
    $student->set_username($_SESSION['username']);
    $student->set_codeForces_handle($_SESSION['codeforces_handle']);
    $student->set_univeristy($_SESSION['university']);
    $student->set_college_id($_SESSION['college_id']);
    $student->set_rate($_SESSION['rate']);
    $courses = new Course();
    $courses = $student->ViewCourse($_SESSION['student_id']);
    $dates = array();
    for ($ctr = 0; $ctr < count($courses); $ctr++) {
        for ($ctr2 = 0; $ctr2 < count($courses[$ctr]->quizes); $ctr2++) {
            $data2 = array(
                "quiz_id" => $courses[$ctr]->quizes[$ctr2]->id,
                "quiz_date" => $courses[$ctr]->quizes[$ctr2]->date,
                "quiz_time" => $courses[$ctr]->quizes[$ctr2]->time,
                "quiz_duration" => $courses[$ctr]->quizes[$ctr2]->duration,
                "quiz_type" => $courses[$ctr]->quizes[$ctr2]->type
            );
            if ($student->IsPermitted($student->get_college_id(), $courses[$ctr]->quizes[$ctr2]->id) && !$student->IsQuized($_SESSION['student_id'], $courses[$ctr]->quizes[$ctr2]->id)) {
                $dates[] = $data2;
            }
        }
    }
    if (isset($_POST['start_quiz'])) {

        header('Location : do_quiz.php');
    }
    ?>




    <!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <!-- for internet explorer compatibality-->
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <!--first mobile meta-->
            <title>student courses</title>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

            <link rel="stylesheet" type="text/css" href="css/eyad_css/student courses_styleSheet.css">

        </head>
        <body onload="updateQuizTime()">
            <div class="container-fluid myContainer">


                <div class="row">
                    <div class="col-md-12">
                        <h1>Your current courses:</h1><br><br>

                        <!-- Start of the courses table-->
                        <table class="table table-striped">
                            <thead class="headTable">
                                <tr>
                                    <th>Course Name</th>
                                    <th>Materials</th>
                                    <th>Describtion</th>
                                    <th>Quizs</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                for ($i = 0; $i < count($courses); $i++) {
                                    ?>
                                    <tr>
                                        <td><?php echo $courses[$i]->name; ?></td>
                                        <td><?php
                                            for ($j = 0; $j < count($courses[$i]->materials); $j++) {
                                                echo '<a href = "' . $courses[$i]->materials[$j]->path . '">' . $courses[$i]->materials[$j]->title . '</a><br><br>';
                                                ;
                                            }
                                            ?></td>
                                        <td><?php echo $courses[$i]->description; ?></td><td>
                                            <?php
                                            for ($m = 0; $m < count($courses[$i]->quizes); $m++) {
                                                ?><form method="POST" action="do_quiz.php"><button disabled="disabled" class="btn btn-primary" type="submit" id ="start_quiz_<?php echo $courses[$i]->quizes[$m]->id; ?>" name ="start_quiz" value = "">Start Quiz</button><br><br>
                                                    <input value="<?php echo $courses[$i]->quizes[$m]->id; ?>" type="hidden" id ="quiz_id" name = "quiz_id"></form><?php }
                                            ?>

                                        </td> </tr><?php } ?>

                            </tbody>
                        </table>
                        <hr> <br><br>
                        <!-- End of the courses table-->
                        <h2 style="color: #2d6a9f;">Add New Course</h2>
                        <br><br><br>
                    </div>
                </div>
                <!-- Start add new course div-->
                <div class="row">
                    <div class="col-md-12">
                        <div class="toBeToggled" style="margin-top: -50px;">
                            <h2>Choose a new course from the above menu:</h2>
                            <br>
                            <span>Course Name:</span> 
                            <br><br>
                            <form method="POST" action="">
                                <select name="taskOption">
                                    <?php
                                    $courseav = $student->AvailableCourses($_SESSION['student_id']);
                                    for ($i = 0; $i < count($courseav); $i++) {
                                        echo '<option id = "' . $courseav[$i]->id . '">' . $courseav[$i]->id. ':' . $courseav[$i]->name . '</option>';
                                    }
                                    ?>  
                                </select>
                                <span style="color: red;"></span>
                                <br><br>
                                <button type="Submit" name="Add" class="btn-primary">
                                    <span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span>
                                    Add Course
                                </button>
                            </form>
                        </div>
                        <!-- End add new course div-->
                    </div>
                </div>
            </div>
        </body>
    </html>
    <script>
        function updateQuizTime() {
            var quiz_data = <?php echo json_encode($dates); ?>;
            setTimeout(function () {
                $.post('ajax/ajax_update_time.php', {
                    quiz_data: quiz_data
                }, function (html2) {
                    var possible = html2.split(/[:]/);
                    var i;
                    for (i = 0; i < possible.length; i++) {
                        $("#start_quiz_" + possible[i]).attr("disabled", false);
                    }
                });
            }, 1000);
        }
    </script><?php
} else {
    header('Location: home.php');
    exit();
}
?>
