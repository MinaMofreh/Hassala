<html>
<head>
      <title>Hsala</title>
      <link rel="stylesheet" href="../layout/css/bootstrap.min.css" />
      <link rel="stylesheet" href="../layout/css/studentNavbar.css">
      <link rel="stylesheet" href="../layout/css/font-awesome.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
      <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
</head>
<body>
<nav class="navbar  navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container-fluid">
             <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                </button>
            </div>


                  <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                  <div class="navbar-header">
                  <a class="navbar-brand" href="#" dir='rtl' lang='ar'>حَصَّالَة</a>
                  <ul class="nav navbar-nav">
                  <li class="active"><a href="#">Page1</a></li>
                  <li class="active"><a href="#">Page2</a></li>
                  <li class="active"><a href="#">Page3</a></li>
                  <li class="active"><a href="#">Page4</a></li>
                  </ul>
                  </div>

                 <ul  class="nav navbar-nav navbar-right">
                 <li  class="username">Welcome <!--<?php echo $_SESSION['student']?>--></li> 
                 <li  class="dropdown">
                 <li id="logIn"><a href="Logout.php"><span class="glyphicon glyphicon-user" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal1"> Logout </span></a></li>
                  
                  </ul>
                  </div>
  </div>
</nav>