<div class="row">
    <div class="hpanel hgreen">
       <div class="panel-heading hbuilt">
            <div class="panel-tools">
                <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                <a class="closebox"><i class="fa fa-times"></i></a>
            </div>
            Edit Data Guru <?php $guru=$this->gmodel->getDataTableInfo("data_guru","id_guru",$this->urlenkripsi->decode_url($id_guru)); if(sizeof($guru)==0){$this->gmodel->alert($guru,"","Data Tidak Ada");redirect("instansi/guru");}echo $guru['nama_guru'];?>
        </div>
        <div class="panel-body">
<!-- Tambah Guru -->
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
<?php echo form_open("operation/edit_guru"); ?>
<div class="col-md-4">
    <fieldset>
    <legend>Data Diri</legend>
        <div class="row">
            <div class="form-group">
                <label>No KTP (NIK)</label>
                <input type="hidden" value="<?php echo $this->session->userdata('id_instansi'); ?>" name="id_instansi">
                <input type="hidden" value="<?php echo $guru['id_guru']; ?>" name="id_guru">
                <input type="text" placeholder="No KTP" class="form-control" name="no_ktp" value="<?php echo $guru['no_ktp']; ?>" required="">
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <label>NIP Pegawai</label>
                <input type="text" placeholder="NIP" class="form-control" name="nip" value="<?php echo $guru['nip']; ?>" required="">
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <label>Nama Guru</label>
                <input type="text" placeholder="Nama Guru" class="form-control" name="nama_guru" value="<?php echo $guru['nama_guru']; ?>" required="">
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <label>Jenis Kelamin</label>
                <select class="form-control" name="jenkel" required="">
                    <option value="">-- Jenis Kelamin --</option>
                    <option value="L" <?php echo $guru['jenkel']=="L"?"selected":""; ?>>Laki - laki</option>
                    <option value="P" <?php echo $guru['jenkel']=="P"?"selected":""; ?>>Perempuan</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <label>Tempat Lahir</label>
                    <input type="text" class="form-control" placeholder="Tempat lahir" name="tmp_lhr" value="<?php echo $guru['tmp_lhr']; ?>" required="">
            </div>  
        </div>
        <div class="row">
            <div class="form-group">
                <label>Tanggal Lahir</label>
                <div class="input-group date">
                    <input type="text" class="form-control datepicker" value="<?php echo date_format(date_create($guru['tgl_lhr']),'d/m/Y'); ?>" placeholder="Tanggal lahir" name="tgl_lhr" required=""><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
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
                            <option value="<?php echo $key->id; ?>" <?php echo $key->id==$guru['prov_id']?"selected":""; ?>><?php echo $key->name; ?></option>
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
                        $this->db->where("province_id",$guru['prov_id']);
                        $kota=$this->db->get("data_kota");
                        $kota=$kota->result();
                        foreach ($kota as $key) {
                            ?>
                            <option value="<?php echo $key->id; ?>" <?php echo $key->id==$guru['kab_id']?"selected":""; ?>><?php echo $key->name; ?></option>
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
                        $this->db->where("regency_id",$guru['kab_id']);
                        $kec=$this->db->get("data_kecamatan");
                        $kec=$kec->result();
                        foreach ($kec as $key) {
                            ?>
                            <option value="<?php echo $key->id; ?>" <?php echo $key->id==$guru['kec_id']?"selected":""; ?>><?php echo $key->name; ?></option>
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
                        $this->db->where("district_id",$guru['kec_id']);
                        $desa=$this->db->get("data_desa");
                        $desa=$desa->result();
                        foreach ($desa as $key) {
                            ?>
                            <option value="<?php echo $key->id; ?>" <?php echo $key->id==$guru['desa_id']?"selected":""; ?>><?php echo $key->name; ?></option>
                            <?php
                        }
                    ?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <label>Alamat</label>
                <textarea class="form-control" name="alamat"><?php echo $guru['alamat']; ?></textarea>
            </div>
        </div>
    </fieldset>
</div>    
<div class="col-md-4">
    <fieldset>
    <legend>Status Guru</legend>
        <div class="row">
            <div class="form-group">
                <label>Status Guru</label>
                <select class="form-control" name="status_guru">
                    <option value="">-- Status Pegawai --</option>
                    <option value="PNS" <?php echo $guru['status_guru']=="PNS"?'selected':'';?>>PNS</option>
                    <option value="TETAP" <?php echo $guru['status_guru']=="TETAP"?'selected':'';?>>Tetap</option>
                    <option value="KONTRAK" <?php echo $guru['status_guru']=="KONTRAK"?'selected':'';?>>Kontrak</option>
                    <option value="HONORER" <?php echo $guru['status_guru']=="HONORER"?'selected':'';?>>Honorer</option>
                    <option value="LAIN-LAIN" <?php echo $guru['status_guru']=="LAIN-LAIN"?'selected':'';?>>Lain-Lain</option>
                </select>
            </div>
        </div>
    </fieldset>
    <br>
    <div class="form-group">
        <button class="btn btn-success btn-block" type="submit">Simpan</button>
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