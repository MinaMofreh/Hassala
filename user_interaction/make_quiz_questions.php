<!--In this page, assume that the instructor on his courses page, and he clicks on "Make Quiz" button -->
<?php
if (isset($_SESSION['instructor'])){
include_once "validate_quiz_questions.php";
include_once 'includes.html';
$val = new mcq_problem_validation();
$val->mcq_validation();
$val->problem_validation();
$val->div_checker();
if($val->submit_quiz()){
    header("Location: add_course_inst.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <!--to make java script on during making quiz-->
        <noscript>
            <h1>you have to turn on java script</h1>
            <style>div {display :none;}</style>
        </noscript>

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
        <style type="text/css">
            .error {color: #FF0000;}
        </style>
        <title>Make Quiz</title>
    </head>
<body style="background-color: #e6f3ff;">

    <!--<?php
    echo $GLOBALS['quiz']->title . '<br>';
    echo $GLOBALS['quiz']->description . '<br>';
    echo $mcq_questions_num . '<br>';
    echo $problem_questions_num . '<br>';
    echo $GLOBALS['quiz']->date . '<br>';
    echo $GLOBALS['quiz']->duration . '<br>';
    echo $GLOBALS['quiz']->time . '<br>';
    print_r($_SESSION['excel_sheet']);
    ?>-->
    <div class="container makeQuiz_container" style="padding-top: 20px; background-color: #fff; margin: 90px 70px; border-radius: 10px;padding-bottom: 50px;">

        <br><br>
        <div class="mcqQuestion" style="border: solid 1px #337ab7; border-radius: 15px; margin: 20px;padding: 10px; font-family: 'Josefin Sans'; font-size: 18px;" id="mcq_div">
             <br>
            <h4 style="display: inline-block;"><strong>Question content:</strong></h4>
            <form method="post" action="">
                <input type="textarea" name="question_title"
                       style="width: 1050px; height: 50px; resize: none; display: inline-block;">
                <br>
                <span class= "error"><?php echo $val->question_title_error; ?></span>
                <br><br>
                <h4><strong>Answers:</strong></h4>
                <span>A:</span>
                <input type="text" name="answer_A" style="width: 300px; height: 25px;">
                <span style="margin-left: 50px;">B:</span>
                <input type="text" name="answer_B" style="width: 300px; height: 25px;">
                <span style="margin-left: 50px;">C:</span>
                <input type="text" name="answer_C" style="width: 300px; height: 25px;">
                <br><br>
                <span>D:</span>
                <input type="text" name="answer_D" style="width: 300px; height: 25px;">
                <span style="margin-left: 50px;">E:</span>
                <input type="text" name="answer_E" style="width: 300px; height: 25px;">
                <br>
                <span class= "error"><?php echo $val->answer_error; ?></span>
                <!-- E is not required -->
                <br><br><br>
                <h4 style="display: inline; margin-right: 20px;"><strong>Correct answer:</strong></h4>
                <select name="correct_answer" style="width: 80px; height:30px;">
                    <option>A</option>
                    <option>B</option>
                    <option>C</option>
                    <option>D</option>
                    <option>E</option>
                </select>
                <h4 style="display: inline; margin-left: 80px; margin-right: 20px;"><strong>Question Grade:</strong></h4>
                <input type="text" name="question_grade" placeholder="Grade" style="width: 70px; height: 30px;">
                <span class="error"><?php echo $val->question_grade_error; ?></span>
                <button type="Submit" value="mcq" class="btn btn-primary confirm_question" name="confirm_question" style="margin-left: 180px; width: 160px; height: 45px;"onclick="update_question()"><strong>Next Question</strong></button>
            </form>
        </div>


        <br><br>

        <div class="problemQuestion" style="border: solid 1px #337ab7; border-radius: 15px;
             margin: 20px; padding: 10px;" id="problem_div">
            <form action="" method="post">

                <h4>Problem content:</h4>
                <textarea name="problem_content" style="width: 1000px; height: 300px; resize: none;"></textarea>
                <br>
                <span class="error"><?php echo $val->problem_content_error; ?></span> <br><br>
                <label>Input Format: <input type="text" name="input_format" style="margin-left: 12px;"></label>
                <span class="error"><?php echo $val->input_format_error; ?></span>
                <br><br>
                <label>Output Format: <input type="text" name="output_format"></label>
                <span class="error"><?php echo $val->input_format_error; ?></span>
                <h4>Test cases:</h4>
                <div class="testCases">
                    <span style="color: blue; font-weight: bold; font-size: 17px;">Hint: every input and output is followed by #</span><br>
                    <span style="color: red; font-weight: bold; font-size: 17px;">Example: 1#2#3#4</span>
                    <div>
                        <h5>Inputs:</h5>
                        <textarea name="input_test_case" style="width: 400px; height: 100px; resize: none;"></textarea>
                        <br>
                        <span class="error"><?php echo $val->input_test_case_error; ?></span>
                    </div>
                    <div>
                        <h5>Outputs:</h5>
                        <textarea name="output_test_case" style="width: 400px; height: 100px; resize: none; display: inherit;"></textarea>
                        <span class="error"><?php echo $val->output_test_case_error; ?></span>
                    </div>
                    <br><br>
                </div>
                <br><br>
                <h4 style="display: inline; margin-left: 10px; margin-right: 20px;">Question Grade: </h4>
                <input type="text" name="problem_grade" placeholder="Grade" style="width: 70px; height: 30px;">
                <span class="error"><?php echo $val->problem_grade_error; ?></span>
                <button type="Submit" value="problem"class="btn btn-primary" name="confirm_problem" id="problem_button"
                        style="margin-left: 680px; width: 160px; height: 45px;" onclick="update_problem();">Submit</button>

            </form>
        </div>




        <form action="" method="post" value="complete">
            <center><button type="submit" id="quiz_button" value="complete"class="btn btn-danger submit_quiz_btn" name="submit_quiz_btn"
                        style="width: 400px;">Submit Quiz!</button></center>
        </form>
    </div>
    
</body>
<script type="text/javascript">
    var mcqNo = '<?php echo $mcq_questions_num; ?>';//value of mcqNo
    var problemNo = '<?php echo $problem_questions_num; ?>';//value of problemNo
    var problem_counter = 0;
    var mcq_counter = 0;
    
    $(document).ready(function () {
        
        if(mcqNo == 0){
            $("#mcq_div").hide();
        }
        if(problemNo == 0){
            $("#problem_div").hide();
        }
        
    })
</script>
</html>
<?php } else {
    header("Location: home.php");
}
?>

