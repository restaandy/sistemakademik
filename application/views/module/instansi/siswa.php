<div class="row">
    <div class="hpanel hgreen">
       <div class="panel-heading hbuilt">
            <div class="panel-tools">
                <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                <a class="closebox"><i class="fa fa-times"></i></a>
            </div>
            Data Siswa <?php $siswa=$this->gmodel->getDataTableInfo("data_siswa","id_siswa",$this->urlenkripsi->decode_url($id_siswa)); if(sizeof($siswa)==0){$this->gmodel->alert($siswa,"","Data Tidak Ada");redirect("instansi/siswa");}echo $siswa['nama_siswa'];?>
        </div>
        <div class="panel-body">
<!-- Tambah siswa -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/select2-3.5.2/select2.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/select2-bootstrap/select2-bootstrap.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/bootstrap-datepicker-master/dist/css/bootstrap-datepicker3.min.css" />
<script src="<?php echo base_url(); ?>assets/vendor/select2-3.5.2/select2.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/bootstrap-datepicker-master/dist/js/bootstrap-datepicker.min.js"></script>
<style type="text/css">
fieldset { 
    display: block;
    margin-left: 2px;
    margin-right: 2px;
    padding-top: 0.5em;
    padding-bottom: 1.625em;
    padding-left: 1.75em;
    padding-right: 1.75em;
    border: 0.1em solid gray;
}
</style>
<div class="text-center m-b-md" id="wizardControl">
    <a class="btn btn-primary" href="<?php echo base_url(); ?>instansi/siswa/edit/<?php echo $id_siswa; ?>">Step 1 - Data Siswa</a>
    <a class="btn btn-default" href="<?php echo base_url(); ?>instansi/siswa/ortu/<?php echo $id_siswa; ?>">Step 2 - Data Orang Tua</a>
</div>
<?php echo form_open("operation/edit_siswa"); ?>
<div class="row">
<div class="col-md-4">
    <fieldset>
    <legend>Data Diri</legend>
        <div class="row">
            <div class="form-group">
                <label>NISN</label>
                <input type="hidden" value="<?php echo $this->session->userdata('id_instansi'); ?>" name="id_instansi">
                <input type="hidden" value="<?php echo $this->urlenkripsi->decode_url($id_siswa); ?>" name="id_siswa">
                <input type="text" placeholder="NISN" class="form-control" name="nisn" value="<?php echo $siswa['nisn']; ?>" required="">
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <label>NIS</label>
                <input type="text" placeholder="NIS" class="form-control" name="nis" value="<?php echo $siswa['nis']; ?>" required="">
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <label>Nama Siswa</label>
                <input type="text" placeholder="Nama Siswa" class="form-control" name="nama_siswa" value="<?php echo $siswa['nama_siswa']; ?>" required="">
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <label>Jenis Kelamin</label>
                <select class="form-control" name="jenkel" required="">
                    <option value="">-- Jenis Kelamin --</option>
                    <option value="L" <?php echo $siswa['jenkel']=="L"?"selected":""; ?>>Laki - laki</option>
                    <option value="P" <?php echo $siswa['jenkel']=="P"?"selected":""; ?>>Perempuan</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <label>Tempat Lahir</label>
                    <input type="text" class="form-control" placeholder="Tempat lahir" name="tmp_lhr" value="<?php echo $siswa['tmp_lhr']; ?>" required="">
            </div>  
        </div>
        <div class="row">
            <div class="form-group">
                <label>Tanggal Lahir</label>
                <div class="input-group date">
                    <input type="text" class="form-control datepicker" value="<?php echo date_format(date_create($siswa['tgl_lhr']),'d/m/Y'); ?>" placeholder="Tanggal lahir" name="tgl_lhr" required=""><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                </div>
            </div>
        </div>
    </fieldset>
</div>
<div class="col-md-4">
    <fieldset>
    <legend>Data Alamat</legend>
        <div class="row">
            <div class="form-group">
                <label>Provinsi</label>
                <select class="form-control" name="prov_id" onchange="get_kab(event)">
                    <option value="">-- Pilih Provinsi --</option>
                    <?php
                        $prov=$this->db->get("data_provinsi");
                        $prov=$prov->result();
                        foreach ($prov as $key) {
                            ?>
                            <option value="<?php echo $key->id; ?>" <?php echo $key->id==$siswa['prov_id']?"selected":""; ?>><?php echo $key->name; ?></option>
                            <?php
                        }
                    ?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <label>kabupaten/Kota</label>
                <select class="form-control" name="kab_id" onchange="get_kec(event)">
                    <option value="">-- Pilih Kabupaten/Kota --</option>
                    <?php
                        $this->db->where("province_id",$siswa['prov_id']);
                        $kota=$this->db->get("data_kota");
                        $kota=$kota->result();
                        foreach ($kota as $key) {
                            ?>
                            <option value="<?php echo $key->id; ?>" <?php echo $key->id==$siswa['kab_id']?"selected":""; ?>><?php echo $key->name; ?></option>
                            <?php
                        }
                    ?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <label>Kecamatan</label>
                <select class="form-control" name="kec_id" onchange="get_desa(event)">
                    <option value="">-- Pilih Kecamatan --</option>
                    <?php
                        $this->db->where("regency_id",$siswa['kab_id']);
                        $kec=$this->db->get("data_kecamatan");
                        $kec=$kec->result();
                        foreach ($kec as $key) {
                            ?>
                            <option value="<?php echo $key->id; ?>" <?php echo $key->id==$siswa['kec_id']?"selected":""; ?>><?php echo $key->name; ?></option>
                            <?php
                        }
                    ?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <label>Desa</label>
                <select class="form-control" name="desa_id">
                    <option value="">-- Pilih Desa --</option>
                    <?php
                        $this->db->where("district_id",$siswa['kec_id']);
                        $desa=$this->db->get("data_desa");
                        $desa=$desa->result();
                        foreach ($desa as $key) {
                            ?>
                            <option value="<?php echo $key->id; ?>" <?php echo $key->id==$siswa['desa_id']?"selected":""; ?>><?php echo $key->name; ?></option>
                            <?php
                        }
                    ?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <label>Alamat</label>
                <textarea class="form-control" name="alamat"><?php echo $siswa['alamat']; ?></textarea>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <label>Pendidikan Terakhir</label>
                <?php $ortu['pendidikan_ayah']=isset($ortu['pendidikan_ayah'])?$ortu['pendidikan_ayah']:''; ?>
                <select class="form-control" name="pendidikan_ayah" required="">
                    <option value="">-- Pilih Pendidikan --</option>
                    <option value="SD" <?php echo $ortu['pendidikan_ayah']=="SD"?"selected":""; ?>>SD</option>
                    <option value="SMP / MTS" <?php echo $ortu['pendidikan_ayah']=="SMP / MTS"?"selected":""; ?>>SMP / MTS</option>
                    <option value="SMA / MA / MI" <?php echo $ortu['pendidikan_ayah']=="SMA / MA / MI"?"selected":""; ?>>SMA / MA / MI</option>
                    <option value="DIPLOMA (D1 - D3)" <?php echo $ortu['pendidikan_ayah']=="DIPLOMA (D1 - D3)"?"selected":""; ?>>DIPLOMA (D1 - D3)</option>
                    <option value="SARJANA (S1)" <?php echo $ortu['pendidikan_ayah']=="SARJANA (S1)"?"selected":""; ?>>SARJANA (S1)</option>
                    <option value="MAGISTER (S2)" <?php echo $ortu['pendidikan_ayah']=="MAGISTER (S2)"?"selected":""; ?>>MAGISTER (S2)</option>
                    <option value="DOCTOR (S3)" <?php echo $ortu['pendidikan_ayah']=="DOCTOR (S3)"?"selected":""; ?>>DOCTOR (S3)</option>
                </select>
            </div>
        </div>
    </fieldset>
</div>    
<div class="col-md-4">
    <fieldset>
    <legend>Status Siswa</legend>
        <div class="row">
            <div class="form-group">
                <label>Status siswa</label>
                <select class="form-control" name="status_siswa">
                    <option value="">-- Status Pegawai --</option>
                    <option value="Aktif" <?php echo $siswa['status_siswa']=="Aktif"?'selected':'';?>>Aktif</option>
                    <option value="Lulus" <?php echo $siswa['status_siswa']=="Lulus"?'selected':'';?>>Lulus</option>
                    <option value="Keluar" <?php echo $siswa['status_siswa']=="Keluar"?'selected':'';?>>Keluar</option>
                    <option value="Di Keluarkan" <?php echo $siswa['status_siswa']=="Di Keluarkan"?'selected':'';?>>Di Keluarkan</option>
                </select>
            </div>
        </div>
    </fieldset>
    <br>
    <div class="form-group">
        <button class="btn btn-success btn-block" type="submit">Simpan</button>
        <a href="<?php echo base_url(); ?>instansi/siswa/ortu/<?php echo $id_siswa; ?>" class="btn btn-primary btn-block">Lengkapi Data Orang Tua</a>
    </div>
</div>  
</div>
<?php echo form_close(); ?>  
<script type="text/javascript">
    $(document).ready(function(){
        $("select[name='prov_id']").select2();
        $("select[name='kab_id']").select2();
        $("select[name='kec_id']").select2();
        $("select[name='desa_id']").select2();
        $(".datepicker").datepicker({format:'dd/mm/yyyy'});
    });
    function get_kab(e){
        $.post('<?php echo base_url(); ?>ajax/get_kab',{prov_id:$(e.target).val()},function(data){
            $("select[name='kab_id']").html(data);
            $("select[name='kec_id']").html("<option value=''>-- Pilih Kecamatan --</option>");
            $("select[name='desa_id']").html("<option value=''>-- Pilih Desa --</option>");
            $("select[name='kab_id']").select2();
            $("select[name='kec_id']").select2();
            $("select[name='desa_id']").select2();
        });
    }
    function get_kec(e){
        $.post('<?php echo base_url(); ?>ajax/get_kec',{kab_id:$(e.target).val()},function(data){
            $("select[name='kec_id']").html(data);
            $("select[name='desa_id']").html("<option value=''>-- Pilih Desa --</option>");
            $("select[name='kec_id']").select2();
            $("select[name='desa_id']").select2();
        });
    }
    function get_desa(e){
        $.post('<?php echo base_url(); ?>ajax/get_desa',{kec_id:$(e.target).val()},function(data){
            $("select[name='desa_id']").html(data);
            $("select[name='desa_id']").select2();
        });
    }
</script>
</div></div></div>