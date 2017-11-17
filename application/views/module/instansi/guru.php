<div class="row">
    <div class="hpanel hgreen">
       <div class="panel-heading hbuilt">
            <div class="panel-tools">
                <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                <a class="closebox"><i class="fa fa-times"></i></a>
            </div>
            Data Guru <?php echo $this->session->userdata("nama_instansi"); ?>
        </div>
        <div class="panel-body">
            <?php if($page==NULL){?>
<!-- Daftar Guru -->
            <div class="row">
                <div class="col-md-6">
                    <a href="<?php echo base_url(); ?>instansi/guru/add" class="btn btn-info btn-sm">Tambah Guru</a>
                </div>
                <div class="col-md-6">
                                <div class="pull-right">
                                    <form class="form-inline">
                                      <div class="form-group">
                                        <label for="pwd">Cari:</label>
                                        <select class="form-control input-sm">
                                            <option value="nama">Nama Guru</option>
                                        </select>
                                        <input type="text" class="form-control input-sm" id="pwd">
                                      </div>
                                      <button type="submit" class="btn btn-primary btn-sm">Cari</button>
                                    </form>
                                </div>  
                </div>
        </div>
        <p></p>
    <div class="table-responsive">
        <table class="table table-hover table-bordered table-striped">
            <thead>
                <tr>
                    <th>No Identitas</th>
                    <th>Nama</th>
                    <th>Tempat, Tgl Lahir</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $guru=$this->db->get_where("data_guru",array("id_instansi"=>$this->session->userdata("id")));
            $guru=$guru->result();
            foreach ($guru as $key) {
               ?>
               <tr>
                    <td>
                        No KTP : <?php echo $key->no_ktp; ?></br>
                        NIP : <?php echo $key->nip; ?>
                    </td>
                    <td>
                        <?php echo $key->nama_guru; ?>
                        <span class="label label-success">Added</span>
                    </td>
                    <td>
                        <?php echo $key->tmp_lhr; ?>, <?php echo date_format(date_create($key->tgl_lhr),'d M Y'); ?>
                    </td>
                    <td>
                        <?php echo $key->alamat; ?>, 
                        <?php echo $key->desa_id; ?>, 
                        <?php echo $key->kec_id; ?>, 
                        <?php echo $key->kab_id; ?>, 
                        <?php echo $key->prov_id; ?>
                    </td>
                    <td>
                        
                    </td>
               <?php
            }
            ?>
            </tbody>
        </table>
    </div>
<!-- End Daftar guru -->
     <?php }elseif($page=="add"){
?>
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
<?php echo form_open("operation/save_guru"); ?>
<div class="col-md-4">
    <fieldset>
    <legend>Data Diri</legend>
        <div class="row">
            <div class="form-group">
                <label>No KTP (NIK)</label>
                <input type="hidden" value="<?php echo $this->session->userdata('id_instansi'); ?>" name="id_instansi">
                <input type="text" placeholder="No KTP" class="form-control" name="no_ktp" required="">
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <label>NIP Pegawai</label>
                <input type="text" placeholder="NIP" class="form-control" name="nip" required="">
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <label>Nama Guru</label>
                <input type="text" placeholder="Nama Guru" class="form-control" name="nama_guru" required="">
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <label>Tempat Lahir</label>
                    <input type="text" class="form-control" placeholder="Tempat lahir" name="tmp_lhr" required="">
            </div>  
        </div>
        <div class="row">
            <div class="form-group">
                <label>Tanggal Lahir</label>
                <div class="input-group date">
                    <input type="text" class="form-control datepicker" placeholder="Tanggal lahir" name="tgl_lhr" required=""><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
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
                            <option value="<?php echo $key->id; ?>"><?php echo $key->name; ?></option>
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
                    <option value="">-- Pilih Kota --</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <label>Kecamatan</label>
                <select class="form-control" name="kec_id" onchange="get_desa(event)">
                    <option value="">-- Pilih Kecamatan --</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <label>Desa</label>
                <select class="form-control" name="desa_id">
                    <option value="">-- Pilih Desa --</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <label>Alamat</label>
                <textarea class="form-control" name="alamat"></textarea>
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
                    <option value="PNS">PNS</option>
                    <option value="TETAP">Tetap</option>
                    <option value="KONTRAK">Kontrak</option>
                    <option value="HONORER">Honorer</option>
                    <option value="LAIN-LAIN">Lain-Lain</option>
                </select>
            </div>
        </div>
    </fieldset>
    <br>
    <div class="form-group">
        <button class="btn btn-success btn-block" type="submit">Simpan</button>
    </div>
</div>    
<script type="text/javascript">
    $(document).ready(function(){
        $("select[name='prov_id']").select2();
        $("select[name='kab_id']").select2();
        $("select[name='kec_id']").select2();
        $("select[name='desa_id']").select2();
        /*$("select[name='id_pekerjaan']").select2();
        $("select[name='id_kurs']").select2();
        $("select[name='id_kepemilikan']").select2();
        $("select[name='id_bid_usaha']").select2();
        $("select[name='id_warga_negara']").select2();
        $("select[name='id_negara']").select2();
        $("select[name='id_negara_p']").select2();
        $("select[name='id_propinsi_p']").select2();
        $("select[name='id_kota_p']").select2();
        $("select[name='id_kecamatan_p']").select2();
        //$("select[name='id_kelurahan_p']").select2();*/
        $(".datepicker").datepicker({format:'dd/mm/yyyy'});
    });
    function get_kab(e){
        $.post('<?php echo base_url(); ?>ajax/get_kab',{prov_id:$(e.target).val()},function(data){
            $("select[name='kab_id']").html(data);
        });
    }
    function get_kec(e){
        $.post('<?php echo base_url(); ?>ajax/get_kec',{kab_id:$(e.target).val()},function(data){
            $("select[name='kec_id']").html(data);
        });
    }
    function get_desa(e){
        $.post('<?php echo base_url(); ?>ajax/get_desa',{kec_id:$(e.target).val()},function(data){
            $("select[name='desa_id']").html(data);
        });
    }
</script>
<?php echo form_close(); ?>
<!-- End Tambah Guru -->
<?php } ?> 
            </div>
    </div>  
</div>