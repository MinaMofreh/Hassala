<?php

include_once realpath(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'initialize.inc.php');
session_start();

$GLOBALS['quiz'] = new Quiz();
$GLOBALS['qust'] = null;
$GLOBALS['problem'] = null;
$GLOBALS['test_case'] = null;
if (!isset($_SESSION['problem_array'])) {
    $_SESSION['problem_array'] = array();
}
if (!isset($_SESSION['question_array'])) {
    $_SESSION['question_array'] = array();
}
//to count mcq
if (!isset($_SESSION['mcq_counter'])) {
    $_SESSION['mcq_counter'] = 0;
}
//to count problem
if (!isset($_SESSION['problem_counter'])) {
    $_SESSION['problem_counter'] = 0;
}
//to calculate full grade
if (!isset($_SESSION['full_grade'])) {
    $_SESSION['full_grade'] = "0";
}


$mcq_questions_num = $_SESSION['mcq_questions_num'];  // i will take it's real value from john's page. (i'll just assume a value)
$problem_questions_num = $_SESSION['problems_num'];  // i will take it's real value from john's page. (i'll just assume a value)


/* fill quiz object */
$GLOBALS['quiz']->title = $_SESSION['quiz_title'];
$GLOBALS['quiz']->description = $_SESSION['quiz_description'];
$GLOBALS['quiz']->date = $_SESSION['quiz_date'];
$GLOBALS['quiz']->duration = $_SESSION['quiz_duration'];

if ($_SESSION['quizHeld'] == "") {
    $GLOBALS['quiz']->type = 1;
} else {
    $GLOBALS['quiz']->type = 0;
    $GLOBALS['quiz']->time = $_SESSION['quizHeld'];
}

class mcq_problem_validation {

    public $question_title;
    public $answer_A;
    public $answer_B;
    public $answer_C;
    public $answer_D;
    public $answer_E;
    public $correct_answer;
    public $question_grade;
    public $problem_content;
    public $input_test_case;
    public $output_test_case;
    public $output_counter; //to test if No of input format are equal to No of output format
    public $input_counter;
    public $input_format;
    public $output_format;
    public $problem_grade;
    public $question_title_error;
    public $answer_error;
    public $question_grade_error;
    public $error_counter = 0;
    public $problem_content_error;
    public $input_test_case_error;
    public $output_test_case_error;
    public $problem_grade_error;
    public $input_format_error;
    public $output_format_error;
    public $mcq_error_counter = 0;

    public function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

//mcq validation
    public function mcq_validation() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            //mcq questions validation

            if (empty($_POST["question_title"])) {
                $this->question_title_error = "This field is required";
                $this->mcq_error_counter++;
            } else {
                $this->question_title = $this->test_input($_POST["question_title"]);
            }

            //if true and false question.

            if (empty($_POST["answer_A"]) || empty($_POST["answer_B"])) {
                $this->answer_error = "Please fill A and B at least.";
                $this->mcq_error_counter++;
            } else {
                $this->answer_A = $this->test_input($_POST["answer_A"]);
                $this->answer_B = $this->test_input($_POST["answer_B"]);
                $this->answer_C = $this->test_input($_POST["answer_C"]);
                $this->answer_D = $this->test_input($_POST["answer_D"]);
                $this->answer_E = $this->test_input($_POST["answer_E"]);
            }

            if (isset($_POST['correct_answer'])) {
                $this->correct_answer = $this->test_input($_POST["correct_answer"]);
            }

            if (empty($_POST["question_grade"])) {
                $this->question_grade_error = "This field is required";
                $this->mcq_error_counter++;
            } else {
                if ($_POST['question_grade'] <= 0) {
                    $this->question_grade_error = "Only positive numbers allowed";
                    $this->mcq_error_counter++;
                } else {
                    $this->question_grade = $this->test_input($_POST["question_grade"]);
                }
            }

            if ($this->mcq_error_counter == 0) {

                if (isset($_POST['confirm_question'])) {

                    $_SESSION['mcq_counter'] ++;
                }
                $GLOBALS['qust'] = new Question();
                $GLOBALS['qust']->question_content = $this->question_title;
                $GLOBALS['qust']->answers[0] = $this->answer_A;
                $GLOBALS['qust']->answers[1] = $this->answer_B;
                $GLOBALS['qust']->answers[2] = $this->answer_C;
                $GLOBALS['qust']->answers[3] = $this->answer_D;
                $GLOBALS['qust']->answers[4] = $this->answer_E;
                $GLOBALS['qust']->correct_answer = $this->correct_answer;
                $GLOBALS['qust']->question_grade = $this->question_grade;

                $_SESSION['question_array'][] = $GLOBALS['qust'];
            }
            $this->div_checker();
        }
    }

//problem validation
    public function problem_validation() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            //problem questions validation

            if (empty($_POST["problem_content"])) {
                $this->problem_content_error = "This field is required";
                $this->error_counter++;
            } else {
                $this->problem_content = $this->test_input($_POST["problem_content"]);
            }

            if (empty($_POST['input_format'])) {
                $this->input_format_error = "This field is required";
                $this->error_counter++;
            } else {
                $this->input_format = $_POST['input_format'];
            }

            if (empty($_POST['output_format'])) {
                $this->output_format_error = "This field is required";
                $this->error_counter++;
            } else {
                $this->output_format = $_POST['output_format'];
            }

            if (empty($_POST["input_test_case"])) {
                $this->input_test_case_error = "This field is required";
                $this->error_counter++;
            } else {
                $this->input_test_case = $this->test_input($_POST["input_test_case"]);
                $this->input_counter = count(explode("#", $this->input_test_case));
            }

            if (empty($_POST["output_test_case"])) {
                $this->output_test_case_error = "This field is required";
                $this->error_counter++;
            } else {
                $this->output_test_case = $this->test_input($_POST["output_test_case"]);
                $this->output_counter = count(explode("#", $this->output_test_case));
            }

            //check if No of input equal No of output   
            if ($this->input_counter != $this->output_counter) {
                $this->input_test_case_error = "Number of input doesn't equal Number of ouput";
                $this->output_test_case_error = "Number of input doesn't equal Number of ouput";
                $this->error_counter++;
            }

            if (empty($_POST["problem_grade"])) {
                $this->problem_grade_error = "This field is required";
                $this->error_counter++;
            } else {
                $this->problem_grade = $this->test_input($_POST["problem_grade"]);
                if (!preg_match("/^(?![0.]+$)\d+(\.\d{1,2})?$/", $this->problem_grade)) {
                    $this->problem_grade_error = "Only positive numbers allowed";
                    $this->error_counter++;
                }
            }


            if ($this->error_counter == 0) {

                if (isset($_POST['confirm_problem'])) {

                    $_SESSION['problem_counter'] ++;
                }
                $GLOBALS['problem'] = new Problem_Quiz();
                $GLOBALS['problem']->Description = $this->problem_content;
                $GLOBALS['problem']->input_format = $this->input_format;
                $GLOBALS['problem']->output_format = $this->output_format;
                $GLOBALS['problem']->grade = $this->problem_grade;
                $this->get_test_cases();
                $_SESSION['problem_array'][] = $GLOBALS['problem'];
            }
            $this->div_checker();
        }
    }

    //done
    public function get_test_cases() {
        $input = array();
        $output = array();
        $input = explode("#", $this->input_test_case);
        $output = explode("#", $this->output_test_case);

        for ($ct = 0; $ct < count($input); $ct++) {
            $GLOBALS['test_case'] = new TestCase();
            $GLOBALS['test_case']->input = $input[$ct];
            $GLOBALS['test_case']->output = $output[$ct];
            $GLOBALS['problem']->test_case[$ct] = $GLOBALS['test_case'];
        }
    }

    //done
    public function div_checker() {
        if ($_SESSION['mcq_counter'] >= $_SESSION['mcq_questions_num']) {
            echo '<script>$(document).ready(function () {$("#mcq_div").hide();})</script>';
        }
        if ($_SESSION['problem_counter'] >= $_SESSION['problems_num']) {
            echo '<script>$(document).ready(function () {$("#problem_div").hide();})</script>';
        }
    }

    //to fill database
    public function submit_quiz() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['submit_quiz_btn'])) {
                if (($_SESSION['mcq_counter'] == $_SESSION['mcq_questions_num']) && ($_SESSION['problem_counter'] == $_SESSION['problems_num'])) {
                    //create quiz in database
                    //make all questions in quiz object
                    for ($ct = 0; $ct < count($_SESSION['question_array']); $ct++) {
                        if (!empty($_SESSION['question_array'])) {
                            $_SESSION['full_grade'] += $_SESSION['question_array'][$ct]->question_grade;
                        }
                        if (!empty($_SESSION['problem_array'])) {
                            $_SESSION['full_grade'] += $_SESSION['problem_array'][$ct]->grade;
                        }
                    }
                    $GLOBALS['quiz']->questions = $_SESSION['question_array'];
                    $GLOBALS['quiz']->problems = $_SESSION['problem_array'];
                    $GLOBALS['quiz']->full_grade = $_SESSION['full_grade'];
                    $ins = new Instructor();
                    $ins->CreateQuiz($GLOBALS['quiz'], $_SESSION['quiz_course_id'], $_SESSION['instructor_id'], $_SESSION['excel_sheet']);
                    return TRUE;
                } else {
                    return FALSE;
                }
            }
        }
    }

}
