<?php
include_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'includes.html';
include_once dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . 'initialize.inc.php';
$fun = new validator();
$stu = new Student();
session_start();
$var = $_SESSION['credential'];
// get student data by qr code string
if ($result = $stu->SignUp($var)) { // law 3ml retrive mn eldatabase
    $name = $result['first_name'] . ' ' . $result['last_name'];
    $Fname = $result['first_name'];
    $id = $result['student_id'];
    $Lname = $result['last_name'];
    $email = $result['email'];
    $gender = $result['gender'];
    $univeristy = $result['university'];
    $codeforces = $result['codeforces_handle'];
    $college_id = $result['college_id'];
    if ($stu->validate_regestration($codeforces) == True) { // if first time regestrartion
        ?> 
        <style>
            /* start body*/
            body{
                background-image: url('../images/mina_images/books.jpg');
                background-repeat: no-repeat;
                background-size:  cover; 
            }
            label{
                color:#000;
            }
            /*end body*/
            /*start Admin Login*/
            h2{
                margin-left: 150px;
                color:gray;
            }
            .ajax{
                margin:auto 10px;
                color:blue;
                font-weight: bold;
                text-decoration: none;
            }
            .form-horizontal{
                margin-top: 20px;
                width: 550px;
                margin : 60px auto;
            }
            .SignUp input{
                margin-bottom: 10px;
            }
            .SignUp .form-control{
                background-color: #000;
                hr{
                    height: 10px;
                }
                h4{
                    color: grey;
                }
            }

        </style>
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>"  id="myform" method="post" class="form-horizontal">


            <h2>Student-SignUp</h2>
            <hr>


            <div class="form-group">    
                <label class="col-md-4 control-label" for="userName">Name</label>
                <div class="col-md-6">
                    <h4><?php if (isset($name)) echo $name; ?></h4>
                </div>
            </div>

            <div class="form-group">    
                <label class="col-md-4 control-label" for="userName">ID</label>
                <div class="col-md-6">
                    <h4><?php if (isset($college_id)) echo $college_id; ?></h4>
                </div>
            </div>


            <div class="form-group">    
                <label class="col-md-4 control-label" for="userName">User Name</label>
                <div class="col-md-6">
                    <input type="text" class="form-control" id="username" name="username" placeholder="User name..." value="<?php
                    if (isset($userName)) {
                        echo $userName;
                    }
                    ?>" required>                
                </div>
            </div>

            <?php if (!empty($userNameError1) || !empty($userNameError)) { ?>
                <div class="alert alert-danger alert-dismissible" role="start">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <?php
                    if (isset($userNameError)) {
                        echo $userNameError;
                    }
                    if (isset($userNameError1)) {
                        echo $userNameError1;
                    }
                    ?>
                </div>
            <?php } ?>


            <div class="form-group">    
                <label class="col-md-4 control-label" for="cfHandle">CodeForces Handle</label>
                <div class="col-md-6">
                    <input type="text" class="form-control" id="cfHandle" name="cfHandle" placeholder="handle..." value="<?php
                    if (isset($cf_handle)) {
                        echo $cf_handle;
                    }
                    ?>" required>                
                </div>
            </div> 




            <div class="form-group">    
                <label class="col-md-4 control-label" for="password">Password</label>
                <div class="col-md-4">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter password..."  minlength="3" value="<?php
                    if (isset($password)) {
                        echo $password;
                    }
                    ?>" required> 
                </div>
                <span class="col-md-4" id="pass"></span>
            </div>

            <?php if (!empty($passwordError)) { ?>
                <div class="alert alert-danger alert-dismissible" role="start">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <?php
                    echo $passwordError;
                    ?>
                </div> 
            <?php } ?> 


            <div class="form-group">    
                <label class="col-md-4 control-label" for="password_again">Confirm password</label>
                <div class="col-md-4">
                    <input type="password" class="form-control" id="password_again" name="password_again" value="<?php
                    if (isset($confirmPass)) {
                        echo $confirmPass;
                    }
                    ?>" placeholder="Confirm password..." >                
                </div>
                <span class="col-md-4" id="conpass"></span>
            </div>

            <?php if (!empty($confirmPassError)) { ?>
                <div class="alert alertt-danger alert-dismissible" role="start">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <?php
                    echo $confirmPassError;
                    ?>
                </div>
            <?php } ?>

            <div class="form-group">
                <label class="col-md-4 control-label" for="profile">Profile picture</label>
                <div class="col-md-6">
                    <input type="file" id="file">
                </div>
            </div>
            <input class="btn btn-primary" type="submit" name="register" value="Register" />


        </form>
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userName = $_POST['username'];
            $cf_handle = $_POST['cfHandle'];
            $password = $_POST['password'];
            $confirmPass = $_POST['password_again'];
            $userNameError = '';
            $userNameError1 = '';
            $cf_handleError = '';
            $passwordError = '';
            $confirmPassError = '';
            $ErrorCounter = 0;

            if (is_numeric($userName) || empty($userName)) {
                $userNameError = '<span class="glyphicon glyphicon-alert" aria-hidden="true"></span> please fill username name with only <strong>Alphabitic</strong> Characters <span class="glyphicon glyphicon-hand-up" aria-hidden="true"></span>';
                $ErrorCounter++;
            } else if (!is_numeric($userName) || !empty($userName)) {
                $userNameError = '';
            }

            if (!($stu->check_username_num($userName))) {
                $userNameError1 = '<span class="glyphicon glyphicon-alert" aria-hidden="true"></span> This userName is already exist <strong>Try</strong> another one <span class="glyphicon glyphicon-hand-up" aria-hidden="true"></span>';
                $ErrorCounter++;
            } else if ($stu->check_username_num($userName)) {
                $userNameError1 = '';
            }

            if (empty($cf_handle)) {
                $cf_handleError = '<span class="glyphicon glyphicon-alert" aria-hidden="true"></span> please fill valid <strong>handle </strong> <span class="glyphicon glyphicon-hand-up" aria-hidden="true"></span>';
                $ErrorCounter++;
            } else if (!is_numeric($cf_handle) || !empty($cf_handle)) {
                $cf_handleError = '';
            }

            if (empty($password)) {
                $passwordError = '<span class="glyphicon glyphicon-alert" aria-hidden="true"></span> please fill <strong>password </strong> <span class="glyphicon glyphicon-hand-up" aria-hidden="true"></span>';
                $ErrorCounter++;
            } else if (!is_numeric($password) || !empty($password)) {
                $passwordError = '';
            }

            if (empty($confirmPass) || $confirmPass != $password) {
                $confirmPassError = '<span class="glyphicon glyphicon-alert" aria-hidden="true"></span> coundnot match please enter <strong> again </strong> <span class="glyphicon glyphicon-hand-up" aria-hidden="true"></span>';
                $ErrorCounter++;
            } else if (!empty($confirmPass)) {
                $confirmPassError = '';
            }
            if ($ErrorCounter == 0) {
                $stu->set_college_id($college_id);
                $stu->set_firstName($Fname);
                $stu->set_lastName($Lname);
                $stu->set_email($email);
                $stu->set_gender($gender);
                $stu->set_univeristy($univeristy);
                $stu->set_codeForces_handle($cf_handle);
                $stu->set_username($userName);
                $stu->set_password($fun->hashData($password));
                $stu->Register($stu, $id);
                ?>
                <div class="alert alert-success" role="alert">
                    <strong>Welcome to Hsala, you have registred successfully :)
                    </strong> <a href="../home.php" class="alert-link">redirect to home</a></div>
                <?php
            }
        }
    } else {
        ?>
        <div class="alert alert-danger" role="alert">
            <strong>Error, it seems that you have registred before!</strong> 
            <a href="../home.php" class="alert-link">redirect to home</a></div>
        <style>
            body {
                background-image: url('../images/mina_images/error.jpeg');
                background-size:  cover;
            }
        </style>
        <?php
    }
} else {
    ?>
    <div class="alert alert-danger" role="alert">
        <strong>Error, The scanned QrCode is not authorized by Hsala Community!
        </strong> <a href="../home.php" class="alert-link">redirect to home</a></div>
    <style>
        body {
            background-image: url('../images/mina_images/error.jpeg');
            background-size:  cover;
        }
    </style>
<?php }
?>

<html>
    <head>
        <title>Student SignUP</title>
    </head>
    <body>

        <script src="js/mina_js/backend.js"></script>
    </body>
</html>
