<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Site extends MY_Controller {

	public function __construct(){
		parent::__construct();
        $this->load->model('Mconfigs');
	}

    public function index(){
        $this->load->view('site/home');
	}

	public function update(){
		$user = $this->checkUserLoginHome();
		if($user){
			$data = $this->arrayFromPost(array('NumberOne', 'NumberTwo'));
			if(intval($data['NumberOne']) >= 0 || intval($data['NumberTwo']) >= 0){
				$this->load->model('Mcustomersanticipates');
				$dateNow = getCurentDateTime();
				$date1 = str_replace('-', '/', $dateNow);
				$tomorrow = date('Y-m-d H:i:s',strtotime($date1 . "+1 days"));
				$userId = $user['UserId'];
				$flag = false;
				if($dateNow <= date('Y-m-d 16:00:00')){
					$flag = $this->Mcustomersanticipates->checkExist_1($userId);
				}
				if($dateNow > date('Y-m-d 16:00:00')){
					$flag = $this->Mcustomersanticipates->checkExist_2($userId);
				}

				if($flag){
					echo json_encode(array('code' => -1, 'message' => "Bạn đã đăng ký số chơi xổ số rồi nhé"));
					die;
				}
				else{
					$postData = array(
						'LotteryStationId' => 17,
						'Number' => $data['NumberOne'].$data['NumberTwo'],
						'UserId' => $userId,
						'CrDateTime' => getCurentDateTime(),
						'StatusId' => STATUS_ACTIVED,
					);
					$flag = $this->Mcustomersanticipates->save($postData);
					if($flag) echo json_encode(array('code' => 1, 'message' => "Thêm số dự đoán thành công."));
					else echo json_encode(array('code' => 0, 'message' => "Có lỗi xảy ra, vui lòng thử lại."));
				}
				
				
			}else echo json_encode(array('code' => -1, 'message' => "Có lỗi xảy ra, vui lòng thử lại."));
		} else echo json_encode(array('code' => -2, 'message' => "Vui lòng đăng nhập"));
	}

}