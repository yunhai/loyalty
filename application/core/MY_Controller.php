<?php
defined('BASEPATH') OR exit('No direct script access allowed');

abstract class MY_Controller extends CI_Controller {

    public function __construct(){
        parent::__construct();
        if(function_exists('date_default_timezone_set')) date_default_timezone_set('Asia/Bangkok');
    }

    protected function commonData($user, $title, $data = array()){
        $data['user'] = $user;
        $data['title'] = $title;
        $data['listActions'] = $this->Mactions->getByUserId($user['UserId']);
        return $data;
    }

    public function getUserFromSesson($fe = true) {
        $user = $this->session->userdata('user');
        if ($fe) {
            return ($user['RoleId'] != 1) ? $user : [];
        }

        return ($user['RoleId'] == 1) ? $user : [];
    }

    protected function checkUserLogin($isApi = false){
        // $user = $this->session->userdata('user');
        $user = $this->getUserFromSesson(false);
        if ($user) {
            $statusId = $this->Musers->getFieldValue(array('UserId' => $user['UserId']), 'StatusId', 0);
            if ($statusId == STATUS_ACTIVED) {
                return $user;
            }
            $fields = array('user', 'configs');
            foreach ($fields as $field) {
                $this->session->unset_userdata($field);
            }
            if($isApi) {
                echo json_encode(array('code' => -1, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
            }
            else {
                redirect('admin?redirectUrl='.current_url());
            }
            die();
        }
        else {
            if($isApi) echo json_encode(array('code' => -1, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
            else redirect('admin?redirectUrl='.current_url());
            die();
        }
    }

    protected function checkUserLoginHome($isApi = false){
        $user = $this->getUserFromSesson(true);
        if($user) {
            $statusId = $this->Musers->getFieldValue(array('UserId' => $user['UserId']), 'StatusId', 0);
            if ($statusId == STATUS_ACTIVED) {
                return $user;
            }
            else{
                $fields = array('user', 'configs');
                foreach($fields as $field) {
                    $this->session->unset_userdata($field);
                }
                if($isApi) {
                    echo json_encode(array('code' => -1, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
                } else {
                    echo json_encode(array('code' => 0, 'message' => "Vui lòng đăng nhập"));
                }
                die();
            }
        }
        else {
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
}