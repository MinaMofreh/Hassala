<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of database
 *
 * @author root
 */
class DataBase {

    //put your code here

    private $host = "localhost";
    private $username = "root";
    private $password = "Fedora25:(";
    //private static $instance;// single database object i will explain it next section 
    private $db_name = "Hassala"; //your database name 
    private $mysqli; // 

    public function __construct() {
        $this->mysqli = $this->database_connect($this->host, $this->username, $this->password);
        $this->database_select($this->db_name);
    }

    private function database_connect($database_host, $database_username, $database_password) {
        if ($c = new mysqli($database_host, $database_username, $database_password)) {
            return $c;
        } else {


            die("Database connection error");
        }
    }

    public function insert($table, $data) {
        $q = "INSERT INTO `$table` ";
        $v = "";
        $n = "";

        foreach ($data as $key => $val) {
            $n .= "`$key`, ";
            if (strtolower($val) == 'null')
                $v .= "NULL, ";
            elseif (strtolower($val) == 'now()')
                $v .= "NOW(), ";
            else
                $v .= "'$val', ";
        }

        $q .= "(" . rtrim($n, ', ') . ") VALUES (" . rtrim($v, ', ') . ");";
        if ($this->database_query($q)) {
            return mysqli_insert_id($this->mysqli);
        } else
            return false;
    }

    public function get_row($query) {
        if (!strstr(strtoupper($query), "LIMIT"))
            $query .= " LIMIT 0,1";
        if (!($res = $this->database_query($query))) {
            die("Database error: " . mysqli_error($this->mysqli) . "<br/>In query: " . $query);
        }
        return mysqli_fetch_assoc($res);
    }

    private function database_select($database_name) {
        return $this->mysqli->select_db($database_name)
                or die("no db is selecteted");
    }

    public function database_close() {
        if (!mysqli_close($this->database_connection))
            die("Connection close failed.");
    }

    public function database_query($database_query) {

        if ($query_result = $this->mysqli->query($database_query))
            return $query_result;
    }

    public function database_all_array($database_result) {
        $array_return = array();
        while ($row = mysqli_fetch_array($database_result)) {
            $array_return[] = $row;
        }
//        if(count($array_return)>0)
        return $array_return;
    }

    /**
     * Executes query result (table, array of array)
     *
     * @param string database_result

     * @access public
     * @return associated array of rows 
     */
    public function database_all_assoc($database_result) {
        $array_return = array();
        while ($row = mysqli_fetch_assoc($database_result)) {
            $array_return[] = $row;
        }
        return $array_return;
    }

    public function database_affected_rows($database_result) {

        return mysqli_affected_rows($database_result);
    }

    public function database_num_rows($database_result) {
        return mysqli_num_rows($database_result);
    }

#-#############################################
# desc: does an update query with an array
# param: table, assoc array with data (not escaped), where condition (optional. if none given, all records updated)
# returns: (query_id) for fetching results etc

    public function update($table, $data, $where = '1') {
        $q = "UPDATE `$table` SET ";

        foreach ($data as $key => $val) {
            if (strtolower($val) == 'null')
                $q .= "`$key` = NULL, ";
            elseif (strtolower($val) == 'now()')
                $q .= "`$key` = NOW(), ";
            else
                $q .= "`$key`='" . $this->mysqli->escape_string($this->mysqli,$val) . "', ";
        }

        $q = rtrim($q, ', ') . ' WHERE ' . $where . ';';

        return $this->query($q);
    }

    /* De 3shan lw 3ozna ngeb a5r value fe 7aga
     * ID bta3 student aw instructor 
     * 3ayz agep el PK bta3 7d lesa da5l w hms7o 
     * ageeb be 3dd
     */

    public function getLastValue($table, $coulmn) {
        $result = $this->database_query("SELECT $coulmn FROM `$table` ORDER BY $coulmn DESC LIMIT 1");
        $arr = $this->database_all_array($result);

        return $arr[0][0];
    }

    /* de 3shan lw 3ozt aktb query mo3yna fe ay finction w 3ayz a3rf 
     * el id bta3 column mo3yn w m3aya esmo msln
     */

    public function getValueFromCoulmn($table, $coulmnNameNeeded, $coulmnName, $coulmnValue) {
        $result = $this->database_query(
                "SELECT $coulmnNameNeeded FROM `$table` WHERE $coulmnName = '$coulmnValue'");
        $arr = $this->database_all_assoc($result);
        return $arr[0][$coulmnNameNeeded];
    }

    public function get_row_by_id($id, $table, $coulumn_name) {
        $qu = "SELECT * FROM `$table` WHERE `$coulumn_name` = '$id' ";
        return $this->get_row($qu);
    }

    //tested_mina
    public function set_profilePic($table, $path, $id) {
        $q = "UPDATE `$table` SET `profile_photo` = '$path' WHERE `student_id` = '$id'";
        $this->database_query($query);
    }

//tested_mina
    public function updateTable($table, $id, $field, $data) {
        $query = "UPDATE `$table` SET `$field` = '$data' WHERE `student_id` = '$id'";
        $this->database_query($query);
    }

    //tested_mina
    public function check_rows($table, $field, $string) {
        $stm1 = "SELECT COUNT(*) FROM `$table` WHERE `$field` = '$string'";
        $result = $this->get_row($stm1);
        return $result['COUNT(*)'];
    }
    public static function sql_injection($data){
       return mysqli_real_escape_string($mysqli,$data);
    }

}
