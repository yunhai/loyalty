<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Site extends MY_Controller {

	public function __construct(){
		parent::__construct();
	}


    public function index(){
    	$user = $this->session->userdata('user');
        $this->load->view('site/home', array('user' =>$user));
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
					if($flag) echo json_encode(array('code' => 1, 'message' => "Thêm số dự đoán thành công.", 'number' => $postData['Number']));
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

	public function receiveCard(){
		$user = $this->session->userdata('user');
		$customersAnticipateId = $this->input->post('CustomersAnticipateId');
		if($user && $customersAnticipateId > 0){
			$this->load->model(array('Mcustomersanticipates', 'Mcards'));
			$cardId = $this->Mcustomersanticipates->getCardId($user['UserId'], $customersAnticipateId);
			if($cardId > 0){
				$flag = $this->Mcards->save(array('CardActiveId' => 4), $cardId);
				if($flag){
					$card = $this->Mcards->get($cardId);
					$card['CardType'] = $this->Mconstants->typeCard[$card['CardTypeId']];
					echo json_encode(array('code' => 1, 'message' => "Nhận card thành công", 'data' => $card));
				}else echo json_encode(array('code' => 0, 'message' => 'Có lỗi xảy ra, vui lòng thử lại'));
			}
		}else $this->load->view('user/permission');
	}

}