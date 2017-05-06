<?php
session_start();
include_once 'includes.html';
include_once realpath(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'initialize.inc.php');
$student = new Student();
$course = new Course();


	/**********************************************************************************************************************
		Assume that there is an object of class Course and another objet of class Student,, when the student choose the new course, it will be added to his courses array.
	**********************************************************************************************************************/

	function generate_new_row($crs_name) {
		echo '		<tr>
						<td>' . $crs_name . '</td>
						<td><a href="#">See materials</a></td>
						<td><a href="#">Read the Describtion</a></td>
					</tr> ';
	}



  	function test_input($data) {
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}
$error_counter = 0;
$course_name = $student_id = "";
//validation
$student_id_error = $course_name_error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

	if (empty($_POST['course_name'])) {
		$course_name_error = "This field is required.";
		$error_counter++;
	}
	else {
		$course_name = test_input($_POST['course_name']);
	}
	if (empty($_POST['student_id'])) {
		$student_id_error = "This field is required.";
		$error_counter++;
		}
	else {
		$student_id = test_input($_POST['student_id']);
	}

	if ($error_counter == 0) {
		$course->name = $course_name;
		$student->courses[] = $course; //here i want to assign the $course object to the last element of courses[] array which belongs to the student


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
	<title>student courses</title>
	 <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	
	<link rel="stylesheet" type="text/css" href="<?php echo $css?>eyad_css/student courses_styleSheet.css">

</head>
<body>
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
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Operating Systmes - I</td>
						<td><a href="#">See materials</a></td>
						<td><a href="#">Read the Describtion</a></td>
					</tr>
					<tr>
						<td>Software Engineering - I</td>
						<td><a href="#">See materials</a></td>
						<td><a href="#">Read the Describtion</a></td>
					</tr>
					<tr>
						<td>Computer Networks - I</td>
						<td><a href="#">See materials</a></td>
						<td><a href="#">Read the Describtion</a></td>
					</tr>
					<tr>
						<td>Data Structures &amp; Algorithms</td>
						<td><a href="#">See materials</a></td>
						<td><a href="#">Read the Describtion</a></td>
					</tr>
					<tr>
						<td>Discrete Mathematics</td>
						<td><a href="#">See materials</a></td>
						<td><a href="#">Read the Describtion</a></td>
					</tr>
					<tr>
						<td>Programming - III</td>
						<td><a href="#">See materials</a></td>
						<td><a href="#">Read the Describtion</a></td>
					</tr>
					<?php
					if ($error_counter == 0) {
						generate_new_row($course_name);
					}
					?>
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
						<form method="POST" action="">
							<h2>Choose a new course from the above menu:</h2>
								<br>
								<span>Course Name:</span> &nbsp; &nbsp;
								<input type="text" name="course_name">
								<span style="color: red;"><?php echo $course_name_error; ?></span>
								<br><br>
								<span class="id_p">Your ID:</span>
								<input type="text" name="student_id" placeholder="20150000">
								<span style="color: red;"><?php echo $student_id_error; ?></span>
								<br><br>
								<button type="Submit" class="btn-primary">
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