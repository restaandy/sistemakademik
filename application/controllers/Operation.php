<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Operation extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if($this->session->userdata("app")!="sistemakademik"){
			redirect("login/logout");
		}
	}
	function save_guru(){
		if($this->input->post()){

		}else{
			show_404();
		}
	}
	
}
