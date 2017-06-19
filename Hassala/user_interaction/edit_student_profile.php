<?php
session_start();
if (isset($_SESSION['student'])) {
    include_once 'includes.html';
    include_once realpath(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'initialize.inc.php');

    $validate = new Validator();
    $student = new Student();

    $student->set_username($_SESSION['username']);
//$student->set_profilePic($file_extn, $file_temp);
    $invaled_username_error = $password_not_matches_error = $password_length_error = $password_form_error = $username_length_error = "";

    $validate_error_counter = 0;


    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (empty($_POST['username']) && empty($_POST['password']) && empty($_POST['confirm_password']) && empty($_POST['profile_photo'])) {
            header('location:student_profile.php');
        } else if ((is_numeric($_POST['username']) || !$validate->alphaNumeric($_POST['username'])) && !empty($_POST['username'])) {
            $invaled_username_error = "Username must include only letters and numbers";
            $validate_error_counter++;
        } else if (strlen($_POST['username']) < 5 && !empty($_POST['username'])) {
            $username_length_error = "Username must be more than 5 characters";
            $validate_error_counter++;
        } else if ($_POST['password'] != $_POST['confirm_password']) {
            $password_not_matches_error = "password don't match!";
            $validate_error_counter++;
        } else if ((strlen($_POST['password']) < 5) && !empty($_POST['password'])) {
            $password_length_error = "Password must be more than 5 characters";
            $validate_error_counter++;
        } else if (!$validate->alphaNumeric($_POST['password']) && !empty($_POST['password'])) {
            $password_form_error = "Password must include only letters and numbers";
            $validate_error_counter++;
        }


        if ($validate_error_counter == 0) {

            if (isset($_FILES['profile_photo']) && !empty($_FILES['profile_photo'])) {
                $file_name = $_FILES['profile_photo']['name'];
                $file_size = $_FILES['profile_photo']['size'];
                $file_temp = $_FILES['profile_photo']['tmp_name'];
                if ($validate->validate_image($file_name, $file_size)) {
                    $extension = strtolower(end(explode('.', $file_name)));
                    unlink($_SESSION['profile_photo']);
                    $image_path = $student->set_profilePic($extension, $file_temp);
                    $_SESSION['profile_photo'] = $image_path;
                }
            }


            if (!empty($_POST['username']) || !empty($_POST['password']) || !empty($_POST['profile_photo']))
                $student->EditProfile($_SESSION['student_id'], $_POST['username'], $_POST['password']);

            if (!empty($_POST['username']))
                $_SESSION['username'] = $_POST['username'];


            header('location:student_profile.php');
        }
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
            <title>Edit Profile</title>
            <!--[if lt IE 9]>
             <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
             <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
            <![endif]-->

            <link rel="stylesheet" type="text/css" href="<?php echo $css; ?>eyad_css/edit_student_profile_styleSheet.css">
            <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Josefin+Sans">

            <style type="text/css">
                .error {color: red;}
            </style>
        </head>
        <body style="overflow-x: hidden;">

            <div class="container editProfileClass">
                <form method="post" action="" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-12 lead">
                                            <h2 style="  color: #337ab7; font-family: 'Josefin Sans', sans-serif;margin-left: 25px;">Edit user profile</h2>
                                            <hr>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 text-center">
                                            <div class="img-circle avatar avatar-original center-block" style="background-size:cover;background-image:url(<?php echo $_SESSION['profile_photo']; ?>)"></div>
                                            <br> 
                                            <span class="btn btn-link btn-file"> Upload new photo <input type="file" name="profile_photo"></span>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label>Username:</label>
                                                <input type="text" class="form-control" name="username" placeholder="<?php echo $student->get_username(); ?>">
                                                <span class="error"><?php echo $invaled_username_error; ?></span>
                                                <br>
                                                <span class="error"><?php echo $username_length_error; ?></span>
                                            </div>
                                            <br>
                                            <div class="form-group">
                                                <h4 style="margin-bottom: 15px; margin-top: 10px; font-weight: bolder; color: #337ab7; font-family: 'Josefin Sans', sans-serif;">Want to change your password ?</h4>
                                                <label for="user_middle_name">New Password:</label>
                                                <input type="Password" class="form-control" name="password">
                                                <span class="error"><?php echo $password_form_error; ?></span>
                                            </div>  
                                            <div class="form-group">
                                                <label for="user_middle_name">Confirm New Password:</label>
                                                <input type="Password" class="form-control" name="confirm_password">
                                                <span class="error"><?php echo $password_not_matches_error; ?></span>
                                                <br>
                                                <span class="error"><?php echo $password_length_error; ?></span>
                                            </div>                

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <hr>
                                            <button type="submit" class="btn btn-primary pull-right"><i class="glyphicon glyphicon-floppy-disk"></i> Save</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </body>
    </html>
    <?php include_once 'templates' . DIRECTORY_SEPARATOR . 'footer' . DIRECTORY_SEPARATOR . 'footer.inc.php';
} else {
    header("Location: home.php");
    exit();
}
?>
