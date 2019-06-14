<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Config extends MY_Controller {

	public function index(){
		$user = $this->checkUserLogin();
		$data = $this->commonData($user,
			'Cấu hình chung',
			array('scriptFooter' => array('js' => array('ckfinder/ckfinder.js', 'js/config.js')))
		);
		if($this->Mactions->checkAccess($data['listActions'], 'config')) {
			$this->loadModel(array('Mconfigs', 'Mprovinces', 'Mdistricts', 'Mwards'));
			$data['listProvinces'] = $this->Mprovinces->getList();
			$data['listConfigs'] = $this->Mconfigs->getListMap();
			$this->load->view('config/general', $data);
		}
		else $this->load->view('user/permission', $data);
	}

	public function store(){
		$user = $this->checkUserLogin();
		$data = $this->commonData($user,
			'Cấu hình chức năng',
			array(
				'scriptHeader' => array('css' => 'vendor/plugins/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css'),
				'scriptFooter' => array('js' => array('vendor/plugins/bootstrap-switch/dist/js/bootstrap-switch.min.js', 'js/config.js'))
			)
		);
		if($this->Mactions->checkAccess($data['listActions'], 'config')) {
			$this->load->model('Mconfigs');
			$data['listConfigs'] = $this->Mconfigs->getListMap(2);
			$this->load->view('config/store', $data);
		}
		else $this->load->view('user/permission', $data);
	}
}
