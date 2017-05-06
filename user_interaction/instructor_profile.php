<?php
  session_start();
 include_once 'includes.html';
include_once realpath(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'initialize.inc.php');
  /*
    I will assume that there is an open session and it will be passed to me with the student object which has his information, 
    now i'll simulate (create studnet object and give it it's values and i will show them in the design).
  */
    $instructor = new Instructor();
    $instructor->set_firstName("Ghada");
    $instructor->set_lastName("Mohammed");
    $instructor->set_email("email@test.com");
    $instructor->set_username("ghada_khoriba");
    $instructor->courses = array('Helwan','MIS');
    $instructor_first_name = $instructor->get_firstName();
    $instructor_last_name = $instructor->get_lastName();
    $instructor_email = $instructor->get_email();
    $instructor_username = $instructor->get_username();
    $instructor_universities = $instructor->get_univeristy();
    $instructor_position = "Proffesor";
    $instructor_degree = "PhD";
    $instructor_courses = array('Software Engineering I','Operating Systems II','Programming I');

?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<!-- for internet explorer compatibality-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--first mobile meta-->
	<title>Instructor Profile</title>
	 <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    
      <!-- bootstrap -->
  <link rel="stylesheet" type="text/css" href="<?php echo $css;?>eyad_css/instructor_profile_styleSheet.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Josefin+Sans">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Gentium+Basic|Josefin+Sans">


</head>
<body>
<!-- start instructor profile page -->
<br>
<div class="container profileContainer">
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="row">
            <div class="col-md-12 lead"><h1 style="padding-left: 70px;">Instructor Profile</h1><hr></div>
          </div>
          <div class="row">
      <div class="col-md-4 text-center">
          <img class="profilePhoto" style="display:block; margin:auto;" src="images/eyad_images/avatar.png" alt="profile photo">
            </div>
            <div class="col-md-8">
              <div class="row">
                <div class="col-md-12">
                  <h2 class="only-bottom-margin"><?php echo $instructor_first_name . " " . $instructor_last_name;?></h2><br>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 information">
                <h3 style="color: #337ab7; font-weight: bold;">Basic Information</h3>
                  <span class="text-muted">Email:</span> <?php echo $instructor_email; ?><br>
                  <span class="text-muted">Username:</span> <?php echo $instructor_username; ?><br>
                  <h3 style="color: #337ab7; font-weight: bold;">Education</h3>
                  <span class="text-muted">University:</span> <?php foreach ($instructor_universities as $universities) {
                    echo $universities . '   ';} ?><br>         
                  <span class="text-muted">Position:</span> <?php echo $instructor_position; ?><br>
                  <span class="text-muted">Degree:</span> <?php echo $instructor_degree; ?><br>
                  <span class="text-muted">Courses:</span> <?php foreach ($instructor_courses as $courses) {
                    echo $courses . '  ';} ?><br>         

                </div>
             </div>
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
