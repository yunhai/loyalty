<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Share extends MY_Controller {

	public function __construct(){
		parent::__construct();
	}

	public function index(){
		$this->loadModel(array('Mcustomersanticipates'));
		$data = array(
            'categoryUrlPage' => base_url('ban-da-chia-se-ket-qua-du-doan-la-{$1}'),
            'pageTitle' => 'Chia sẻ kết quả của bạn là : '. $num,
        );
        $data['configSites']['pageUrl'] = base_url('ban-da-chia-se-ket-qua-du-doan-la-{$1}');
        $this->load->view('site/share', $data);
	}
}