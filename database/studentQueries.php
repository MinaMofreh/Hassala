<?php
include_once realpath(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR .'initialize.inc.php');
class studentQueries{
	private $db;

	public function __construct(){

		$this->db = new DataBase();
	}

    public function reset_pass($username, $password, $id){
     $query = "UPDATE `Users` SET `user_name` = '$username' , `password` = '$password' WHERE 
     `student_id` = '$id' ";
     $this->db->database_query($query);
    }
    
    public function check_username($str){
      $result =  $this->db->check_rows('Users','user_name',$str);
     return $result;
    }
     


     public function getStudent($qrString){
     $query = "SELECT * FROM `Student` WHERE `qr_code_string` = '$qrString'";
        if($query_run = $this->db->database_query($query)){
             if(mysqli_num_rows($query_run)==NULL){
                  return False;
             } else{
               $query_row = $this->db->database_all_assoc($query_run);
                   return $query_row[0];
              }
             } else {
                   return False;
               }
     }

	public function regester($Student, $id, $path){
    $data = array(); // to hold instructor table data
    $data1 = array(); // to hold user table data 
    
    $userName = $Student->get_username();
    $password = $Student->get_password();
    $result= $this->db->updateTable('Student', $id , 'codeforces_handle', $Student->get_codeForces_handle());
    $result1 = $this->db->updateTable('Student', $id, 'profile_photo', $path);
        
         $data1['student_id']    = $id;
         $data1['user_name']     = $userName;
         $data1['password']      = $password;
         $data1['type']          = 0;
         $res = $this->db->insert('Users', $data1);
        
    }
}

?>