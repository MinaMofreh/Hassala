<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ApplicationUser
 *
 * @author root
 */
include_once 'Person.php';

include_once 'Material.php';

class ApplicationUser extends Person {

    private $FirstName;
    private $LastName;
    private $email;
    private $Gender;
    private $University;
    private $codeForces_handle;
    private $solvedProblems;
    private $profilePic;

    // setters
    public function set_firstName($firstName) {
        $this->FirstName = $firstName;
    }

    public function set_lastName($lastName) {
        $this->LastName = $lastName;
    }

    public function set_email($Email) {
        $this->email = $Email;
    }

    public function set_gender($gen) {
        $this->Gender = $gen;
    }

    public function set_univeristy($univ) {
        $this->University = $univ;
    }

    public function set_codeForces_handle($var) {
        $this->codeForces_handle = $var;
    }

    public function increment_solvedProblems() {
        $this->solvedProblems++;
    }

    public function set_profilePic($file_extn, $file_temp) {
        $tmp_path = $this->Create_profilePath($file_extn);
        $this->profilePic = $tmp_path;
        move_uploaded_file($file_temp, $tmp_path);
        return $tmp_path;
    }

    public function get_image_path() {
        return $this->profilePic;
    }

    // getters
    public function get_firstName() {
        return $this->FirstName;
    }

    public function get_lastName() {
        return $this->LastName;
    }

    public function get_email() {
        return $this->email;
    }

    public function get_gender() {
        return $this->Gender;
    }

    public function get_university() {
        return $this->University;
    }

    public function get_codeForces_handle() {
        return $this->codeForces_handle;
    }

    public function get_solvedProblems() {
        return 0;
    }

    public function SignUp($param) {
        
    }

    private function Create_profilePath($file_extn) {
        return 'redirectories/images/mina_images/ProfileImages/' . substr(md5(time()), 0, 10) . '.' . $file_extn;
    }

    public function login($username, $pass) {
        if ($this->get_data_in_login($username, $pass)) {
            return True;
        }
    }

    private function get_data_in_login($username, $pass) {
        $data = $this->get_username_password($username, $pass);
        if ($data['user_name'] == $username && $data['password'] == $pass) {
            // kda how login tmam we 3wzen ngeb el id 3lshan aload eladata we start session we ashof tabel 
            // ellook up role 
            $db = new DataBase();
            if ($data['type'] == '0') { //student
                $data_array = $db->get_row_by_id($data['student_id'], 'Student', 'student_id');
                $this->start_session($data_array, 'student', $data['user_name'], $data['password']);
            } else if ($data['type'] == 1) { // instructor
                $data_array = $db->get_row_by_id($data['instructor_id'], 'Instructor', 'instructor_id');
                $this->start_session($data_array, 'instructor', $data['user_name'], $data['password']);
            }
            return $data_array; // delete after testing
        }
    }

    public function Reset_pass($username, $password, $id) {
        
    }

    public function EditProfile($username, $password, $profile_picture) {
        //$this->SignUp($email, $first_name, $last_name);   
    }

    public function SolveProblem($param) {
        
    }

    private function start_session($data_array, $type, $username, $pass) {
        if ($type == 'student') {
            session_start();
            $_SESSION['student'] = "STUDENT";
            $_SESSION['username'] = $username;
            $_SESSION['password'] = $pass;
            $_SESSION['student_id'] = $data_array['student_id'];
            $_SESSION['college_id'] = $data_array['college_id'];
            $_SESSION['first_name'] = $data_array['first_name'];
            $_SESSION['last_name'] = $data_array['last_name'];
            $_SESSION['university'] = $data_array['university'];
            $_SESSION['rate'] = $data_array['rate'];
            $_SESSION['email'] = $data_array['email'];
            $_SESSION['solved_problems'] = $data_array['solved_problems'];
            $_SESSION['profile_photo'] = $data_array['profile_photo'];
            $_SESSION['gender'] = $data_array['gender'];
            $_SESSION['codeforces_handle'] = $data_array['codeforces_handle'];
            $_SESSION['qr_code_string'] = $data_array['qr_code_string'];
        } else if ($type == 'instructor') {
            session_start();
            $_SESSION['instructor'] = "INSTRUCTOR";
            $_SESSION['username'] = $username;
            $_SESSION['password'] = $pass;
            $_SESSION['instructor_id'] = $data_array['instructor_id'];
            $_SESSION['instructor_fname'] = $data_array['instructor_fname'];
            $_SESSION['solved_problems'] = $data_array['solved_problems'];
            $_SESSION['email'] = $data_array['email'];
            $_SESSION['gender'] = $data_array['gender'];
            $_SESSION['cf_handle'] = $data_array['cf_handle'];
            $_SESSION['profile_photo'] = $data_array['profile_photo'];
        }
    }

    public function Logout() {

    }

    public function get_lookup() {
        if (isset($_SESSION['student'])) {
            $db = new Database();
            $query = "SELECT `page_link` FROM role_pages WHERE `role_type` = 0";
        } else {
            $db = new Database();
            $query = "SELECT `page_link` FROM role_pages WHERE `role_type` = 1";
        }
        $result = $db->get_row($query);
        return $result['page_link'];
    }

}
