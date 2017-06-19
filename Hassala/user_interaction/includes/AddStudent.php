<?php

$val = new validator();
$student = new Student();
$admin = new Admin();

if ($_POST['add']) {
    $FirstName = $val->secureData(filter_var($_POST['FirstName'], FILTER_SANITIZE_STRING));
    $LastName = $val->secureData(filter_var($_POST['LastName'], FILTER_SANITIZE_STRING));
    $id = $val->secureData(/* filter_var( */$_POST['collegeID']/* , FILTER_SANITIZE_NUMBER_INT) */);
    $email = $val->secureData(filter_var($_POST['Email'], FILTER_SANITIZE_EMAIL));
    $Gender = $_POST['gender'];
    $University = $_POST['univeristy'];
    $ErrorCounter = 0;
    print_r($_POST);
    //validation
    if (empty($FirstName) || $val->ContainsNumbers($FirstName)) {
        $FnameError = '<span class="glyphicon glyphicon-alert" aria-hidden="true"></span> please fill First name with only <strong>Alphabitic</strong> Characters <span class="glyphicon glyphicon-hand-up" aria-hidden="true"></span>';
        $ErrorCounter++;
    } else {
        $FnameError = '';
    }

    if (!($admin->email_num($email)) || empty($email)) {
        $emailError = '<span class="glyphicon glyphicon-alert" aria-hidden="true"></span>these email is used before, <strong>please</strong> check it again <span class="glyphicon glyphicon-hand-up" aria-hidden="true"></span>';
        $ErrorCounter++;
    } else {
        $emailError = '';
    }

    if (empty($LastName) || $val->ContainsNumbers($LastName)) {
        $LnameError = '<span class="glyphicon glyphicon-alert" aria-hidden="true"></span> please fill Last name with only <strong>Alphabitic</strong> Characters <span class="glyphicon glyphicon-hand-up" aria-hidden="true"></span>';
        $ErrorCounter++;
    } else {
        $LnameError = '';
    }

    if (empty($id) || !is_numeric($id)) {
        $IdError = '<span class="glyphicon glyphicon-alert" aria-hidden="true"></span> please fill ID  with only <strong>Numeric</strong> Characters <span class="glyphicon glyphicon-hand-up" aria-hidden="true"></span>';
        $ErrorCounter++;
    } else {
        $IdError = '';
    }
    // End validation
    //Enter to Database
    if ($ErrorCounter == 0) {  //if no error enter the data
        $student->set_firstName($FirstName);
        $student->set_lastName($LastName);
        $student->set_id($id);
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