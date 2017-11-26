<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/bootstrap-datepicker-master/dist/css/bootstrap-datepicker3.min.css">
<?php  
$kelas=$this->db->get_where("sch_kelas",array("id_instansi"=>$this->session->userdata("id_instansi")));
$kelas=$kelas->result();
if(sizeof($kelas)>15){
?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/select2-3.5.2/select2.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/select2-bootstrap/select2-bootstrap.css" />
<script src="<?php echo base_url(); ?>assets/vendor/select2-3.5.2/select2.min.js"></script>
<?php
}
?>
<div class="row">
    <div class="hpanel hgreen">
       <div class="panel-heading hbuilt">
		Sistem Absensi Siswa	            
       </div>
        <div class="panel-body">
        	<div class="row" style="padding-left: 10px;">
        	<div class="input-group col-md-4">
        	<label>Ruang Kelas</label>
        		<select class="form-control" name="id_kelas">
        			<option value="">-- Pilih Kelas --</option>
        			<?php  
        				foreach ($kelas as $key) {
        					?>
        						<option value="<?php echo $key->id_kelas; ?>"><?php echo $key->nama_kelas; ?></option>
        					<?php
        				}
        			?>
        		</select>
        	</div>
        	</div>
        	<div class="row" style="margin-top: 10px;padding-left: 10px;">
        	<label>Tanggal Absen</label>
              <div class="input-group date col-md-4">
              <input type="text" required="" name="tanggal" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
              </div>
              <button type="button" onclick="loadabsen()" class="btn btn-primary btn-sm" style="margin-top: 10px;">Cari</button>
        	</div>
        	<center class="load hide"><img src="<?php echo base_url(); ?>assets/images/loading.gif" width="80" height="80"></center>
        	<div id="loadabsen"></div>
        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>assets/vendor/bootstrap-datepicker-master/dist/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript">
 $(document).ready(function(){
    $('.date').datepicker({format:"dd/mm/yyyy"});  
    <?php
    	if(sizeof($kelas)>15){
    		?>
    		$("select[name='id_kelas']").select2();
    		<?php
    	}
    ?>
  });
 function loadabsen(){
 	$(".load").removeClass("hide");
 	$.post("<?php echo base_url(); ?>ajax/getabsen",{tgl:$("input[name='tanggal']").val()},function(data,status){
 		if(status=="success"){
 			$(".load").addClass("hide");
 		}else{
 			$(".load").addClass("hide");
 		}
 	});
 }
</script>