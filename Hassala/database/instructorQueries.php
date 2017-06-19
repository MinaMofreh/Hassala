<?php

include_once realpath(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'initialize.inc.php');

class instructorQueries {

    private $db;

    public function __construct() {

        $this->db = new DataBase();
    }

    public function regester($instructor) {
        $data = array(); // to hold instructor table data
        $data1 = array(); // to hold user table data 
        $data2 = array(); // to hold instructor id and univeristy
        $data['instructor_fname'] = $instructor->get_fullName();
        $data['solved_problems'] = $instructor->get_solvedProblems();
        $data['email'] = $instructor->get_email();
        $data['cf_handle'] = $instructor->get_codeForces_handle();
        $data['profile_photo'] = $instructor->get_image_path();
        $userName = $instructor->get_username();
        $password = $instructor->get_password();
        $result = $this->db->insert('Instructor', $data);
        echo $result;

        if ($result) {
            $id = $result;
            $data1['instructor_id'] = $id;
            $data1['user_name'] = $userName;
            $data1['password'] = $password;
            $data1['type'] = 1;

            $res = $this->db->insert('Users', $data1);

            $data2['university_name'] = $instructor->get_university();
            $data2['inst_id'] = $id;
            $return = $this->db->insert('Instructor_university', $data2);
            if ($return)
                echo 'done';
            else
                echo 'fail';
            return TRUE;
        }
        else {
            return FALSE;
        }
    }

    public function check_username($str) {
        $result = $this->db->check_rows('Users', 'user_name', $str);
        return $result;
    }

    public function check_email($str) {
        $result = $this->db->check_rows('Instructor', 'email', $str);
        return $result;
    }

    public function insert_quiz($Quiz, $CourseID, $InstructorID, $StudentIDs) {
        $quiz_data = array(
            "instructor_id" => $InstructorID,
            "course_id" => $CourseID,
            "title" => $Quiz->title,
            "quiz_date" => $Quiz->date,
            "quiz_time" => $Quiz->time,
            "quiz_duration" => $Quiz->duration,
            "description" => $Quiz->description,
            "quiz_full_mark" => $Quiz->full_grade,
            "type" => $Quiz->type
        );
        $QuizID = $this->db->insert("Quiz", $quiz_data);
        if ($QuizID != FALSE) { //Check that Quiz inserted
            $Quiz->id = $QuizID;
            /*
             * insert Questions and there answers
             */
            for ($i = 0; $i < count($Quiz->questions); $i++) {
                /*
                 * insert every Question data in quiz
                 */
                $Question = $Quiz->questions[$i];
                $question_data = array(
                    "question_header" => $Quiz->questions[$i]->question_content,
                    "question_model_answer" => $Quiz->questions[$i]->correct_answer,
                    "quiz_id" => $QuizID,
                    "question_grade" => $Quiz->questions[$i]->question_grade
                );
                $QuestionID = $this->db->insert("Question", $question_data);

                if ($QuestionID != FALSE) {//check that Question inserted
                    $Quiz->questions[$i]->question_id = $QuestionID;
                    for ($j = 0; $j < count($Quiz->questions[$i]->answers); $j++) {
                        /*
                         * insert every answer data 
                         */
                        $Answer = $Quiz->questions[$i]->answers[$j];
                        $answer_data = array(
                            "question_id" => $QuestionID,
                            "answer" => $Quiz->questions[$i]->answers[$j],
                            "chosen_count" => 0
                        );
                        $answerID = $this->db->insert("question_answers", $answer_data);
                    }
                }
            }
            /*
             * insert Problems and there test cases
             */
            for ($k = 0; $k < count($Quiz->problems); $k++) {
                /*
                 * insert every Problem data in quiz
                 */
                $Problem = $Quiz->problems[$k];
                $problem_data = array(
                    "description" => $Problem->Description,
                    "inputformat" => $Problem->input_format,
                    "outputformat" => $Problem->output_format,
                    "quiz_id" => $QuizID,
                    "problem_grade" => $Problem->grade
                );
                $ProblemID = $this->db->insert("quiz_problem", $problem_data);
                if ($ProblemID != FALSE) {//check Problem inserted
                    $Problem->problem_id = $QuestionID;
                    for ($l = 0; $l < count($Problem->test_case); $l++) {
                        /*
                         * insert every testcase data 
                         */
                        $TC = $Problem->test_case[$l];
                        $test_case_data = array(
                            "input" => $TC->input,
                            "output" => $TC->output,
                            "problem_id" => $ProblemID
                        );
                        $TCID = $this->db->insert("TestCase", $test_case_data);
                    }
                }
            }
            for ($h = 2; $h < count($StudentIDs) + 2; $h++) {

                $data = array(
                    "quiz_id" => $QuizID,
                    "student_id" => $StudentIDs[$h]
                );
                $this->db->insert("quiz_permitted_students", $data);
            }
        }
    }

    public function ViewInstructorCourses($instructor_id) {
        $database_query = "SELECT * FROM Course WHERE instructor_id = $instructor_id";
        return $this->db->database_all_assoc($this->db->database_query($database_query));
    }

}

?>