<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lotteryresult extends MY_Controller {

	public function index(){
        $user = $this->checkUserLogin();
        if($user['RoleId'] == 1){
            $data = $this->commonData($user,
                'Danh sách Kết quả xổ số',
                array(
                    'scriptHeader' => array('css' => array('vendor/plugins/tagsinput/jquery.tagsinput.min.css','vendor/plugins/datepicker/datepicker3.css')),
                    'scriptFooter' => array('js' => array('vendor/plugins/sortable/jquery-ui.js', 'vendor/plugins/sortable/Sortable.min.js','vendor/plugins/tagsinput/jquery.tagsinput.min.js','vendor/plugins/datepicker/bootstrap-datepicker.js', 'js/search_item.js', 'js/lotteryresult_list.js'))
                )
            );
            if($this->Mactions->checkAccess($data['listActions'], 'lotteryresult')) {
                $this->load->view('lotteryresult/list', $data);
            }
            else $this->load->view('user/permission', $data);
        } else redirect(base_url());
	}

	public function add(){
		$user = $this->checkUserLogin();
        if($user['RoleId'] == 1){
            $data = $this->commonData($user,
                'Thêm mới Kết quả xổ số',
                array(
                    'scriptHeader' => array('css' => array('vendor/plugins/tagsinput/jquery.tagsinput.min.css','vendor/plugins/datepicker/datepicker3.css')),
                    'scriptFooter' => array('js' => array('vendor/plugins/timepicker/bootstrap-timepicker.min.js', 'vendor/plugins/tagsinput/jquery.tagsinput.min.js','vendor/plugins/datepicker/bootstrap-datepicker.js', 'js/lotteryresult_update.js'))
                )
            );
            if ($this->Mactions->checkAccess($data['listActions'], 'lotteryresult/add')) {
            	$this->loadModel(array('Mlotterystations'));
            	$data['lotteryStationList'] = $this->Mlotterystations->getBy(array());
            	$this->load->view('lotteryresult/add', $data);
            }
            else $this->load->view('user/permission', $data);
        } else redirect(base_url());
	}

    public function edit($lotteryResultId = 0){
        $user = $this->checkUserLogin();
        if($user['RoleId'] == 1){
            if ($lotteryResultId > 0) {
                $data = $this->commonData($user,
                    'Cập nhật Kết quả xổ số',
                    array(
                        'scriptHeader' => array('css' => array('vendor/plugins/tagsinput/jquery.tagsinput.min.css','vendor/plugins/datepicker/datepicker3.css')),
                        'scriptFooter' => array('js' => array('vendor/plugins/timepicker/bootstrap-timepicker.min.js', 'vendor/plugins/tagsinput/jquery.tagsinput.min.js','vendor/plugins/datepicker/bootstrap-datepicker.js', 'js/lotteryresult_update.js'))
                    )
                );
                if ($this->Mactions->checkAccess($data['listActions'], 'lotteryresult/edit')) {
                    $this->loadModel(array('Mlotterystations', 'Mlotteryresults', 'Mlotteryresultdetails'));
                    $lotteryresult = $this->Mlotteryresults->get($lotteryResultId);
                    if($lotteryresult){
                        $data['lotteryStationList'] = $this->Mlotterystations->getBy(array());
                        $data['lotteryresult'] = $lotteryresult;
                        $data['lotteryResultId'] = $lotteryResultId;
                    }else{
                        $data['lotteryResultId'] = 0;
                        $data['txtError'] = "Không tìm thấy trang";
                    }
                    
                    $this->load->view('lotteryresult/edit', $data);
                }
                else $this->load->view('user/permission', $data);
            } else redirect('lotteryresult');
        } else redirect(base_url());
    }

    public function update(){
        $user = $this->checkUserLogin();
        if($user['RoleId'] == 1){
            $postData = $this->arrayFromPost(array('LotteryStationId', 'CrDateTime', 'Raffle'));
            if(!empty($postData['CrDateTime']) && $postData['LotteryStationId'] > 0){
                $lotteryResultId = $this->input->post('LotteryResultId');
                $this->load->model('Mlotteryresults');
                $postData['StatusId'] = STATUS_ACTIVED;
                if (!empty($postData['CrDateTime'])) $postData['CrDateTime'] = ddMMyyyyToDate($postData['CrDateTime']);
                $lotteryResultId = $this->Mlotteryresults->save($postData, $lotteryResultId);
                if ($lotteryResultId > 0) echo json_encode(array('code' => 1, 'message' => "Cập nhật thành công", 'data' => $lotteryResultId));
                else echo json_encode(array('code' => 0, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
            }else echo json_encode(array('code' => -1, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
        } else redirect(base_url());
    }

    public function delete(){
        $user = $this->checkUserLogin();
        if($user['RoleId'] == 1){
            $lotteryResultId = $this->input->post('LotteryResultId');
            if($lotteryResultId > 0){
                $this->load->model('Mlotteryresults');
                $flag = $this->Mlotteryresults->changeStatus(0, $lotteryResultId);
                if($flag) echo json_encode(array('code' => 1, 'message' => "Xóa thành công"));
                else echo json_encode(array('code' => 0, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
            }
            else echo json_encode(array('code' => -1, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
        } else redirect(base_url());
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
        $this->loadModel(array('Mlotteryresults'));
        $data1 = $this->Mlotteryresults->searchByFilter($searchText, $itemFilters, $limit, $page);
        $data = array_merge($data, $data1);
        echo json_encode($data);
    }
}