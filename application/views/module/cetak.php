<link rel="stylesheet" href="<?php echo base_url() ?>assets/vendor/bootstrap-datepicker-master/dist/css/bootstrap-datepicker3.min.css" />
<script src="<?php echo base_url() ?>assets/vendor/bootstrap-datepicker-master/dist/js/bootstrap-datepicker.min.js"></script>

<div class="row">

	<div class="hpanel">

		<div class="panel-body">

			<form method="POST" action="<?php echo base_url(); ?>index.php/welcome/printout" target="_blank">

				<div class="row">	

				<div class="form-group col-md-4">

					<label>Kecamatan</label>	

		    			<select class="form-control" name="id_kecamatan" required="" onchange="get_loc(event)">

		    				<option value="">-- Pilih Kecamatan --</option>

		    				<?php 	

		    					$data=$this->db->get("data_kecamatan");

		    					$data=$data->result();

		    					foreach ($data as $key) {

		    						?>

		    						<option value="<?php echo $key->id; ?>"	><?php 	echo $key->nama_kecamatan; ?></option>

		    						<?php

		    					}

		    				 ?>

		    			</select>

				</div>

				</div>

				<div class="row">

				<div class="form-group col-md-4">	

	    			<label>Desa</label>	

	    			<select class="form-control" required="" name="id_desa">

	    				<option value="">-- Pilih Desa --</option>

	    			</select>	

    			</div>

    			</div>

    			<div class="row">

				<div class="form-group col-md-4">	

	    			<label>Format</label>	

	    			<select class="form-control" required="" name="format">

	    				<option value="">-- Pilih Format Laporan --</option>

	    				<option value="excel">Excel</option>

	    				<option value="pdf">PDF</option>

	    			</select>	

    			</div>
    			<label>Tanggal Laporan</label>	

    		<div class="input-group date col-md-4">

                                    <input type="text" name="tanggal" required class="form-control datepicker"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>

                                </div>	

    			</div>

    			<div class="form-group">	

	    			<button type="submit" class="btn btn-primary">Cetak</button>

    			</div>

			</form>

		</div>

	</div>

</div>

<script type="text/javascript">

	function get_loc(e){

		$("select[name='id_desa']").html();

		$.post("<?php 	echo base_url(); ?>index.php/welcome/get_desa",{id:$(e.target).val()},function(data){

			$("select[name='id_desa']").html(data);	

		});	

	}
$(document).ready(function(){

		$('.datepicker').datepicker({format:'dd/m/yyyy'});

	});

</script>