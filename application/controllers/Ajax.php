<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Ajax extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
	}
	function get_kab(){
		if($this->input->is_ajax_request()){
			$kab=$this->db->get_where("data_kota",array("province_id"=>$this->input->post("prov_id")));
			$kab=$kab->result();
			echo '<option value="">-- Pilih Kabupaten/Kota --</option>';
			foreach ($kab as $key) {
				echo "<option value='".$key->id."'>".$key->name."</option>";
			}
		}else{
			show_404();
		}
	}
	function get_kec(){
		if($this->input->is_ajax_request()){
			$kab=$this->db->get_where("data_kecamatan",array("regency_id"=>$this->input->post("kab_id")));
			$kab=$kab->result();
			echo '<option value="">-- Pilih Kecamatan --</option>';
			foreach ($kab as $key) {
				echo "<option value='".$key->id."'>".$key->name."</option>";
			}
		}else{
			show_404();
		}
	}
	function get_desa(){
		if($this->input->is_ajax_request()){
			$kab=$this->db->get_where("data_desa",array("district_id"=>$this->input->post("kec_id")));
			$kab=$kab->result();
			echo '<option value="">-- Pilih Desa --</option>';
			foreach ($kab as $key) {
				echo "<option value='".$key->id."'>".$key->name."</option>";
			}
		}else{
			show_404();
		}
	}
}
