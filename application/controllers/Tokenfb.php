<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tokenfb extends MY_Controller {

	public function index(){
		$user = $this->checkUserLogin();
		$data = $this->commonData($user,
            'Lấy token user',
            array(
                
            )
        );
        if($this->Mactions->checkAccess($data['listActions'], 'tokenfb')) {
            $this->load->view('token/list', $data);
        }
        else $this->load->view('user/permission', $data);
		


	}

	public function getToken(){
		$data = array(
			"api_key" => "3e7c78e35a76a9299309885393b02d97",
			"email" => 'facebook66665@gmail.com',
			"format" => "JSON",
			//"generate_machine_id" => "1",
			//"generate_session_cookies" => "1",
			"locale" => "vi_vn",
			"method" => "auth.login",
			"password" => 'haminhmanh',
			"return_ssl_resources" => "0",
			"v" => "1.0"
		);

		$sig = "";
		foreach($data as $key => $value){
			$sig .= "$key=$value";
		}
		$sig .= 'c1e620fa708a1d5696fb991c1bde5662';
		$sig = md5($sig);
		$data['sig'] = $sig;
		// var_dump(http_build_query($data));
		echo  http_build_query($data);
		// return $data;
	}

	// if($_GET) $_POST = $_GET;
	// function sign_creator(&$data){
	// 	$sig = "";
	// 	foreach($data as $key => $value){
	// 		$sig .= "$key=$value";
	// 	}
	// 	$sig .= 'c1e620fa708a1d5696fb991c1bde5662';
	// 	$sig = md5($sig);
	// 	return $data['sig'] = $sig;
	// }
	// $data = array(
	// 	"api_key" => "3e7c78e35a76a9299309885393b02d97",
	// 	"email" => $_POST['u'],
	// 	"format" => "JSON",
	// 	//"generate_machine_id" => "1",
	// 	//"generate_session_cookies" => "1",
	// 	"locale" => "vi_vn",
	// 	"method" => "auth.login",
	// 	"password" => $_POST['p'],
	// 	"return_ssl_resources" => "0",
	// 	"v" => "1.0"
	// );
	// sign_creator($data);
}