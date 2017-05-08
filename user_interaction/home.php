<?php
include_once realpath(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'initialize.inc.php');
include 'includes.html';


include 'login.php';
$admin = new Admin();
$result = $admin->GenerateStatistics();
$browser = get_browser(null, true);
$browserType = /*$browser['browser']*/ "Firefox";
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <title>HSALAH</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="<?php echo $css; ?>mina_css/home.css">
        <link rel="stylesheet" href="<?php echo $css; ?>fonts/font-awesome.min.css">
        <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Indie+Flower" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Josefin+Sans" rel="stylesheet">

        <!-- start genrate statisitics -->
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
            google.charts.load('current', {'packages': ['corechart']});
            google.charts.setOnLoadCallback(drawChart);
            function drawChart() {
                var data = google.visualization.arrayToDataTable(<?php echo $result; ?>);

                var options = {
                    title: 'Users from each university',
                    is3D: true,
                };
                var chart = new google.visualization.PieChart(document.getElementById('piechart'));
                chart.draw(data, options);
            }
        </script>
        <!-- end genrate statisitics -->
        /
    </head>
    <body>

        <!--********************** start nav bar ****************-->
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
                        <a class="github-logo" rel="home" href="https://github.com/andrewnagyeb/Hassala" title="Github project" target="_blank">
                            <img style="max-width:100px;max-height: 45px;"
                                 src="<?php echo $images; ?>GitHub-Mark-120px-plus.png" class="github-logo-img">
                        </a>
                    </div>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user" class="btn btn-info btn-lg"></span> Signup<span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="redirectories/InstSignup.php">Instructor</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="#" data-toggle="modal" data-target="#myModal" >Student</a></li>
                            </ul>
                        </li>
                        <li id="logIn"><a href="#"><span class="glyphicon glyphicon-log-in" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal1"> Login </span></a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <!--********************** end nav bar ****************-->
        <div class="modal fade" id="myModal1" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" class="form-horizontal" data-toggle="validator" role="form">
                    <div class="modal-content">
                        <script>


                        </script>
                        <div class="modal-header">
                            <h4 class="modal-title"><span id="signupspan">Login</span> Form</h4>
                        </div>

                        <div class="modal-body">

                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <input id="text1" type="text"  class="form-control" name="username" placeholder="user name....." required value="<?php if (isset($userName)) echo $userName; ?>">
                            </div>


                            <br>

                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                <input id="password" type="password" class="form-control" name="password"   placeholder="Password" required value="<?php if (isset($password)) echo $password; ?>">
                            </div>

                        </div>

                        <div class="modal-footer"> <?php
                            if ($browserType == 'Firefox') {
                                echo '
          <a style="color:red;" href="redirectories/index.php">Forget Password(Student)</a>
          ';
                            } else {
                                echo 'Forget password(Student) feature only allowed on Mozila browser<br>';
                            }
                            ?>                    <a style="color:red;" href="redirectories/instructorForgetPass.php">- Forget Password(instructor)</a> 
                            <button type="submit" class="btn btn-success" name="login">Login</button>   
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>

                    </div>  
                </form>
            </div>
        </div>  
        <!--********************** end login form*****************-->




        <!--**********************start student signup form***************-->
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <form action="<?php if ($browserType == 'Firefox') echo 'API/QrScanner/index.php'; ?>"  id="myform" method="post" class="form-horizontal">

                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Student's <span>signup</span> Form</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="col-md-6 control-label" for="QR">To Scan QrCode Click -></label>
                                <div class="col-md-6"><?php
                                    if ($browserType == 'Firefox') {
                                        echo '<button id="submitbutton" name="scan" type="submit" class="btn btn-success">Scan Qr Code</button>';
                                    } else {
                                        echo 'sorry! you should use a comopatable browser with QrCode scanner i.e(Mozila Firefox)';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>  
                </form>
            </div>
        </div>  
        <!--********************** end student sign up********************-->




        <!--***********start instructor signup******************-->
    </div>
    <!--**********************end signup form***************-->




    <!--********************** start slider******************-->
    <div class="slider2" class="container-fluid">
        <div class="row">
            <div class="row-sn-12">
                <div id="myslider" class="carousel slide" data-ride="carousel">

                    <ol class="carousel-indicators">
                        <li data-target="#myslider" data-slide-to="0" class="active"></li>
                        <li data-target="#myslider" data-slide-to="1"></li>
                        <li data-target="#myslider" data-slide-to="2"></li>
                    </ol>


                    <div id="texttt" class="carousel-inner" role="listbox">
                        <div class="item active">
                            <img width="100%" src="<?php echo $images; ?>mina_images/p56.jpeg" alt="BOOKS"/>
                        </div>

                        <div class="item">
                            <img width="100%" src="<?php echo $images; ?>mina_images/p1.jpeg" alt="Professors"/>
                            <div class="carousel-caption">
                            </div>
                        </div>

                        <div class="item">
                            <img width="100%" src="<?php echo $images; ?>mina_images/p2.jpeg" alt="online judge"/>
                        </div>
                    </div>
                    <a class="left carousel-control" href="#myslider" roel="button" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left"></span>
                    </a>


                    <a class="right carousel-control" href="#myslider" roel="button" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right"></span>
                    </a>

                </div>
            </div> 
        </div>
        <!--********************** end slider********************-->
    </div>
    <div class="container">

        <div class="row">
            <div class="col-md-6 stat" id="piechart" ></div>
            <hr>
        </div>
        <section class="aboutUs text-center">
            <div class="container aboutUsContainer">
                <h1>About Us</h1>
                <hr>
                <p>We are all a team of computer science students in the Faculty of Computers and Information -Helwan University-<br>
                    we developed this wep application to be our project for Software Engineering Course Under supervision
                    of Dr. <b>Ghada Khoriba</b>.<br>
                    Our project will be totally <b>open source</b> project and it's okay to any one to keep on developing it.<br><br></p>
                <br>
                <h2>Project Scope</h2>
                <h3>Online Judge</h3>
                <p>Our web application scope includes online judging feature for problem
                    sets(in C/C++), which could compile, run &amp; return a solving status to the
                    user.</p>
                <h3>Course Management</h3>
                <p>It is also allowing professors to create courses and assign their materials and write
                    their description. Moreover, they can create online judging problems and
                    provide their test cases. They're also allowed to create quizzes and determine
                    their time , when quiz's time is finished, an auto-generated PDF file is sent
                    to the instructor includes students names and their assigned grades. If an
                    essay plagiarism is found , an immediate e-mail is sent to the doctor includes
                    students names . Professors can create contests between course's participants</p>
                <h3>Server Contests</h3>
                <p>Our server-side developers will be creating contests between all students in
                    Egypt. their processes should go as mentioned below:<br>
                    -Local contest between same college students.<br>
                    -Winners of local contest will be advanced to a national one between all
                    colleges.<br>
                    -Winners of national competition will be honored.</p>
                <h3>Rating</h3>
                <p>Rating feature is one of the most in
                    uential features. Colleges will be rated
                    on a scale from 1 to 10 depending on how many students of the college have
                    solved problem sets which is made by the server-side developers. And so will
                    do students , they're going to be rated as well. List will be made at all web
                    application's pages shows them all time.</p>
                <h3>ID Detecting</h3>
                <p>Changing registration criteria from being accepting new participants manu-
                    ally to an auto-detecting feature, which checks whether the uploaded image
                    conrms to our terms & conditions.</p>
                <h3>Open Source</h3>
                <p>Our vision after finishing the project is uploading it to <b>GitHub</b> so we can
                    help and inspire developers to innovate. We'll also allow contributions in
                    order to achieve professional service to participants.</p>
                <br><br><br>
                <h2>Project Developers</h2>
                <br>
                <div class="Photos">
                    <div class="eyadId">
                        <img class="circled" src="images/about_us/eyad.jpg">
                        <span class="eyadName">Eyad Mohammad</span>  
                    </div>
                    <div class="andrewId">
                        <img class="circled" src="images/about_us/andrew.jpg">
                        <span class="andrewName">Andrew Amir</span>
                    </div>
                    <div class="yassenId">
                        <img class="circled" src="images/about_us/yassen.jpg">
                        <span class="yassenName">Yassen Mehrez</span>
                    </div>
                    <div class="johnId">
                        <img class="circled" src="images/about_us/john.jpg">
                        <span class="johnName">John Nabil</span>
                    </div>
                    <div class="minaId">
                        <img class="circled" src="images/about_us/mina.jpg">
                        <span class="minaName">Mina Mofreh</span>
                    </div>
                </div>
            </div>
        </section>
    </div>



    <!--*****EYAD************** start footer*****************-->
    <section class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h3 class="logo"><a href="#">حَصَّالَة</a></h3>
                    <br>
                    <ul class="list-unstyled social-list">
                        <li><a href="#"><img class="socialMedia" src="icons/1489085056_social-facebook-circle.png"></a></li>
                        <li><a href="#"><img class="socialMedia" src="icons/1489085120_twitter.png"></a></li>
                        <li><a href="#"><img class="socialMedia" src="icons/1489085185_youtube.png"></a></li>
                        <li><a href="#"><img class="socialMedia" src="icons/1489085390_google_circle.png"></a></li>
                        <li><a href="#"></a></li>
                    </ul>
                    <br>
                    <a href="#">Home</a> . <a href="#">FAQ</a> . <a href="#">Contact Us</a>
                </div>  
                <div class="col-md-4">
                    <h3 class="sitemap">Sitemap</h3>
                    <ul class="list-unstyled">
                        <li><a href="#">Home</a></li>
                    </ul>
                    <br><br><br>
                    <center><p class="copyrights">All rights not received <span class="copyleft">&copy;</span></p></center>

                </div>


                <div class="col-md-4">
                    <h3 class="visitus">Visit us</h3>
                    <br>
                    <ul class="list-unstyled visit">
                        <li><img class="locationPic" src="icons/maps-placeholder-outlined-tool.png"><span class="title">Helwan Univirsity,<br>Helwan</span></li>
                        <li><img class="mailPic" src="icons/mail.png"><a class="mail" href="#"><u>hassalafcih@gmail.com</u></a></li>
                        <li><img class="phonePic" src="icons/telephone.png">+201154713529</li> <!-- Da rakamy haah :D -->
                    </ul>
                </div>              
            </div>
        </div>
    </section>
    <!--*****EYAD**************end footer********************-->