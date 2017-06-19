<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Instructor
 *
 * @author root
 */
include_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'database' . DIRECTORY_SEPARATOR . 'instructorQueries.php';
include_once 'ApplicationUser.php';

class Instructor extends ApplicationUser {

    //put your code here
    public $position;
    public $degree;
    public $univerity = array();
    public $courses = array();
    private $val;  // object from validator class
    private $fullName;
    private $verificationCode;
    private $inst_query;
    public $DB;
    public function __construct() {
        $this->DB = new DataBase();
        $this->val = new Validator();
        $this->solvedProblems = 0;
        $this->inst_query = new instructorQueries();
    }

    public function CreateCourse($Course, $instructor_id) {
        $this->courses[] = $Course;
        $instID = $instructor_id;
        $course_data = array(
            "course_name" => $Course->name,
            "course_description" => $Course->description,
            "instructor_id" => $instID
        );
        $CourseID = $this->DB->insert("Course", $course_data);
        for ($i = 0; $i < count($Course->materials); $i++) {
            $material_data = array(
                "title" => $Course->materials[$i]->title,
                "path" => $Course->materials[$i]->path,
                "course_matrial_id" => $CourseID
            );
            $materialID = $this->DB->insert("Matrial", $material_data);
            $Course->material[$i]->id = $materialID;
        }
    }

    public function CreateQuiz($Quiz, $CourseID, $InstructorID, $StudentIDs) {
        $this->inst_query->insert_quiz($Quiz, $CourseID, $InstructorID, $StudentIDs);
        
    }

    public function AddTestCase() {
        
    }

    public function DropCourse($CourseName, $InstructorID) {

        /*
         * Get Course ID
         */
        for ($index = 0; $index < count($this->courses); $index++) {
            if ($CourseName == $this->courses[$index]->name)
                $CourseID = $this->courses[$index]->id;
        }

        /*
         * Check If the Course have quizes ....
         */
        $QzsIDsQry = $this->DB->database_query("SELECT * FROM `Quiz` WHERE `course_id` = $CourseID;");
        $QzsIDs_assoc = $this->DB->database_all_assoc($QzsIDsQry);
        $QzsIDs = array();
        $QustnIDs = array();
        $PrblmIDs = array();
        for ($i = 0; $i < count($QzsIDs_assoc); $i++) {
            /*
             * Drop all Question in any quiz in that course..
             */
            $QzsIDs[$i] = $QzsIDs_assoc[$i]["quiz_id"];
            $QutnIDQry = $this->DB->database_query("SELECT * FROM `Question` WHERE `quiz_id` = $QzsIDs[$i];");
            $PrblmIDQry = $this->DB->database_query("SELECT * FROM `quiz_problem` WHERE `quiz_id` = $QzsIDs[$i];");
            $QutnIDs_assoc = $this->DB->database_all_assoc($QutnIDQry);
            $PrblmIDs_assoc = $this->DB->database_all_assoc($PrblmIDQry);
            for ($j = 0; $j < count($QutnIDs_assoc); $j++) {
                $QustnIDs[$j] = $QutnIDs_assoc[$j]["question_id"];
                /*
                 * Drop Students activity in that course
                 */
                $this->DB->database_query("DELETE FROM `student_question` WHERE `question_id` = $QustnIDs[$j];");
                $this->DB->database_query("DELETE FROM `question_answers` WHERE `question_id` = $QustnIDs[$j];");
                $this->DB->database_query("DELETE FROM `Question` WHERE `question_id` = $QustnIDs[$j];");
            }
            /*
             * Drop all problems in any quiz in that course....
             */

            for ($k = 0; $k < count($PrblmIDs_assoc); $k++) {
                $PrblmIDs[$k] = $PrblmIDs_assoc[$k]["problem_id"];
                $this->DB->database_query("DELETE FROM `solve_quiz_problem` WHERE `prob_id` = $PrblmIDs[$k];");
                $this->DB->database_query("DELETE FROM `TestCase` WHERE `problem_id` = $PrblmIDs[$k];");
                $this->DB->database_query("DELETE FROM `quiz_problem` WHERE `problem_id` = $PrblmIDs[$k];");
            }
            $this->DB->database_query("DELETE FROM `solve_quiz` WHERE `quiz_id` = $QzsIDs[$i];");
            $this->DB->database_query("DELETE FROM `quiz_permitted_students` WHERE `quiz_id` = $QzsIDs[$i];");
            $this->DB->database_query("DELETE FROM `Quiz` WHERE `quiz_id` = $QzsIDs[$i];");
        }
        /*
         * Drop any thing have an relation with this course...
         */
        $this->DB->database_query("DELETE FROM `student_course` WHERE `crs_id` = $CourseID;");
        $this->DB->database_query("DELETE FROM `Matrial` WHERE `course_matrial_id` = $CourseID;");
        $this->DB->database_query("DELETE FROM `Course` WHERE `course_id` = $CourseID;");
    }

    public function EditQuiz() {
        
    }

    public function EditCourse($urls, $titles, $course_id) {
        for ($i = 0; $i < count($urls); $i++) {
            $data = array(
                "title" => $titels[$i],
                "path" => $urls[$i],
                "course_matrial_id" => $course_id
            );
            $this->DB->insert("Matrial", $data);
        }
    }

    public function set_verficationCode($var1, $var2) {
        $this->verificationCode = $this->val->GenrateVerificationCode($var1, $var2);
        $this->send_email($this->get_email());
    }

    public function set_fullName($str) {
        $this->fullName = $str;
    }

    public function set_password($str) {
        $this->password = $this->val->hashData($str);
    }

    public function get_fullName() {
        return $this->fullName;
    }

    public function SignUp($instructor) {
        if ($this->inst_query->regester($instructor)) {
            return True;
        } else {
            return False;
        }
    }

    public function login($username, $password) {
        
    }

    public function logout() {
        if (isset($_SESSION['instructor_name'])) {
            unset($_SESSION['instructor_name']);
            header('location: home.php'); //redirect to login page
            exit();
        }
    }

    public function check_username_num($str) {
        $result = $this->inst_query->check_username($str);
        if ($result != 0) {
            return False;
        } else {
            return True;
        }
    }

    public function check_email_num($str) {
        $result = $this->inst_query->check_email($str);
        if ($result != 0) {
            return False;
        } else {
            return True;
        }
    }

    private function send_email($email) {
        $mail = new PHPMailer; // create new object
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'hassalafcih@gmail.com';                 // SMTP username
        $mail->Password = '20150156';                           // SMTP password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('from@example.com', 'Hsala');
        $mail->addAddress($email, 'Joe User');     // Add a recipient
        $mail->addReplyTo('hassalafcih@gmail.com', 'Admin');
        $mail->addCC('cc@example.com');
        $mail->addBCC('bcc@example.com');


        $mail->isHTML(true);                                  // Set email format to HTML

        $mail->Subject = 'Welcome, Dr/' . $this->fullName;
        $mail->Body = 'Welcome to <b>Hsala</b> course management community<br> 
                      <b>Verification code:</b>' . $this->verificationCode . '//sitelink ';

        if (!$mail->send()) {
            return True;
        } else {
            return False;
        }
    }

    public function Reset_pass($username, $password, $id) {
        
    }
    public function ViewCourses($instructor_id){
        return $this->inst_query->ViewInstructorCourses($instructor_id);
    }

}
