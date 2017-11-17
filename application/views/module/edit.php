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

<link rel="stylesheet" href="<?php echo base_url() ?>assets/vendor/bootstrap-datepicker-master/dist/css/bootstrap-datepicker3.min.css" />

<script src="<?php echo base_url() ?>assets/vendor/bootstrap-datepicker-master/dist/js/bootstrap-datepicker.min.js"></script>

<style type="text/css">

fieldset { border:1px solid gray;padding:10px;  }

</style>

<div class="row">	

<div class="col-md-12">	

<div class="hpanel">

    <div class="panel-body">

    <form method="POST" action="<?php echo base_url(); ?>index.php/welcome/edit_perangkat">

    <div class="col-md-6">	

    		<fieldset>

    		<legend>Tempat Bertugas</legend>

    		<div class="form-group">	

    			<label>Kecamatan</label>

                <input type="hidden" name="id" value="<?php echo $data->id; ?>">	

    			<select class="form-control" name="id_kecamatan" required="" onchange="get_loc(event)">

    				<option value="">-- Pilih Kecamatan --</option>

    				<?php 	

    					$datas=$this->db->get("data_kecamatan");

    					$datas=$datas->result();

    					foreach ($datas as $key) {

    						?>

    						<option value="<?php echo $key->id; ?>"	<?php echo $data->id_kecamatan==$key->id?'selected':''; ?>><?php 	echo $key->nama_kecamatan; ?></option>

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

    			<input type="number" class="form-control filter" value="<?php echo $data->nik; ?>" required="" name="nik">	

    		</div>	

    		<div class="form-group">	

    			<label>Nama</label>	

    			<input type="text" class="form-control filter" required="" name="nama" value="<?php echo $data->nama; ?>">	

    		</div>

    		<div class="form-group">	

    			<label>Jenis Kelamin</label>	

    			<select class="form-control" required="" name="jenkel">

    				<option value="">-- Pilih Jenis Kelamin --</option>

    				<option value="L" <?php echo $data->jenkel=='L'?'selected':''; ?>>Laki - laki</option>

    				<option value="P" <?php echo $data->jenkel=='P'?'selected':''; ?>>Perempuan</option>

    			</select>	

    		</div>	

    		<div class="form-group">	

    			<label>Tempat Lahir</label>	

    			<input type="text" class="form-control filter" required="" name="tmp_lhr" value="<?php echo $data->tmp_lhr; ?>">	

    		</div>

    		<label>Tanggal Lahir</label>	

    		<div class="input-group date">

                                    <input type="text" name="tgl_lhr" required="" value="<?php echo date_format(date_create($data->tgl_lhr),'d/m/Y'); ?>" class="form-control datepicker"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>

                                </div>

    		<div class="form-group">	

    			<label>Agama</label>	

    			<select class="form-control" name="agama">

    				<option value="">-- Pilih Agama --</option>

    				<option value="Islam" <?php echo $data->agama=='Islam'?'selected':''; ?>>Islam</option>

    				<option value="Kristen" <?php echo $data->agama=='Kristen'?'selected':''; ?>>Kristen</option>

    				<option value="Budha" <?php echo $data->agama=='Budha'?'selected':''; ?>>Budha</option>

    				<option value="Hindu" <?php echo $data->agama=='Hindu'?'selected':''; ?>>Hindu</option>

    				<option value="Katholik" <?php echo $data->agama=='Katholik'?'selected':''; ?>>Katholik</option>

    			</select>	

    		</div>

    		<div class="form-group">	

    			<label>Alamat</label>	

    			<textarea class="form-control" name="alamat"><?php echo $data->alamat; ?></textarea>

    		</div>

    		<div class="form-group">	

    			<label>Pendidikan Terakhir</label>	

    			<select class="form-control" name="pendidikan_terakhir">

    				<option value="">-- Pilih Pendidikan Terakhir --</option>

    				<option value="SMP" <?php echo $data->pendidikan_terakhir=='SMP'?'selected':''; ?>>SMP</option>

    				<option value="SMA / MA / MI / MTS" <?php echo $data->pendidikan_terakhir=='SMA / MA / MI / MTS'?'selected':''; ?>>SMA / MA / MI / MTS</option>

    				<option value="Diploma" <?php echo $data->pendidikan_terakhir=='Diploma'?'selected':''; ?>>Diploma</option>

    				<option value="Sarjana" <?php echo $data->pendidikan_terakhir=='Sarjana'?'selected':''; ?>>Sarjana</option>

    				<option value="Magister" <?php echo $data->pendidikan_terakhir=='Magister'?'selected':''; ?>>Magister</option>

    			</select>	

		    </div>

		    <div class="form-group">	

		    	<label>Jurusan</label>	

		    	<input type="text" name="jurusan" class="form-control filter" value="<?php echo $data->jurusan; ?>">	

		    </div>

		</fieldset>

    </div>

    <div class="col-md-6">	

    <fieldset>

    <legend>SK Pengangkatan</legend>

    <div class="form-group">	

    			<label>No SK Pengangkatan</label>	

    			<input type="text" name="sk_no_pengangkatan" value="<?php echo $data->sk_no_pengangkatan; ?>" class="form-control filter">	

    </div>

    		<label>Tanggal SK Pengangkatan</label>	

    		<div class="input-group date">

                                    <input type="text" name="sk_tgl_pengangkatan" value="<?php echo date_format(date_create($data->sk_tgl_pengangkatan),'d/m/Y'); ?>" class="form-control datepicker"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>

                                </div>	

    

    <label>TMT SK Pengangkatan</label>	

    		<div class="input-group date">

                                    <input type="text" name="sk_tmt_pengangkatan" value="<?php echo date_format(date_create($data->sk_tmt_pengangkatan),'d/m/Y'); ?>" class="form-control datepicker"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>

                                </div>

    </fieldset>

    <fieldset>

    <legend>Jabatan Baru</legend>

    <div class="form-group">	

    			<label>No SK Pengangkatan Baru</label>	

    			<input type="text" name="sk_baru_no_pengangkatan" value="<?php echo $data->sk_baru_no_pengangkatan; ?>" class="form-control filter">	

    </div>

    <label>Tanggal SK Pengangkatan Baru</label>	

    		<div class="input-group date">

                                    <input type="text" name="sk_baru_tgl_pengangkatan" value="<?php echo date_format(date_create($data->sk_baru_tgl_pengangkatan),'d/m/Y'); ?>" class="form-control datepicker"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>

                                </div>

    <label>TMT SK Pengangkatan Baru</label>	

    		<div class="input-group date">

                                    <input type="text" value="<?php echo date_format(date_create($data->sk_baru_tmt_pengangkatan),'d/m/Y'); ?>" name="sk_baru_tmt_pengangkatan" class="form-control datepicker"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>

                                </div>

    <div class="form-group">	

    			<label>Jabatan Lama</label>	

    			<input type="text" name="jabatan_lama" value="<?php echo $data->jabatan_lama; ?>" class="form-control filter">	

    </div>

    <div class="form-group">	

    			<label>Jabatan Baru</label>	

    			<input type="text" name="jabatan_baru" value="<?php echo $data->jabatan_baru; ?>" class="form-control filter">	

    </div>

    <div class="form-group">	

    			<label>Tunjangan Diterima (Rp.)</label>	

    			<input type="number" name="tunjangan_diterima" value="<?php echo $data->tunjangan_diterima; ?>" class="form-control filter">	

    </div>

    <div class="form-group">	

    			<label>Tanah Kas (hektar)</label>	

    			<input type="number" name="tanah_kas" value="<?php echo $data->tanah_kas; ?>" class="form-control filter">	

    </div>

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



    $.post("<?php echo base_url(); ?>index.php/welcome/get_desa_edit",{id:'<?php echo $data->id_kecamatan; ?>',id_desa:'<?php echo $data->id_desa; ?>'},function(data){

            $("select[name='id_desa']").html(data); 

    }); 



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