<?php
if (isset($_SESSION['instructor'])){
include_once realpath(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'initialize.inc.php');

class QuizData {

    public $excelExtention = array("ods", "uos", "xlsx", "xls", "xlsm");
    //just insialization..
    public $quiz_title;
    public $quiz_description;
    public $mcq_questions_num;
    public $problems_num;
    public $quiz_date;
    public $hours;
    public $minutes;
    public $seconds;
    public $quiz_duration;
    public $excel_sheet;
    public $quizHeld = "";
    public $filePath = "";
    // to reply with a message error
    public $quiz_tite_error = "";
    public $quiz_description_error;
    public $mcqAndProb_error;
    public $date_error;
    public $duration_error;
    public $sheet_error;
    public $held_error = "";
    public $error_counter = 0;

    public function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    /* function to find string in string */

    public function trimeString($string, $find) {
        $sLen = strlen($string);
        $exNum = 0;
        for ($ct = 0; $ct < $sLen; $ct++) {
            if ($string[$ct] == ".") {
                $exNum = $ct;
                break;
            }
        }
        return substr($string, $exNum);
    }

    public function makQzValidation() {


        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            //start validation
            if (empty($_POST['quiz_title'])) {
                $this->quiz_tite_error = "this field is required";
                $this->error_counter++;
            } else {
                $this->quiz_title = $this->test_input($_POST["quiz_title"]);
            }


            $this->quiz_description = $this->test_input($_POST['quiz_describtion']);



            if ($_POST['mcqNo'] == '0' && $_POST['problemNo'] == '0') {
                $this->mcqAndProb_error = "you should fill one of the 2 above comboboxes";
                $this->error_counter++;
            } else {
                $this->mcq_questions_num = $this->test_input($_POST['mcqNo']);
                $this->problems_num = $this->test_input($_POST['problemNo']);
            }



            if (empty($_POST['quizDate'])) {
                $this->date_error = "you should set the date";
                $this->error_counter++;
            } else {
                $this->quiz_date = $_POST['quizDate'];
            }



            if ($_POST['hour'] == '0' && $_POST['minute'] == '0' && $_POST['second'] == '0') {
                $this->duration_error = "you should set the duration";
                $this->error_counter++;
            } else {
                $this->hours = $this->test_input($_POST['hour']);
                $this->minutes = $this->test_input($_POST['minute']);
                $this->seconds = $this->test_input($_POST['second']);
                $this->quiz_duration = $this->hours . ":" . $this->minutes . ":" . $this->seconds;
            }

            //if it's not set so $quizHeld = "" as default so the quiz will be helld all the day
            if (isset($_POST['quizTime'])) {
                $this->quizHeld = $this->test_input($_POST['quizTime']);
            }
            if($this->error_counter == 0){
                header("Location:make_quiz_questions.php");
            }
        }
    }

//end of makQzValidation method

    public function getSheet() {

        if (isset($_FILES['excelSheet'])) {

            if (empty($_FILES['excelSheet']['name'])) {
                $this->sheet_error = "you should upload the excel sheet";
                $this->error_counter++;
                return NULL;
            } else {

                $file_name = $_FILES['excelSheet']['name'];
                $file_temp = $_FILES['excelSheet']['tmp_name'];
                $file_extn = strtolower(end(explode('.', $file_name)));
                if (in_array($file_extn, $this->excelExtention)) {
                    $file_path = 'sheets/' . substr(md5(time()), 0, 10) . '.' . $file_extn;
                    $this->filePath = $file_path;
                    move_uploaded_file($file_temp, $file_path);
                    //to check if it read the right data
                    $array = $this->getStudentIds();
                    print_r($array);
                    return $array;
                } else {
                    $this->sheet_error = "Wrong Extension";
                    $this->error_counter++;
                    return NULL;
                }
            }
        } else {
            $this->sheet_error = "you should upload the excel sheet";
            $this->error_counter++;
            return NULL;
        }
    }

//end get sheet method

    public function getStudentIds() {
        $student_ids = array();
        $file_name = $this->filePath;
        $excelReader = PHPExcel_IOFactory::createReaderForFile($file_name);
        $excelReader->setReadDataOnly();
        $loadSheets = array('Sheet1');
        $excelReader->setLoadSheetsOnly($loadSheets);
        //$excelReader->setLoadAllSheets();  if we want to load all sheets

        $excelObj = $excelReader->load($file_name);
        $excelObj->getActiveSheet()->toArray(null, true, true, true);
        $columnNo = $excelObj->setActiveSheetIndex(0)->getHighestRow();
        for ($ct = 2; $ct <= $columnNo; $ct++) {
            $ids[$ct] = $excelObj->getActiveSheet()->getCell('A' . $ct)->getValue();
        }
        return $ids;
    }

//end of get student ids
}
} else {
    header("Location: home.php");
    exit();
}
?>