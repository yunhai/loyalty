<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Card extends MY_Controller {

	public function index(){
        $user = $this->checkUserLogin();
        $data = $this->commonData($user,
            'Danh sách Card',
            array(
                'scriptHeader' => array('css' => array('vendor/plugins/tagsinput/jquery.tagsinput.min.css','vendor/plugins/datepicker/datepicker3.css')),
                'scriptFooter' => array('js' => array('vendor/plugins/sortable/jquery-ui.js', 'vendor/plugins/sortable/Sortable.min.js','vendor/plugins/tagsinput/jquery.tagsinput.min.js','vendor/plugins/datepicker/bootstrap-datepicker.js', 'js/search_item.js', 'js/card_list.js'))
            )
        );
        if($this->Mactions->checkAccess($data['listActions'], 'card')) {
            $this->load->view('card/list', $data);
        }
        else $this->load->view('user/permission', $data);
	}

	public function add(){
		$user = $this->checkUserLogin();
        $data = $this->commonData($user,
            'Thêm mới Card',
            array(
                'scriptHeader' => array('css' => array('vendor/plugins/tagsinput/jquery.tagsinput.min.css')),
                'scriptFooter' => array('js' => array('vendor/plugins/timepicker/bootstrap-timepicker.min.js', 'vendor/plugins/tagsinput/jquery.tagsinput.min.js', 'js/card_update.js'))
            )
        );
        if ($this->Mactions->checkAccess($data['listActions'], 'card/add')) {
        	$this->load->view('card/add', $data);
        }
        else $this->load->view('user/permission', $data);
	}

	public function edit($cardId = 0){
        if ($cardId > 0) {
            $user = $this->checkUserLogin();
            $data = $this->commonData($user,
                'Cập nhật VIP LIKE',
                array(
                    'scriptHeader' => array('css' => array('vendor/plugins/tagsinput/jquery.tagsinput.min.css')),
                    'scriptFooter' => array('js' => array('vendor/plugins/timepicker/bootstrap-timepicker.min.js', 'vendor/plugins/tagsinput/jquery.tagsinput.min.js', 'js/card_update.js'))
                )
            );
            if ($this->Mactions->checkAccess($data['listActions'], 'card/edit')) {
                $this->loadModel(array('Mcards'));
                $card = $this->Mcards->get($cardId);
                if($card){
                    $data['card'] = $card;
                    $data['cardId'] = $cardId;
                }else{
                    $data['cardId'] = 0;
                    $data['txtError'] = "Không tìm thấy trang";
                }
                $this->load->view('card/edit', $data);
            }
            else $this->load->view('user/permission', $data);
        } else redirect('card');
	}

	public function update(){
		$user = $this->checkUserLogin();
		$postData = $this->arrayFromPost(array('CardNameId', 'CardSeri', 'CardNumber'));
        $cardId = $this->input->post('CardId');
        if($postData['CardNameId'] > 0  && $postData['CardSeri'] > 0 && $postData['CardNumber'] > 0){
        	$this->load->model('Mcards');
            $flag = $this->Mcards->checkExist($postData, $cardId);
            if($flag){
                echo json_encode(array('code' => 0, 'message' => "Card đã tồn tại."));
                return false;
            } else {
            	if($cardId > 0){
                }else{
                    $postData['CardActiveId'] = STATUS_ACTIVED;
                    $postData['StatusId'] = STATUS_ACTIVED;
                }
                $cardId = $this->Mcards->save($postData, $cardId);
                if($cardId) echo json_encode(array('code' => 1, 'message' => "Cập nhật Card thành công."));
                else echo json_encode(array('code' => 0, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
            }
        }else echo json_encode(array('code' => -1, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
	}

	public function delete(){
        $this->checkUserLogin(true);
        $cardId = $this->input->post('CardId');
        if($cardId > 0){
            $this->load->model('Mcards');
            $flag = $this->Mcards->changeStatus(0, $cardId);
            if($flag) echo json_encode(array('code' => 1, 'message' => "Xóa thành công"));
            else echo json_encode(array('code' => 0, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
        }
        else echo json_encode(array('code' => -1, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
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
        $this->loadModel(array('Mcards'));
        $data1 = $this->Mcards->searchByFilter($searchText, $itemFilters, $limit, $page);
        $data = array_merge($data, $data1);
        echo json_encode($data);
    }
}