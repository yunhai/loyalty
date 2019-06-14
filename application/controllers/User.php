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
			//$this->load->view('user/login', $data);
			$this->load->view('user/login_new', $data);
			//$this->load->view('user/register_new', $data);
		}
		else redirect('user/dashboard');
	}

	public function logout(){
		$fields = array('user', 'configs');
		foreach($fields as $field) $this->session->unset_userdata($field);
		redirect('user');
	}

	public function forgotPass(){
		// $this->load->view('user/forgotpass', array('title' => 'Quên mật khẩu'));
		$this->load->view('user/forgotpass_new', array('title' => 'Quên mật khẩu'));
	}

	public function register(){
		$this->load->model('Mquestions');
		$listQuestions = $this->Mquestions->getBy(array('StatusId' => STATUS_ACTIVED));
		$this->load->view('user/register_new', array('title' => 'Đăng ký', 'listQuestions' => $listQuestions));
	}

	public function sendToken(){
		$email = trim($this->input->post('Email'));
		if(!empty($email)){
			$user = $this->Musers->getBy(array('StatusId' => STATUS_ACTIVED, 'Email' => $email), true, "", "UserId,FullName");
			if($user){
				$token = bin2hex(mcrypt_create_iv(10, MCRYPT_DEV_RANDOM));
				$token = substr($token, 0, 14);
				$message = "Xin chào {$user['FullName']}<br/>Xin vào link ".base_url('user/changePass/'.$token).' để đổi mật khẩu.';
				$configs = $this->session->userdata('configs');
				if(!$configs) $configs = array();
				$emailFrom = isset($configs['EMAIL_COMPANY']) ? $configs['EMAIL_COMPANY'] : 'dathang86@gmail.com';
				$companyName = isset($configs['COMPANY_NAME']) ? $configs['COMPANY_NAME'] : 'Đặt hàng 86';
				$flag = $this->sendMail($emailFrom, $companyName, $email, 'Lấy lại mật khẩu', $message);
				if($flag){
					$this->Musers->save(array('Token' => $token), $user['UserId']);
					$this->load->view('user/forgotpass_new', array('title' => 'Quên mật khẩu', 'txtSuccess' => 'Kiểm tra email và làm theo hướng dẫn'));
				}
			}
			else $this->load->view('user/forgotpass_new', array('title' => 'Quên mật khẩu', 'txtError' => 'Người dùng không tốn tại hoặc chưa kích hoạt!'));
		}
		else $this->load->view('user/forgotpass_new', array('title' => 'Quên mật khẩu', 'txtError' => 'Email không được bỏ trống!'));
	}

	public function changePass($token = ''){
		$data = array('title' => 'Đổi mật khẩu', 'token' => $token);
		$isWrongToken = true;
		if(!empty($token)){
			$user = $this->Musers->getBy(array('StatusId' => STATUS_ACTIVED, 'Token' => $token), true, "", "UserId");
			if($user){
				if($this->input->post('UserPass')) {
					$postData = $this->arrayFromPost(array('UserPass', 'RePass'));
					if (!empty($postData['UserPass']) && $postData['UserPass'] == $postData['RePass']){
						$this->Musers->save(array('UserPass' => md5($postData['UserPass']), 'Token' => ''), $user['UserId']);
						$this->session->set_flashdata('txtSuccess', "Đổi mật khẩu thành công");
						redirect('user');
						exit();
					}
					else $data['txtError'] = "Mật khẩu không trùng";
				}
			}
			else {
				$data['txtError'] = "Mã Token không dúng";
				$isWrongToken = false;
			}
		}
		else {
			$data['txtError'] = "Mã Token không dúng";
			$isWrongToken = false;
		}
		$data['isWrongToken'] = $isWrongToken;
		$this->load->view('user/changepass', $data);
	}

	public function dashboard(){
		$user = $this->checkUserLogin();
		$data = $this->commonData($user,
			'Dashboard'
			//array('scriptFooter' => array('js' => array('vendor/plugins/jquery.matchHeight.js', 'js/dashboard.js')))
		);
		$this->load->view('user/dashboard', $data);
	}

	public function permission(){
		$this->load->view('user/permission');
	}

	public function profile(){
		$user = $this->checkUserLogin();
		$data = $this->commonData($user,
			'Trang cá nhân - '.$user['FullName'],
			array(
				'scriptHeader' => array('css' => 'vendor/plugins/datepicker/datepicker3.css'),
				'scriptFooter' => array('js' => array('vendor/plugins/datepicker/bootstrap-datepicker.js', 'ckfinder/ckfinder.js', 'js/user_profile.js'))
			)
		);
		$this->loadModel(array('Mprovinces', 'Mdistricts', 'Mwards'));
		
		$data['listProvinces'] = $this->Mprovinces->getList();
		$this->load->view('user/profile', $data);
	}

	public function staff(){
		$user = $this->checkUserLogin();
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

	}

	public function add(){
		$user = $this->checkUserLogin();
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
	}

	public function edit($userId = 0){
		if($userId > 0) {
			$user = $this->checkUserLogin();
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