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
<div class="col-md-12">
    <fieldset>
        <legend>Form Standar Kompetensi / Kompetensi Dasar</legend>
        <div class="row">
        <div class="form-group col-md-6">
            <label>Pilih Mata Pelajaran</label>
            <input type="hidden" value="<?php echo $this->session->userdata('id_instansi'); ?>" name="id_instansi">
            <select class="form-control" name="id_pelajaran" id="id_pelajaran" onchange="get_kd(event)">
                <option value="">-- Pilih Mata Pelajaran --</option>
                <?php
                    $this->db->select("*")
                            ->from("sch_pelajaran a")
                            ->join("sch_jenjang_pendidikan b","a.id_jenjang=b.id_jenjang","left")
                            ->where("a.id_instansi",$this->session->userdata("id_instansi"));
                    $mapel=$this->db->get();
                    $mapel=$mapel->result();
                    foreach ($mapel as $key) {
                       ?>
                       <option value="<?php echo $key->id_pelajaran; ?>"><?php echo $key->nama_pelajaran; ?> (<?php echo $key->status; ?>) Kelas <?php echo $key->jenjang; ?></option>
                       <?php
                    }
                ?>
            </select>
        </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <button type="button" class="btn btn-success btn-xs" onclick="tambah_kd()">Tambah</button>&nbsp<small><b>Daftar Standar Kompetensi Mata Pelajaran</b></small>
                <table class="table table-border" style="margin-top: 5px">
                  <thead>  
                    <tr>
                        <th>No</th>
                        <th>Mata Pelajaran</th>
                        <th>Jenis Mapel</th>
                        <th>Kelas</th>
                        <th>Standar Kompetensi</th>
                        <th>Bobot (%)</th>
                        <th>KKM</th>
                        <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody id="datakd">
                      
                  </tbody>  
                </table>
                <center class="load hide"><img src="<?php echo base_url(); ?>assets/images/loading.gif"></center>
            </div>
        </div>
    </fieldset>
</div>
<div class="modal fade" id="skmodal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="color-line"></div>
                <div class="modal-header text-center">
                    <h5 class="modal-title">Tambah Standar Kompetensi</h5>
                    <small class="font-bold">isikan standar kompetensi mata pelajaran di bawah ini</small>
                </div>
                <div class="modal-body">
                <?php echo form_open("",array("id"=>"tmbh_kd")); ?>
                <div class="form-group">
                    <label>Pelajaran</label>
                    <input type="hidden" id="m_id_pelajaran" name="id_pelajaran">
                    <input type="text" readonly="" id="ket_pelajaran" class="form-control">
                </div>
                <div class="form-group">
                    <label>Standar Kompetensi / Kompetensi Dasar</label>
                    <textarea class="form-control" name="nama_sk" placeholder="example : siswa mampu memahami kasus A"></textarea>
                </div>
                <div class="form-group">
                    <label>Bobot Dalam Persen (%)</label>
                    <input type="number" name="bobot" class="form-control">
                </div>
                <div class="form-group">
                    <label>Standar Nilai Kelulusan</label>
                    <input type="number" name="kkm" class="form-control">
                </div>
                <div class="form-group">
                    <button class="form-control btn btn-success" type="submit">Simpan</button>
                </div>
                <?php echo form_close(); ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
</div>
<div class="modal fade" id="skmodaledit" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="color-line"></div>
                <div class="modal-header text-center">
                    <h5 class="modal-title">Edit Standar Kompetensi</h5>
                    <small class="font-bold">Edit standar kompetensi mata pelajaran di bawah ini</small>
                </div>
                <div class="modal-body">
                <?php echo form_open("",array("id"=>"edit_kd")); ?>
                <div class="form-group">
                    <label>Pelajaran</label>
                    <input type="hidden" name="id_sk">
                    <select class="form-control" name="id_pelajaran" id="id_pelajaran2"></select>
                </div>
                <div class="form-group">
                    <label>Standar Kompetensi / Kompetensi Dasar</label>
                    <textarea class="form-control" name="nama_sk" placeholder="example : siswa mampu memahami kasus A"></textarea>
                </div>
                <div class="form-group">
                    <label>Bobot Dalam Persen (%)</label>
                    <input type="number" name="bobot" class="form-control">
                </div>
                <div class="form-group">
                    <label>Standar Nilai Kelulusan</label>
                    <input type="number" name="kkm" class="form-control">
                </div>
                <div class="form-group">
                    <button class="form-control btn btn-success" type="submit">Simpan</button>
                </div>
                <?php echo form_close(); ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
</div>
<div class="modal fade" id="skmodalhapus" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="color-line"></div>
                <div class="modal-header text-center">
                    <h5 class="modal-title">Hapus Standar Kompetensi</h5>
                    <small class="font-bold">Hapus standar kompetensi mata pelajaran di bawah</small>
                </div>
                <div class="modal-body">
                <?php echo form_open("",array("id"=>"hapus_kd")); ?>
                <div class="form-group">
                    <input type="hidden" name="id_sk">
                    <label>Yakin ingin menghapus ?</label>
                    <button class="form-control btn btn-danger" type="submit">Hapus</button>
                </div>
                <?php echo form_close(); ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
</div>
<script type="text/javascript">
$(document).ready(function(){$("select[name='id_pelajaran']").select2();});
function tambah_kd(){
    if($("#id_pelajaran").val()!=""){$("#skmodal").modal("show");}
    else{alert("Pilih Mata Pelajaran terlebih dahulu");}
}
function hps_kd(e){
    $("#skmodalhapus .modal-body input").val($(e.target).attr('data-id'));
    $("#skmodalhapus").modal("show");
}
function edit_kd(e){
    $("#id_pelajaran2").html($("#id_pelajaran").html());
    $("#id_pelajaran2 option[value='"+$(e.target).attr("data-idpelajaran")+"']").attr("selected","selected");
    $("select[name='id_pelajaran']").select2();
    $("#skmodaledit .modal-body input[name='id_sk']").val($(e.target).attr('data-id'));
    $("#skmodaledit .modal-body textarea").val($("#datakd #row"+$(e.target).attr('data-id')+" td[idx='e']").html());
    $("#skmodaledit .modal-body input[name='bobot']").val($("#datakd #row"+$(e.target).attr('data-id')+" td[idx='f']").html());
    $("#skmodaledit .modal-body input[name='kkm']").val($("#datakd #row"+$(e.target).attr('data-id')+" td[idx='g']").html());
    $("#skmodaledit").modal("show");

}
function get_kd(e){
    var val="";var ket_pel="";var ket_id="";
        if(e.target==undefined){
            val=e.val();ket_pel=$("#id_pelajaran option[value='"+e.val()+"']").html();ket_id=e.val();
        }else{
            val=$(e.target).val();ket_pel=e.added.text;ket_id=e.added.id;
        }
        $("#ket_pelajaran").val(ket_pel);$("#m_id_pelajaran").val(ket_id);
        $(".load").removeClass("hide");
        $.post('<?php echo base_url(); ?>ajax/get_kd',{id_mapel:val},function(data,status){
            if(status=="success"){
                data=JSON.parse(data);var size=data.length;var temp="";
                for(var x=0;x<size;x++){
                    temp+="<tr id='row"+data[x].id_sk+"'>";
                    temp+="<td idx='a'>";temp+=(x+1);temp+="</td>";
                    temp+="<td idx='b'>";temp+=data[x].nama_pelajaran;temp+="</td>";
                    temp+="<td idx='c'>";temp+=data[x].status;temp+="</td>";
                    temp+="<td idx='d'>Kelas ";temp+=data[x].jenjang;temp+="</td>";
                    temp+="<td idx='e'>";temp+=data[x].nama_sk;temp+="</td>";
                    temp+="<td idx='f'>";temp+=data[x].bobot;temp+="</td>";
                    temp+="<td idx='g'>";temp+=data[x].kkm;temp+="</td>";
                    temp+="<td>";temp+="<button class='btn btn-warning btn-xs' onclick='edit_kd(event)' data-id='"+data[x].id_sk+"' data-idpelajaran='"+data[x].id_pelajaran+"'>Edit</button>&nbsp<button class='btn btn-danger btn-xs' onclick='hps_kd(event)' data-id='"+data[x].id_sk+"'>Hapus</button>";temp+="</td>";    
                    temp+="</tr>";
                }
                $(".load").addClass("hide");$("#datakd").html(temp);
            }else{
                $(".load").addClass("hide");
            }
        });
}
$("#tmbh_kd" ).on( "submit", function( event ) {
  event.preventDefault();
  $.post('<?php echo base_url(); ?>ajax/savekd',{data:JSON.stringify($(this).serializeArray())},function(data,status){
    data=JSON.parse(data);
    if(data.status==1){alert("Standar Kompetensi Berhasil di Tambahkan");$("#skmodal").modal("hide");}
    get_kd($("#id_pelajaran"));
  });
});
$("#hapus_kd" ).on( "submit", function( event ) {
  event.preventDefault();
  $.post('<?php echo base_url(); ?>ajax/delkd',{data:JSON.stringify($(this).serializeArray())},function(data,status){
    data=JSON.parse(data);
    if(data.status==1){alert("Standar Kompetensi Berhasil di Hapus");$("#skmodalhapus").modal("hide");}
    get_kd($("#id_pelajaran"));
  });
});
$("#edit_kd" ).on( "submit", function( event ) {
  event.preventDefault();
  $.post('<?php echo base_url(); ?>ajax/editkd',{data:JSON.stringify($(this).serializeArray())},function(data,status){
    data=JSON.parse(data);
    if(data.status==1){alert("Standar Kompetensi Berhasil di Perbarui");$("#skmodaledit").modal("hide");}
    get_kd($("#id_pelajaran"));
  });
});
</script>
</div></div></div>