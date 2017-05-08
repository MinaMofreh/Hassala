<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if (isset($_POST['quiz_data'])) {
    $now = new DateTime();
    $data = $_POST['quiz_data'];
    $possible_quizzes = '';
    for ($i = 0; $i < count($data); $i++) {
        if ($data[$i]['quiz_date'] == date_format($now, 'Y-m-d') 
                        && $data[$i]['quiz_type'] == 1) {
            $possible_quizzes = $possible_quizzes . $data[$i]['quiz_id'].":";
        }
        else if ($data[$i]['quiz_type'] == 0 
                && (strtotime($data[$i]['quiz_time']) )<= time() + (strtotime($data[$i]['quiz_duration']))
                && $data[$i]['quiz_date'] == date_format($now, 'Y-m-d'))
        {
            $possible_quizzes = $possible_quizzes . $data[$i]['quiz_id'].":";
        }
        
    }

    echo $possible_quizzes;
}

