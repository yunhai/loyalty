<?php
defined('BASEPATH') OR exit('No direct script access allowed');

abstract class MY_Controller extends CI_Controller {

    public function __construct(){
        parent::__construct();
        if(function_exists('date_default_timezone_set')) date_default_timezone_set('Asia/Bangkok');
        $user = $this->Musers->get(1);$this->session->set_userdata('user', $user);
    }

    protected function commonData($user, $title, $data = array()){
        $data['user'] = $user;
        $data['title'] = $title;
        $data['listActions'] = $this->Mactions->getByUserId($user['UserId']);
        //$data['listProductTypes'] = $this->Mproducttypes->getBy(array('StatusId' => STATUS_ACTIVED));
        return $data;
    }

    protected function checkUserLogin($isApi = false){
        $user = $this->session->userdata('user');
        if($user){
            $statusId = $this->Musers->getFieldValue(array('UserId' => $user['UserId']), 'StatusId', 0);
            if($statusId == STATUS_ACTIVED) return $user;
            else{
                $fields = array('user', 'configs');
                foreach($fields as $field) $this->session->unset_userdata($field);
                if($isApi) echo json_encode(array('code' => -1, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
                else redirect('admin?redirectUrl='.current_url());
                die();
            }
        }
        else{
            if($isApi) echo json_encode(array('code' => -1, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
            else redirect('admin?redirectUrl='.current_url());
            die();
        }
    }

    protected function checkUserLoginHome($isApi = false){
        $user = $this->session->userdata('user');
        if($user){
            $statusId = $this->Musers->getFieldValue(array('UserId' => $user['UserId']), 'StatusId', 0);
            if($statusId == STATUS_ACTIVED) return $user;
            else{
                $fields = array('user', 'configs');
                foreach($fields as $field) $this->session->unset_userdata($field);
                if($isApi) echo json_encode(array('code' => -1, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
                else echo json_encode(array('code' => 0, 'message' => "Vui lòng đăng nhập"));
                die();
            }
        }
        else{
            if($isApi) echo json_encode(array('code' => -1, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
            else echo json_encode(array('code' => 0, 'message' => "Vui lòng đăng nhập"));
            die();
        }
    }

    protected function loadModel($models = array()){
        foreach($models as $model) $this->load->model($model);
    }

    protected function arrayFromPost($fields) {
        $data = array();
        foreach ($fields as $field) $data[$field] = trim($this->input->post($field));
        return $data;
    }

    protected function arrayFromGet($fields) {
        $data = array();
        foreach ($fields as $field) $data[$field] = trim($this->input->get($field));
        return $data;
    }

    protected function sendMail($emailFrom, $nameFrom, $emailTo, $subject, $messageBody, $files = array()){
        /*$this->load->library('email');
        $this->email->set_mailtype("html");
        $this->email->set_newline("\r\n");
        $this->email->from($emailFrom, $nameFrom);
        $this->email->to($emailTo);
        $this->email->subject($subject);
        $this->email->message($messageBody);
        if($this->email->send()) return true;
        return false;*/
        require_once APPPATH.'third_party/swiftmailer/autoload.php';
        $transport = (new Swift_SmtpTransport('smtp.googlemail.com', 465, 'ssl'))
            ->setUsername('infor02@ceocorp.vn')
            ->setPassword('info@123456')
        ;
        $mailer = new Swift_Mailer($transport);
        $message = (new Swift_Message($subject))
            ->setFrom([$emailFrom => $nameFrom])
            ->setTo($emailTo)
            ->setBody($messageBody);
        if(!empty($files)) {
            foreach ($files as $file) {
                $message->attach(
                    Swift_Attachment::fromPath($file['url'])->setFilename($file['name'])
                );
            }
        }
        return $mailer->send($message);
    }

    function updateDepartBy($userId) {
        $this->loadModel(['Mdepartments', 'Mpositions']);
        $levelMax = $this->Mpositions->getLevelBy($userId);
        $positionDetail = $this->Mpositions->getBy(['CrUserId' => $userId, 'ParentPositionId' => 0, 'StatusId' => 2, 'OrganizeChartId' => 0], true);
        if(!empty($positionDetail)) {
            $PositionId = $positionDetail['PositionId'];
            $DepartmentId = $positionDetail['DepartmentId'];
            $checkExist = $this->Mdepartments->getBy(['DepartmentId' => $DepartmentId, 'StatusId' => 2]);
            if(empty($checkExist) || $DepartmentId == 0) {
                $dataDepartment = [
                    'DepartmentLevel' => 1,
                    'IsCEO' => 1,
                    'StatusId' => 2,
                    'ParentDepartmentId' => 0,
                    'CrUserId' => $userId,
                    'CrDateTime' => getCurentDateTime()
                ];
                $ParentDepartmentId = $this->Mdepartments->save($dataDepartment);
            }  else {
                $ParentDepartmentId = $DepartmentId;
            }
            $this->Mpositions->updateBy(['PositionId' => $PositionId], ['DepartmentId' => $ParentDepartmentId]);
            $this->updateItemDepartment($ParentDepartmentId, $PositionId, $userId, $levelMax);
        }
    }

    function updateItemDepartment($ParentDepartmentId, $PositionId, $userId, $levelMax) {
        $listPosition = $this->Mpositions->getBy(['ParentPositionId' => $PositionId, 'StatusId' => 2, 'CrUserId' => $userId, 'OrganizeChartId' => 0]);
        $this->Mactions->updateBy(['UserId' => $userId, 'DepartmentLevel >=' => $levelMax], ['StatusId' => 0]);
        $dataArr = [];
        if(!empty($listPosition)) {
            foreach ($listPosition as $key=>$position) {
                $PositionId = $position['PositionId'];
                $DepartmentId = $position['DepartmentId'];
                $checkExist = $this->Mdepartments->getBy(['DepartmentLevel' => $position['PositionLevel'], 'StatusId' => 2, 'OrganizeChartId' => 0]);
                $DepartmentTypeId = $IsCEO = 0;
                if(!empty($checkExist)) {
                    foreach ($checkExist as $item) {
                        if($item['DepartmentTypeId'] > 0) {
                            $DepartmentTypeId = $item['DepartmentTypeId'];
                        }

                        if($item['IsCEO'] == 1) {
                            $IsCEO = $item['IsCEO'];
                        }
                    }
                }
                $dataDepartment = [
                    'DepartmentLevel' => $position['PositionLevel'],
                    'ParentDepartmentId' => $ParentDepartmentId,
                    'DepartmentTypeId' => $DepartmentTypeId,
                    'IsCEO' => $IsCEO,
                    'StatusId' => 2,
                    'CrUserId' => $userId,
                    'CrDateTime' => getCurentDateTime()
                ];
                $DepartmentId = $this->Mdepartments->save($dataDepartment, $DepartmentId);
                $this->updateItemDepartment($DepartmentId, $PositionId, $userId, $levelMax);
                $this->Mpositions->updateBy(['PositionId' => $PositionId], ['DepartmentId' => $DepartmentId]);
            }
        }
    }
}