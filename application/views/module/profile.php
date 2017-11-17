<?php  

$data=$this->db->get_where("data_perangkat_desa",array("id"=>$this->db->escape_str($id)));

$data=$data->result();

if(sizeof($data)==1){

   $data=$data[0];

}else{

$this->session->set_flashdata("notif",array("type"=>"error","msg"=>"Data Perangkat Desa Tidak di temukan"));

redirect("welcome/daftar_perangkat_desa");

}

?>

<br>

<div class="row">

    <div class="col-lg-4">

        <div class="hpanel hgreen">

            <div class="panel-body">

                <div class="pull-right text-right">

                    <div class="btn-group">
                    
                    </div>

                </div>

                <img alt="logo" style="width:50%;height: 60%;" class="img-circle m-b m-t-md" src="<?php echo base_url(); ?>assets/uploads/<?php echo $data->foto; ?>" onError="this.onerror=null;this.src='<?php echo base_url(); ?>assets/images/profile-default.png';">

                <h3><a href=""><?php echo $data->nama; ?></a></h3>

                <div class="text-muted font-bold m-b-xs"><?php echo $data->tmp_lhr; ?>, <?php echo date_format(date_create($data->tgl_lhr),'d M Y'); ?></div>

                <p>

                    <?php echo $data->alamat; ?>

                </p>

                <div class="progress m-t-xs full progress-small">

                    <div style="width: 100%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="65" role="progressbar" class=" progress-bar progress-bar-success">

                        <span class="sr-only"></span>

                    </div>

                </div>
                <form method="POST" action="<?php echo base_url(); ?>index.php/welcome/ganti_foto" enctype="multipart/form-data">
                	<input type="file" name="foto">
                	<input type="hidden" name="id" value="<?php echo $data->id; ?>">
                	<button type="submit" class="btn btn-success btn-sm">Simpan</button>
                    <label>Mak size foto (500 Kb)</label>
                </form>

            </div>

           

            

            <div class="panel-footer contact-footer">

                <!--<div class="row">

                    <div class="col-md-4 border-right">

                        <div class="contact-stat"><span>Projects: </span> <strong>200</strong></div>

                    </div>

                    <div class="col-md-4 border-right">

                        <div class="contact-stat"><span>Messages: </span> <strong>300</strong></div>

                    </div>

                    <div class="col-md-4">

                        <div class="contact-stat"><span>Views: </span> <strong>400</strong></div>

                    </div>

                </div>-->

            </div>



        </div>

    </div>

    <div class="col-lg-8">

        <div class="hpanel hgreen">

            <div class="panel-body">

                <dl>

                    <dt>Nomor Induk Kependudukan</dt>

                    <dd><?php echo $data->nik; ?></dd>

                    <dt>Tempat Bertugas Sekarang</dt>

                    <dd>Kecamatan <?php echo $this->db->get_where("data_kecamatan",array("id"=>$data->id_kecamatan))->result()[0]->nama_kecamatan; ?>, Desa <?php echo $this->db->get_where("data_desa",array("id"=>$data->id_desa))->result()[0]->nama_desa; ?></dd>

                    <dt>Jenis Kelamin</dt>

                    <dd><?php echo $data->jenkel=="L"?"Laki - laki":"Perempuan"; ?></dd>

                    <dt>Pendidikan Terakhir</dt>

                    <dd><?php echo $data->pendidikan_terakhir; ?> Jurusan <?php echo $data->jurusan; ?></dd>

                    <dt>Agama</dt>

                    <dd><?php echo $data->agama; ?></dd>

                </dl>

            </div>

            <div class="panel-body">

                <dl>

                    <dt>Jabatan Lama</dt>

                    <dd><?php echo $data->jabatan_lama; ?></dd>

                    <dt>No SK Pengangkatan</dt>

                    <dd><?php echo $data->sk_no_pengangkatan; ?></dd>

                    <dt>Tgl SK Pengangkatan</dt>

                    <dd><?php echo date_format(date_create($data->sk_tgl_pengangkatan),'d M Y'); ?></dd>

                    <dt>TMT SK Pengangkatan</dt>

                    <dd><?php echo date_format(date_create($data->sk_tmt_pengangkatan),'d M Y'); ?></dd>

                    <hr>

                    <dt>Jabatan Baru</dt>

                    <dd><?php echo $data->jabatan_baru; ?></dd>

                    <dt>No SK Pengangkatan Baru</dt>

                    <dd><?php echo $data->sk_baru_no_pengangkatan; ?></dd>

                    <dt>Tgl SK Pengangkatan Baru</dt>

                    <dd><?php echo date_format(date_create($data->sk_baru_tgl_pengangkatan),'d M Y'); ?></dd>

                    <dt>TMT SK Pengangkatan Baru</dt>

                    <dd><?php echo date_format(date_create($data->sk_baru_tmt_pengangkatan),'d M Y'); ?></dd>

                </dl>

            </div>

        </div>

    </div>

</div>