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
		else redirect('user/list');
	}

	public function logout(){
		$fields = array('user', 'configs');
		foreach($fields as $field) $this->session->unset_userdata($field);
		redirect('user');
	}

	public function list(){
		$user = $this->checkUserLogin();

		if($user['RoleId'] == 1){
	        $data = $this->commonData($user,
	            'Danh sách người chơi',
	            array(
	                'scriptHeader' => array('css' => array('vendor/plugins/tagsinput/jquery.tagsinput.min.css','vendor/plugins/datepicker/datepicker3.css')),
	                'scriptFooter' => array('js' => array('vendor/plugins/sortable/jquery-ui.js', 'vendor/plugins/sortable/Sortable.min.js','vendor/plugins/tagsinput/jquery.tagsinput.min.js','vendor/plugins/datepicker/bootstrap-datepicker.js', 'js/search_item.js', 'js/user_list.js'))
	            )
	        );
	        $this->load->view('user/list', $data);
	    } else redirect(base_url());
	}

	public function edit($userId = 0){
		$user = $this->checkUserLogin();
		if($user['RoleId'] == 1){
			if($userId > 0) {
				$data = $this->commonData($user,
					'Cập nhật người chơi',
					array(
						'scriptHeader' => array('css' => 'vendor/plugins/datepicker/datepicker3.css'),
						'scriptFooter' => array('js' => array('vendor/plugins/datepicker/bootstrap-datepicker.js', 'ckfinder/ckfinder.js', 'js/user_update.js'))
					)
				);
				$userEdit = $this->Musers->get($userId);
				if ($userEdit) {
					$data['canEdit'] = true;
					$data['userId'] = $userId;
					$data['userEdit'] = $userEdit;
					$this->load->view('user/edit', $data);
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

	public function update(){
        $postData = $this->arrayFromPost(
			[
				'PhoneNumber', 
				'Email', 
				'FullName', 
				'Password', 
				'PasswordConfirm',
				'UserId'
			]
		);
		
		$password = trim($postData['Password'] ?? '');
		$passwordConfirm = trim($postData['PasswordConfirm'] ?? '');
		if (empty($postData['PhoneNumber']) ||
            empty($postData['Email']) ||
            empty($postData['FullName'])
        ) {
            echo json_encode(array('code' => -1, 'message' => "Vui lòng nhập đầy đủ thông tin"));
            return;
        }

        $username = $postData['PhoneNumber'] ?? $postData['Email'] ?? '';
        $update = array(
            'FullName' => $postData['FullName'],
            'PhoneNumber' => $postData['PhoneNumber'],
            'Email' => $postData['Email'],
            "UpdateUserId" => 1,
            "UpdateDateTime" => getCurentDateTime(),
		);		
		if ($password) {
			$update['UserPass'] = md5($this->getPassword($password));
		}
		$target = $this->checkUserLogin(true);
        $userId = $this->Musers->save($update, $postData['UserId'] ?? 0);
        if ($userId > 0)  {
			if ($postData['UserId'] == $target['UserId']) {
				$this->session->set_userdata('user', array_merge($target, $update));
			}
			
            echo json_encode(['code' => 1, 'message' => "Cập nhật profile thành công.", 'data' => $update]);
            return;
        }
        echo json_encode(array('code' => 0, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
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

    public function exportUser(){
    	$user = $this->checkUserLogin();
    	if($user['RoleId'] == 1){
    		$listUsers = $this->Musers->getBy(array("StatusId" => STATUS_ACTIVED, "StatusId" => STATUS_ACTIVED));
    		if(!empty($listUsers)) {
    			$fileUrl = FCPATH . 'assets/uploads/excels/users.xls';
    			$this->load->library('excel');
    			$objReader = PHPExcel_IOFactory::createReader('Excel5');
                $objPHPExcel = $objReader->load($fileUrl);
                $objPHPExcel->setActiveSheetIndex(0);

                $sheet = $objPHPExcel->getActiveSheet();
                $i = 2;
                foreach($listUsers as $u) {
                	$crDateTimec= ddMMyyyy($u['CrDateTime'], 'd/m/Y H:i');
                	$sheet->setCellValue('A' . $i, $u['FullName']);
                	$sheet->setCellValue('B' . $i, $u['PhoneNumber']);
                	$sheet->setCellValue('C' . $i, $u['Email']);
                	$sheet->setCellValue('D' . $i, $crDateTimec);
                	$i++;
                }
                $cellIterator = $sheet->getRowIterator()->current()->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(true);
                $filename = "user_".date('Y-m-d').".xls";
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="' . $filename . '"');
                header('Cache-Control: max-age=0');
                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                $objWriter->save('php://output');
                $objPHPExcel->disconnectWorksheets();
                unset($objPHPExcel);
    		} else echo "<script>window.close();</script>";
    	} else redirect(base_url());
	}

    private function getPassword($password = '') {
        return '@pandog#' . $password;
    }
}