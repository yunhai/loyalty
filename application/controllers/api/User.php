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

    public function admin_login(){
		header('Content-Type: application/json');
        $postData = $this->arrayFromPost(array('UserName', 'Password'));
	
        $account = $postData['UserName'] ?? '';
        $password = $postData['Password'] ?? '';
        
        if (empty($account) || empty($password)) {
            echo json_encode(array('code' => -1, 'message' => "Vui lòng nhập đầy đủ thông tin"));
            return;
        }

        $user = $this->Musers->admin_login($account, $this->getPassword($password));

        if ($user) {
            $this->session->set_userdata('user', $user);
            
            $user['SessionId'] = uniqid();
            echo json_encode(array('code' => 1, 'message' => "Đăng nhập thành công", 'data' => array('User' => $user, 'message' => "Đăng nhập thành công")));
            return;
        }
        echo json_encode(array('code' => 0, 'message' => "Username hoặc mật khẩu không chính xác"));
        return;
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
