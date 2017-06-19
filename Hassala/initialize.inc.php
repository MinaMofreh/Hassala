<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$css = 'css'.DIRECTORY_SEPARATOR;
$js = 'js'.DIRECTORY_SEPARATOR;
$images ='images'.DIRECTORY_SEPARATOR;
$icons = 'icons'.DIRECTORY_SEPARATOR;
$fonts = 'fonts'.DIRECTORY_SEPARATOR;

require_once 'database'.DIRECTORY_SEPARATOR.'DataBase.php';
include_once 'classes'.DIRECTORY_SEPARATOR.'Student.php';
include_once 'classes'.DIRECTORY_SEPARATOR.'Instructor.php';
include_once 'classes'.DIRECTORY_SEPARATOR.'Admin.php';
include_once 'classes'.DIRECTORY_SEPARATOR.'Validator.php';
include_once 'user_interaction'.DIRECTORY_SEPARATOR.'API'.DIRECTORY_SEPARATOR.'fpdf-1-6-es'.DIRECTORY_SEPARATOR.'fpdf.php';
include_once 'user_interaction'.DIRECTORY_SEPARATOR.'API'.DIRECTORY_SEPARATOR.'PHPExcel.php';