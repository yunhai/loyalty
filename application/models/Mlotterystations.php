<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mlotterystations extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "lotterystations";
        $this->_primary_key = "LotteryStationId";
    }
}