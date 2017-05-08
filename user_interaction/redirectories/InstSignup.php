<?php
include_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'includes.html';
include_once dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . 'initialize.inc.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fun = new validator();
    $inst = new instructor();
    $sent_verificationCode = $_POST['verification_code'];

// get and validate data from form
    $gender = $_POST['gender'];  // from comboBox
    $univeristy = $_POST['univeristy'];  // from comboBox
    $Fname = $_POST['firstname'];
    $userName = $_POST['username'];
    $cf_handle = $_POST['cfHandle'];
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $verifCode = $_POST['vercode'];
    $password = $_POST['password'];
    $confirmPass = $_POST['password_again'];
    $image_path = '';
// end getting form data
// validate input data
    // variables to hold error message 
    if (isset($_FILES['profile']) && !empty($_FILES['profile'])) {
        $fileName = $_FILES['profile']['name'];
        $fileSize = $_FILES['profile']['size'];
        $file_temp = $_FILES['profile']['tmp_name'];
        $file_extn = strtolower(end(explode('.', $fileName)));
        //move_uploaded_file($file_temp, 'images/jkd.'.$file_extn);
        $image_path = $inst->set_profilePic($file_extn, $file_temp);
    } 

    $datahandle = '';
    $FnameError = '';
    $userNameError = '';
    $verifCodeError = '';
    $passwordError = '';
    $confirmPassError = '';
    $emailError = '';
    $emailError1 = '';
    $cfhandleError = '';
    $file_error = '';
    $ErrorHandler = '12345';

    if (is_numeric($Fname) || empty($Fname) || !$fun->ContainsNumbers($Fname)) {
        $FnameError = '<span class="glyphicon glyphicon-alert" aria-hidden="true"></span> Error please fill <strong>Name</strong> with only alphabetic Characters <span class="glyphicon glyphicon-hand-up" aria-hidden="true"></span>';
        $ErrorHandler .= '1';
    } else if (!is_numeric($Fname) || !empty($Fname)) {
        $FnameError = '';
    }

    if (is_numeric($userName) || empty($userName) || $fun->alphaNumeric($userName)) {
        $userNameError = '<span class="glyphicon glyphicon-alert" aria-hidden="true"></span> please fill userName with only <strong>Alphanumeric</strong> Characters <span class="glyphicon glyphicon-hand-up" aria-hidden="true"></span>';
        $ErrorHandler .= '1';
    } else if (!empty($userName) || !is_numeric($userName) || !$fun->alphaNumeric($userName)) {
        $userNameError = '';
    }

    if (!($inst->check_username_num($userName))) {
        $userNameError1 = '<span class="glyphicon glyphicon-alert" aria-hidden="true"></span> This userName is already exist <strong>please</strong> check it.<span class="glyphicon glyphicon-hand-up" aria-hidden="true"></span>';
        $ErrorHandler .= '1';
    } else if ($inst->check_username_num($userName)) {
        $userNameError1 = '';
    }

    if (!empty($cfHandle)) {
        $cfhandleError = '<span class="glyphicon glyphicon-alert" aria-hidden="true"></span> please fill <strong>codeForces</strong> Handle field <span class="glyphicon glyphicon-hand-up" aria-hidden="true"></span>';
        $ErrorHandler .= '1';
    } else if (empty($cfHandle)) {
        $cfhandleError = '';
    }


    if ($verifCode != $sent_verificationCode) {
        $verifCodeError = '<span class="glyphicon glyphicon-alert" aria-hidden="true"></span> Error please check <strong>verifivation</strong> <span class="glyphicon glyphicon-hand-up" aria-hidden="true"></span>';
        $ErrorHandler .= '1';
    } else if ($verifCode == $sent_verificationCode) {
        $verifCodeError = '';
    }


    if ((strpos($email, 'fci') == False)) {
        $emailError = '<span class="glyphicon glyphicon-alert" aria-hidden="true"></span> Error please fill email contains domain : <strong>@fci</strong> <span class="glyphicon glyphicon-hand-up" aria-hidden="true"></span>';
        $ErrorHandler .= '1';
    } else if (strpos($email, 'fci') != False) {
        $emailError = '';
    }

    if (!($inst->check_email_num($email))) {
        $emailError1 = '<span class="glyphicon glyphicon-alert" aria-hidden="true"></span> Error this Email is already exist <strong>please</strong> check it.<span class="glyphicon glyphicon-hand-up" aria-hidden="true"></span>';
        $ErrorHandler .= '1';
    } else if ($inst->check_email_num($email)) {
        $emailError1 = '';
    }

    if ($password != $confirmPass) {
        $confirmPassError = '<span class="glyphicon glyphicon-alert" aria-hidden="true"></span>Wrong Password<strong>please</strong> check it.<span class="glyphicon glyphicon-hand-up" aria-hidden="true"></span>';
        $ErrorHandler .= '1';
    } else if ($password == $confirmPass) {
        $confirmPassError = '';
    }

    if (empty($password)) {
        $passwordError = '<span class="glyphicon glyphicon-alert" aria-hidden="true"></span> Wrong Password <strong>please</strong> check it.<span class="glyphicon glyphicon-hand-up" aria-hidden="true"></span>';
        $ErrorHandler .= '1';
    } else if (!empty($password)) {
        $passwordError = '';
    }
// end validate input data
//start input data
    // waiting for yassin
    if (@strlen($ErrorHandler) == 5) {
        $inst->set_gender($gender);
        $inst->set_univeristy($univeristy);
        $inst->set_fullName($Fname);
        $inst->set_username($userName);
        $inst->set_codeForces_handle($cf_handle);
        $inst->set_email($email);
        $inst->set_password($password);
        $inst->set_verficationCode($userName, $cf_handle);

        if ($inst->signUp($inst)) {
            $datahandle = True;
        }
    }
//end input data
}
?>

<style>
    /* start body*/
    body{
        background-image: url(../images/mina_images/image4.JPG);
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
        color:#000;
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
    }
    hr{
        height: 10px;
    }

</style>

<html>
    <head>
        <title>Instructor SignUP</title>
        <link rel="stylesheet" href="../css/fonts/font-awesome.min.css"> 
    </head>
    <body>


        <form action="<?php echo $_SERVER['PHP_SELF'] ?>"  id="myform" method="post" class="form-horizontal" enctype="multipart/form-data">


            <h2>Instructor-SignUp</h2>
            <hr>

            <?php if (@strlen($ErrorHandler) == 5 && $datahandle == True) { ?>
                <div class="alert alert-success alert-dismissible" role="alert">
                    <a href="../home.php" class="alert-link">You have registered Successfully, Thank You</a>   
                </div>
            <?php } ?>

            <div class="form-group"> 
                <label class="col-md-4 control-label" for="membership">Gender</label>
                <div class="col-sm-4">
                    <select class="form-control" id="membership" name="gender" required>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
            </div>



            <div class="form-group"> 
                <label class="col-md-4 control-label" for="university">University</label>
                <div class="col-md-4">
                    <select class="form-control input-sm" id="university" name="univeristy" required>
                        <option value="Helwan">Helwan</option>
                        <option value="Cairo">Cairo</option>
                        <option value="Ain Shams">Ain Shams</option>
                        <option value="Mansora">Mansora</option>
                        <option value="Assuit">Assuit</option>
                        <option value="Zagazig">Zagazig</option>
                        <option value="Menia">Menia</option>
                        <option value="Fayoum">Fayoum</option>
                        <option value="Banha">Banha</option>
                        <option value="Minufiya">Minufiya</option>
                        <option value="Suez Canal">Suez Canal</option>
                        <option value="Masr">Masr</option>
                        <option value="October">October</option>
                        <option value="Mostkbal">Mostkbal</option>
                        <option value="Delta">Delta</option>
                    </select>
                </div>
            </div>
        </div>



        <div class="form-group">    
            <label class="col-md-4 control-label" for="name">Name</label>
            <div class="col-md-6">
                <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Full name..." value="<?php
                if (isset($Fname)) {
                    echo $Fname;
                }
                ?>" required>             
            </div>
        </div>

        <?php if (!empty($FnameError)) { ?>
            <div class="alert alert-warning" role="alert">
                </button> 
                <?php
                echo $FnameError;
                ?>
            </div>
        <?php } ?>

        <div class="form-group">    
            <label class="col-md-4 control-label" for="username">UserName</label>
            <div class="col-md-6">
                <input type="text" class="form-control" id="username" name="username" placeholder="username..." value="<?php
                if (isset($userName)) {
                    echo $userName;
                }
                ?>" required>                
            </div>
        </div>

        <?php if (!empty($userNameError) || !empty($userNameError1)) { ?>
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

        <?php if (!empty($cfhandleError)) { ?>
            <div class="alert alert-danger alert-dismissible" role="start">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <?php
                echo $cfhandleError;
                ?>
            </div>
        <?php } ?>


        <div class="form-group">
            <label class="col-md-4 control-label" for="inputEmail">Mail</label>
            <div class="col-md-6">
                <input type="email" class="form-control" id="email" name="email" placeholder="example@fci...." value="<?php
                if (isset($email)) {
                    echo $email;
                }
                ?>"required>
            </div>
            <button type="button" class="btn btn-primary" id="verify" onclick="send_verification_code()" >Verfiy</button>
        </div>


        <?php if (!empty($emailError) || !empty($emailError1)) { ?>
            <div class="alert alert-danger alert-dismissible" role="start">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <?php
                if (isset($emailError))
                    echo $emailError;
                if (isset($emailError1))
                    echo $emailError1;
                ?>
            </div>
        <?php } ?>


        <div class="form-group">
            <label class="col-md-4 control-label" for="verification">Verification code</label>
            <div class="col-md-6">
                <input type="text" class="form-control" id="vercode" name="vercode" placeholder="click verify mail and check mail...." value="<?php
                if (isset($verifCode)) {
                    echo $verifCode;
                }
                ?>" required>
            </div>
        </div>

        <?php if (!empty($verifCodeError)) { ?>
            <div class="alert alert-danger alert-dismissible" role="start">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <?php
                echo $verifCodeError;
                ?>
            </div>
        <?php } ?>


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
            <div class="alert alert-danger alert-dismissible" role="start">
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
                <input type="file" id="file" name="profile">
            </div>
        </div>
        <input class="btn btn-primary btn-block" type="submit" name="register" value="Register" />
        <input type="hidden" id ="verification_code" name="verification_code">

    </form>
    <script src="<?php echo $js ?>mina_js/backend.js"></script>
</body>
</html>
<script>
                function send_verification_code() {
                    $("#verify").attr("disabled", true);
                    var email = $("#email").val();
                    var name = $("#username").val();
                    var DR_name = $("#firstname").val();
                    var codeforces_handle = $("#cfHandle").val();
                    var str = name + ":" + codeforces_handle + ":" + email + ":" + DR_name;
                    $.post('ajax/ajax_verify_instructor.php', {
                        str: str
                    }, function (html) {
                        $("#verification_code").val(html);
                    });
                }
</script>