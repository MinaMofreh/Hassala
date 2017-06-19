<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Student
 *
 * @author root
 */
include_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'database' . DIRECTORY_SEPARATOR . 'studentQueries.php';
include_once 'ApplicationUser.php';
include_once 'Course.php';
include_once 'Quiz.php';
include_once 'Question.php';
include_once 'Answer.php';
include_once 'TestCase.php';
include_once 'Problem_Quiz.php';
include_once 'student_quiz_problem.php';
include_once 'student_question.php';

class Student extends ApplicationUser {

    public $courses = array();
    public $DB;
    private $college_id;
    private $rate;
    private $qr_code_string;
    private $stu_query; // object from studentqueries class

    public function __construct() {
        $this->DB = new DataBase();
        $this->rate = 0;
        $this->stu_query = new studentQueries();
    }

    public function PartcipateCourse($CourseID, $StudentID) {
        $this->stu_query->JoinCourse($CourseID, $StudentID);
    }

    public function ViewCourse($ID) {
        $this->courses = $this->stu_query->getCourses($ID);
        return $this->courses;
    }

    public function IsPermitted($Student_College_ID, $QuizID) {
        $Qry = "SELECT * FROM `quiz_permitted_students` WHERE `quiz_id` = $QuizID AND `student_college_id` = $Student_College_ID";
        //print_r($this->DB->database_query($Qry) );
        if ($this->DB->database_all_assoc($this->DB->database_query($Qry)) == NULL)
            return FALSE;
        else
            return TRUE;
    }

    public function IsQuized($StudentID, $QuizID) {
        $Qry = "SELECT * FROM `solve_quiz` WHERE `quiz_id` = $QuizID AND `student_id` = $StudentID";
        if ($this->DB->database_all_assoc($this->DB->database_query($Qry)) == NULL)
            return FALSE;
        else
            return TRUE;
    }

    public function AvailableCourses($StudentID) {
        $courses = $this->stu_query->getAvailableCourses($StudentID);
        return $courses;
    }

    public function TakeQuiz($QuizID) {
        /*         * **************
         * 
         * Select Course And Fill Data s
         * 
         * ************** */
        $sql_query = "SELECT * FROM `Quiz` WHERE `quiz_id` = $QuizID";
        $quiz_query = $this->DB->database_query($sql_query);
        $QuzArr = $this->DB->database_all_assoc($quiz_query);

        $Quiz = new Quiz();
        $quiz_id = $QuzArr[0]["quiz_id"];
        $Quiz->id = $quiz_id;
        $Quiz->title = $QuzArr[0]["title"];
        $Quiz->date = $QuzArr[0]["quiz_date"];
        $Quiz->time = $QuzArr[0]["quiz_time"];
        $Quiz->duration = explode(":", $QuzArr[0]["quiz_duration"]);
        $Quiz->description = $QuzArr[0]["description"];
        $Quiz->full_grade = $QuzArr[0]["quiz_full_mark"];
        /*         * **********
         * 
         * Select Questions to this quiz
         * 
         * ************ */

        $QuestionsQ = "SELECT * FROM `Question` WHERE `quiz_id` = $quiz_id;";
        $QuesArr = $this->DB->database_all_assoc(
                $this->DB->database_query($QuestionsQ));
        for ($i = 0; $i < count($QuesArr); $i++) {
            $qst = new Question();
            $QusID = $QuesArr[$i]["question_id"];
            $qst->question_id = $QusID;
            $qst->question_content = $QuesArr[$i]["question_header"];
            $qst->correct_answer = $QuesArr[$i]["question_model_answer"];
            $qst->question_grade = $QuesArr[$i]["question_grade"];
            /*             * *****
             * 
             * Select Answers to this Questions
             * 
             * ***** */
            $ansQu = " SELECT * FROM `question_answers` WHERE `question_id` = $QusID;";
            $AnsArr = $this->DB->database_all_assoc(
                    $this->DB->database_query($ansQu));
            for ($k = 0; $k < count($AnsArr); $k++) {
                $ans = new Answer();
                $ans->answer = $AnsArr[$k]["answer"];
                $ans->count = $AnsArr[$k]["chosen_count"];
                $qst->answers[$k] = $ans;
            }
            $Quiz->questions[$i] = $qst;
        }
        /*         * *********
         *
         * Select Problems for this quiz
         *
         * ********* */
        $ProblemQ = "SELECT * FROM `quiz_problem` WHERE `quiz_id` = $quiz_id;";
        $ProblemArr = $this->DB->database_all_assoc(
                $this->DB->database_query($ProblemQ));
        for ($j = 0; $j < count($ProblemArr); $j++) {
            $problem = new Problem_Quiz();
            $PrblmID = $ProblemArr[$j]["problem_id"];
            $problem->problem_id = $PrblmID;
            $problem->Description = $ProblemArr[$j]["description"];
            $problem->input_format = $ProblemArr[$j]["inputformat"];
            $problem->output_format = $ProblemArr[$j]["outputformat"];
            $problem->grade = $ProblemArr[$j]["problem_grade"];
            /*
             * 
             * Select Test Cases for this problem
             * 
             */
            $TestCaseQuery = "SELECT * FROM `TestCase` WHERE `problem_id` = $PrblmID;";
            $TestCaseArr = $this->DB->database_all_assoc($this->DB->database_query($TestCaseQuery));
            for ($l = 0; $l < count($TestCaseArr); $l++) {
                $Test_Case = new TestCase();
                $Test_Case->input = $TestCaseArr[$l]["input"];
                $Test_Case->output = $TestCaseArr[$l]["output"];
                $problem->test_case[] = $Test_Case;
            }
            $Quiz->problems[] = $problem;
        }

        //Object finally filled
        return $Quiz;
    }

    public function RemoveCourse($param) {
        
    }

    public function DownloadMaterial($param) {
        
    }

    public function JoinContest($param) {
        
    }

    public function RateUniversity($param) {
        
    }

    public function set_college_id($num) {
        $this->college_id = $num;
    }

    public function set_rate($num) {
        return $this->rate = $num;
    }

    public function set_qr_code() {
        $code = $this->get_firstName() . '7sala' . $this->get_lastName() . 'Hsala';
        $this->qr_code_string = md5($code);
    }

    //getters
    public function get_college_id() {
        return $this->college_id;
    }

    public function get_rate() {
        return $this->rate;
    }

    public function SignUp($qrString) {

        $result = $this->stu_query->getStudent($qrString);
        return $result;
    }

    public function Register($Student, $id) {
        $this->stu_query->regester($Student, $id);
    }

    public function validate_regestration($codeForces_handle) {
        if (empty($codeForces_handle)) {
            return True;
        } else {
            return False;
        }
    }

    public function check_username_num($str) {
        $result = $this->stu_query->check_username($str);
        if ($result != 0)
            return False;
        else
            return True;
    }

    public function get_qr_code() {
        return $this->qr_code_string;
    }

    public function Reset_pass($username, $password, $id) {
        return $this->stu_query->reset_pass($username, sha1($password), $id);
    }

    public function login($username, $pass) {
        echo $this->login($username, $pass);
    }

    public function logout() {
        //if(isset($_SESSION['student'])){
        //unset($_SESSION['student']);
        //header('location: Admin.php'); //redirect to login page
        //exit();
        //}
    }

    public function RemarkQuiz($Quiz, $Stdn_Qustn, $Stdn_Prblm, $studentID) {
        $Quiz_Grade = $this->RemarkQuestion($Stdn_Qustn, $Quiz->questions, $Quiz->id) + $this->RemarkProblem($Stdn_Prblm, $Quiz->problems, $Quiz->id);
        $data = array(
            "student_id" => $studentID,
            "quiz_id" => $Quiz->id,
            "student_grade" => $Quiz_Grade
        );
        $this->DB->insert("solve_quiz", $data);
    }

    private function RemarkQuestion($Stdn_Qustn, $Questions, $QuizID) {
        $garde = 0;
        for ($i = 0; $i < count($Questions); $i++) {
            if ($Questions[$i]->$correct_answer == $Stdn_Qustn[$i]->$student_answer) {
                $garde += $Questions[$i]->question_grade;
                $Stdn_Qustn[$i]->question_status = TRUE;
            } else {
                $Stdn_Qustn[$i]->question_status = FALSE;
            }
            $Stdn_Qustn[$i]->question_status = $question_status;
            $data = array(
                "std_id" => $Stdn_Qustn[$i]->student_id,
                "question_id" => $Stdn_Qustn[$i]->question_id,
                "student_answer" => $Stdn_Qustn[$i]->student_answer,
                "question_status" => $Stdn_Qustn[$i]->question_status
            );
            $this->DB->insert("student_question", $data);
        }
        return $grade;
    }

    private function RemarkProblem($Stdn_Prblm, $Problem_Quiz, $QuizID, $studentID) {
        $student_folder = shell_exec("mkdir student_problem/student_$studentID");

        for ($i = 0; $i < count($Problem_Quiz); $i++) {
            $problem_id = $Problem_Quiz[$i]->problem_id;
            shell_exec("mkdir student_problem/problem_$problem_id");
            for ($j = 0; $j < count($Problem_Quiz[$i]->test_case); $j++) {
                $test_case_input = $Problem_Quiz[$i]->test_case[$j]->input . "#";
                $myfile_input = fopen("student_problem/problem_$problem_id/inputfile.txt", "a") or die("Unable to open file");
                fwrite($myfile_input, $test_case_input);
                fclose($myfile_input);
                $test_case_output = $Problem_Quiz[$i]->test_case[$j]->output;
                $myfile_output = fopen("student_problem/problem_$problem_id/outputfile.txt", "a") or die("Unable to open file");
                fwrite($myfile_output, $test_case_output);
                fclose($myfile_output);
            }
        }
        for ($k = 0; $k < count($Stdn_Prblm); $k++) {
            $student_problem_id = $Stdn_Prblm[$k]->problem_id;
            shell_exec("mkdir student_problem/student_$studentID/$student_problem_id");
            $student_code = fopen("student_problem/student_$studentID/$student_problem_id/code.cpp", "w+") or die("Unable to open file");
            $compile_code = $Stdn_Prblm[$i]->student_code;
            fwrite($student_code, $compile_code);
            fclose($student_code);
            $compile_output = shell_exec("g++ /var/www/html/classes/student_problem/student_$studentID/$student_problem_id/code.cpp"
                    . " -o /var/www/html/classes/student_problem/student_$studentID/$student_problem_id/a.out");
            if ($compile_output == NULL) {
                $running_output = shell_exec("LD_PRELOAD=/var/www/html/classes/EasySandbox-master/EasySandbox.so "
                        . "/var/www/html/classes/student_problem/student_$studentID/$student_problem_id/a.out");
                if ($running_output != "Killed") {
                    $test_program_command = "sh student_programs/bashfile.sh /var/www/html/classes/student_problem/problem_$problem_id/inputfile.txt" .
                            "student_problem/student_$studentID/$student_problem_id/a.out" .
                            "/var/www/html/classes/student_problem/student_$studentID/$student_problem_id/program_output.txt";
                    $test_program_output = shell_exec($test_program_command);
                    if ($test_program_output == NULL) {
                        $test_program_results_command = "diff -iwbBZ student_problem/problem_$problem_id/outputfile.txt" .
                                "student_problem/student_$studentID/$student_problem_id/program_output.txt";
                        $test_program_results_output = shell_exec($test_program_results_command);
                        if ($test_program_results_output == NULL) {
                            $Stdn_Prblm[$k]->problem_status = TRUE;
                        } else {
                            $Stdn_Prblm[$k]->problem_status = FALSE;
                        }
                    }
                } else {
                    $Stdn_Prblm[$k]->problem_status = FALSE;
                }
            }
        }
    }

    public function EditProfile($id, $username, $password, $profile_picture) {
        $this->stu_query->updateData($id, $username, $password, $profile_picture);
    }

}
