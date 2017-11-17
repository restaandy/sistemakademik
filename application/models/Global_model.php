<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');
class Global_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }
    public function set_ta_aktif($id_ta)
    {
    	$this->db->trans_start();
			$this->db->where("id_instansi",$this->session->userdata("id_instansi"));
			$this->db->where("aktif","Aktif");
        	$this->db->update("sch_tahun_ajaran",array("aktif"=>"Tidak Aktif"));
        	$this->db->where("id_ta",$id_ta);
        	$this->db->update("sch_tahun_ajaran",array("aktif"=>"Aktif"));
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{return FALSE;}else{return TRUE;}
    }
    public function alert($result,$msgyes,$msgno,$war=NULL){
    	if(sizeof($result)>0 || $result==TRUE){
    		$type="success";
    		$msg=$msgyes;
    	}else{
    		$type=$war==NULL?'danger':'warning';
    		$msg=$msgno;
    	}
    	$this->session->set_flashdata("notif",array("type"=>$type,"msg"=>$msg));
    }

}