<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Action extends MY_Controller {

	public function index(){
		$user = $this->checkUserLogin();
		$data = $this->commonData($user,
			'Menu hệ thống nội bộ',
			array('scriptFooter' => array('js' => 'js/action.js'))
		);
		if ($this->Mactions->checkAccess($data['listActions'], 'action')) {
			$data['listActiveActions'] = $this->Mactions->getHierachy();
			$this->load->view('setting/action', $data);
		}
		else $this->load->view('user/permission', $data);
	}

	public function update(){
		$this->checkUserLogin(true);
		$postData = $this->arrayFromPost(array('ActionName', 'ActionUrl', 'ParentActionId', 'DisplayOrder', 'FontAwesome', 'ActionLevel'));
		$postData['StatusId'] = STATUS_ACTIVED;
		$actionId = $this->input->post('ActionId');
		$flag = $this->Mactions->update($postData, $actionId);
		if($flag) echo json_encode(array('code' => 1, 'message' => "Cập nhật menu thành công"));
		else echo json_encode(array('code' => 0, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
	}

	public function delete(){
		$this->checkUserLogin(true);
		$actionId = $this->input->post('ActionId');
		if($actionId > 0){
			$flag = $this->Mactions->deleteBy($actionId);
			if($flag) echo json_encode(array('code' => 1, 'message' => "Xóa menu thành công"));
			else echo json_encode(array('code' => 0, 'message' => "Menu này chưa xóa được vì có menu con"));
		}
		else echo json_encode(array('code' => -1, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
	}
}