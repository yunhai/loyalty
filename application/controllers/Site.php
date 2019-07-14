<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Site extends MY_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->library('user_agent');
    }

    public function index(){
        $user = $this->getUserFromSesson();

        $this->load->model(array('Mquestions'));
        $listQuestions = $this->Mquestions->getBy(array('StatusId' => STATUS_ACTIVED));
        $this->load->view('site/home', array(
            'user' => $user, 
            'listQuestions' => $listQuestions,
            'is_sp' => $this->agent->mobile()
        ));
    }

    public function logout(){
        $fields = array('user', 'configs');
        foreach($fields as $field) $this->session->unset_userdata($field);
        redirect();
    }

    public function update(){
        $user = $this->checkUserLoginHome();
        if (!$user) {
            echo json_encode(array('code' => -2, 'message' => "Vui lòng đăng nhập"));
            return;
        }

        $data = $this->arrayFromPost(array('NumberOne', 'NumberTwo'));
        if (empty($data['NumberOne']) || empty($data['NumberTwo'])) {
            echo json_encode(array('code' => -1, 'message' => "Vui lòng nhập số tham dự"));
            return;
        }

        $this->load->model('Mcustomersanticipates');

        $userId = $user['UserId'];
        $dateNow = getCurentDateTime();
        $date1 = str_replace('-', '/', $dateNow);
        $tomorrow = date('Y-m-d 00:00:00', strtotime($date1 . "+1 days"));

        if ($dateNow > date('Y-m-d 16:00:00')) {
            $dateNow = $tomorrow;
        }

        $flag = $this->Mcustomersanticipates->checkExist($userId, date('Y-m-d 00:00:00', strtotime($dateNow)));
        if ($flag) {
            echo json_encode(array('code' => -1, 'message' => "Bạn đã đăng ký số chơi xổ số rồi"));
            return;
        }

        $postData = array(
            'LotteryStationId' => 17,
            'Number' => $data['NumberOne'].  $data['NumberTwo'],
            'UserId' => $userId,
            'CrDateTime' => $dateNow,
            'StatusId' => STATUS_ACTIVED,
        );
        if ($this->Mcustomersanticipates->save($postData)) {
            echo json_encode(array('code' => 1, 'message' => "Thêm số dự đoán thành công.", 'number' => $postData['Number']));
            return;
        }
        echo json_encode(array('code' => 0, 'message' => "Có lỗi xảy ra, vui lòng thử lại."));
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
        if (empty($user) || !$customersAnticipateId) {
            echo json_encode(array('code' => 0, 'message' => "Có lỗi xảy ra, vui lòng thử lại."));
            return;
        }

        $this->load->model(array('Mcustomersanticipates', 'Mcards'));
        $cardId = $this->Mcustomersanticipates->getCardId($user['UserId'], $customersAnticipateId);
        if (empty($cardId)) {
            echo json_encode(array('code' => 0, 'message' => "Có lỗi xảy ra, vui lòng thử lại."));
            return;
        }

        $flag = $this->Mcards->save(array('CardActiveId' => 4), $cardId);
        if($flag){
            $card = $this->Mcards->get($cardId);
            $card['CardType'] = $this->Mconstants->typeCard[$card['CardTypeId']];
            echo json_encode(array('code' => 1, 'message' => "Nhận card thành công", 'data' => $card));
            return;
        }

        echo json_encode(array('code' => 0, 'message' => 'Có lỗi xảy ra, vui lòng thử lại'));
    }

    public function forGotPass(){
        $this->load->model(array('Mquestions'));
        $listQuestions = $this->Mquestions->getBy(array('StatusId' => STATUS_ACTIVED));
        $this->load->view('user/forgotpass', array("listQuestions" => $listQuestions));
    }
}
