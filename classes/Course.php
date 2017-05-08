<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Course
 *
 * @author root
 */
class Course {
    //put your code here
    public $id;
    public $name;
    public $description;
    public $quizes = array();
    public $materials = array();
    
    public function __construct() {
        $this->quizes = array();
        $this->materials = array();
    }
}
