<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Ajax extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
	}
	function popup($page=NULL){
		if($this->input->is_ajax_request()){
			$this->load->view("module/modal/".$page,$this->input->post());
		}else{
			show_404();
		}
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
	function get_kd(){
		if($this->input->is_ajax_request()){
			$this->db->select("b.*,a.id_sk,a.kkm,a.nama_sk,a.bobot,c.jenjang");
			$this->db->from("sch_standar_kompetensi a");
			$this->db->join("sch_pelajaran b","a.id_pelajaran=b.id_pelajaran","left");
			$this->db->join("sch_jenjang_pendidikan c","b.id_jenjang=c.id_jenjang","left");
			$this->db->where("a.id_pelajaran",$this->input->post("id_mapel"));
			$this->db->where("a.id_instansi",$this->session->userdata("id_instansi"));
			$kd=$this->db->get();
			$kd=$kd->result();
			echo json_encode($kd);
		}else{
			show_404();	
		}
	}
	function savekd(){
		if($this->input->is_ajax_request()){
			$datainput=json_decode($this->input->post('data'));
			$input=array();
			$input['id_instansi']=$this->session->userdata("id_instansi");
			foreach ($datainput as $key) {
				$input[$key->name]=$key->value;
			}
			$this->db->insert("sch_standar_kompetensi",$input);
			echo json_encode(array("status"=>$this->db->affected_rows()));
		}else{show_404();}
		
	}
	function editkd(){
		if($this->input->is_ajax_request()){
			$datainput=json_decode($this->input->post('data'));
			$input=array();
			$input['id_instansi']=$this->session->userdata("id_instansi");
			foreach ($datainput as $key) {
				$input[$key->name]=$key->value;
			}
			$this->db->where("id_sk",$input['id_sk']);
			$this->db->where("id_instansi",$input['id_instansi']);
			$this->db->update("sch_standar_kompetensi",$input);
			echo json_encode(array("status"=>$this->db->affected_rows()));
		}else{show_404();}
		
	}
	function delkd(){
		if($this->input->is_ajax_request()){
			$datainput=json_decode($this->input->post('data'));
			$input=array();
			$input['id_instansi']=$this->session->userdata("id_instansi");
			foreach ($datainput as $key) {
				$input[$key->name]=$key->value;
			}
			$this->db->where("id_instansi",$input['id_instansi']);
			$this->db->where("id_sk",$input['id_sk']);
			$this->db->delete("sch_standar_kompetensi");
			echo json_encode(array("status"=>1));
		}else{show_404();}
	}
	function getJadwalPelajaranbyHari(){
		if($this->input->is_ajax_request()){
			$hari=$this->input->post('hari');
			$data=$this->gmodel->getJadwalPelajaranbyHari($hari);
			echo json_encode($data);
		}else{show_404();}
	}
	function getabsen(){
		if($this->input->is_ajax_request()){
			$tgl=$this->input->post('tgl');
			$this->gmodel->getabsen($this->gmodel->formatdate("Y-m-d",$tgl));
			//$data=$this->gmodel->getJadwalPelajaranbyHari($hari);
			//echo $this->gmodel->formatdate("Y-m-d",$tgl);
		}else{show_404();}
	}
}
