<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller {

	public function register() {
		$postData = $this->arrayFromPost(array('Password', 'FullName', 'Email', 'PhoneNumber', 'ConfirmPassword', 'SecurityQuestion', 'SecurityAnswer'));

        $password = trim($postData['Password']);
        $confirmPassword = trim($postData['ConfirmPassword']);

        if (empty($postData['PhoneNumber']) ||
            empty($password) ||
            empty($confirmPassword) ||
            empty($postData['FullName']) ||
            empty($postData['Email']) ||
            empty($postData['SecurityQuestion']) ||
            empty($postData['SecurityAnswer'])
        ) {
            echo json_encode(array('code' => -1, 'message' => "Vui lòng nhập đầy đủ thông tin"));
            return;
        }

        // $postData['Email'] = time() . '@email.com';
        // $postData['PhoneNumber'] = time();

        $username = $postData['PhoneNumber'] ?? $postData['Email'] ?? '';
        if ($this->Musers->checkExist(0, $postData['Email'], $postData['PhoneNumber'])) {
            echo json_encode(array('code' => -1, 'message' => "Số điện thoại hoặc Email đã tồn tại trong hệ thống"));
            return;
        }

        $data = [
            'UserName' => $username,
            'UserPass' => md5($this->getPassword($password)),
            'FullName' => $postData['FullName'],
            'PhoneNumber' => $postData['PhoneNumber'],
            'Email' => $postData['Email'],
            'FullName' => $postData['FullName'],
            'QuestionId' => $postData['SecurityQuestion'],
            'AnswerId' => $postData['SecurityAnswer'],
            'GenderId' => 1,
            'RoleId' => 2,
            'StatusId' => 2,
            'CrUserId' => 1,
            'CrDateTime' => getCurentDateTime(),
        ];

        $userId = $this->Musers->update($data, 0, true);
        if ($userId > 0) {
            echo json_encode(array('code' => 1, 'message' => "Đăng ký thành viên đã thành công.", 'data' => $userId));
            return;
        }

        echo json_encode(array('code' => 0, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
        return;
    }

	public function resetPassword(){
        $postData = $this->arrayFromPost(['PhoneNumber', 'Password', 'ConfirmPassword', 'SecurityQuestion', 'SecurityAnswer']);

        $password = trim($postData['Password']);
        $confirmPassword = trim($postData['ConfirmPassword']);
        if (empty($postData['PhoneNumber']) ||
            empty($password) ||
            empty($confirmPassword) ||
            empty($postData['SecurityQuestion']) ||
            empty($postData['SecurityAnswer'])
        ) {
            echo json_encode(array('code' => -1, 'message' => "Vui lòng nhập đầy đủ thông tin"));
            return;
        }

        if ($confirmPassword != $password) {
            echo json_encode(array('code' => -1, 'message' => "Mật khẩu & mật khẩu xác thực không khớp"));
            return;
        }

        $targetId = $this->Musers->checkExistForGot($postData);
        if ($targetId == 0) {
            echo json_encode(array('code' => -1, 'message' => "Thông tin cung cấp không chính xác"));
            return;
        }

        $newPass = trim($postData['Password']);
        $update = array(
                "UserPass" => md5($this->getPassword($postData['Password'])),
                "UpdateUserId" => 1,
                "UpdateDateTime" => getCurentDateTime(),
        );

        $userId = $this->Musers->save($update, $targetId);
        if ($userId > 0)  {
            echo json_encode(array('code' => 1, 'message' => "Đổi mật khẩu thành công."));
            return;
        }
        echo json_encode(array('code' => 0, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
    }

    public function password(){
        $postData = $this->arrayFromPost(['CurrentPassword', 'Password', 'ConfirmPassword']);

        $password = trim($postData['Password']);
        $confirmPassword = trim($postData['ConfirmPassword']);
        $currentPassword = trim($postData['CurrentPassword']);
        if (empty($password) ||
            empty($currentPassword) ||
            empty($confirmPassword)
        ) {
            echo json_encode(array('code' => -1, 'message' => "Vui lòng nhập đầy đủ thông tin"));
            return;
        }

        if ($confirmPassword != $password) {
            echo json_encode(array('code' => -1, 'message' => "Mật khẩu & mật khẩu xác thực không khớp"));
            return;
        }

        $target = $this->checkUserLogin(true);
        if ($target['UserPass'] != md5($this->getPassword($currentPassword))) {
            echo json_encode(array('code' => -1, 'message' => "Mật khẩu cũ không chính xác"));
            return;
        }

        $update = array(
            "UserPass" => md5($this->getPassword($password)),
            "UpdateUserId" => 1,
            "UpdateDateTime" => getCurentDateTime(),
        );

        $userId = $this->Musers->save($update, $target['UserId']);
        if ($userId > 0)  {
            $this->session->set_userdata('user', array_merge($target, $update));
            echo json_encode(array('code' => 1, 'message' => "Đổi mật khẩu thành công."));
            return;
        }
        echo json_encode(array('code' => 0, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
    }

    public function profile(){
        $postData = $this->arrayFromPost(['PhoneNumber', 'Email', 'FullName', 'SecurityQuestion', 'SecurityAnswer']);
        if (empty($postData['PhoneNumber']) ||
            empty($postData['Email']) ||
            empty($postData['FullName']) ||
            empty($postData['SecurityQuestion']) ||
            empty($postData['SecurityAnswer'])
        ) {
            echo json_encode(array('code' => -1, 'message' => "Vui lòng nhập đầy đủ thông tin"));
            return;
        }

        $username = $postData['PhoneNumber'] ?? $postData['Email'] ?? '';
        $update = array(
            'UserName' => $username,
            'FullName' => $postData['FullName'],
            'PhoneNumber' => $postData['PhoneNumber'],
            'Email' => $postData['Email'],
            'QuestionId' => $postData['SecurityQuestion'],
            'AnswerId' => $postData['SecurityAnswer'],
            "UpdateUserId" => 1,
            "UpdateDateTime" => getCurentDateTime(),
        );
        $target = $this->checkUserLogin(true);
        $userId = $this->Musers->save($update, $target['UserId']);
        if ($userId > 0)  {
            $this->session->set_userdata('user', array_merge($target, $update));
            echo json_encode(['code' => 1, 'message' => "Cập nhật profile thành công.", 'data' => $update]);
            return;
        }
        echo json_encode(array('code' => 0, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
    }

	public function login(){
		header('Content-Type: application/json');
        $postData = $this->arrayFromPost(array('PhoneNumber', 'Password', 'IsRemember'));
	
        $account = $postData['PhoneNumber'] ?? '';
        $password = $postData['Password'] ?? '';
        if (empty($account) || empty($password)) {
            echo json_encode(array('code' => -1, 'message' => "Vui lòng nhập đầy đủ thông tin"));
            return;
        }

        $user = $this->Musers->login($account, $this->getPassword($password));
        if ($user) {
            $this->session->set_userdata('user', $user);
            // if ($postData['IsRemember'] == 'on') {
            //     $this->load->helper('cookie');
            //     $this->input->set_cookie(array('name' => 'userName', 'value' => $account, 'expire' => '86400'));
            //     $this->input->set_cookie(array('name' => 'userPass', 'value' => $password, 'expire' => '86400'));
            // }
            $user['SessionId'] = uniqid();
            echo json_encode(array('code' => 1, 'message' => "Đăng nhập thành công", 'data' => array('User' => $user, 'message' => "Đăng nhập thành công")));
            return;
        }
        echo json_encode(array('code' => 0, 'message' => "Số điện thoại hoặc mật khẩu không chính xác"));
        return;
	}

	public function logout(){
		$fields = array('user', 'configs');
		foreach($fields as $field) $this->session->unset_userdata($field);
    }
    
    private function getPassword($password = '') {
        return '@pandog#' . $password;
    }

    // public function addUsers(){
    //     $user = $this->checkUserLogin(true);
    //     $this->loadModel(['Musers', 'Muserpositions']);
    //     $postData = $this->arrayFromPost(array('FullName', 'GenderId', 'PhoneNumber', 'Email', 'BirthDay', 'UserPass', 'IsOld'));
    //     $message = $this->getMessageError($postData, false, 0,2);
    //     if(!empty($message)) {
    //         echo json_encode(['code' => 0, 'message' => $message['message'], 'field' => $message['field']]);
    //     }
    //     else {
    //         if ($this->Musers->checkStaffExist(0, $postData['PhoneNumber'], $user['UserId'])) {
    //             echo json_encode(array('code' => -1, 'message' => "Số điện thoại đã tồn tại trong hệ thống"));
    //             die;
    //         }
    //         $userPass = $postData['UserPass'];
    //         $postData['UserPass'] = md5($userPass);
    //         //$postData['UserPassRaw'] = $userPass;
    //         $postData['CrUserId'] = $user['UserId'];
    //         $postData['CrDateTime'] = getCurentDateTime();
    //         $postData['StatusId'] =  2;
    //         $postData['RoleId'] =  2;
    //         $postData['Email'] = strtolower($postData['Email']);
    //         $postData['BirthDay'] = ddMMyyyyToDate($postData['BirthDay']);
    //         $userId = $this->Musers->save($postData);
    //         if($userId > 0) {
    //             $UserIdText =  'NV-'.($userId + 10000);
    //             echo json_encode(['code' => 1, 'message' => 'Thêm nhân viên vào vị trí thành công', 'id' => $userId, 'UserIdText' => $UserIdText, 'FullName' => $postData['FullName'], 'PhoneNumber' => $postData['PhoneNumber']]);
    //         }
    //         else echo json_encode(array('code' => -1, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));
    //     }
    // }

    // function getMessageError($postData, $checkPass = false, $userId = 0, $roleId = 0) {
    //     $user = $this->checkUserLogin(true);
    //     $FullName = $postData['FullName'];
    //     $Password = $postData['UserPass'];
    //     $PhoneNumber = $postData['PhoneNumber'];
    //     $Email = strtolower($postData['Email']);
    //     if($FullName == '') {
    //         return [
    //             'message' => 'Họ tên không được phép để trống',
    //             'field' => 'FullName'
    //         ];
    //     }

    //     if($PhoneNumber == '') {
    //         return [
    //             'message' => 'Số điện thoại không được phép để trống',
    //             'field' => 'PhoneNumber'
    //         ];
    //     }

    //     if($checkPass) {
    //         if($postData['UserPass'] == '') {
    //             return [
    //                 'message' => 'Mật khẩu không được phép để trống',
    //                 'field' => 'UserPass'
    //             ];
    //         }
    //         if($userId == 0) {
    //             if($this->input->post('PackageId') == '') {
    //                 return [
    //                     'message' => 'Gói sử dụng không được phép để trống',
    //                     'field' => 'PackageId'
    //                 ];
    //             }
    //         }
    //     }

    //     if($Email == '') {
    //         return [
    //             'message' => 'Email không được phép để trống',
    //             'field' => 'Email'
    //         ];
    //     }

    //     if($Password == '') {
    //         return [
    //             'message' => 'Mật khẩu không được phép để trống',
    //             'field' => 'UserPass'
    //         ];
    //     }

    //     $checkEmail = $this->isValidEmail($Email);
    //     if(!$checkEmail) {
    //         return [
    //             'message' => 'Định dạng email chưa đúng',
    //             'field' => 'Email'
    //         ];
    //     }

    //     $checkPhone = $this->checkPhoneNumeber($PhoneNumber);
    //     if(!$checkPhone) {
    //         return [
    //             'message' => 'Định dạng số điện thoại chưa đúng',
    //             'field' => 'PhoneNumber'
    //         ];
    //     }
    //     if($roleId == 2 || $roleId == 3) {
    //         $checkExistPhoneNumber = $this->Musers->getBy(['PhoneNumber' => $PhoneNumber, 'StatusId' => 2, 'RoleId' => $roleId, 'UserId !=' => $userId, 'CrUserId' => $user['UserId']]);
    //         $checkExistEmail = $this->Musers->getBy(['Email' => $Email, 'StatusId' => 2, 'RoleId' => $roleId, 'UserId !=' => $userId, 'CrUserId' => $user['UserId']]);
    //         if(!empty($checkExistPhoneNumber)) {
    //             return [
    //                 'message' => 'Số điện thoại đã tồn tại',
    //                 'field' => 'PhoneNumber'
    //             ];
    //         }
    //         if(!empty($checkExistEmail)) {
    //             return [
    //                 'message' => 'Email đã tồn tại',
    //                 'field' => 'Email'
    //             ];
    //         }
    //     }
    //     return '';
    // }

    // public function saveUser2(){
    //     $user = $this->session->userdata('user');
	// 	$postData = $this->arrayFromPost(array('Password', 'FullName', 'Email', 'PhoneNumber', 'ConfirmPassword', 'SecurityQuestion', 'SecurityAnswer'));
        
    //     $password = trim($postData['Password']);
    //     $confirmPassword = trim($postData['ConfirmPassword']);
        
    //     if (empty($postData['PhoneNumber']) ||
    //         empty($password) ||
    //         empty($confirmPassword) ||
    //         empty($postData['FullName']) ||
    //         empty($postData['Email']) ||
    //         empty($postData['SecurityQuestion']) ||
    //         empty($postData['SecurityAnswer'])
    //     ) {
    //         echo json_encode(array('code' => -1, 'message' => "Vui lòng nhập đầy đủ thông tin"));
    //         return;
    //     }

    //     $username = $postData['PhoneNumber'] ?? $postData['Email'] ?? '';
    //     $userId = $this->input->post('UserId');

    //     if ($this->Musers->checkExist(0, $postData['Email'], $postData['PhoneNumber'])) {
    //         echo json_encode(array('code' => -1, 'message' => "Số điện thoại hoặc Email đã tồn tại trong hệ thống"));
    //     }

    //     $userPass = $postData['UserPass'];
    //     if ($userId == 0){
    //         $postData['StatusId'] = STATUS_ACTIVED;
    //         $postData['RoleId'] = 2;
    //         $postData['UserPass'] = md5($userPass);
    //         $postData['CrUserId'] = ($user) ? $user['UserId'] : 0;
    //         $postData['CrDateTime'] = getCurentDateTime();
    //     }
    //     else {
    //         unset($postData['UserPass']);
    //         $newPass = trim($this->input->post('NewPass'));
    //         if (!empty($newPass)) $postData['UserPass'] = md5($newPass);
    //         $postData['UpdateUserId'] = ($user) ? $user['UserId'] : 0;
    //         $postData['UpdateDateTime'] = getCurentDateTime();
    //     }
    //     $userId = $this->Musers->update($postData, $userId, true);
    //     if ($userId > 0) {
    //         if($user && $user['UserId'] == $userId){
    //             $user = array_merge($user, $postData);
    //             $this->session->set_userdata('user', $user);
    //         }
    //         echo json_encode(array('code' => 1, 'message' => "Cập nhật thành công", 'data' => $userId));
    //     }
    //     else echo json_encode(array('code' => 0, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));

	// 	if(!empty($postData['FullName']) && !empty($postData['PhoneNumber']) && !empty($postData['Email']) && $postData['AnswerId'] > 0 && $postData['QuestionId'] > 0) {
	// 		if ($this->Musers->checkExist($userId, $postData['Email'], $postData['PhoneNumber'])) {
	// 			echo json_encode(array('code' => -1, 'message' => "Số điện thoại hoặc Email đã tồn tại trong hệ thống"));
	// 		}
	// 		else {
				
	// 		}
	// 	}
	// 	else echo json_encode(array('code' => -1, 'message' => "Có lỗi xảy ra trong quá trình thực hiện"));

	// }

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
