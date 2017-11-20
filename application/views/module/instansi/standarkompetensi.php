<div class="row">
    <div class="hpanel hgreen">
       <div class="panel-heading hbuilt">
            <div class="panel-tools">
                <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                <a class="closebox"><i class="fa fa-times"></i></a>
            </div>
           Standar Kompetensi Pelajaran
        </div>
        <div class="panel-body">
<!-- Tambah siswa -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/select2-3.5.2/select2.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/select2-bootstrap/select2-bootstrap.css" />
<script src="<?php echo base_url(); ?>assets/vendor/select2-3.5.2/select2.min.js"></script>
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
<?php echo form_open("operation/edit_siswa"); ?>

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