<center>
<?php echo form_open("instansi/tahunajaran"); ?>
<div class="form-group">
	<input type="hidden" name="id_ta" value="<?php echo $id_ta; ?>">
	<button class="btn btn-success btn-block" type="submit" value="1" name="simpan">Aktifkan</button>
</div>
<?php form_close(); ?>
</center>