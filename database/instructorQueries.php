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
        $data['gender'] = $instructor->get_gender();
        $data['cf_handle'] = $instructor->get_codeForces_handle();
        $data['profile_photo'] = $instructor->get_image_path();
        //$data['type']              = 1;  // forgien key !!!!!! to user Tabels 'mina yat7das :D' ely hyshof el comment yegawbny we ye update GitHub hshofo
        $userName = $instructor->get_username();
        $password = $instructor->get_password();

        $result = $this->db->insert('instructor', $data);

        if ($result) {
            $id = $result;
            $data1['instructor_id'] = $id;
            $data1['user_name'] = $userName;
            $data1['password'] = $password;
            $data1['type'] = 1;

            $res = $this->db->insert('Users', $data1);

            $data2['university_name'] = $instructor->get_univeristy();
            $data2['inst_id'] = $id;
            $return = $this->db->insert('instructor_university', $data2);
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
        $result = $this->db->check_rows('users', 'user_name', $str);
        return $result;
    }

    public function check_email($str) {
        $result = $this->db->check_rows('instructor', 'email', $str);
        return $result;
    }

}

?>