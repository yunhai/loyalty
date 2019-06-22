<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Site extends MY_Controller {

	public function __construct(){
		parent::__construct();
        $this->load->model('Mconfigs');
	}

    public function index(){
    	$user = $this->session->userdata('user');
        $this->load->view('site/home', $user);
	}

	public function update(){
		$user = $this->checkUserLoginHome();
		if($user){
			$data = $this->arrayFromPost(array('NumberOne', 'NumberTwo'));
			if(!empty($data['NumberOne']) && !empty($data['NumberTwo']) || (intval($data['NumberOne']) >= 0 || intval($data['NumberTwo']) >= 0)){
				$this->load->model('Mcustomersanticipates');
				$dateNow = getCurentDateTime();
				$date1 = str_replace('-', '/', $dateNow);
				$tomorrow = date('Y-m-d 00:00:00',strtotime($date1 . "+1 days"));
				$userId = $user['UserId'];
				$flag = false;
				if($dateNow <= date('Y-m-d 16:00:00')){
					$flag = $this->Mcustomersanticipates->checkExist_1($userId, $dateNow);
				}
				if($dateNow > date('Y-m-d 16:00:00')){
					$flag = $this->Mcustomersanticipates->checkExist_2($userId, $tomorrow);
				}

				if($flag){
					echo json_encode(array('code' => -1, 'message' => "Bạn đã đăng ký số chơi xổ số rồi nhé"));
					die;
				}
				else{
					$dateTime = date('Y-m-d 00:00:00');
					if($dateNow > date('Y-m-d 16:00:00')) $dateTime = $tomorrow;
					$postData = array(
						'LotteryStationId' => 17,
						'Number' => $data['NumberOne'].$data['NumberTwo'],
						'UserId' => $userId,
						'CrDateTime' => $dateTime,
						'StatusId' => STATUS_ACTIVED,
					);
					$flag = $this->Mcustomersanticipates->save($postData);
					if($flag) echo json_encode(array('code' => 1, 'message' => "Thêm số dự đoán thành công."));
					else echo json_encode(array('code' => 0, 'message' => "Có lỗi xảy ra, vui lòng thử lại."));
				}
				
				
			}else echo json_encode(array('code' => -1, 'message' => "Có lỗi xảy ra, vui lòng thử lại."));
		} else echo json_encode(array('code' => -2, 'message' => "Vui lòng đăng nhập"));
	}

	public function ajaxUserWin(){
		$user = $this->session->userdata('user');
		$this->load->model('Mcustomersanticipates');
		$listDatas = $this->Mcustomersanticipates->getListHomeWin($user);
		echo json_encode(array('code' => 1, 'message' => "data trả về", "data" => $listDatas));
	}

}