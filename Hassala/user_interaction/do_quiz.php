<?php
session_start();
include_once 'includes' . DIRECTORY_SEPARATOR . 'studentnav.inc.php';
include_once 'includes.html';
include_once realpath(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'initialize.inc.php');
if ($_SESSION['student']) {
    if (!isset($_SESSION['student-question-answer'])) {
        $_SESSION['student-question-answer'] = array();
    }
    if (!isset($_SESSION['student-problem-answer'])) {
        $_SESSION['student-problem-answer'] = array();
    }
    $student_question_answer = array();
    $student_problem_answer = array();
    $student = new Student();
    $_SESSION['student_id'] = "20150153";
    $QUIZ = new Quiz();
    $quiz_id = $_POST['quiz_id'];
    $QUIZ = $student->TakeQuiz($quiz_id);

    // -------------------------------------
    //defines the question number in quesitons array
    $question_number = 0;
    //total number of questions in the array
    $number_of_questions = count($QUIZ->questions);
    //defines the problem number in problems array
    $problem_number = 0;
    //total number of problem in the array
    $number_of_problems = count($QUIZ->problems);
    //questions tracker to tell student which question is he solving ATM
    $question_tracker = 1;
    //total numbers of questions ( questions + problems )
    $total_number_of_questions = $number_of_problems + $number_of_questions;
    //total number of questions which are answered
    $total_attempts = 0;
    if (isset($_POST['submit-quiz'])) {
        if (isset($_POST['radio'])) {
            if ($_SESSION['student-question-answer'][(count($QUIZ->questions)-1)]->student_answer != null){
                $_SESSION['student-question-answer'][(count($QUIZ->questions)-1)]->student_answer = $_POST['radio'];
            }
        } else {
            if ($_SESSION['student-problem-answer'][(count($QUIZ->questions)-1)]->student_code != null){
                $_SESSION['student-problem-answer'][(count($QUIZ->questions)-1)]->student_code = $_POST['student_code'];
            }
        }
            $student->RemarkQuiz($QUIZ, $_SESSION['student-question-answer'], $_SESSION['student-problem-answer'], $_SESSION['student_id']);
    }
    ?>
    <!DOCTYPE html>
    <html>
        <head>
            <script src="<?php echo $js; ?>tinymce/js/tinymce/tinymce.min.js"></script>
            <script src="<?php echo $js; ?>tinymce/js/tinymce/jquery.tinymce.min.js"></script>
            <title>EXAMINATION FORM</title>
            <noscript>
        <center><h1>Turning JavaScript on is a must to do this quiz!</h1></center>
        <style>div {display:none;}</style>
        </noscript>
        <?php
        echo '<script type="text/javascript">timer=' .  ( $QUIZ->duration[1]*60 ). '</script>';
        ?>
        <script>
            window.onload = setTimeout(function () {

            },<?php echo (60) * 1000; ?>)
        </script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="<?php echo $css; ?>do_quiz_css/do_quiz_stylesheet.css">
        <script src="<?php echo $js; ?>do_quiz_js/countdown.js"></script>
        <script src="<?php echo $js; ?>do_quiz_js/on_active.js"></script>
        <script src="<?php echo $js; ?>do_quiz_js/buttons_script.js"></script>
    </head>
    <body onload="submit_quiz()">
        <!--  Content Area-->
        <div class="container">
            <h1>EXAMINATION FORM <small>powered by Hassala FCI | All rights reserved</small></h1>
            <hr>
            <h4 style="text-decoration: underline;"><center><?php echo $QUIZ->title; ?></center></h4>
            <p style="color:red;"><strong>CAUTION:</strong> Switching to any other tab than <strong>quiz's</strong> tab will be considered as cheating and your answers will be submitted automatically.</p>
            <h5>Quiz Description:</h5> 
            <!------- QUIZ DESCRIPTION ----->
            <div class="row">
                <div class="col-sm-8">
                    <pre><?php echo $QUIZ->description; ?></pre>
                    <!--------- Countdown Timer ----->
                    <div id='timer'>
                        <script src="<?php echo $js; ?>do_quiz_js/do_quiz_timer.js" type="text/javascript"></script>      
                    </div>
                    <!-------------------------------->
                </div>
                <!----QUIZ GRADE ----------->
                <div class = "col-sm-4">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Full Grade</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <?php echo $QUIZ->full_grade; ?> Marks
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!---------- Quiz Form ------->
            <form action="" method="POST" role="form" id="quiz-form">
                <!---------Filling QUIZ questions---->
                <div id="design-indent">
                    <div id="question-form">
                        <?php
                        if ($question_number < $number_of_questions) {
                            //<!----- Question Header & Grade-->                           
                            ?>
                            <div class="row">
                                <div class="col-sm-8">
                                    <h5>Question #<?php echo $question_number + 1; ?></h5>
                                    <h5><pre><?php echo $QUIZ->questions[$question_number]->question_content; ?></pre></h5>
                                </div>
                                <div class="col-sm-4">
                                    <h5>Grade : <?php echo $QUIZ->questions[$question_number]->question_grade; ?> Marks</h5>
                                </div>
                            </div>
                            <input type="hidden" id="question-id" value="<?php echo $QUIZ->questions[$question_number]->question_id; ?>">
                            <?php
                            $answers_count = count($QUIZ->questions[$question_number]->answers);
                            ?> 
                            <!--- Beginning of input radio buttons--->
                            <div class="input-group">
                                <?php
                                for ($i = 0; $i < $answers_count; $i++) {
                                    echo '<label class="radio-inline">
                            <input type="radio" id="choose" name="optradio" value="' .
                                    $QUIZ->questions[$question_number]->answers[$i]->answer . '">';
                                    if ($QUIZ->questions[$question_number]->answers[$i]->answer != null) {
                                        echo $QUIZ->questions[$question_number]->answers[$i]->answer;
                                    }
                                    echo '</label><br>';
                                }
                                echo '</div>';
                            } elseif ($number_of_problems != 0) {
                                //Problem Info
                                ?> 
                                <div class="row">
                                    <div class="col-sm-8">
                                        <h5>Problem #<?php echo $problem_number + 1; ?></h5>
                                        <strong><pre><?php echo $QUIZ->problems[$problem_number]->Description; ?></pre></strong>
                                    </div>
                                    <div class="col-lg-4">
                                        <h5>Grade : <?php echo $QUIZ->problems[$problem_number]->grade; ?> Marks</h5>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input-format">Input format:</label>
                                    <p id="input-format"><?php echo $QUIZ->problems[$problem_number]->input_format; ?></p>
                                    <label for="input-format">Output format:</label>
                                    <p id="input-format"><?php echo $QUIZ->problems[$problem_number]->output_format; ?></p>
                                </div>
                                <?php
                                // Input & Output Examples
                                $testCasesCount = count($QUIZ->problems[$problem_number]->test_case);
                                for ($x = 0; $x < $testCasesCount; $x++) {
                                    echo '<label for="exampleInput">Example Input:</label>
                            <pre id="exampleInput">' . $QUIZ->problems[$problem_number]->test_case[$x]->input . '</pre>
                                <label for="exampleOutput">Example Output:</label>
                            <pre id="exampleOutput">' . $QUIZ->problems[$problem_number]->test_case[$x]->output . '</pre>';
                                    if ($testCasesCount > 1) {
                                        echo '<hr>';
                                    }
                                }
                                ?>
                                <label for="select-coding-language">Coding Language:</label>
                                <select class="selectpicker" id="select-coding-language">
                                    <option>GNU GCC</option>
                                    <option>GNU G++</option>
                                </select>
                                <!--------------------------------->
                                <br>
                                <!----Answering problem text area-->
                                <label for="exampleTextarea">Please copy your code into the following textarea</label>
                                <textarea class="form-control" id="exampleTextarea" rows="30" style="resize:none;font-family: courier new;" name="student_code"></textarea>
                                <input type="hidden" id="problem-id" value="<?php echo $QUIZ->problems[$problem_number]->problem_id; ?>">
                                <!-- ------------------------------------->
                                <?php
                            }
                            ?>
                        </div>
                        <!--------------------------------->
                        <br>
                        <!------NEXT & PREVIOUS Buttons --->
                        <button disabled="disabled" type="button" class="previous btn btn-primary" onclick="get_previous_question()">Previous</button> 
                        <?php
                        if ($total_number_of_questions == 1 || $total_number_of_questions == 0) {

                            echo '<button disabled="disabled" type="button" class="next btn btn-primary" onclick="get_next_question()">Next</button>';
                        } else {
                            echo '<button type="button" class="next btn btn-primary" onclick="get_next_question()" name="next-button">Next</button>';
                        }
                        ?>
                        <!-------------------------->
                        <br>
                        <br>
                        <!------------------------->
                        <!---Questions Information --->
                        <div id="question-data">
                            <code>Question <?php echo $question_tracker; ?> of <?php echo $total_number_of_questions ?></code>
                            <br>
                            <code>Total Attempts : <?php echo $total_attempts; ?></code><br>
                        </div>
                        <!---------------------->
                    </div>
                    <!---- Submit Button --->
                    <button type="submit" class="btn btn-primary" id="submit-button" name="submit-quiz" onclick="submit_wanring()">I'M DONE, SUBMIT TEST</button>
                    <p id="caution-paragraph">Do not go to any other page, your data may be lost!</p>       
                </div>
                <!----- End of form ------>
            </form>
        </div>
    </body>
    <input type="hidden" id="last_q" value="1">
    <input type="hidden" id="course_name" value="<?php echo $quiz_id; ?>">
    <input type="hidden" id="count" value="<?php echo $number_of_questions; ?>">
    <input type="hidden" id="last_p" value="1">
    <input type="hidden" id="total_questions" value="<?php echo $total_number_of_questions; ?>">
    <input type="hidden" id="question_tracker" value="<?php echo $question_tracker + 1; ?>">
    <input type="hidden" id="total_attempts" value="0">
    <input type="hidden" id="count_problems" value="<?php echo $number_of_problems; ?>">
    <input type="hidden" id="student_id" value="<?php echo $_SESSION['student_id']; ?>">
    </html>
    <?php
    include_once 'templates' . DIRECTORY_SEPARATOR . 'footer' . DIRECTORY_SEPARATOR . 'footer.inc.php';
} else {
    header("Location: index.php");
    exit();
}    