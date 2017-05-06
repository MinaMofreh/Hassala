<?php 
session_start();
include_once 'includes.html';
include_once realpath(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'initialize.inc.php');
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

  <!-- bootstrap -->
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" type="text/css" href="<?php echo $css;?>eyad_css/edit_student_profile_styleSheet.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Josefin+Sans">


</head>
<body>

<form>
  <div class="container editProfileClass" style="margin-left: 150px; width: 100%">
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
                <div id="img-preview-block" class="img-circle avatar avatar-original center-block" style="background-size:cover; 
                background-image:url(icons/eyad.jpg)"></div>
                <br> 
                <span class="btn btn-link btn-file">Upload new photo <input type="file" id="upload-img"></span>
              </div>
              <div class="col-md-8">
                <div class="form-group">
                  <label>Username:</label>
                  <input type="text" class="form-control" id="user_last_name" required>
                </div>
                <div class="form-group">
                  <label for="user_middle_name">New Password:</label>
                  <input type="Password" class="form-control" id="user_middle_name">
                </div>  
                <div class="form-group">
                  <label for="user_middle_name">Confirm New Password:</label>
                  <input type="Password" class="form-control" id="user_middle_name">
                </div>                
              
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <hr>
                <button class="btn btn-primary pull-right"><i class="glyphicon glyphicon-floppy-disk"></i> Save</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div id="delete-user-modal" class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
          <p>Are you sure you want to delete account?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-danger">Delete</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
</form>

  <script type="text/javascript" src="jquery-1.12.4.min.js"></script>

</body>
</html>