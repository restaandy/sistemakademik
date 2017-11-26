<div class="row">
  <div class="col-md-12">
  	<div class="row">
  	<div class="col-lg-4 animated-panel zoomIn">
        <div class="hpanel hgreen">
            <div class="panel-heading hbuilt">
                SENIN <button class="btn btn-success btn-xs pull-right" onclick="tambah_jadwal('SENIN')">Tambah Jadwal</button>
            </div>
            <div class="panel-body no-padding jdw" id="jsenin" data-hari="SENIN" style="max-height: 178px;overflow-y: auto">
               <center class="load"><img src="<?php echo base_url(); ?>assets/images/loading.gif" width="80" height="80"></center>
               <ul class="list-group">
               		
               </ul>
            </div>
            <div class="panel-footer">
                Daftar semua jadwal hari senin
            </div>
        </div>
        <div class="hpanel hgreen">
            <div class="panel-heading hbuilt">
                SELASA <button class="btn btn-success btn-xs pull-right" onclick="tambah_jadwal('SELASA')">Tambah Jadwal</button>
            </div>
            <div class="panel-body no-padding jdw" id="jselasa" data-hari="SELASA" style="max-height: 178px;overflow-y: auto">
               <center class="load"><img src="<?php echo base_url(); ?>assets/images/loading.gif" width="80" height="80"></center>
               <ul class="list-group">
               	
               </ul>
            </div>
            <div class="panel-footer">
                Daftar semua jadwal hari selasa 
            </div>
        </div>
        <div class="hpanel hgreen">
            <div class="panel-heading hbuilt">
                RABU <button class="btn btn-success btn-xs pull-right" onclick="tambah_jadwal('RABU')">Tambah Jadwal</button>
            </div>
            <div class="panel-body no-padding jdw" id="jrabu" data-hari="RABU" style="max-height: 178px;overflow-y: auto">
               <center class="load"><img src="<?php echo base_url(); ?>assets/images/loading.gif" width="80" height="80"></center>
               <ul class="list-group">
               	
               </ul>
            </div>
            <div class="panel-footer">
                Daftar semua jadwal hari rabu
            </div>
        </div>
    </div>
    <div class="col-lg-4 animated-panel zoomIn">
        <div class="hpanel hgreen">
            <div class="panel-heading hbuilt">
                KAMIS <button class="btn btn-success btn-xs pull-right" onclick="tambah_jadwal('KAMIS')">Tambah Jadwal</button>
            </div>
            <div class="panel-body no-padding jdw" id="jkamis" data-hari="KAMIS" style="max-height: 178px;overflow-y: auto">
               <center class="load"><img src="<?php echo base_url(); ?>assets/images/loading.gif" width="80" height="80"></center>
               <ul class="list-group">
               	
               </ul>
            </div>
            <div class="panel-footer">
                Daftar semua jadwal hari kamis
            </div>
        </div>
        <div class="hpanel hgreen">
            <div class="panel-heading hbuilt">
                JUMAT <button class="btn btn-success btn-xs pull-right" onclick="tambah_jadwal('JUMAT')">Tambah Jadwal</button>
            </div>
            <div class="panel-body no-padding jdw" id="jjumat" data-hari="JUMAT" style="max-height: 178px;overflow-y: auto">
            <center class="load"><img src="<?php echo base_url(); ?>assets/images/loading.gif" width="80" height="80"></center>
               <ul class="list-group">
               	
               </ul>
            </div>
            <div class="panel-footer">
                Daftar semua jadwal hari jumat
            </div>
        </div>
         <div class="hpanel hgreen">
            <div class="panel-heading hbuilt">
                SABTU <button class="btn btn-success btn-xs pull-right" onclick="tambah_jadwal('SABTU')">Tambah Jadwal</button>
            </div>
            <div class="panel-body no-padding jdw" id="jsabtu" data-hari="SABTU" style="max-height: 178px;overflow-y: auto">
            <center class="load"><img src="<?php echo base_url(); ?>assets/images/loading.gif" width="80" height="80"></center>
               <ul class="list-group">
               	
               </ul>
            </div>
            <div class="panel-footer">
                Daftar semua jadwal hari sabtu
            </div>
        </div>
    </div>   
    <div class="col-lg-4 animated-panel zoomIn">
        <div class="hpanel hgreen">
            <div class="panel-heading hbuilt">
                MINGGU <button class="btn btn-success btn-xs pull-right" onclick="tambah_jadwal('MINGGU')">Tambah Jadwal</button>
            </div>
            <div class="panel-body no-padding jdw" id="jminggu" data-hari="MINGGU" style="max-height: 178px;overflow-y: auto">
            <center class="load"><img src="<?php echo base_url(); ?>assets/images/loading.gif" width="80" height="80"></center>
               <ul class="list-group">

               </ul>
            </div>
            <div class="panel-footer">
                Daftar semua jadwal hari minggu
            </div>
        </div>
    </div> 
    
  </div>
  </div>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/select2-3.5.2/select2.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/select2-bootstrap/select2-bootstrap.css" />
<script src="<?php echo base_url(); ?>assets/vendor/select2-3.5.2/select2.min.js"></script>
  <script type="text/javascript">
  	function getjadwal(id,hari){
  		$.post("<?php echo base_url(); ?>ajax/getJadwalPelajaranbyHari",{hari:hari},function(data,status){
  			if(status=="success"){
  				data=JSON.parse(data);var size=data.length;var temp="";
                for(var x=0;x<size;x++){
                    temp+="<li class='list-group-item hgreen'>";
                    temp+="<b>Hari : "+data[x].hari+", "+data[x].waktu_mulai+" - "+data[x].waktu_selesai+" WIB";
                    temp+="<br>Ruang : "+data[x].nama_kelas+" ";
                    temp+="<br>Mapel : "+data[x].nama_pelajaran+" ("+data[x].status+")";
                    temp+="</b><br><div>";
                    temp+="<button class='btn btn-danger btn-xs' onclick='hapus_jadwal(event)' data-id='"+data[x].id_pertemuan+"'>Hapus</button><button class='btn btn-warning btn-xs' onclick='edit_jadwal(event)' data-id='"+data[x].id_pertemuan+"'>Edit</button><button class='btn btn-info btn-xs'>Lihat</button></div></li>";
                }
                $("#"+id+" center").addClass("hide");
                $("#"+id+" ul").html(temp);
  			}else{
  				
  			}
  		});
  	}
  	function tambah_jadwal(hari){
  		$('#siamodal').attr("class","modal fade hmodal-info");
        $('#siamodal .modal-title').text("Tambah Jadwal");
        $('#siamodal .modal-body').html('<center class="load"><img src="<?php echo base_url(); ?>assets/images/loading.gif" width="100" height="100"></center>');
        $('#siamodal').modal('show');
        $.post('<?php echo base_url(); ?>ajax/popup/tambah_jadwal',{hari:hari},function(data){
            $('#siamodal .modal-body').html(data);
        });
  	}
  	function edit_jadwal(e){
  		$('#siamodal').attr("class","modal fade hmodal-warning");
        $('#siamodal .modal-title').text("Edit Jadwal");
        $('#siamodal .modal-body').html('<center class="load"><img src="<?php echo base_url(); ?>assets/images/loading.gif" width="100" height="100"></center>');
		$('#siamodal').modal('show');
        $.post('<?php echo base_url(); ?>ajax/popup/edit_jadwal',{id_pertemuan:$(e.target).attr("data-id")},function(data){
            $('#siamodal .modal-body').html(data);
        });
  	}
  	function hapus_jadwal(e){
  		$('#siamodal').attr("class","modal fade hmodal-danger");
        $('#siamodal .modal-title').text("Hapus Jadwal");
        $('#siamodal .modal-body').html('<center class="load"><img src="<?php echo base_url(); ?>assets/images/loading.gif" width="100" height="100"></center>');
		$('#siamodal').modal('show');
        $.post('<?php echo base_url(); ?>ajax/popup/hapus_jadwal',{id_pertemuan:$(e.target).attr("data-id")},function(data){
            $('#siamodal .modal-body').html(data);
        });
  	}
  	getjadwal("jsenin","SENIN");
  	getjadwal("jselasa","SELASA");
  	getjadwal("jrabu","RABU");
  	getjadwal("jkamis","KAMIS");
  	getjadwal("jjumat","JUMAT");
  	getjadwal("jsabtu","SABTU");
  	getjadwal("jminggu","MINGGU");
  </script>
</div>