<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Site extends MY_Controller {

	public function __construct(){
		parent::__construct();
        $this->load->model('Mconfigs');
	}

    public function index(){
	}

}