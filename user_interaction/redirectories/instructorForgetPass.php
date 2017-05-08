<?php
include_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'includes.html';
include_once dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . 'initialize.inc.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $inst = new instructor();
    $val = new validator();

    $email = $_POST['email'];
    $username = $_POST['username'];
    $verifCode = $_POST['vercode'];
    $password = $_POST['password'];
    $confirmPass = $_POST['password_again'];
    $sent_verificationCode = $_POST['verification_code'];


    $emailError = '';
    $emailError1 = '';
    $usernameError = '';
    $usernameError1 = '';
    $passwordError = '';
    $confirmPassError = '';
    $verifCodeError = '';
    $ErrorHandler = 0;

    // start validation
    if (!($inst->check_email_num($email))) {
        $emailError1 = '<span class="glyphicon glyphicon-alert" aria-hidden="true"></span> Error this Email is already exist <strong>please</strong> check it.<span class="glyphicon glyphicon-hand-up" aria-hidden="true"></span>';
        $ErrorHandler += 1;
    } else if ($inst->check_email_num($email)) {
        $emailError1 = '';
    }

    if (empty($email) || (strpos($email, 'fci') == False)) {
        $emailError = '<span class="glyphicon glyphicon-alert" aria-hidden="true"></span> Error please fill email contains domain : <strong>@fci</strong> <span class="glyphicon glyphicon-hand-up" aria-hidden="true"></span>';
        $ErrorHandler += 1;
    } else {
        $emailError = '';
    }

    if ($verifCode != $sent_verificationCode) {
        $verifCodeError = '<span class="glyphicon glyphicon-alert" aria-hidden="true"></span> Error please check <strong>verifivation</strong> <span class="glyphicon glyphicon-hand-up" aria-hidden="true"></span>';
        $ErrorHandler .= '1';
    } else if ($verifCode == $sent_verificationCode) {
        $verifCodeError = '';
    }

    if (empty($username) || !$val->alphaNumeric($username) || is_numeric($username)) {
        $usernameError = '<span class="glyphicon glyphicon-alert" aria-hidden="true"></span> Error please fill username with <strong>alphaNumeric</strong> characters<span class="glyphicon glyphicon-hand-up" aria-hidden="true"></span>';
        $ErrorHandler += 1;
    } else if (!empty($username) || $val->alphaNumeric($username) || !is_numeric($username)) {
        $usernameError = '';
    }

    if (!($inst->check_username_num($username))) {
        $userenameError1 = '<span class="glyphicon glyphicon-alert" aria-hidden="true"></span> This userName is already exist <strong>please</strong> check it.<span class="glyphicon glyphicon-hand-up" aria-hidden="true"></span>';
        $ErrorHandler += 1;
    } else if ($inst->check_username_num($username)) {
        $usernameError1 = '';
    }

    if (empty($password) || !$val->alphaNumeric($password)) {
        $passwordError = '<span class="glyphicon glyphicon-alert" aria-hidden="true"></span> This userName is already exist <strong>please</strong> check it.<span class="glyphicon glyphicon-hand-up" aria-hidden="true"></span>';
        $ErrorHandler += 1;
    } else if (!empty($password) || $val->alphaNumeric($password)) {
        $passwordError = '';
    }

    if (empty($confirmPass) || ($confirmPass != $password)) {
        $confirmPassError = '<span class="glyphicon glyphicon-alert" aria-hidden="true"></span>Error please fill as <strong>Password </strong> .<span class="glyphicon glyphicon-hand-up" aria-hidden="true"></span>';
        $ErrorHandler += 1;
    } else if (!empty($confirmPass) || $val->alphaNumeric($confirmPass)) {
        $confirmPassError = '';
    }
    // end validation
    if ($ErrorHandler == 0) {
        if ($inst->Reset_pass($username, $password, $email)) {
            echo '<div class="alert alert-success" role="alert">
  <strong>Well done!</strong> You successfully reset password <a href="../home.php" class="alert-link">Click here</a>.
</div>';
        } else {
            echo '<div class="alert alert-danger" role="alert">
  <strong>Oh snap!</strong> Something Went wrog with Database, try submitting again.
</div>';
        }
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
                <label class="col-md-4 control-label" for="email">Emial</label>
                <div class="col-md-6">
                    <input type="email" class="form-control" id="email" name="email" placeholder="example@fci..." value="<?php
                    if (isset($email)) {
                        echo $email;
                    }
                    ?>" required>                
                </div>
                <button type="button" class="btn btn-primary" id="verify" onclick="send_verification_code()">Verfiy</button>
            </div>

            <?php if (!empty($emailError) || !empty($emailError1)) { ?>
                <div class="alert alert-danger alert-dismissible" role="start">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <?php
                    if (isset($emailError1)) {
                        echo $emailError1;
                    }
                    if (isset($emailError)) {
                        echo $emailError;
                    }
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
                <label class="col-md-4 control-label" for="userName">new UserName</label>
                <div class="col-md-6">
                    <input type="text" class="form-control" id="username" name="username" placeholder="User name..." value="<?php
                    if (isset($username)) {
                        echo $username;
                    }
                    ?>" required>                
                </div>
            </div>

            <?php if (!empty($usernameError) || !empty($usernameError1)) { ?>
                <div class="alert alert-danger alert-dismissible" role="start">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <?php
                    if (isset($usernameError1)) {
                        echo $usernameError1;
                    }
                    if (isset($usernameError)) {
                        echo $usernameError;
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
            <input type="hidden" id ="verification_code" name="verification_code">
        </form>
        <script src="js/backend.js"></script>
        <script src="js/mina_js/backend.js"></script>
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
    <!-- ajax -->
    <script>
                    function send_verification_code() {
                        $("#verify").attr("disabled", true);
                        var email = $("#email").val();
                        var str = email;
                        $.post('ajax/ajax_forget_pass.php', {
                            str: str
                        }, function (html) {
                            $("#verification_code").val(html);
                        });
                    }
    </script>