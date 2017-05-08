<?php
session_start();
include_once realpath(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'initialize.inc.php');
if (isset($_SESSION['Admin'])) {
    include_once 'includes.html';

    $val = new validator();
    $student = new Student();
    $admin = new Admin();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $FirstName = $_POST['FirstName'];
        $LastName = $_POST['LastName'];
        $id = $_POST['collegeID'];
        $email = $_POST['Email'];
        $Gender = $_POST['gender'];
        $University = $_POST['univeristy'];

        $ErrorCounter = 0;

        //validation
        if (empty($FirstName) || !$val->ContainsNumbers($FirstName)) {
            $FnameError = '<span class="glyphicon glyphicon-alert" aria-hidden="true"></span> please fill First name with only <strong>Alphabitic</strong> Characters <span class="glyphicon glyphicon-hand-up" aria-hidden="true"></span>';
            $ErrorCounter++;
        } else {
            $FnameError = '';
        }

        if (empty($LastName) || !$val->ContainsNumbers($LastName)) {
            $LnameError = '<span class="glyphicon glyphicon-alert" aria-hidden="true"></span> please fill Last name with only <strong>Alphabitic</strong> Characters <span class="glyphicon glyphicon-hand-up" aria-hidden="true"></span>';
            $ErrorCounter++;
        } else {
            $LnameError = '';
        }


        if (!($admin->email_num($email)) || empty($email)) {
            $emailError = '<span class="glyphicon glyphicon-alert" aria-hidden="true"></span>these email is used before, <strong>please</strong> check it again <span class="glyphicon glyphicon-hand-up" aria-hidden="true"></span>';
            $ErrorCounter++;
        } else {
            $emailError = '';
        }


        if (empty($id) || $val->alphaNumeric($id)) {
            $IdError = '<span class="glyphicon glyphicon-alert" aria-hidden="true"></span> please fill ID  with only <strong>AlphaNumeric</strong> Characters <span class="glyphicon glyphicon-hand-up" aria-hidden="true"></span>';
            $ErrorCounter++;
        } else {
            $IdError = '';
        }
        // End validation
        //Enter to Database
        if ($ErrorCounter == 0) {  //if no error enter the data
            $student->set_firstName($FirstName);
            $student->set_lastName($LastName);
            $student->set_college_id($id);
            $student->set_email($email);
            $student->set_gender($Gender);
            $student->set_univeristy($University);
            $student->set_qr_code();
            if ($admin->addStudent($student)) {
                echo '<style>
     .alert{width:300px;margin: 10px auto;}
      </style>
      <div class="alert alert-success" role="alert">
      <strong>Added Successfully!</strong><a href="Adminpage.php" class="alert-link">Click Here</a>.
      </div>';
            } else {
                echo'<style>
     .alert{width:300px;margin: 10px auto;}
      </style>
      <div class="alert alert-danger" role="alert">
      <strong>Adding failed!</strong><a href="Adminpage.php" class="alert-link">Click Here</a>.
      </div>';
            }
            $admin->generate_qr($student->get_qr_code(), $student->get_email(), $student->get_firstName());
        }
        //End Data entry
        //generate qr code and send email 
    }
    ?>

    <!DOCTYPE html>
    <html>
        <head>
        <head>
            <meta charset="UTF-8" />
            <link rel="stylesheet" href="<?php echo $css; ?>mina_css/login.css" />
            <link rel="stylesheet" href="<?php echo $css; ?>mina_css/AddStudent.css" />
        </head>
    </head>
    <body>
        <nav class="navbar navbar-inverse">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-nav" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">Admin Page</a>
                </div>
                <div class="collapse navbar-collapse" id="app-nav">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Admin<span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="./logout.php">Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container">
            <h2 class="text-center">ADD NEW STUDENT</h2>
            <form class="contact-form" action="Adminpage.php" method="POST">

                <input class="form-control" type="text" name="FirstName" placeholder="First Name..."
                       value="<?php
                       if (isset($FirstName)) {
                           echo $FirstName;
                       }
                       ?>"/>


                <?php if (!empty($FnameError)) { ?>
                    <div class="alert alert-danger alert-dismissible" role="start">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button> 
                        <?php
                        echo $FnameError;
                        ?>
                    </div>
                <?php } ?>


                <input class="form-control" type="text" name="LastName" placeholder="Last Name ..."
                       value="<?php
                       if (isset($LastName)) {
                           echo $LastName;
                       }
                       ?>"/>


                <?php if (!empty($LnameError)) { ?>
                    <div class="alert alert-danger alert-dismissible" role="start">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button> 
                        <?php
                        echo $LnameError;
                        ?>
                    </div>
                <?php } ?>


                <input class="form-control" type="text" name="collegeID" placeholder="ID..."
                       value="<?php
                       if (isset($id)) {
                           echo $id;
                       }
                       ?>"/>


                <?php if (!empty($IdError)) { ?>
                    <div class="alert alert-danger alert-dismissible" role="start">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button> 
                        <?php
                        echo $IdError;
                        ?>
                    </div>
                <?php } ?>


                <input class="form-control" type="email" name="Email" placeholder="Email..."
                       value="<?php
                       if (isset($email)) {
                           echo $email;
                       }
                       ?>"/> 


                <?php if (!empty($emailError)) { ?>
                    <div class="alert alert-danger alert-dismissible" role="start">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button> 
                        <?php
                        echo $emailError;
                        ?>
                    </div>
                <?php } ?>


                <select class="form-control" id="gender" name="gender" required>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
                <br>
                <select class="form-control input-sm" id="university" name="univeristy" required>

                    <option value="Helwan">Helwan</option>
                    <option value="Cairo">Cairo</option>
                    <option value="Ain Shmas">Ain Shams</option>
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
                    <option value="Mostakbal">Mostkbal</option>
                    <option value="Delta">Delta</option>
                </select>
                <br>
                <input class="btn btn-success btn-block" type="submit" value="ADD" name="add"/>
            </form>
        </div>
    </body>
    </html>
    <?php
} else {
    header('Location: Admin.php');
    exit();
}
?>

