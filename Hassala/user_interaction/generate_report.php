

<?php
/*
include_once 'fpdf-1-6-es/fpdf.php';
include_once 'DataBase.php';

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
$Solve_Quiz_Arr = $DB->database_all_assoc($DB->database_query("SELECT * FROM `solve_quiz` WHERE `quiz_id` = 1;"));
//echo $Solve_Quiz_Arr[0]['student_id'];
$College_IDs = array();
for ($i = 0; $i < count($Solve_Quiz_Arr); $i++) {
    $str = $Solve_Quiz_Arr[$i]['student_id'];
    //echo $str;
    //print_r($DB->database_all_assoc($DB->database_query("SELECT college_id FROM `Student` WHERE `student_id` = $str;")));
$College_IDs[] = $DB->database_all_assoc($DB->database_query("SELECT college_id FROM `Student` WHERE `student_id` = $str;"))[0]['college_id'];
}

for ($j = 0; $j < count($Solve_Quiz_Arr); $j++) {
    $pdf->Cell($width_cell[1], 10, $College_IDs[$j], 1, 0, 'C', $fill);
    $pdf->Cell($width_cell[2], 10, $Solve_Quiz_Arr[$j]['student_grade'], 1, 1, 'C', $fill);
    $fill = !$fill; // to give alternate background fill  color to rows
}
/// end of records /// 

$pdf->Output();*/
include_once realpath(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'initialize.inc.php');
echo Admin::GeneratePDF_Report(1);
?>

