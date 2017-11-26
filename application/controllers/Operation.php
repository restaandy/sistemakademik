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
	function edit_ortu(){
		if($this->input->post()){
			$datainput=$this->input->post();
			$datainput['tgl_lhr_ayah']=date_format(date_create(str_replace("/", "-", $datainput['tgl_lhr_ayah'])),'Y-m-d');
			$datainput['tgl_lhr_ibu']=date_format(date_create(str_replace("/", "-", $datainput['tgl_lhr_ibu'])),'Y-m-d');
			$tif=$this->gmodel->getDataTableInfo("data_ortu","id_siswa",$datainput['id_siswa']);
			if(sizeof($tif)>0){
				$this->db->where("id_siswa",$datainput['id_siswa']);
				$result=$this->db->update("data_ortu",$datainput);
			}else{
				$this->db->insert("data_ortu",$datainput);
			}
			$this->gmodel->alert($this->db->affected_rows(),"Data Berhasil di Perbarui","Tidak ada yang di perbarui","warning");
			redirect("instansi/siswa/ortu/".$this->urlenkripsi->encode_url($datainput['id_siswa']));
		}else{
			show_404();
		}
	}
	function save_jadwal(){
		if($this->input->post()){
			$result=$this->gmodel->savejadwal($this->input->post());
			if($result==FALSE){
				$this->gmodel->alert(FALSE,"","Jadwal Sudah Tersedia, Silahkan pilih waktu jadwal lain");
			}else{
				$this->gmodel->alert($result,"Data Jadwal Tersimpan","Jadwal gagal tersimpan, Silahkan ulangi kembali");
			}
			redirect("instansi/krs");
		}else{
			show_404();
		}
	}
	function edit_jadwal(){
		if($this->input->post()){
			$result=$this->gmodel->editjadwal($this->input->post());
			if($result==FALSE){
				$this->gmodel->alert(FALSE,"","Jadwal Sudah Tersedia, Silahkan pilih waktu jadwal lain");
			}else{
				$this->gmodel->alert($result,"Data Jadwal Telah di perbarui","Tidak ada yang berubah","warning");
			}
			redirect("instansi/krs");
		}else{
			show_404();
		}
	}
	function hapus_jadwal(){
		if($this->input->post()){
			$result=$this->gmodel->hapusjadwal($this->input->post());
			$this->gmodel->alert($result,"Data Jadwal Telah di Hapus","Data gagal di hapus");
			redirect("instansi/krs");
		}else{
			show_404();
		}
	}
	
}
