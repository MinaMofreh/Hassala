<!--In this page, assume that the instructor on his courses page, and he clicks on "Make Quiz" button -->
<?php
session_start();
if(isset($_SESSION['instructor'])){
include_once 'includes.html';
include_once 'makQzValidation.php';
include_once realpath(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'initialize.inc.php');
$quizVal = new QuizData();
$quizVal->makQzValidation();
$quizVal->getSheet();
$_SESSION['quiz_title'] = $quizVal->quiz_title;
$_SESSION['quiz_description'] = $quizVal->quiz_description;
$_SESSION['mcq_questions_num'] = $quizVal->mcq_questions_num;
$_SESSION['problems_num'] = $quizVal->problems_num;
//convert date format
$date = date_create($quizVal->quiz_date);
$_SESSION['quiz_date'] = date_format($date, "Y-m-d");
$_SESSION['quiz_duration'] = $quizVal->quiz_duration;
$_SESSION['excel_sheet'] = $quizVal->getSheet();
$_SESSION['quizHeld'] = $quizVal->quizHeld;
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- for internet explorer compatibality-->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!--first mobile meta-->
        <!--[if lt IE 9]>
     <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
     <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
   <![endif]-->

        <link href="https://fonts.googleapis.com/css?family=Josefin+Sans" rel="stylesheet">
        <title>Make Quiz</title>
        <style type="text/css">

            label{
                font-family: 'Josefin Sans';
                font-weight: bolder;
                font-size: 20px;
                display: inline;
                padding-right: 30px;
                margin-left: 80px;
                padding-top:15px;
            }

            .error{
                color: red;
            }

        </style>
    </head>

    <body style="background-color: #e6f3ff;">

        <div class="form-group" style="background-color: #fff; margin: 90px 70px; border-radius: 10px; padding-bottom: 50px;">

            <br>

            <center style = "color: #0000ff; font-size: 25pt;"><h1 style="font-family: 'Josefin Sans'; font-weight: bolder;">Make Quiz</h1></center>
            <hr><br><br>


            <!-- form -->
            <form action="" method="post" enctype="multipart/form-data">



                <label for="title">

                    Quiz Title:

                    <input type="text" name="quiz_title" style="width: 400px; margin-left: 55px;" value="<?php if (isset($_POST['quiz_title'])) {
    echo $_POST['quiz_title'];
} ?>">

                    <span class= "error"><?php echo $quizVal->quiz_tite_error ?></span>

                </label>
                <br><br><br>

                <label>
                    Quiz description:

                    <br>
                    <input type="textarea" name="quiz_describtion" style="margin-left: 80px; width: 1000px; height: 100px; margin-top: 10px;" value="<?php if (isset($_POST['quiz_describtion'])) {
    echo $_POST['quiz_describtion'];
} ?>">

                    <br>
                    <span class="error" style="margin-left: 80px;"><?php echo $quizVal->quiz_description_error; ?></span>
                </label>
                <br><br><br>

                <label for="McqQ">

                    Number of MCQ Questions:
                    <select style="width: 70px; height: 30px; margin-left: 55px;" id="mcqNo" name="mcqNo" value="<?php if (isset($_POST['mcqNo'])) echo $_POST['mcqNo']; ?>">
                        <?php
                        for ($ct = 0; $ct <= 200; $ct++)
                            echo "<option>" . $ct . "</option>";

                        //for keeping the number had been specified
                        $GLOBALS['mcqSelctd'] = $_POST['mcqNo'];
                        ?>
                    </select>

                </label>
                <br><br><br>

                <label for="problem">

                    Number of problem Questions:
                    <select style="width: 70px; height: 30px; margin-left: 55px;" id="problemNo" name="problemNo" value="<?php if (isset($_POST['problemNo'])) echo $_POST['problemNo']; ?>">
                        <?php
                        for ($ct = 0; $ct <= 200; $ct++)
                            echo "<option>" . $ct . "</option>";

                        //for keeping the number had been specified
                        $GLOBALS['problemSelctd'] = $_POST['problemNo'];
                        ?>
                    </select>

                    <br>
                    <span class= "error" style="margin-left: 75px;"><?php echo $quizVal->mcqAndProb_error; ?></span>


                </label>
                <br><br><br>


                <label for="quizDate">

                    Quiz Date:
                    <input type="date" name="quizDate" style="margin-left: 160px;"  value="<?php if (isset($_POST['quizDate'])) {
                            $date = date_create($_POST['quizDate']);
                            echo date_format($date, "Y-m-d");
                        } ?>" min = "<?php echo date('Y-m-d'); ?>">
                    <span class= "error" style="margin-left: 100px;"><?php echo $quizVal->date_error; ?></span>


                </label>
                <br><br><br>

                <label for="quizDuration">

                    Quiz Duration (Hour/Minute/Second):
                    <select style="width: 70px; height: 30px; margin-left: 55px;" id="hour" name="hour" >
                        <?php
                        for ($i = 0; $i <= 24; $i++) {
                            echo "<option>" . $i . "</option>";
                        }

                        $GLOBALS['hourSelctd'] = $_POST['hour'];
                        ?>
                    </select>
                    <select style="width: 70px; height: 30px; margin-left: 55px;" id="minute" name="minute">
                        <?php
                        for ($i = 0; $i <= 59; $i++) {
                            echo "<option>" . $i . "</option>";
                        }

                        $GLOBALS['minuteSelctd'] = $_POST['minute'];
                        ?>
                    </select>
                    <select style="width: 70px; height: 30px; margin-left: 55px;" id="second" name="second">
                        <?php
                        for ($i = 0; $i <= 59; $i++) {
                            echo "<option>" . $i . "</option>";
                        }

                        $GLOBALS['secondSelctd'] = $_POST['second'];
                        ?>
                    </select>
                    <span class= "error" style="margin-left: 70px;"><?php echo $quizVal->duration_error; ?></span>


                </label>
                <br><br><br>


                <label for="excel">

                    Excel Sheet:
                    <br><br>
                    <span style="font-family: 'Josefin Sans'; font-size: 18px; margin-left: 80px; color: #337ab7;">
                        Hint: You have to upload an excel sheet with Student Ids who are allowed to do this quiz with the following form:<br>
                        <text style="margin-left: 80px;">Note: you should only make it in one sheet because we only read the first sheet because of memory consumption</text>
                    </span>

                    <br>

                    <img src="<?php echo $images ?>john_images/student.png" alt = "Example" style="margin: 10px 0 0 80px;">
                    <input type="file" name="excelSheet" style="margin-left: 80px; margin-top: 30px;">

                    <br>
                    <span class="error" style="margin-left: 75px;"><?php echo $quizVal->sheet_error; ?></span> 


                </label>
                <br><br><br>

                <label for="quizHeld" id="heldLabel">

                    Quiz will be held:
                    <p style="margin-left: 80px; color: orange;" >Warning: if you didn't set a time for the quiz. The quiz will be considered to be held all the day </p>

                    <label> Specific Time : <input type="time" name="quizTime"></label> 

                </label>

                <br><br><br>

                <center><button id="fill" type="submit" class="btn btn-info start_button" style="width: 250px;">Start Quiz</button></center> 
                <!--<?php ?>-->

            </form>

            <br><br>

        </div>
        <!-- for keeping values in the drop down lists in page -->
        <script type="text/javascript">

            var mcqSelctd = '<?php echo $GLOBALS['mcqSelctd']; ?>';//value of mcqNo
            var problemSelctd = '<?php echo $GLOBALS['problemSelctd']; ?>';//value of problemNo
            var hourSelctd = '<?php echo $GLOBALS['hourSelctd']; ?>';//value of hours
            var minuteSelctd = '<?php echo $GLOBALS['minuteSelctd']; ?>';//value of minutes
            var secondSelctd = '<?php echo $GLOBALS['secondSelctd']; ?>';//value of seconds



            $(document).ready(function () {

                if (mcqSelctd == '')
                    $('#mcqNo').val('0');
                else
                    $('#mcqNo').val(mcqSelctd);

                if (problemSelctd == '')
                    $('#problemNo').val('0');
                else
                    $('#problemNo').val(problemSelctd);

                if (hourSelctd == '')
                    $('#hour').val('0');
                else
                    $('#hour').val(hourSelctd);

                if (minuteSelctd == '')
                    $('#minute').val('0');
                else
                    $('#minute').val(minuteSelctd);

                if (secondSelctd == '')
                    $('#second').val('0');
                else
                    $('#second').val(secondSelctd);

            })

        </script>

    </body>
</html>
<?php } else {
     header("Location: home.php");
}
?>