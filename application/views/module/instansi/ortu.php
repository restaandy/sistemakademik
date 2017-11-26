<div class="row">
    <div class="hpanel hgreen">
       <div class="panel-heading hbuilt">
            <div class="panel-tools">
                <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                <a class="closebox"><i class="fa fa-times"></i></a>
            </div>
            Data Orang Tua <?php $siswa=$this->gmodel->getDataTableInfo("data_siswa","id_siswa",$this->urlenkripsi->decode_url($id_siswa)); if(sizeof($siswa)==0){$this->gmodel->alert($siswa,"","Data Tidak Ada");redirect("instansi/siswa");}echo $siswa['nama_siswa'];?>
        </div>
        <div class="panel-body">
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
            <a class="btn btn-default" href="<?php echo base_url(); ?>instansi/siswa/edit/<?php echo $id_siswa; ?>">Step 1 - Data Siswa</a>
            <a class="btn btn-primary" href="<?php echo base_url(); ?>instansi/siswa/ortu/<?php echo $id_siswa; ?>">Step 2 - Data Orang Tua</a>
         </div>
<?php echo form_open("operation/edit_ortu"); ?>
<?php
$ortu=$this->gmodel->getDataTableInfo("data_ortu","id_siswa",$this->urlenkripsi->decode_url($id_siswa));
?>
<div class="row">
<div class="col-md-6">
    <fieldset>
    <legend>Data Ayah</legend>
        <div class="row">
            <div class="form-group">
                <label>No KTP</label>
                <input type="hidden" value="<?php echo $this->session->userdata('id_instansi'); ?>" name="id_instansi">
                <input type="hidden" value="<?php echo isset($ortu)?$ortu['id_ortu']:''; ?>" name="id_ortu">
                <input type="hidden" value="<?php echo $this->urlenkripsi->decode_url($id_siswa); ?>" name="id_siswa">
                <input type="text" placeholder="No KTP" class="form-control" name="no_ktp_ayah" value="<?php echo isset($ortu)?$ortu['no_ktp_ayah']:''; ?>">
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <label>Nama Ayah</label>
                <input type="text" placeholder="Nama Ayah" class="form-control" name="nama_ayah" value="<?php echo isset($ortu)?$ortu['nama_ayah']:''; ?>" required="">
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <label>Tempat Lahir</label>
                    <input type="text" class="form-control" placeholder="Tempat lahir" name="tmp_lhr_ayah" value="<?php echo isset($ortu)?$ortu['tmp_lhr_ayah']:''; ?>">
            </div>  
        </div>
        <div class="row">
            <div class="form-group">
                <label>Tanggal Lahir</label>
                <div class="input-group date">
                    <input type="text" class="form-control datepicker" value="<?php echo isset($ortu)?$this->gmodel->formatdate('d/m/Y',$ortu['tgl_lhr_ayah']):''; ?>" placeholder="Tanggal lahir" name="tgl_lhr_ayah" required=""><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <label>Provinsi</label>
                <select class="form-control" name="prov_id_ayah" onchange="get_kab(event,'ayah')">
                    <option value="">-- Pilih Provinsi --</option>
                    <?php
                        $prov=$this->db->get("data_provinsi");
                        $prov=$prov->result();
                        $ortu['prov_id_ayah']=isset($ortu['prov_id_ayah'])?$ortu['prov_id_ayah']:'';
                        foreach ($prov as $key) {
                            ?>
                            <option value="<?php echo $key->id; ?>" <?php echo $key->id==$ortu['prov_id_ayah']?"selected":""; ?>><?php echo $key->name; ?></option>
                            <?php
                        }
                    ?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <label>kabupaten/Kota</label>
                <select class="form-control" name="kab_id_ayah" onchange="get_kec(event,'ayah')">
                    <option value="">-- Pilih Kabupaten/Kota --</option>
                    <?php
                        $this->db->where("province_id",$ortu['prov_id_ayah']);
                        $kota=$this->db->get("data_kota");
                        $kota=$kota->result();
                        $ortu['kab_id_ayah']=isset($ortu['kab_id_ayah'])?$ortu['kab_id_ayah']:'';
                        foreach ($kota as $key) {
                            ?>
                            <option value="<?php echo $key->id; ?>" <?php echo $key->id==$ortu['kab_id_ayah']?"selected":""; ?>><?php echo $key->name; ?></option>
                            <?php
                        }
                    ?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <label>Kecamatan</label>
                <select class="form-control" name="kec_id_ayah" onchange="get_desa(event,'ayah')">
                    <option value="">-- Pilih Kecamatan --</option>
                    <?php
                        $this->db->where("regency_id",$ortu['kab_id_ayah']);
                        $kec=$this->db->get("data_kecamatan");
                        $kec=$kec->result();
                        $ortu['kec_id_ayah']=isset($ortu['kec_id_ayah'])?$ortu['kec_id_ayah']:'';
                        foreach ($kec as $key) {
                            ?>
                            <option value="<?php echo $key->id; ?>" <?php echo $key->id==$ortu['kec_id_ayah']?"selected":""; ?>><?php echo $key->name; ?></option>
                            <?php
                        }
                    ?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <label>Desa</label>
                <select class="form-control" name="desa_id_ayah">
                    <option value="">-- Pilih Desa --</option>
                    <?php
                        $this->db->where("district_id",$ortu['kec_id_ayah']);
                        $desa=$this->db->get("data_desa");
                        $desa=$desa->result();
                        $ortu['desa_id_ayah']=isset($ortu['desa_id_ayah'])?$ortu['desa_id_ayah']:'';
                        foreach ($desa as $key) {
                            ?>
                            <option value="<?php echo $key->id; ?>" <?php echo $key->id==$ortu['desa_id_ayah']?"selected":""; ?>><?php echo $key->name; ?></option>
                            <?php
                        }
                    ?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <label>Alamat</label>
                <textarea class="form-control" name="alamat_ayah"><?php echo isset($ortu['alamat_ayah'])?$ortu['alamat_ayah']:''; ?></textarea>
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
<div class="col-md-6">
    <fieldset>
    <legend>Data Ibu</legend>
        <div class="row">
            <div class="form-group">
                <label>No KTP</label>
                <input type="text" placeholder="No KTP" class="form-control" name="no_ktp_ibu" value="<?php echo isset($ortu['no_ktp_ibu'])?$ortu['no_ktp_ibu']:''; ?>">
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <label>Nama Ibu</label>
                <input type="text" placeholder="Nama Ibu" class="form-control" name="nama_ibu" value="<?php echo isset($ortu['nama_ibu'])?$ortu['nama_ibu']:''; ?>" required="">
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <label>Tempat Lahir</label>
                    <input type="text" class="form-control" placeholder="Tempat lahir" name="tmp_lhr_ibu" value="<?php echo isset($ortu['tmp_lhr_ibu'])?$ortu['tmp_lhr_ibu']:''; ?>">
            </div>  
        </div>
        <div class="row">
            <div class="form-group">
                <label>Tanggal Lahir</label>
                <div class="input-group date">
                    <input type="text" class="form-control datepicker" value="<?php echo isset($ortu['tgl_lhr_ibu'])?$this->gmodel->formatdate('d/m/Y',$ortu['tgl_lhr_ibu']):''; ?>" placeholder="Tanggal lahir" name="tgl_lhr_ibu" required=""><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <label>Provinsi</label>
                <select class="form-control" name="prov_id_ibu" onchange="get_kab(event,'ibu')">
                    <option value="">-- Pilih Provinsi --</option>
                    <?php
                        $prov=$this->db->get("data_provinsi");
                        $prov=$prov->result();
                        $ortu['prov_id_ibu']=isset($ortu['prov_id_ibu'])?$ortu['prov_id_ibu']:'';
                        foreach ($prov as $key) {
                            ?>
                            <option value="<?php echo $key->id; ?>" <?php echo $key->id==$ortu['prov_id_ibu']?"selected":""; ?>><?php echo $key->name; ?></option>
                            <?php
                        }
                    ?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <label>kabupaten/Kota</label>
                <select class="form-control" name="kab_id_ibu" onchange="get_kec(event,'ibu')">
                    <option value="">-- Pilih Kabupaten/Kota --</option>
                    <?php
                        $this->db->where("province_id",$ortu['prov_id_ibu']);
                        $kota=$this->db->get("data_kota");
                        $kota=$kota->result();
                        $ortu['kab_id_ibu']=isset($ortu['kab_id_ibu'])?$ortu['kab_id_ibu']:'';
                        foreach ($kota as $key) {
                            ?>
                            <option value="<?php echo $key->id; ?>" <?php echo $key->id==$ortu['kab_id_ibu']?"selected":""; ?>><?php echo $key->name; ?></option>
                            <?php
                        }
                    ?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <label>Kecamatan</label>
                <select class="form-control" name="kec_id_ibu" onchange="get_desa(event,'ibu')">
                    <option value="">-- Pilih Kecamatan --</option>
                    <?php
                        $this->db->where("regency_id",$ortu['kab_id_ibu']);
                        $kec=$this->db->get("data_kecamatan");
                        $kec=$kec->result();
                        $ortu['kec_id_ibu']=isset($ortu['kec_id_ibu'])?$ortu['kec_id_ibu']:'';
                        foreach ($kec as $key) {
                            ?>
                            <option value="<?php echo $key->id; ?>" <?php echo $key->id==$ortu['kec_id_ibu']?"selected":""; ?>><?php echo $key->name; ?></option>
                            <?php
                        }
                    ?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <label>Desa</label>
                <select class="form-control" name="desa_id_ibu">
                    <option value="">-- Pilih Desa --</option>
                    <?php
                        $this->db->where("district_id",$ortu['kec_id_ibu']);
                        $desa=$this->db->get("data_desa");
                        $desa=$desa->result();
                        $ortu['desa_id_ibu']=isset($ortu['desa_id_ibu'])?$ortu['desa_id_ibu']:'';
                        foreach ($desa as $key) {
                            ?>
                            <option value="<?php echo $key->id; ?>" <?php echo $key->id==$ortu['desa_id_ibu']?"selected":""; ?>><?php echo $key->name; ?></option>
                            <?php
                        }
                    ?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <label>Alamat</label>
                <textarea class="form-control" name="alamat_ibu"><?php echo isset($ortu['alamat_ibu'])?$ortu['alamat_ibu']:''; ?></textarea>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <label>Pendidikan Terakhir</label>
                <?php $ortu['pendidikan_ibu']=isset($ortu['pendidikan_ibu'])?$ortu['pendidikan_ibu']:''; ?>
                <select class="form-control" name="pendidikan_ibu" required="">
                    <option value="">-- Pilih Pendidikan --</option>
                    <option value="SD" <?php echo $ortu['pendidikan_ibu']=="SD"?"selected":""; ?>>SD</option>
                    <option value="SMP / MTS" <?php echo $ortu['pendidikan_ibu']=="SMP / MTS"?"selected":""; ?>>SMP / MTS</option>
                    <option value="SMA / MA / MI" <?php echo $ortu['pendidikan_ibu']=="SMA / MA / MI"?"selected":""; ?>>SMA / MA / MI</option>
                    <option value="DIPLOMA (D1 - D3)" <?php echo $ortu['pendidikan_ibu']=="DIPLOMA (D1 - D3)"?"selected":""; ?>>DIPLOMA (D1 - D3)</option>
                    <option value="SARJANA (S1)" <?php echo $ortu['pendidikan_ibu']=="SARJANA (S1)"?"selected":""; ?>>SARJANA (S1)</option>
                    <option value="MAGISTER (S2)" <?php echo $ortu['pendidikan_ibu']=="MAGISTER (S2)"?"selected":""; ?>>MAGISTER (S2)</option>
                    <option value="DOCTOR (S3)" <?php echo $ortu['pendidikan_ibu']=="DOCTOR (S3)"?"selected":""; ?>>DOCTOR (S3)</option>
                </select>
            </div>
        </div>
    </fieldset>
    <br>
    <div class="form-group">
        <button class="btn btn-success btn-block" type="submit">Simpan</button>
        <a href="<?php echo base_url(); ?>instansi/siswa/edit/twk8680mQIKdmfJ0O_JX3HBEydZIQH6gPtFdrDsWWLU" class="btn btn-primary btn-block">Lanjut Data Orang Tua</a>
    </div>
</div>
</div>
<?php echo form_close(); ?>  
<script type="text/javascript">
    $(document).ready(function(){
        $("select[name='prov_id_ayah']").select2();
        $("select[name='kab_id_ayah']").select2();
        $("select[name='kec_id_ayah']").select2();
        $("select[name='desa_id_ayah']").select2();
        $("select[name='prov_id_ibu']").select2();
        $("select[name='kab_id_ibu']").select2();
        $("select[name='kec_id_ibu']").select2();
        $("select[name='desa_id_ibu']").select2();
        $(".datepicker").datepicker({format:'dd/mm/yyyy'});
    });
    function get_kab(e,scope){
        $.post('<?php echo base_url(); ?>ajax/get_kab',{prov_id:$(e.target).val()},function(data){
            $("select[name='kab_id_"+scope+"']").html(data);
            $("select[name='kec_id_"+scope+"']").html("<option value=''>-- Pilih Kecamatan --</option>");
            $("select[name='desa_id_"+scope+"']").html("<option value=''>-- Pilih Desa --</option>");
            $("select[name='kab_id_"+scope+"']").select2();
            $("select[name='kec_id_"+scope+"']").select2();
            $("select[name='desa_id_"+scope+"']").select2();
        });
    }
    function get_kec(e,scope){
        $.post('<?php echo base_url(); ?>ajax/get_kec',{kab_id:$(e.target).val()},function(data){
            $("select[name='kec_id_"+scope+"']").html(data);
            $("select[name='desa_id_"+scope+"']").html("<option value=''>-- Pilih Desa --</option>");
            $("select[name='kec_id_"+scope+"']").select2();
            $("select[name='desa_id_"+scope+"']").select2();
        });
    }
    function get_desa(e,scope){
        $.post('<?php echo base_url(); ?>ajax/get_desa',{kec_id:$(e.target).val()},function(data){
            $("select[name='desa_id_"+scope+"']").html(data);
            $("select[name='desa_id_"+scope+"']").select2();
        });
    }
</script>
</div></div></div>