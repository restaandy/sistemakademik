<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include("libraries/autoload.php" );
use GroceryCrud\ Core\ GroceryCrud;
use GroceryCrud\ Core\ Model\ whereModel;
class Welcome extends CI_Controller {
	public function index()
	{
		$var['var_module']="home";
		$var['var_other']=array();	
		$this->load->view('main',$var);
	}
	public function ganti_foto(){
		 $namafile=pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
		 $config['upload_path']          = './assets/uploads/';
         $config['allowed_types']        = 'jpg|png';
         $config['max_size']             = 500;
         $config['overwrite'] = TRUE;
         $config['file_ext_tolower'] = TRUE;
		 $config['file_name'] =$this->input->post("id").".".$namafile;
         $this->load->library('upload', $config);

         if ( ! $this->upload->do_upload('foto'))
         {
                  
         }
         else
         {
         	$this->db->where("id",$this->input->post("id"));
            $this->db->update("data_perangkat_desa",array("foto"=>$this->upload->data('file_name')));   
         }
         redirect("welcome/detail_perangkat_desa/".$this->input->post("id"));
	}
	public function data_desa(){
		$database = include( 'database.php' ); //config database Grocery
				$config = include( 'config.php' ); //config library Grocery
				$this->crud = new GroceryCrud( $config, $database ); //initialize Grocery
				/* start Grocery global configuration */
				$this->crud->unsetDeleteMultiple();
				$this->crud->unsetDeleteMultiple();
				$this->crud->unsetPrint();
				$this->crud->unsetExport();
				$this->crud->unsetJquery();		
				$this->crud->setTable('data_desa');
				$this->crud->setRelation('id_kecamatan','data_kecamatan','nama_kecamatan');
		      	$output = $this->crud->render();

		      if ($output->isJSONResponse) {
		          header('Content-Type: application/json; charset=utf-8');
		          echo $output->output;
		          exit;
		      }

		$var['var_module']="datadesa";
		$var['var_other']=array("headerinfo"=>"Desa Kab. Tegal");	
		$var['gcrud']=1;
		 $var['css_files'] = $output->css_files;
	      $var['js_files'] = $output->js_files;
	      $var['output'] = $output->output;
		$this->load->view('main',$var);		
	}
	public function perangkat_desa(){

		$var['var_module']="perangkat";

		$var['var_other']=array("headerinfo"=>"Pendataan Perangkat Desa Kab. Tegal");	

		$this->load->view('main',$var);

	}

	public function daftar_perangkat_desa(){

		$var['var_module']="daftar";

		$var['var_other']=array("headerinfo"=>"Daftar Perangkat Desa Kab. Tegal");	

		$this->load->view('main',$var);

	}

	public function detail_perangkat_desa($id=NULL){

		$var['var_module']="profile";

		$var['var_other']=array("headerinfo"=>"Detail Perangkat Desa Kab. Tegal","id"=>$id);	

		$this->load->view('main',$var);

	}

	public function edit_perangkat_desa($id=NULL){

		$var['var_module']="edit";

		$var['var_other']=array("headerinfo"=>"Edit Perangkat Desa Kab. Tegal","id"=>$id);	

		$this->load->view('main',$var);

	}

	public function cetak_perangkat_desa($id=NULL){

		$var['var_module']="cetak";

		$var['var_other']=array("headerinfo"=>"Cetak Perangkat Desa Kab. Tegal","id"=>$id);	

		$this->load->view('main',$var);

	}

	function save_perangkat(){

		if(sizeof($this->input->post())>0){

			$data=$this->input->post();

			$datainput=array();

			foreach ($data as $key => $value) {

				if(in_array($key, array("tgl_lhr","sk_tgl_pengangkatan","sk_tmt_pengangkatan","sk_baru_tgl_pengangkatan","sk_baru_tmt_pengangkatan"))){

					$var=$value;

					$var=explode("/", $var);

					$datainput[$key]=$var[2]."-".$var[1]."-".$var[0];

				}else{

					$datainput[$key]=strtoupper($value);

				}

			}

			$this->db->insert("data_perangkat_desa",$datainput);

			if($this->db->affected_rows()>0){

				$this->session->set_flashdata("notif",array("type"=>"success","msg"=>"Data Perangkat Desa Berhasil di Tambahkan"));

			}else{

				$this->session->set_flashdata("notif",array("type"=>"error","msg"=>"Data Perangkat Desa Gagal di Tambahkan"));

			}

			redirect("welcome/daftar_perangkat_desa");

		}else{show_404();}

	}

	function edit_perangkat(){

		if(sizeof($this->input->post())>0){

			$data=$this->input->post();

			$datainput=array();

			foreach ($data as $key => $value) {

				if(in_array($key, array("tgl_lhr","sk_tgl_pengangkatan","sk_tmt_pengangkatan","sk_baru_tgl_pengangkatan","sk_baru_tmt_pengangkatan"))){

					$var=$value;

					$var=explode("/", $var);

					$datainput[$key]=$var[2]."-".$var[1]."-".$var[0];

				}else{

					$datainput[$key]=strtoupper($value);

				}

			}

			$this->db->where("id",$datainput["id"]);

			$this->db->update("data_perangkat_desa",$datainput);

			if($this->db->affected_rows()>0){

				$this->session->set_flashdata("notif",array("type"=>"success","msg"=>"Data Perangkat Desa Berhasil di Perbarui"));

			}else{

				$this->session->set_flashdata("notif",array("type"=>"warning","msg"=>"Tidak ada perubahan"));

			}

			redirect("welcome/edit_perangkat_desa/".$datainput['id']);

		}else{show_404();}

	}

	function hapusdata(){

		if(sizeof($this->input->post())>0){

			$this->db->where("id",$this->input->post("id"));

			$this->db->delete("data_perangkat_desa");

			if($this->db->affected_rows()>0){

				$this->session->set_flashdata("notif",array("type"=>"success","msg"=>"Data Perangkat Desa Berhasil di Hapus"));

			}else{

				$this->session->set_flashdata("notif",array("type"=>"error","msg"=>"Data Perangkat Desa Gagal di Hapus"));

			}

			redirect("welcome/daftar_perangkat_desa");

		}else{

			show_404();

		}

	}

	function get_desa(){

		if(sizeof($this->input->post())>0){

			$this->db->where("id_kecamatan",$this->input->post("id"));

			$data=$this->db->get("data_desa");

			$data=$data->result();

			echo "<option value=''>-- Pilih Desa --</option>";

			foreach ($data as $key) {

				?>

					<option value="<?php echo $key->id; ?>"><?php 	echo $key->nama_desa; ?></option>	

				<?php			

			}	

		}

	}

	function get_desa_edit(){

		if(sizeof($this->input->post())>0){

			$this->db->where("id_kecamatan",$this->input->post("id"));

			$data=$this->db->get("data_desa");

			$data=$data->result();

			echo "<option value=''>-- Pilih Desa --</option>";

			foreach ($data as $key) {

				?>

					<option value="<?php echo $key->id; ?>" <?php echo $this->input->post('id_desa')==$key->id?'selected':''; ?>><?php 	echo $key->nama_desa; ?></option>	

				<?php			

			}	

		}

	}

	function printout(){

		if($this->input->post("format")=="pdf"){

			$this->load->view("module/printout2",array("id_kecamatan"=>$this->input->post("id_kecamatan"),"id_desa"=>$this->input->post("id_desa"),"tanggal"=>$this->input->post("tanggal")));

		}else{

			$this->load->view("module/printout_excel",array("id_kecamatan"=>$this->input->post("id_kecamatan"),"id_desa"=>$this->input->post("id_desa"),"tanggal"=>$this->input->post("tanggal")));

		}

		

	}

	function logout(){

		redirect("login");

	}

}

