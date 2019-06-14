<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller {

	public function updateProfile(){
		$user = $this->checkUserLogin(true);
		$postData = $this->arrayFromPost(array('UserPass', 'NewPass', 'FullName', 'Email', 'GenderId', 'ProvinceId', 'DistrictId', 'WardId', 'Address', 'BirthDay', 'PhoneNumber', 'DegreeName', 'Avatar', 'Facebook'));
		if(!empty($postData['FullName']) && $postData['GenderId'] > 0) {
			$flag = false;
			if (!empty($postData['NewPass'])) {
				if ($user['UserPass'] == md5($postData['UserPass'])) {
					$flag = true;
					$postData['UserPass'] = md5($postData['NewPass']);
					unset($postData['NewPass']);
				}
				else echo json_encode(array('code' => -1, 'message' => "Mật khảu cũ không đúng"));
			}
			else {
				$flag = true;
				unset($postData['UserPass']);
				unset($postData['NewPass']);
			}
			if ($flag) {
				if($this->Musers->checkExist($user['UserId'], $postData['Email'], $postData['PhoneNumber'])) {
					echo json_encode(array('code' => -1, 'message' => "Tên đăng nhập hoặc Số điện thoại đã tồn tại trong hệ thống"));
				}
				else {
					$postData['BirthDay'] = ddMMyyyyToDate($postData['BirthDay']);
					if(empty($postData['Avatar'])) $postData['Avatar'] = NO_IMAGE;
					else $postData['Avatar'] = replaceFileUrl($postData['Avatar'], USER_PATH);
					$postData['UpdateUserId'] = $user['UserId'];
					$postData['UpdateDateTime'] = getCurentDateTime();
					$userId = $this->Musers->update($postData, $user['UserId'], false);
					if($userId > 0){
						$user = array_merge($user, $postData);
						$this->session->set_userdata('user', $user);
						echo json_encode(array('code' => 1, 'message' => "Cập nhật thông tin cá nhân thành công"));
					}
					else echo json_encode(array('code' => 0, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
				}
			}
		}
		else echo json_encode(array('code' => -1, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
	}

	public function changeStatus(){
		$user = $this->checkUserLogin(true);
		$userId = $this->input->post('UserId');
		$statusId = $this->input->post('StatusId');
		if($userId > 0 && $statusId >= 0 && $statusId <= count($this->Mconstants->status)) {
			$flag = $this->Musers->changeStatus($statusId, $userId, '', $user['UserId']);
			if($flag) {
				$statusName = "";
				if($statusId == 0) $txtSuccess = "Xóa {$this->input->post('UserTypeName')} thành công";
				else{
					$txtSuccess = "Đổi trạng thái thành công";
					$statusName = '<span class="' . $this->Mconstants->labelCss[$statusId] . '">' . $this->Mconstants->status[$statusId] . '</span>';
				}
				echo json_encode(array('code' => 1, 'message' => $txtSuccess, 'data' => array('StatusName' => $statusName)));
			}
			else echo json_encode(array('code' => 0, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
		}
		else echo json_encode(array('code' => -1, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
	}

	public function saveUser(){
		$user = $this->session->userdata('user');
		$postData = $this->arrayFromPost(array('UserName','UserPass','FullName', 'Email','PhoneNumber', 'AnswerId', 'QuestionId'));
		$userId = $this->input->post('UserId');
		if(!empty($postData['FullName']) && !empty($postData['PhoneNumber']) && $postData['AnswerId'] > 0 && $postData['QuestionId'] > 0) {
			if ($this->Musers->checkExist($userId, $postData['Email'], $postData['PhoneNumber'])) {
				echo json_encode(array('code' => -1, 'message' => "Số điện thoại hoặc Email đã tồn tại trong hệ thống"));
			}
			else {
				$userPass = $postData['UserPass'];
				if ($userId == 0){
					$postData['StatusId'] = STATUS_ACTIVED;
					$postData['RoleId'] = 2;
					$postData['UserPass'] = md5($userPass);
					$postData['CrUserId'] = ($user) ? $user['UserId'] : 0;
					$postData['CrDateTime'] = getCurentDateTime();
				}
				else {
					unset($postData['UserPass']);
					$newPass = trim($this->input->post('NewPass'));
					if (!empty($newPass)) $postData['UserPass'] = md5($newPass);
					$postData['UpdateUserId'] = ($user) ? $user['UserId'] : 0;
					$postData['UpdateDateTime'] = getCurentDateTime();
				}
				$userId = $this->Musers->update($postData, $userId, true);
				if ($userId > 0) {
					if($user && $user['UserId'] == $userId){
						$user = array_merge($user, $postData);
						$this->session->set_userdata('user', $user);
					}
					echo json_encode(array('code' => 1, 'message' => "Cập nhật khách hàng thành công", 'data' => $userId));
				}
				else echo json_encode(array('code' => 0, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
			}
		}
		else echo json_encode(array('code' => -1, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
	}

	public function checkLogin(){
        header('Access-Control-Allow-Origin: *');
		header('Content-Type: application/json');
		//log_message('error', json_encode($_POST));
		//log_message('error', json_encode(file_get_contents('php://input')));
		$postData = $this->arrayFromPost(array('UserName', 'UserPass', 'IsRemember', 'IsGetConfigs'));
		$userName = $postData['UserName'];
		$userPass = $postData['UserPass'];
		if(!empty($userName) && !empty($userPass)) {
			$configs = array();
			$user = $this->Musers->login($userName, $userPass);
			if ($user) {
				if(empty($user['Avatar'])) $user['Avatar'] = NO_IMAGE;
				$this->session->set_userdata('user', $user);
				if ($postData['IsGetConfigs'] == 1) {
					$this->load->model('Mconfigs');
					$configs = $this->Mconfigs->getListMap();
					$this->session->set_userdata('configs', $configs);
				}
				if ($postData['IsRemember'] == 'on') {
					$this->load->helper('cookie');
					$this->input->set_cookie(array('name' => 'userName', 'value' => $userName, 'expire' => '86400'));
					$this->input->set_cookie(array('name' => 'userPass', 'value' => $userPass, 'expire' => '86400'));
				}
                $user['SessionId'] = uniqid();
				echo json_encode(array('code' => 1, 'message' => "Đăng nhập thành công", 'data' => array('User' => $user, 'Configs' => $configs, 'message' => "Đăng nhập thành công")));
			}
			else echo json_encode(array('code' => 0, 'message' => "Đăng nhập không thành công"));
		}
		else echo json_encode(array('code' => -1, 'message' => "Tên đăng nhập hoặc Mật khẩu không được bỏ trống"));
	}

	public function forgotPass(){
		header('Content-Type: application/json');
		$email = trim($this->input->post('Email'));
		if(!empty($email)){
			$user = $this->Musers->getBy(array('StatusId' => STATUS_ACTIVED, 'Email' => $email), true, "", "UserId,FullName");
			if($user){
				$userPass = bin2hex(mcrypt_create_iv(5, MCRYPT_DEV_RANDOM));
				$message = "Xin chào {$user['FullName']}.<br/> Mật khẩu mới của bạn là {$userPass}";
				$this->load->model('Mconfigs');
				$configs = $this->Mconfigs->getListMap();
				$emailFrom = isset($configs['EMAIL_COMPANY']) ? $configs['EMAIL_COMPANY'] : 'ricky@gmail.com';
				$companyName = isset($configs['COMPANY_NAME']) ? $configs['COMPANY_NAME'] : 'Ricky';
				$flag = $this->sendMail($emailFrom, $companyName, $email, 'Mật khẩu mới của bạn', $message);
				if($flag){
					$this->Musers->save(array('UserPass' => md5($userPass)), $user['UserId']);
					echo json_encode(array('code' => 1, 'message' => "Đã gửi mật khẩu vào {$email}", 'data' => array('message' => "Đăng nhập thành công")));
				}
				else echo json_encode(array('code' => 0, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
			}
			else echo json_encode(array('code' => 0, 'message' => "Người dùng không tốn tại hoặc chưa kích hoạt"));
		}
		else echo json_encode(array('code' => -1, 'message' => "Email không được bỏ trống"));
	}

	public function checkStatus(){
		header('Content-Type: application/json');
		$userName = trim($this->input->post('UserName'));
		if(!empty($userName)){
			$userId = $this->Musers->getFieldValue(array('UserName' => $userName, 'StatusId' => STATUS_ACTIVED), 'UserId', 0);
			if($userId > 0) echo json_encode(array('code' => 1, 'message' => "Nhân viên vẫn còn hiệu lực"));
			else echo json_encode(array('code' => -1, 'message' => "Nhân viên không còn hiệu lực"));
		}
		else echo json_encode(array('code' => -1, 'message' => "Tên đăng nhập không được bỏ trống"));
	}

	public function logout(){
		$fields = array('user', 'configs');
		foreach($fields as $field) $this->session->unset_userdata($field);
	}

	public function requestSendToken(){
		$email = trim($this->input->post('Email'));
		if(!empty($email)){
			$user = $this->Musers->getBy(array('StatusId' => STATUS_ACTIVED, 'Email' => $email), true, "", "UserId,FullName");
			if($user){
				$token = bin2hex(mcrypt_create_iv(10, MCRYPT_DEV_RANDOM));
				$token = substr($token, 0, 14);
				$message = "Xin chào {$user['FullName']}<br/>Xin vào link ".base_url('user/changePass/'.$token).' để đổi mật khẩu.';
				$configs = $this->session->userdata('configs');
				if(!$configs) $configs = array();
				$emailFrom = isset($configs['EMAIL_COMPANY']) ? $configs['EMAIL_COMPANY'] : 'ricky@gmail.com';
				$companyName = isset($configs['COMPANY_NAME']) ? $configs['COMPANY_NAME'] : 'Ricky';
				$flag = $this->sendMail($emailFrom, $companyName, $email, 'Lấy lại mật khẩu', $message);
				if($flag){
					$this->Musers->save(array('Token' => $token), $user['UserId']);
					echo json_encode(array('code' => 1, 'message' => "Kiểm tra email và làm theo hướng dẫn"));
				}
				else echo json_encode(array('code' => 0, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
			}
			else echo json_encode(array('code' => 0, 'message' => "Người dùng không tốn tại hoặc chưa kích hoạt"));
		}
		else echo json_encode(array('code' => -1, 'message' => "Email không được bỏ trống"));
	}

    public function addUsers(){
        $user = $this->checkUserLogin(true);
        $this->loadModel(['Musers', 'Muserpositions']);
        $postData = $this->arrayFromPost(array('FullName', 'GenderId', 'PhoneNumber', 'Email', 'BirthDay', 'UserPass', 'IsOld'));
        //$PositionId = $this->input->post('PositionId');
        $message = $this->getMessageError($postData, false, 0,2);
        if(!empty($message)) {
            echo json_encode(['code' => 0, 'message' => $message['message'], 'field' => $message['field']]);
        }
        else {
            if ($this->Musers->checkStaffExist(0, $postData['PhoneNumber'], $user['UserId'])) {
                echo json_encode(array('code' => -1, 'message' => "Số điện thoại đã tồn tại trong hệ thống"));
                die;
            }
            $userPass = $postData['UserPass'];
            $postData['UserPass'] = md5($userPass);
            //$postData['UserPassRaw'] = $userPass;
            $postData['CrUserId'] = $user['UserId'];
            $postData['CrDateTime'] = getCurentDateTime();
            $postData['StatusId'] =  2;
            $postData['RoleId'] =  2;
            $postData['Email'] = strtolower($postData['Email']);
            $postData['BirthDay'] = ddMMyyyyToDate($postData['BirthDay']);
            $userId = $this->Musers->save($postData);
            if($userId > 0) {
                $UserIdText =  'NV-'.($userId + 10000);
                echo json_encode(['code' => 1, 'message' => 'Thêm nhân viên vào vị trí thành công', 'id' => $userId, 'UserIdText' => $UserIdText, 'FullName' => $postData['FullName'], 'PhoneNumber' => $postData['PhoneNumber']]);
            }
            else echo json_encode(array('code' => -1, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
        }
    }

    function getMessageError($postData, $checkPass = false, $userId = 0, $roleId = 0) {
        $user = $this->checkUserLogin(true);
        $FullName = $postData['FullName'];
        $Password = $postData['UserPass'];
        $PhoneNumber = $postData['PhoneNumber'];
        $Email = strtolower($postData['Email']);
        if($FullName == '') {
            return [
                'message' => 'Họ tên không được phép để trống',
                'field' => 'FullName'
            ];
        }

        if($PhoneNumber == '') {
            return [
                'message' => 'Số điện thoại không được phép để trống',
                'field' => 'PhoneNumber'
            ];
        }

        if($checkPass) {
            if($postData['UserPass'] == '') {
                return [
                    'message' => 'Mật khẩu không được phép để trống',
                    'field' => 'UserPass'
                ];
            }
            if($userId == 0) {
                if($this->input->post('PackageId') == '') {
                    return [
                        'message' => 'Gói sử dụng không được phép để trống',
                        'field' => 'PackageId'
                    ];
                }
            }
        }

        if($Email == '') {
            return [
                'message' => 'Email không được phép để trống',
                'field' => 'Email'
            ];
        }

        if($Password == '') {
            return [
                'message' => 'Mật khẩu không được phép để trống',
                'field' => 'UserPass'
            ];
        }

        $checkEmail = $this->isValidEmail($Email);
        if(!$checkEmail) {
            return [
                'message' => 'Định dạng email chưa đúng',
                'field' => 'Email'
            ];
        }

        $checkPhone = $this->checkPhoneNumeber($PhoneNumber);
        if(!$checkPhone) {
            return [
                'message' => 'Định dạng số điện thoại chưa đúng',
                'field' => 'PhoneNumber'
            ];
        }
        if($roleId == 2 || $roleId == 3) {
            $checkExistPhoneNumber = $this->Musers->getBy(['PhoneNumber' => $PhoneNumber, 'StatusId' => 2, 'RoleId' => $roleId, 'UserId !=' => $userId, 'CrUserId' => $user['UserId']]);
            $checkExistEmail = $this->Musers->getBy(['Email' => $Email, 'StatusId' => 2, 'RoleId' => $roleId, 'UserId !=' => $userId, 'CrUserId' => $user['UserId']]);
            if(!empty($checkExistPhoneNumber)) {
                return [
                    'message' => 'Số điện thoại đã tồn tại',
                    'field' => 'PhoneNumber'
                ];
            }
            if(!empty($checkExistEmail)) {
                return [
                    'message' => 'Email đã tồn tại',
                    'field' => 'Email'
                ];
            }
        }
        return '';
    }

    function isValidEmail($email){
        $regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
        if (preg_match($regex, $email)){
            return true;
        }
        else {
            return false;
        }
    }

    function checkPhoneNumeber($phone) {
        $regex = '/^(\d[\s-]?)?[\(\[\s-]{0,2}?\d{3}[\)\]\s-]{0,2}?\d{3}[\s-]?\d{4}$/i';
        if(preg_match($regex, $phone)) {
            return true;
        } else {
            return false;
        }
    }
}