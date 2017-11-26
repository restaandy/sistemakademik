<script type="text/javascript">
	function set_aktif_ta(e){
		$('#siamodal').attr("class","modal fade hmodal-info");
        $('#siamodal .modal-title').text("Setting Tahun Ajaran");
        $.post('<?php echo base_url(); ?>ajax/popup/tahun_ajaran',{id_ta:$(e.target).attr('data-id')},function(data){
            $('#siamodal .modal-body').html(data);
        });
		$('#siamodal').modal('show');
	}
</script>
<?php  
    if($this->session->flashdata("notif")!=NULL){
        ?>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/toastr/build/toastr.min.css" />
		<script src="<?php echo base_url(); ?>assets/vendor/toastr/build/toastr.min.js"></script>
		<script type="text/javascript">
                 toastr.options = {
                    "debug": false,
                    "newestOnTop": false,
                    "positionClass": "toast-top-right",
                    "closeButton": true,
                    "toastClass": "animated fadeInDown",
                };
            <?php  
            if($this->session->flashdata("notif")["type"]=="success"){
                ?>
                    toastr.success('<?php echo $this->session->flashdata("notif")["msg"]; ?>');
                <?php
            }
            if($this->session->flashdata("notif")["type"]=="info"){
                ?>
                    toastr.info('<?php echo $this->session->flashdata("notif")["msg"]; ?>');
                <?php
            }
            if($this->session->flashdata("notif")["type"]=="warning"){
                ?>
                    toastr.warning('<?php echo $this->session->flashdata("notif")["msg"]; ?>');
                <?php
            }
            if($this->session->flashdata("notif")["type"]=="error"){
                ?>
                    toastr.error('<?php echo $this->session->flashdata("notif")["msg"]; ?>');
                <?php
            }
            ?>
        </script>
        <?php
    }
?>
