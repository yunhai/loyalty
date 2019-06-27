<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller {

	public function index(){
		if(!$this->session->userdata('user')){
			$data = array('title' => 'Đăng nhập');
			if ($this->session->flashdata('txtSuccess')) $data['txtSuccess'] = $this->session->flashdata('txtSuccess');
			$this->load->helper('cookie');
			$data['userName'] = $this->input->cookie('userName', true);
			$data['userPass'] = $this->input->cookie('userPass', true);
			$this->load->view('user/login_new', $data);
		}
		else redirect('user/staff');
	}

	public function logout(){
		$fields = array('user', 'configs');
		foreach($fields as $field) $this->session->unset_userdata($field);
		redirect('user');
	}

	public function permission(){
		$this->load->view('user/permission');
	}


	public function staff(){
		$user = $this->checkUserLogin();
		// if($user['RoleId'] == 1){
	        $data = $this->commonData($user,
	            'Danh sách khách hàng',
	            array(
	                'scriptHeader' => array('css' => array('vendor/plugins/tagsinput/jquery.tagsinput.min.css','vendor/plugins/datepicker/datepicker3.css')),
	                'scriptFooter' => array('js' => array('vendor/plugins/sortable/jquery-ui.js', 'vendor/plugins/sortable/Sortable.min.js','vendor/plugins/tagsinput/jquery.tagsinput.min.js','vendor/plugins/datepicker/bootstrap-datepicker.js', 'js/search_item.js', 'js/user_list.js'))
	            )
	        );
	        if($this->Mactions->checkAccess($data['listActions'], 'user/staff')) {
	            $this->load->view('user/list', $data);
	        }
	        else $this->load->view('user/permission', $data);
	    // } else redirect(base_url());
	}

	public function add(){
		$user = $this->checkUserLogin();
		if($user['RoleId'] == 1){
			$data = $this->commonData($user,
				'Thêm CTV',
				array(
					'scriptHeader' => array('css' => 'vendor/plugins/datepicker/datepicker3.css'),
					'scriptFooter' => array('js' => array('vendor/plugins/datepicker/bootstrap-datepicker.js', 'ckfinder/ckfinder.js', 'js/user_update.js'))
				)
			);
			if ($this->Mactions->checkAccess($data['listActions'], 'user/staff')) {
				$this->loadModel(array('Mgroups'));
				$data['listGroups'] = $this->Mgroups->getBy(array('StatusId' => STATUS_ACTIVED));
				$this->load->view('user/add', $data);
			}
			else $this->load->view('user/permission', $data);
		} else redirect(base_url());
	}

	public function edit($userId = 0){
		$user = $this->checkUserLogin();
		if($user['RoleId'] == 1){
			if($userId > 0) {
				$data = $this->commonData($user,
					'Cập nhật khách hàng',
					array(
						'scriptHeader' => array('css' => 'vendor/plugins/datepicker/datepicker3.css'),
						'scriptFooter' => array('js' => array('vendor/plugins/datepicker/bootstrap-datepicker.js', 'ckfinder/ckfinder.js', 'js/user_update.js'))
					)
				);
				$userEdit = $this->Musers->get($userId);
				if ($userEdit) {
					if ($this->Mactions->checkAccess($data['listActions'], 'user/staff')) {
						$this->loadModel(array('Mquestions'));
						$data['canEdit'] = true;
						$data['userId'] = $userId;
						$data['userEdit'] = $userEdit;
						$data['question'] = $this->Mquestions->getFieldValue(array('QuestionId' => $userEdit['QuestionId']), 'QuestionName', '');
						$this->load->view('user/edit', $data);
					}
					else $this->load->view('user/permission', $data);
				}
				else {
					$data['userId'] = 0;
					$data['txtError'] = "Không tìm thấy khách hàng";
					$this->load->view('user/edit', $data);
				}
			}
			else redirect('user/profile');
		} else redirect(base_url());
	}

	public function searchByFilter(){
        $user = $this->checkUserLogin(true);
        $data = array();
        $filterId = $this->input->post('filterId');
        $searchText = $this->input->post('searchText');
        $itemFilters = $this->input->post('itemFilters');
        if(!is_array($itemFilters)) $itemFilters = array();
        if ($filterId > 0 && empty($itemFilters)){
            $this->load->model('Mfilters');
            $data = $this->Mfilters->getInfo($filterId);
            $itemFilters = $data['itemFilters'];
        }
        $page = $this->input->post('page');
        if (!is_numeric($page) || $page < 1) $page = 1;
        $limit = $this->input->post('limit');
        if (!is_numeric($limit) || $limit < 1) $limit = DEFAULT_LIMIT;
       	$data1 = $this->Musers->searchByFilter($searchText, $itemFilters, $limit, $page, $user['UserId']);
        $data = array_merge($data, $data1);
        echo json_encode($data);
    }
}