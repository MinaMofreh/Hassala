<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Quiz
 *
 * @author root
 */
class Quiz {
    public $id;
    public $title;
    public $duration;
    public $date;
    public $time;
    public $description;
    public $full_grade; 
    public $questions = array();
    public $problems = array();
    public $type;
    
}