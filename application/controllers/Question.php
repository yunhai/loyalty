<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Question extends MY_Controller {

	public function index(){
        $user = $this->checkUserLogin();
        $data = $this->commonData($user,
            'Danh sách câu hỏi',
            array('scriptFooter' => array('js' => 'js/question.js'))
        );
        if($this->Mactions->checkAccess($data['listActions'], 'question')) {
            $this->load->model('Mquestions');
            $data['listQuestions'] = $this->Mquestions->getBy(array('StatusId' => STATUS_ACTIVED));
            $this->load->view('setting/question', $data);
        }
        else $this->load->view('user/permission', $data);
    }

    public function update(){
        $this->checkUserLogin(true);
        $postData = $this->arrayFromPost(array('QuestionName'));
        if(!empty($postData['QuestionName'])) {
            $postData['StatusId'] = STATUS_ACTIVED;
            $questionId = $this->input->post('QuestionId');
            $this->load->model('Mquestions');
            $flag = $this->Mquestions->save($postData, $questionId);
            if ($flag > 0) {
                $postData['QuestionId'] = $flag;
                $postData['IsAdd'] = ($questionId > 0) ? 0 : 1;
                echo json_encode(array('code' => 1, 'message' => "Cập nhật câu hỏi thành công", 'data' => $postData));
            }
            else echo json_encode(array('code' => 0, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
        }
        else echo json_encode(array('code' => -1, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
    }

    public function delete(){
        $this->checkUserLogin(true);
        $questionId = $this->input->post('QuestionId');
        if($questionId > 0){
            $this->load->model('Mquestions');
            $flag = $this->Mquestions->changeStatus(0, $questionId);
            if($flag) echo json_encode(array('code' => 1, 'message' => "Xóa loại câu hỏi thành công"));
            else echo json_encode(array('code' => 0, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
        }
        else echo json_encode(array('code' => -1, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
    }
}