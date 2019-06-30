<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mquestions extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "questions";
        $this->_primary_key = "QuestionId";
    }
}