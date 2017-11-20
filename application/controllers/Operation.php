<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Operation extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if($this->session->userdata("app")!="sistemakademik"){
			redirect("login/logout");
		}
	}
	function edit_guru(){
		if($this->input->post()){
			$datainput=$this->input->post();
			$datainput['tgl_lhr']=date_format(date_create(str_replace("/", "-", $datainput['tgl_lhr'])),'Y-m-d');
			$this->db->where("id_guru",$datainput['id_guru']);
			$result=$this->db->update("data_guru",$datainput);
			$this->gmodel->alert($this->db->affected_rows(),"Data Berhasil di Perbarui","Tidak ada yang di perbarui","warning");
			redirect("instansi/guru/edit/".$this->urlenkripsi->encode_url($datainput['id_guru']));
		}else{
			show_404();
		}
	}
	function edit_siswa(){
		if($this->input->post()){
			$datainput=$this->input->post();
			$datainput['tgl_lhr']=date_format(date_create(str_replace("/", "-", $datainput['tgl_lhr'])),'Y-m-d');
			$this->db->where("id_siswa",$datainput['id_siswa']);
			$result=$this->db->update("data_siswa",$datainput);
			$this->gmodel->alert($this->db->affected_rows(),"Data Berhasil di Perbarui","Tidak ada yang di perbarui","warning");
			redirect("instansi/siswa/edit/".$this->urlenkripsi->encode_url($datainput['id_siswa']));
		}else{
			show_404();
		}
	}
	
}
