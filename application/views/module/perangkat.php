<link rel="stylesheet" href="<?php echo base_url() ?>assets/vendor/bootstrap-datepicker-master/dist/css/bootstrap-datepicker3.min.css" />
<script src="<?php echo base_url() ?>assets/vendor/bootstrap-datepicker-master/dist/js/bootstrap-datepicker.min.js"></script>

<style type="text/css">

fieldset { border:1px solid gray;padding:10px;  }

</style>

<div class="row">	

<div class="col-md-12">	

<div class="hpanel">

    <div class="panel-body">

    <form method="POST" action="<?php echo base_url(); ?>index.php/welcome/save_perangkat">

    <div class="col-md-6">	

    		<fieldset>

    		<legend>Tempat Bertugas</legend>

    		<div class="form-group">	

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

    		<div class="form-group">	

    			<label>Desa</label>	

    			<select class="form-control" required="" name="id_desa">

    				<option value="">-- Pilih Desa --</option>

    			</select>	

    		</div>

    		</fieldset>

    		<fieldset>

    		<legend>Data Diri</legend>

    		<div class="form-group">	

    			<label>NIK</label>	

    			<input type="number" class="form-control filter" required="" name="nik">	

    		</div>	

    		<div class="form-group">	

    			<label>Nama</label>	

    			<input type="text" class="form-control filter" required="" name="nama">	

    		</div>

    		<div class="form-group">	

    			<label>Jenis Kelamin</label>	

    			<select class="form-control" required="" name="jenkel">

    				<option value="">-- Pilih Jenis Kelamin --</option>

    				<option value="L">Laki - laki</option>

    				<option value="P">Perempuan</option>

    			</select>	

    		</div>	

    		<div class="form-group">	

    			<label>Tempat Lahir</label>	

    			<input type="text" class="form-control filter" required="" name="tmp_lhr">	

    		</div>

    		<label>Tanggal Lahir</label>	

    		<div class="input-group date">

                                    <input type="text" name="tgl_lhr" required="" class="form-control datepicker"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>

                                </div>

    		<div class="form-group">	

    			<label>Agama</label>	

    			<select class="form-control" name="agama">

    				<option value="">-- Pilih Agama --</option>

    				<option value="Islam">Islam</option>

    				<option value="Kristen">Kristen</option>

    				<option value="Budha">Budha</option>

    				<option value="Hindu">Hindu</option>

    				<option value="Katholik">Katholik</option>

    			</select>	

    		</div>

    		<div class="form-group">	

    			<label>Alamat</label>	

    			<textarea class="form-control" name="alamat"></textarea>

    		</div>

    		<div class="form-group">	

    			<label>Pendidikan Terakhir</label>	

    			<select class="form-control" name="pendidikan_terakhir">

    				<option value="">-- Pilih Pendidikan Terakhir --</option>

    				<option value="SMP">SMP</option>

    				<option value="SMA / MA / MI / MTS">SMA / MA / MI / MTS</option>

    				<option value="Diploma">Diploma</option>

    				<option value="Sarjana">Sarjana</option>

    				<option value="Magister">Magister</option>

    			</select>	

		    </div>

		    <div class="form-group">	

		    	<label>Jurusan</label>	

		    	<input type="text" name="jurusan" class="form-control filter">	

		    </div>

		</fieldset>

    </div>

    <div class="col-md-6">	

    <fieldset>

    <legend>SK Pengangkatan</legend>

    <div class="form-group">	

    			<label>No SK Pengangkatan</label>	

    			<input type="text" name="sk_no_pengangkatan" class="form-control filter">	

    </div>

    		<label>Tanggal SK Pengangkatan</label>	

    		<div class="input-group date">

                                    <input type="text" name="sk_tgl_pengangkatan" class="form-control datepicker"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>

                                </div>	

    

    <label>TMT SK Pengangkatan</label>	

    		<div class="input-group date">

                                    <input type="text" name="sk_tmt_pengangkatan" class="form-control datepicker"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>

                                </div>

    </fieldset>

    <fieldset>

    <legend>Jabatan Baru</legend>

    <div class="form-group">	

    			<label>No SK Pengangkatan Baru</label>	

    			<input type="text" name="sk_baru_no_pengangkatan" class="form-control filter">	

    </div>

    <label>Tanggal SK Pengangkatan Baru</label>	

    		<div class="input-group date">

                                    <input type="text" name="sk_baru_tgl_pengangkatan" class="form-control datepicker"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>

                                </div>

    <label>TMT SK Pengangkatan Baru</label>	

    		<div class="input-group date">

                                    <input type="text" name="sk_baru_tmt_pengangkatan" class="form-control datepicker"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>

                                </div>

    <div class="form-group">	

    			<label>Jabatan Lama</label>	

    			<input type="text" name="jabatan_lama" class="form-control filter">	

    </div>

    <div class="form-group">	

    			<label>Jabatan Baru</label>	

    			<input type="text" name="jabatan_baru" class="form-control filter">	

    </div>
<!--
    <div class="form-group">	

    			<label>Tunjangan Diterima (Rp.)</label>	

    			<input type="number" name="tunjangan_diterima" class="form-control filter">	

    </div>

    <div class="form-group">	

    			<label>Tanah Kas (hektar)</label>	

    			<input type="number" name="tanah_kas" class="form-control filter">	

    </div>
-->
    </fieldset>

    <br>

    <button type="submit" class="btn btn-success btn-block">Simpan</button>

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

		$('.datepicker').datepicker({format:'dd/mm/yyyy'});

	});

$('.filter').keypress(function( e ) {    

		    if(!/[0-9a-zA-Z- ]/.test(String.fromCharCode(e.which))){

		        return false;

		    }

		});

</script>



</div>	