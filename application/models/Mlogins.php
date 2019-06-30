<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mlogins extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table_name = "logins";
        $this->_primary_key = "LoginId";
    }
}
