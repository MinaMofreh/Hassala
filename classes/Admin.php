<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Admin
 *
 * @author root
 */
include_once 'Person.php';

class Admin extends Person {

    //put your code here
    public $database;
    private $fileName;
    private $name;
    private $DataBase_Class;
    private $admin_qeury;

    public function __construct() {
        $this->database = new DataBase();
        $this->admin_qeury = new Admin_Queries();
        $this->DataBase_Class = new DataBase_Class();
    }

    public function set_adminName($name) {
        $this->userName = $name;
    }

    public function set_adminPassword($password) {
        $this->password = sha1($password); //hashing
    }

    public function get_adminName() {
        return $this->userName;
    }

    public function get_adminPassword() {
        return $this->password;
    }

    public function login() {
        $data = $this->get_username_password($this->userName, $this->password);
        if ($data['user_name'] == $this->userName && $data['password'] == $this->password && $data['type'] == 2) {
            $_SESSION['Admin'] = $this->userName; //start session when login
            return True;
        } else {
            return False;
        }
    }

    public function CreateContest($param) {
        
    }

    public function AddStudent($Student) {
        if ($this->admin_qeury->Add_new_Student($Student)) {
            return True;
        } else {
            return False;
        }
    }

    public function AddIntialProblem($param) {
        
    }

    public function BackUp($param) {
        
    }

    public function generate_qr($variable, $email, $name) {
        $PNG_TEMP_DIR = '../UI/Qrcodes/';
        //echo $PNG_TEMP_DIR;
        $this->name = $variable;
        $PNG_WEB_DIR = '../UI/Qrcodes/';
        if (!file_exists($PNG_TEMP_DIR))
            mkdir($PNG_TEMP_DIR);
        $filename = $PNG_TEMP_DIR . 'test.png';
        $errorCorrectionLevel = 'L';
        if (isset($_REQUEST['level']) && in_array($_REQUEST['level'], array('L', 'M', 'Q', 'H')))
            $errorCorrectionLevel = $_REQUEST['level'];
        $matrixPointSize = 8;
        $filename = $PNG_TEMP_DIR . $variable . '.png';
        $this->fileName = $variable . '.png';
        /////////////////////////////////////////////////////////////////////////////////
        echo QRcode::png($variable, $filename, $errorCorrectionLevel, $matrixPointSize, 2);
        ///////////////////////////////////////////////////////////////////////////////// 
        //echo $this->fileName;
        $this->send_email_qr($email, $name); // send mail
    }

    private function send_email_qr($email, $name) {
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

        $mail->addAttachment('Qrcodes/' . $this->name . '.png', 'QRCode.png');    // Optional name
        $mail->isHTML(true);                                  // Set email format to HTML

        $mail->Subject = 'Welcome, ' . $name;
        $mail->Body = 'Welcome to <b>Hsala</b> course management system,<br>
                      Following <b>attached</b> QrCode is the <strong>only</strong><br>
                      Way to complete your registration to the application 
                      <h4>follow the steps : </h4><br>
                      <hr>
                      1- Open //siteLink URL <br>
                      2- Click Signup <br>
                      3- Choose Student <br>
                      4- Scan the attached Qrcode
                      <hr>
                      Hint : keep the Qrcod safe for a future use. (reset username or password)<br>
                      *scan Qrcode using Mozila Browser*
                      //sitelink 
                      <style>
                       h4{
                        color:blue;
                       }
                      </style>';

        if (!$mail->send()) {
            return True;
        } else {
            return False;
        }
    }

    public function logout() {
        if (isset($_SESSION['Admin'])) {

            unset($_SESSION['Admin']);

            header('location: Admin.php'); //redirect to login page
            exit();
        }
    }

    public function email_num($email) {
        $result = $this->admin_qeury->check_email($email);
        if ($result != 0)
            return False;
        else
            return True;
    }

    public function GenerateStatistics() {
        $statistics_query = 'SELECT `university`,COUNT(`university`) as university_count FROM Student GROUP BY `university`';
        $qresult = $this->database->database_query($statistics_query);
        $result = array();
        while ($res = $qresult->fetch_assoc()) {
            $result[] = $res;
        }
        $pie_chart_data = array();
        $pie_chart_data[] = array('Visitors', 'Numbers');
        foreach ($result as $single_result) {
            $pie_chart_data[] = array($single_result['university'], (int) $single_result['university_count']);
        }
        $pie_chart_data = json_encode($pie_chart_data);
        mysqli_free_result($qresult);
        return $pie_chart_data;
    }

    static public function GeneratePDF_Report($QuizID) {
        $pdf = new FPDF();
        $pdf->AddPage();

        $width_cell = array(20, 50, 40, 40, 40);
        $pdf->SetFont('Arial', 'B', 16);

        $pdf->SetFillColor(193, 229, 252); // Background color of header 
// Header starts /// 
        $pdf->Cell($width_cell[1], 10, 'ID', 1, 0, 'C', true); // First header column 
        $pdf->Cell($width_cell[2], 10, 'Grade', 1, 1, 'C', true); // Third header column 
//// header ends ///////

        $pdf->SetFont('Arial', '', 14);
        $pdf->SetFillColor(235, 236, 236); // Background color of header 
        $fill = false; // to give alternate background fill color to rows 
/// each record is one row  ///
        $DB = new DataBase();
        $Solve_Quiz_Arr = $DB->database_all_assoc($DB->database_query("SELECT * FROM `solve_quiz` WHERE `quiz_id` = $QuizID;"));

        $College_IDs = array();
        for ($i = 0; $i < count($Solve_Quiz_Arr); $i++) {
            $str = $Solve_Quiz_Arr[$i]['student_id'];
            $College_IDs[] = $DB->database_all_assoc($DB->database_query("SELECT college_id FROM `Student` WHERE `student_id` = $str;"))[0]['college_id'];
        }

        for ($j = 0; $j < count($Solve_Quiz_Arr); $j++) {
            $pdf->Cell($width_cell[1], 10, $College_IDs[$j], 1, 0, 'C', $fill);
            $pdf->Cell($width_cell[2], 10, $Solve_Quiz_Arr[$j]['student_grade'], 1, 1, 'C', $fill);
            $fill = !$fill; // to give alternate background fill  color to rows
        }
/// end of records /// 

        $pdf->Output();
        $fileFullPath = $pdf->filePath . $pdf->name;
    }

}
