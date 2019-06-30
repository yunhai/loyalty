<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Playerwin extends MY_Controller {

	public function index(){
        $user = $this->checkUserLogin();
        $data = $this->commonData($user,
            'Danh sách trúng thưởng',
            array(
                'scriptHeader' => array('css' => array('vendor/plugins/tagsinput/jquery.tagsinput.min.css','vendor/plugins/datepicker/datepicker3.css')),
                'scriptFooter' => array('js' => array('vendor/plugins/sortable/jquery-ui.js', 'vendor/plugins/sortable/Sortable.min.js','vendor/plugins/tagsinput/jquery.tagsinput.min.js','vendor/plugins/datepicker/bootstrap-datepicker.js', 'js/search_item.js', 'js/playerwin_list.js'))
            )
        );
        if($this->Mactions->checkAccess($data['listActions'], 'playerwin')) {
            $this->load->view('playerwin/list', $data);
        }
        else $this->load->view('user/permission', $data);
	}

    public function update(){
        $user = $this->checkUserLogin();
        $postData = $this->arrayFromPost(array('CardId', 'CustomersAnticipateId'));
        if($postData['CardId'] > 0 && $postData['CustomersAnticipateId'] > 0){
            $this->loadModel(array('Mplayerwins', 'Mcards'));
            $playerWinId = $this->Mplayerwins->save($postData);
            $flag = false;
            if($playerWinId){
                $flag = $this->Mcards->save(array('CardActiveId' => 3), $postData['CardId']);
            }
            if($flag) echo json_encode(array('code' => 1, 'message' => "Thêm card thành công"));
            else echo json_encode(array('code' => 0, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
        }else echo json_encode(array('code' => -1, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
    }

	public function searchByFilter(){
        $user = $this->checkUserLogin();
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
        $this->loadModel(array('Mcustomersanticipates'));
        $data1 = $this->Mcustomersanticipates->searchByFilterWin($searchText, $itemFilters, $limit, $page);
        $data = array_merge($data, $data1);
        echo json_encode($data);
    }
}