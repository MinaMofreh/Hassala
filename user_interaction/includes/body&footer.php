 <!-- start genrate statisitics -->
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
            google.charts.load('current', {'packages': ['corechart']});
            google.charts.setOnLoadCallback(drawChart);
            function drawChart() {
                var data = google.visualization.arrayToDataTable(<?php echo $result; ?>);

                var options = {
                    title: 'Problem solving statisitics for each Univirsity.',
                    is3D: true,
                };
                var chart = new google.visualization.PieChart(document.getElementById('piechart'));
                chart.draw(data, options);
            }
        </script>
        <!-- end genrate statisitics -->
    <!--********************** start slider******************-->
   <body>
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
                       <img width="100%" src="../images/mina_images/p1.jpeg" alt="BOOKS"/>
                    </div>
                    
                      <div class="item">
                       <img width="100%" src="../images/mina_images/p2.jpeg" alt="Professors"/>
                    </div>
                    
                    <div class="item">
                       <img width="100%" src="../images/mina_images/p56.jpeg" alt="online judge"/>
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
          </div>
      </body>
    <!--********************** end lsider********************-->
    <!--generate statistics-->
      <div class="row">
            <div class="col-md-6 stat" id="piechart"></div>
            <hr>
        </div>
     <!--end generate statistics-->
    <!--*****EYAD************** start footer*****************-->
    <!-- Start the footer-->
<!DOCTYPE html>
<html lang="en">

<head>
  <link href="https://fonts.googleapis.com/css?family=Josefin+Sans" rel="stylesheet">
</head>

<body>
    <!--Top rated, Contests, Courses, Quizzes, Profile, Statistics -->
      <section class="footer">
        <div class="container">
          <div class="row">
            <div class="col-md-4">
              <h3 class="logo"><a href="#">حَصَّالة</a></h3>
              <br>
              <ul class="list-unstyled social-list">
                <li><a href="#"><img class="socialMedia" src="../icons/1489085056_social-facebook-circle.png"></a></li>
                <li><a href="#"><img class="socialMedia" src="../icons/1489085120_twitter.png"></a></li>
                <li><a href="#"><img class="socialMedia" src="../icons/1489085185_youtube.png"></a></li>
                <li><a href="#"><img class="socialMedia" src="../icons/1489085390_google_circle.png"></a></li>
                <li><a href="#"></a></li>
              </ul>
              <br>
              <a href="#">Home</a> . <a href="about us.html">About Us</a> . <a href="#">Contact Us</a>
            </div>  
            <div class="col-md-4">
            <h3 class="sitemap">Sitemap</h3>
              <ul class="list-unstyled">
                <li style="margin-bottom: 25px;"><a href="#"><img src="../icons/science-teacher.jpg" alt="courses" style="margin-bottom: 10px; margin-right: 20px; width: 60px; height: 60px; border-radius: 5px;"><span style="font-family: 'Josefin Sans'; font-size: 20px;">Courses</span></a></li>
                <li><a href="#"><img src="../icons/problems.jpg" alt="Problemset" style=" margin-right: 20px;width: 60px; height: 60px; border-radius: 5px;"><span style="font-family: 'Josefin Sans'; font-size: 20px;">Problemset</span></a></li>
              </ul>
              <br><br><br>
              <center><p class="copyrights">All rights are not Reserved <span class="copyleft">&copy;</span></p></center>

            </div>
              
            
            <div class="col-md-4">
              <h3 class="visitus">Visit us</h3>
              <br>
              <ul class="list-unstyled visit">
                <li><img class="locationPic" src="../icons/maps-placeholder-outlined-tool.png" alt="location-icon"><span class="title">Helwan Univirsity,<br>Helwan</span></li>
                <li><img class="mailPic" src="../icons/mail.png" alt="mail-icon"><a class="mail" href="#"><u>hassalafcih@gmail.com</u></a></li>
                <li><img class="phonePic" src="../icons/telephone.png" alt="phone-icon">+201154713529</li> <!-- Da rakamy haah :D -->
              </ul>
            </div>
              
          </div>
        </div>
      </section>
      <!-- End the footer-->
      </body>
    <!--*****EYAD**************end footer********************-->

    </html>