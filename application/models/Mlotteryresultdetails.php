<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mlotteryresultdetails extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "lotteryresultdetails";
        $this->_primary_key = "LotteryResultDetailId";
    }
}