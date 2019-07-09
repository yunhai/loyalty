<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Share extends MY_Controller {

	public function __construct(){
		parent::__construct();
	}

	public function index(){
		$this->loadModel(array('Mcustomersanticipates'));
        $this->load->view('site/share');
	}
}