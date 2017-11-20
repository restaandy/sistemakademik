<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include ("libraries/autoload.php");
use GroceryCrud\Core\GroceryCrud;
use GroceryCrud\Core\Model\whereModel;
class Instansi extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		if($this->session->userdata("app")!="sistemakademik"&&$this->session->userdata("id")==NULL){
			redirect("signin");
		}
		$database = include ('database.php'); //config database Grocery
        $config = include ('config.php'); //config library Grocery
        $this->crud = new GroceryCrud($config, $database); //initialize Grocery
        /* start Grocery global configuration */
        $this->crud->unsetDeleteMultiple();
        $this->crud->unsetDeleteMultiple();
        $this->crud->unsetPrint();
        $this->crud->unsetExport();
        $this->crud->unsetJquery();
        $this->crud->unsetBootstrap();
	}
	public function index(){
		$this->dashboard();
	}
	public function dashboard(){
		$var['var_module']="instansi/dashboard";
		$var['var_other']=array("headerinfo"=>"Selamat Datang ".$this->session->userdata("nama_instansi"));	
		$this->load->view('main',$var);
	}
	public function guru($page=NULL,$id_guru=NULL){
        $var = array();
        $var['module'] = "instansi/guru";
        $var['var_module'] = "instansi/guru";
        $var['var_title'] = "Guru";
        $var['var_subtitle'] = "List Daftar Guru";
        $var['var_custom_css'] = "none";
        $var['var_custom_js'] = "none";
        $var['var_breadcrumb'] = array();
        $var['var_other'] = array("page"=>$page,"id_guru"=>$id_guru);
        if($page=="edit"){
            
        }else{
            $var['gcrud'] = 1;
            //$this->crud->unsetAdd();
            $this->crud->unsetEdit();
            $this->crud->unsetDelete();
            $this->crud->setTable('data_guru');
            $this->crud->columns(['no_ktp','nama_guru','jenkel','tmp_lhr','alamat','status_guru','aksi']);
            $this->crud->where(["id_instansi='".$this->session->userdata('id_instansi')."'"]);
            $this->crud->displayAs("jenkel","Jenis Kelamin");
            $this->crud->displayAs("tmp_lhr","Tempat Lahir");
            $this->crud->displayAs("tgl_lhr","Tanggal Lahir");
            $this->crud->callbackColumn('jenkel', function ($value, $row) {
    		     return $value=="L"?"Laki - laki":"Perempuan";
    		});
            $this->crud->callbackColumn('aksi', function ($value, $row) {
                 return "<a href='#' class='btn btn-info btn-sm'>Detail</a>&nbsp<a href='guru/edit/".$this->urlenkripsi->encode_url($row->id_guru)."' class='btn btn-warning btn-sm'>Edit</a>&nbsp<a href='#' class='btn btn-danger btn-sm'>Hapus</a>";
            });
    		$this->crud->callbackBeforeInsert(function ($stateParameters) {
    		    $stateParameters->data['id_instansi'] = $this->session->userdata('id_instansi');
    		    return $stateParameters;
    		});
            $this->crud->addFields(['no_ktp', 'nama_guru', 'jenkel', 'tmp_lhr','tgl_lhr','alamat','status_guru']);
            $output = $this->crud->render();
            if ($output->isJSONResponse) {
                header('Content-Type: application/json; charset=utf-8');
                echo $output->output;
                exit;
            }
            $var['css_files'] = $output->css_files;
            $var['js_files'] = $output->js_files;
            $var['output'] = $output->output;
        }
        $this->load->view('main',$var);
	}
	public function siswa($page=NULL,$id_siswa=NULL){
        $var = array();
        $var['module'] = "instansi/siswa";
        $var['var_module'] = "instansi/siswa";
        $var['var_title'] = "Siswa";
        $var['var_subtitle'] = "List Daftar Siswa";
        $var['var_custom_css'] = "none";
        $var['var_custom_js'] = "none";
        $var['var_breadcrumb'] = array();
        $var['var_other'] = array("page"=>$page,"id_siswa"=>$id_siswa);
        if($page=="edit"){
            
        }else{
            $var['gcrud'] = 1;
            //$this->crud->unsetAdd();
            $this->crud->unsetEdit();
            $this->crud->unsetDelete();
            $this->crud->setTable('data_siswa');
            $this->crud->columns(['nis','nama_siswa','tmp_lhr','alamat','jenkel','aksi']);
            $this->crud->where(["id_instansi='".$this->session->userdata('id_instansi')."'"]);
            $this->crud->displayAs("jenkel","Jenis Kelamin");
            $this->crud->displayAs("tmp_lhr","Tempat Lahir");
            $this->crud->displayAs("tgl_lhr","Tanggal Lahir");
            $this->crud->displayAs("nohp","Nomor HP");
            $this->crud->callbackColumn('jenkel', function ($value, $row) {
    		     return $value=="L"?"Laki - laki":"Perempuan";
    		});
            $this->crud->callbackColumn('aksi', function ($value, $row) {
                 return "<a href='#' class='btn btn-info btn-sm'>Detail</a>&nbsp<a href='siswa/edit/".$this->urlenkripsi->encode_url($row->id_siswa)."' class='btn btn-warning btn-sm'>Edit</a>&nbsp<a href='#' class='btn btn-danger btn-sm'>Hapus</a>";
            });
    		$this->crud->callbackBeforeInsert(function ($stateParameters) {
    		    $stateParameters->data['id_instansi'] = $this->session->userdata('id_instansi');
    		    return $stateParameters;
    		});
    		$this->crud->addFields(['nisn','nis', 'nama_siswa', 'jenkel', 'tmp_lhr','tgl_lhr','alamat','nohp','email','status_siswa']);
            $output = $this->crud->render();
            if ($output->isJSONResponse) {
                header('Content-Type: application/json; charset=utf-8');
                echo $output->output;
                exit;
            }
            $var['css_files'] = $output->css_files;
            $var['js_files'] = $output->js_files;
            $var['output'] = $output->output;
        }
        $this->load->view('main',$var);
	}
	public function kelas($page=NULL){
        $var = array();
        $var['gcrud'] = 1;
        $var['module'] = "";
        $var['var_module'] = "";
        $var['var_title'] = "Kelas / Ruang";
        $var['var_subtitle'] = "List Daftar Kelas / Ruang";
        $var['var_custom_css'] = "none";
        $var['var_custom_js'] = "none";
        $var['var_breadcrumb'] = array();
        $var['var_other'] = array("page"=>$page);
        //$this->crud->unsetAdd();
        //$this->crud->unsetEdit();
        //$this->crud->unsetDelete();
        $this->crud->setTable('sch_kelas');
        $this->crud->columns(['nama_kelas','kuota','keterangan']);
        $this->crud->where(["id_instansi='".$this->session->userdata('id_instansi')."'"]);
        $this->crud->displayAs("kuota","Kuota Isi Kelas");
        $this->crud->callbackColumn('kuota', function ($value, $row) {
                 return $value." Orang";
        });
		$this->crud->callbackBeforeInsert(function ($stateParameters) {
		    $stateParameters->data['id_instansi'] = $this->session->userdata('id_instansi');
		    return $stateParameters;
		});
        $this->crud->editFields(['nama_kelas','kuota','keterangan']);
		$this->crud->addFields(['nama_kelas','kuota','keterangan']);
        $output = $this->crud->render();
        if ($output->isJSONResponse) {
            header('Content-Type: application/json; charset=utf-8');
            echo $output->output;
            exit;
        }
        $var['css_files'] = $output->css_files;
        $var['js_files'] = $output->js_files;
        $var['output'] = $output->output;
        $this->load->view('main',$var);
	}
	public function pelajaran($page=NULL){
        $var = array();
        $var['gcrud'] = 1;
        $var['module'] = "";
        $var['var_module'] = "";
        $var['var_title'] = "Pelajaran";
        $var['var_subtitle'] = "List Daftar Pelajaran";
        $var['var_custom_css'] = "none";
        $var['var_custom_js'] = "none";
        $var['var_breadcrumb'] = array();
        $var['var_other'] = array("page"=>$page);
        //$this->crud->unsetAdd();
        //$this->crud->unsetEdit();
        //$this->crud->unsetDelete();
        $this->crud->setTable('sch_pelajaran');
        $this->crud->columns(['nama_pelajaran','status','keterangan']);
        $this->crud->where(["id_instansi='".$this->session->userdata('id_instansi')."'"]);
        
		$this->crud->callbackBeforeInsert(function ($stateParameters) {
		    $stateParameters->data['id_instansi'] = $this->session->userdata('id_instansi');
		    return $stateParameters;
		});
        $this->crud->editFields(['nama_pelajaran','status','keterangan']);
		$this->crud->addFields(['nama_pelajaran','status','keterangan']);
        $output = $this->crud->render();
        if ($output->isJSONResponse) {
            header('Content-Type: application/json; charset=utf-8');
            echo $output->output;
            exit;
        }
        $var['css_files'] = $output->css_files;
        $var['js_files'] = $output->js_files;
        $var['output'] = $output->output;
        $this->load->view('main',$var);
	}
    public function jenjang($page=NULL){
        $var = array();
        $var['gcrud'] = 1;
        $var['module'] = "";
        $var['var_module'] = "";
        $var['var_title'] = "Jenjang Pendidikan";
        $var['var_subtitle'] = "List Jenjang Pendidikan";
        $var['var_custom_css'] = "none";
        $var['var_custom_js'] = "none";
        $var['var_breadcrumb'] = array();
        $var['var_other'] = array("page"=>$page);
        //$this->crud->unsetAdd();
        //$this->crud->unsetEdit();
        //$this->crud->unsetDelete();
        $this->crud->setTable('sch_jenjang_pendidikan');
        $this->crud->columns(['jenjang','keterangan']);
        $this->crud->where(["id_instansi='".$this->session->userdata('id_instansi')."'"]);
        $this->crud->displayAs("jenjang","Jenjang Pendidikan");
        $this->crud->callbackBeforeInsert(function ($stateParameters) {
            $stateParameters->data['id_instansi'] = $this->session->userdata('id_instansi');
            return $stateParameters;
        });
        $this->crud->editFields(['jenjang','keterangan']);
        $this->crud->addFields(['jenjang','keterangan']);
        $output = $this->crud->render();
        if ($output->isJSONResponse) {
            header('Content-Type: application/json; charset=utf-8');
            echo $output->output;
            exit;
        }
        $var['css_files'] = $output->css_files;
        $var['js_files'] = $output->js_files;
        $var['output'] = $output->output;
        $this->load->view('main',$var);
    }
	public function standarkompetensi($page=NULL){
        $var = array();
        $var['module'] = "standarkompetensi";
        $var['var_module'] = "instansi/standarkompetensi";
        $var['var_title'] = "Standar Kompetensi";
        $var['var_subtitle'] = "List Standar Kompetensi Pelajaran";
        $var['var_custom_css'] = "none";
        $var['var_custom_js'] = "none";
        $var['var_breadcrumb'] = array();
        $var['var_other'] = array("page"=>$page);
        $this->load->view('main',$var);
	}
	public function tahunajaran($page=NULL){
		if($this->input->post("simpan")!=NULL){
			$result=$this->gmodel->set_ta_aktif($this->input->post("id_ta"));
			$this->gmodel->alert($result,"Tahun Ajaran Berhasil di Setting","Gagal Setting Tahun Ajaran");
			redirect("instansi/tahunajaran");
		}
        $var = array();
        $var['gcrud'] = 1;
        $var['module'] = "";
        $var['var_module'] = "";
        $var['var_title'] = "Tahun Ajaran";
        $var['var_subtitle'] = "List Tahun Ajaran";
        $var['var_custom_css'] = "none";
        $var['var_custom_js'] = "none";
        $var['var_breadcrumb'] = array();
        $var['var_other'] = array("page"=>$page);
        //$this->crud->unsetAdd();
        //$this->crud->unsetEdit();
        //$this->crud->unsetDelete();
        $this->crud->setTable('sch_tahun_ajaran');
        $this->crud->columns(['tahun','status','aktif','aksi']);
        $this->crud->where(["id_instansi='".$this->session->userdata('id_instansi')."'"]);
        $this->crud->callbackColumn('aksi', function ($value, $row) {
		     $aktif=$row->aktif=="Tidak Aktif"?'<a href="#" onclick="set_aktif_ta(event)" data-id="'.$row->id_ta.'" class="btn btn-info btn-sm">Set Aktif</i></a>':'';
		     return $aktif;
		});
        $this->crud->displayAs("aksi","Set Aktif");
		$this->crud->callbackBeforeInsert(function ($stateParameters) {
		    $stateParameters->data['id_instansi'] = $this->session->userdata('id_instansi');
		    return $stateParameters;
		});
        $this->crud->editFields(['tahun','status','aktif']);
		$this->crud->addFields(['tahun','status','aktif']);
        $output = $this->crud->render();
        if ($output->isJSONResponse) {
            header('Content-Type: application/json; charset=utf-8');
            echo $output->output;
            exit;
        }
        $var['css_files'] = $output->css_files;
        $var['js_files'] = $output->js_files;
        $var['output'] = $output->output;
        $this->load->view('main',$var);
	}
}
