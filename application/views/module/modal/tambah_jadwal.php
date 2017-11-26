<?php echo form_open("operation/save_jadwal"); ?>
<div class="form-group">
	<label>Hari</label>
	<input type="text" readonly class="form-control" name="hari" value="<?php echo $hari; ?>">
</div>
<div class="form-group">
	<label>Waktu</label>
	<select name="id_jadwal" class="form-control" required="">
		<option value="">--Pilih Jadwal--</option>
		<?php
		$jadwal=$this->db->get_where("sch_jadwal",array("hari"=>$hari,"id_instansi"=>$this->session->userdata("id_instansi")));
		$jadwal=$jadwal->result();
		foreach ($jadwal as $key) {
			?>
			<option value="<?php echo $key->id_jadwal; ?>"> <?php echo $key->waktu_mulai; ?> - <?php echo $key->waktu_selesai; ?> </option>
			<?php
		}
		?>
	</select>
</div>
<div class="form-group">
	<label>Ruang Kelas</label>
	<select name="id_kelas" class="form-control" required="">
		<option value="">--Pilih Ruang Kelas--</option>
		<?php
		$kelas=$this->db->get_where("sch_kelas",array("id_instansi"=>$this->session->userdata("id_instansi")));
		$kelas=$kelas->result();
		foreach ($kelas as $key) {
			?>
			<option value="<?php echo $key->id_kelas; ?>"> <?php echo $key->nama_kelas; ?></option>
			<?php
		}
		?>
	</select>
</div>
<div class="form-group">
	<label>Pelajaran</label>
	<select name="id_pelajaran" class="form-control" required="">
		<option value="">--Pilih Mapel--</option>
		<?php
		$mapel=$this->db->get_where("sch_pelajaran",array("id_instansi"=>$this->session->userdata("id_instansi")));
		$mapel=$mapel->result();
		foreach ($mapel as $key) {
			?>
			<option value="<?php echo $key->id_pelajaran; ?>"> <?php echo $key->nama_pelajaran; ?> (<?php echo $key->status; ?>)</option>
			<?php
		}
		?>
	</select>
</div>
<div class="form-group">
	<label>Guru / Pengampu</label>
	<select name="id_guru" class="form-control" required="">
		<option value="">--Pilih Guru--</option>
		<?php
		$guru=$this->db->get_where("data_guru",array("id_instansi"=>$this->session->userdata("id_instansi")));
		$guru=$guru->result();
		foreach ($guru as $key) {
			?>
			<option value="<?php echo $key->id_guru; ?>"> <?php echo $key->nama_guru; ?></option>
			<?php
		}
		?>
	</select>
</div>
<div class="form-group">
	<button class="btn btn-success btn-block" type="submit" value="1" name="simpan">Simpan</button>
</div>
<?php form_close(); ?>
<script type="text/javascript">
	$("select").select2();
</script>