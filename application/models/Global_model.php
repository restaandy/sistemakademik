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
    public function get_ta_aktif(){
        $data=$this->db->get_where("sch_tahun_ajaran",array("aktif"=>"Aktif","id_instansi"=>$this->session->userdata("id_instansi")));
        $data=$data->row_array();
        return $data;
    }
    public function formatdate($format,$date){
        $date=str_replace("/", "-", $date);
        return date_format(date_create($date),''.$format);
    }
    public function alert($result,$msgyes,$msgno,$war=NULL){
    	if((is_object($result) || is_array($result)) && sizeof($result)>0){
    		$type="success";
    		$msg=$msgyes;
    	}else if($result==TRUE){
            $type="success";
            $msg=$msgyes;
        }else if($result>0){
            $type="success";
            $msg=$msgyes;
        }else{
    		$type=$war==NULL?'error':'warning';
    		$msg=$msgno;
    	}
    	$this->session->set_flashdata("notif",array("type"=>$type,"msg"=>$msg));
    }
    public function getDataTableInfo($table,$kolom,$where){
        $this->db->where($kolom,$where);
        $data=$this->db->get($table);
        return $data->row_array();
    }
    public function savejadwal($data){
        //cek dulu ada apa tidak
        $id_ta=$this->get_ta_aktif()['id_ta'];
        $datares=$this->db->get_where("sch_pertemuan",array(
            "id_instansi"=>$this->session->userdata("id_instansi"),
            "id_kelas"=>$data['id_kelas'],
            "id_jadwal"=>$data['id_jadwal'],
            "id_ta"=>$id_ta
        ));
        if(sizeof($datares->result())==0){
            unset($data['hari']);
            unset($data['simpan']);
            $data['id_instansi']=$this->session->userdata("id_instansi");
            $data['id_ta']=$id_ta;
            $this->db->insert("sch_pertemuan",$data);
            return $this->db->affected_rows();
            //return sizeof($data->result());
        }else{
            return FALSE;
        }
    }
    public function editjadwal($data){
        unset($data['hari']);
        unset($data['simpan']);
        $data['id_instansi']=$this->session->userdata("id_instansi");
        $datares=$this->db->get_where("sch_pertemuan",array(
            "id_pertemuan"=>$data['id_pertemuan']
        ));
        if(sizeof($datares->result())==0){
            $this->db->where("id_pertemuan",$data['id_pertemuan']);
            $this->db->update("sch_pertemuan",$data);
            return $this->db->affected_rows();    
        }else{
            $datares=$datares->row_array();
            if($datares['id_instansi']==$data['id_instansi']&&$datares['id_kelas']==$data['id_kelas']&&$datares['id_jadwal']==$data['id_jadwal']){
                $this->db->where("id_pertemuan",$data['id_pertemuan']);
                $this->db->update("sch_pertemuan",$data);
                return $this->db->affected_rows();    
            }else{
                return FALSE;   
            }
        }
    }
    public function hapusjadwal($data){
        unset($data['hari']);
        unset($data['simpan']);
        $data['id_instansi']=$this->session->userdata("id_instansi");
        $this->db->where("id_pertemuan",$data['id_pertemuan']);
        $this->db->delete("sch_pertemuan");
        return $this->db->affected_rows();
    }
    public function getJadwalPelajaranbyHari($hari){
        $data=$this->db->query("SELECT 
                a.`id_pertemuan`,
                b.`nama_kelas`,
                c.`nama_pelajaran`,
                c.`status`,
                d.`hari`,
                TIME_FORMAT(d.`waktu_mulai`,'%H : %i') AS waktu_mulai,
                TIME_FORMAT(d.`waktu_selesai`,'%H : %i') AS waktu_selesai,
                e.`nama_guru`
             FROM sch_pertemuan a 
             LEFT JOIN sch_kelas b ON (a.`id_kelas`=b.`id_kelas`) 
             LEFT JOIN sch_pelajaran c ON (a.`id_pelajaran`=c.`id_pelajaran`) 
             LEFT JOIN sch_jadwal d ON (a.`id_jadwal`=d.`id_jadwal`)
             LEFT JOIN data_guru e ON (a.`id_guru`=e.`id_guru`)
             WHERE d.`hari`=? AND a.`id_instansi`=? AND a.`id_ta`=? order by d.waktu_mulai asc;",array($hari,$this->session->userdata('id_instansi'),$this->get_ta_aktif()['id_ta']));
        $data=$data->result();
        return $data;
    }
    public function getabsen($tgl,$id_siswa){
        $id_instansi=$this->session->userdata("id_instansi");
        $data=$this->db->query("SELECT 
            a.`id_siswa`,
            a.`nama_siswa`,
            b.`absen`,
            b.`keterangan`,
            b.`waktu`
        FROM (SELECT id_siswa,nama_siswa FROM data_siswa WHERE id_instansi=? AND id_siswa IN (".implode(',', $id_siswa).")) a 
        LEFT JOIN (SELECT * FROM sch_absensi WHERE id_instansi=? AND DATE(waktu)=? AND id_ta=?) b 
        ON (a.`id_siswa`=b.`id_siswa`);",array($id_instansi,$id_instansi,$tgl,$this->get_ta_aktif()['id_ta']));

    }
}