<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Contest
 *
 * @author root
 */
class Contest {
    public $id;
    public $name;
    public $problem_count;
    public $partcipants_num;
    public $time;
    public $problems;
    public function __construct($param) {
        $this->problems = new ArrayObject(Problem);
    }
}
