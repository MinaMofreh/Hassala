<?php
session_start();
include_once 'includes.html';
include_once realpath(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'initialize.inc.php');
$ERROR = FALSE;
if (isset($_SESSION['instructor'])) {
    $instructor = new Instructor();
    if (isset($_POST['submit_course'])) {
        $course = new Course();
        $Vldtr = new Validator();
        $courseName = $_POST['course_name'];
        $description = $_POST['description'];
        $title = explode(',', $_POST['material_title']);
        $url = explode(',', $_POST['material_url']);
        if (count($url) == count($title)) {
            for ($i = 0; $i < count($title); $i++) {
                $material = new Material();
                $material->title = $title[$i];
                $material->path = $url[$i];
                $course->materials[] = $material;
            }

            $course->description = $description;
            $course->name = $courseName;
            $instructor->CreateCourse($course, $_SESSION['instructor_id']);
        } else {
            $ERROR = TRUE;
        }
    }
    if (isset($_POST['delete_course'])) {
        $instructor->DropCourse($_POST['Drop'], $instructor->id);
    }

    if (isset($_POST['submit_edit'])) {
        $url = explode(',', $_POST['material_urls']);
        $title = explode(',', $_POST['material_titles']);
        if (count($url) == count($title)) {

            $crs_id = $_POST['crs_id'];
            $instructor->EditCourse($url, $title, $crs_id);
        } else {

            $ERROR = TRUE;
        }
    }
    ?>
    <!DOCTYPE html>

    <html>
        <head>
            <title>Courses</title>
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <!-- Latest compiled and minified CSS -->
            <script src="<?php echo $js; ?>add_course_inst_js/drop.js"></script>
        </head>
        <body>
            <div class = "container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Course Name</th>
                            <th>Description</th>
                            <th>Material</th>
                            <th>Edit</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $COURSES = new Course();
                        $COURSES = $instructor->ViewCourses($_SESSION['instructor_id']);
                        for ($i = 0; $i < count($COURSES); $i++) {
                            ?>
                            <tr>
                                <th scope="row"><?php echo $COURSES[$i]["course_name"]; ?></th>
                                <td><?php echo $COURSES[$i]["course_description"]; ?></td>
                                <?php $corsID = $COURSES[$i]->id; ?>
                                <?php
                                $materialss = new Material();
                                $materialss = $COURSES[$i]->materials;
                                if (count($materialss) > 0 || $materialss != NULL) {
                                    ?><td>
                                        <?php
                                        for ($j = 0; $j < count($materialss); $j++) {
                                            echo '<a href = "' . $materialss[$j]->path . '">' . $materialss[$j]->title . '</a><br><br><br>';
                                        }
                                        ?></td>
                                    <td>

                                        <form action= "" method="POST">
                                            <button class="btn btn-primary" type="submit" id ="edit" name ="edit" value = "<?php echo $corsID; ?>">Edit Material</button><br><br>
                                            <input  value = "<?php echo $corsID; ?>" type="hidden" id ="crs_id" name = "crs_id">
                                        </form>

                                    </td><?php } else {
                                        ?>
                                    <td>
                                        <form action= "" method="POST"><button  class="btn btn-primary" type="submit" id ="edit" name ="edit" value = "<?php echo $corsID; ?>">Edit Material</button><br><br>
                                            <input  value = "<?php echo $corsID; ?>" type="hidden" id ="crs_id" name = "crs_id">
                                        </form>
                                    </td>
                                    <?php
                                }
                                ?>
                                <td>                          
                                    <form action= "makeQuiz.php" method="POST">
                                        <input  value = "<?php echo $corsID; ?>" type="hidden" id ="crs_id" name = "crs_id">
                                        <button class="btn btn-primary" type="submit" id ="MakeQuiz" name ="MakeQuiz" value = "<?php echo $corsID; ?>">Create Quiz</button><br><br>
                                    </form>
                                </td>
                            </tr>
                        <?php }
                        ?>

                    </tbody>
                </table>
                <button class="btn btn-primary" id ="add_course">Add Course</button>
                <button class="btn btn-primary" id ="drop_course_button">Drop Course</button>

                <br>
                <br>
                <div>
                    <form action="" method="POST" id="course_form" style="display: none;" >
                        <label for="course_name" class="col-2 col-form-label">Course Name</label>

                        <input class="form-control" type="text" id="course_name" name="course_name" required="True">

                        <label for="Textarea">Course Description</label>

                        <textarea class="form-control" id="Textarea" rows="3" required="True" name ="description" style="resize: none;"></textarea>
                        <label style="color: red">If you wont to add more than one link material you should separate by coma ","</label><br>
                        <label style="color: red">and number of titles must equal number of URLS</label><br>
                        <label for="material_title" class="col-2 col-form-label" >Material Title</label>

                        <input class="form-control" type="text" id="material_title" required="False" name ="material_title">

                        <label for="material_url" class="col-2 col-form-label">Material URL</label>

                        <input class="form-control" type="url" id="material_url" required="False" name="material_url">
                        <br>
                        <button class="btn btn-primary" type="submit" name="submit_course">Submit</button>
                    </form>

                    <form action="" method="POST" id="form" style ="display: none;">
                        <select class="form-control" name="Drop" style ="width:250px;" >
                            <?php
                            for ($j = 0; $j < count($COURSES); $j++) {
                                echo '<option value="' . $COURSES[$j]->name . '">' . $COURSES[$j]->name . '</option>';
                            }
                            ?>

                        </select>
                        <br>
                        <button class="btn btn-primary" type="submit" name="delete_course">Delete</button>
                    </form>
                    <?php
                    if (isset($_POST['edit'])) {
                        $course_id = $_POST['crs_id'];
                        ?>
                        <form method="POST" id = "edit_form" name="edit_form" action="">
                            <label style="color: red">If you wont to add more than one link material you should separate by coma ","</label><br>
                            <label style="color: red">and number of titles must equal number of URLS</label><br>

                            <label for="material_title" class="col-2 col-form-label" >Material Title</label>

                            <input class="form-control" type="text" id="material_title" required="False" name ="material_titles">

                            <label for="material_url" class="col-2 col-form-label">Material URL</label>

                            <input class="form-control" type="url" id="material_url" required="False" name="material_urls">
                            <br>
                            <button class="btn btn-primary" type="submit" name="submit_edit">Submit</button>
                            <input type="hidden" id="coruse_id" name = "crs_id" value="<?php echo $course_id; ?>">

                        </form>
                    <?php }
                    ?>
                    <?php if ($ERROR == TRUE) { ?>
                        <div class="alert alert-success" role="alert"><strong>Numbers of titles not equal number of urls</strong></div>
                        <?php
                        $ERROR = FALSE;
                    }
                    ?>
                </div>  
        </body>
    </html>
    <?php
} else {
    header('Location: home.php');
}
?>