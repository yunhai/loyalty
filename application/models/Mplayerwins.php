<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mplayerwins extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "playerwins";
        $this->_primary_key = "PlayerWinId";
    }
}