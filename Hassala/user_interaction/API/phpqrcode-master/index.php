<?php    
    //set it to writable location, a place for temp generated PNG files
    $PNG_TEMP_DIR =dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
    //html PNG location prefix
    $PNG_WEB_DIR = 'temp/';

    include "qrlib.php";    
    
    //ofcourse we need rights to create temp dir
    if (!file_exists($PNG_TEMP_DIR))
        mkdir($PNG_TEMP_DIR);
    
    
    $filename = $PNG_TEMP_DIR.'test.png';
    
    //processing form input
    //remember to sanitize user input in real-life solution !!!
    $errorCorrectionLevel = 'L';
    if (isset($_REQUEST['level']) && in_array($_REQUEST['level'], array('L','M','Q','H')))
        $errorCorrectionLevel = $_REQUEST['level'];    
        $matrixPointSize = 10;

      $handler = False;
      $var = 'ljkhkmkjhkjhhjkhkjhkhkhjkhkj89896sduifshjks9896a89ainA';
    //if (isset($_REQUEST['data'])) { 
       $filename = $PNG_TEMP_DIR.'test'.md5(/*$_REQUEST['data']*/$var.'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
$handler = True;
       // QRcode::png($_REQUEST['data'], $filename, $errorCorrectionLevel, $matrixPointSize, 2);    
      ////////////////////////////////////////////////////////////////////////////////////////////////
         
        echo QRcode::png($var, $filename, $errorCorrectionLevel, $matrixPointSize, 2); //
         
       /////////////////////////////////////////////////////////////////////////////////////////////  
    //}    
        
    //display generated file
        if(strlen($var) > 0){
        $message = '<img src="'.$PNG_WEB_DIR.basename($filename).'" />';
        echo $message;  
        }else {
            echo 'No value';
        }    
    //echo '<form action="index.php" method="post">
      //  Data:&nbsp;<input name="data" placeholder="enter..." />&nbsp;
       // <input type="submit" value="GENERATE"></form>';
        
    // benchmark
        function send($me){
        echo $me; 
                }
    ?> 

    