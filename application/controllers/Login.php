<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->view('login');
	}
	public function admin()
	{
		$this->load->view('login_admin');
	}
	public function auth_admin(){
		if(sizeof($this->input->post())>0){
			$where=array("username"=>$this->input->post("username"),"password"=>md5($this->input->post("password")));
			$log=$this->db->get_where("data_instansi",$where);
			$log=$log->result();
			if(sizeof($log)==1){
				$this->session->set_userdata("app","sistemakademik");
				$this->session->set_userdata("id_instansi",$log[0]->id_instansi);
				$this->session->set_userdata("nama_instansi",$log[0]->nama_instansi);
				$this->session->set_userdata("jenis_instansi",$log[0]->jenis_instansi);
				$this->session->set_userdata("user_role","instansi");
				redirect("instansi");
			}else{
				redirect("signin");
			}
		}
	}
	public function logout(){
		$this->session->sess_destroy();
		redirect("signin");
	}
}
