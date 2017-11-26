<center>
<?php echo form_open("operation/hapus_jadwal"); ?>
<div class="form-group">
	<label>Yakin Hapus ?</label>
	<input type="hidden" name="id_pertemuan" value="<?php echo $id_pertemuan; ?>">
	<button class="btn btn-danger btn-block" type="submit" value="1" name="simpan">Hapus</button>
</div>
<?php form_close(); ?>
</center>