<?php
include_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'includes.html';
// forget password code
include_once dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . 'initialize.inc.php';
$stu = new Student();
$fun = new validator();
session_start();
$var = $_SESSION['credential'];
if ($result = $stu->SignUp($var)) {
    $name = $result['first_name'] . ' ' . $result['last_name'];
    $id = $result['student_id'];
    $codeforces = $result['codeforces_handle'];
    if (!$codeforces) {
        ?>
        <div class="alert alert-danger" role="alert">
            <strong>Error, you are not a user YET!
            </strong> <a href="../home.php" class="alert-link">redirect to home</a></div>
        <style>
            body{
                background-image: url('');
                background-size:  cover;
            }

            .alert{width:300px;margin: 10px auto;}
        </style>
        <?php
        header();
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $username = $_POST['username'];
        $password = $_POST['password'];
        $confirmPass = $_POST['password_again'];

        $usernameError = '';
        $usernameError1 = '';
        $passwordError = '';
        $confirmPassError = '';
        $ErrorCounter = 0;
        // start validation
        if (empty($username) || is_numeric($username)) {
            $usernameError = '<span class="glyphicon glyphicon-alert" aria-hidden="true"></span> please fill username name with only <strong>Alphabitic</strong> Characters <span class="glyphicon glyphicon-hand-up" aria-hidden="true"></span>';
            $ErrorCounter++;
        } else if (!is_numeric($username) || !empty($username)) {
            $usernameError = '';
        }

        if (!($stu->check_username_num($username))) {
            $usernameError1 = '<span class="glyphicon glyphicon-alert" aria-hidden="true"></span> This userName is already exist <strong>Try</strong> another one <span class="glyphicon glyphicon-hand-up" aria-hidden="true"></span>';
            $ErrorCounter++;
        } else if ($stu->check_username_num($username)) {
            $usernameError1 = '';
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
        // end validation
        if ($ErrorCounter == 0) {
            $handle = $stu->Reset_pass($username, $password, $id); //update username, password 
            ?>
            <div class="alert alert-success" role="alert">
                <strong>Password and username has been Successfully Changed!</strong><a href="../home.php" class="alert-link">Click Here</a>.
            </div>
            <?php
        }
    }
    ?>

    <html>
        <head>
            <title>Forget Password</title>
        </head>
        <body>


            <form action="<?php echo $_SERVER['PHP_SELF'] ?>"  id="myform" method="post" class="form-horizontal">


                <h2>Forget Password</h2>
                <hr>


                <div class="form-group">    
                    <label class="col-md-4 control-label" for="userName">Name</label>
                    <div class="col-md-6">
                        <h4><?php if (isset($name)) echo $name; ?></h4>
                    </div>
                </div>


                <div class="form-group">    
                    <label class="col-md-4 control-label" for="userName">new UserName</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" id="username" name="username" placeholder="User name..." value="<?php
                        if (isset($username)) {
                            echo $username;
                        }
                        ?>" required>                
                    </div>
                </div>

                <?php if (!empty($usernameError1) || !empty($usernameError)) { ?>
                    <div class="alert alert-danger alert-dismissible" role="start">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <?php
                        if (isset($usernameError)) {
                            echo $usernameError;
                        }
                        if (isset($usernameError1)) {
                            echo $usernameError1;
                        }
                        ?>
                    </div>
                <?php } ?>





                <div class="form-group">    
                    <label class="col-md-4 control-label" for="password">new Password</label>
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
                    <div class="alert alert-danger alert-dismissible" role="start">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <?php
                        echo $confirmPassError;
                        ?>
                    </div>
                <?php } ?>
                <input class="btn btn-primary btn-block" type="submit" name="reset" value="Reset" />
            </form>

            <script src="../js/jquery-1.12.1.min.js"></script>
            <script src="../js/bootstrap.min.js"></script>
            <script src="../js/backend.js"></script>
        </body>
    </html>
    <style>

        body{
            background-image: url(../images/books.JPG);
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
        </style>

    <?php } else { ?>
        <div class="alert alert-danger" role="alert">
            <strong>Error, it seems thatbyou have regestred before or 
                the Qr code is not authorized !
            </strong> <a href="../API/QrScanner/index.php" class="alert-link">redirect to scanner</a></div>

        <style>
            body {
                background-image: url('../images/error.jpeg');
                background-size:  cover;
            }
        </style>
    <?php } ?>
    <script src="js/mina_js/backend.js"></script>