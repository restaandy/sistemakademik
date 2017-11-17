<style type="text/css">

.table th{

	text-align: center;

}



</style>

<div class="row">

		<div class="hpanel">



                    <div class="panel-body">



                        <p>

                            <strong>Daftar Semua Perangkat Desa Kabupaten Tegal <?php 
                                if($this->input->post('id_kecamatan')!=NULL&&$this->input->post('id_desa')!=NULL){
                                    echo "Kecamatan ".$this->db->get_where("data_kecamatan",array("id"=>$this->input->post('id_kecamatan')))->row()->nama_kecamatan." / Desa ";
                                    echo $this->db->get_where("data_desa",array("id"=>$this->input->post('id_desa')))->row()->nama_desa; 
                                }else{

                                }   
                            ?></strong>

                        </p>

                        <div class="row" style="padding-right: 10px;">

                        <form class="form-inline pull-right" method="POST" action="">

                            <div class="form-group">

                                <select class="form-control" name="id_kecamatan" required="" onchange="get_loc(event)">

                                <option value="">-- Pilih Kecamatan --</option>

                                <?php   

                                    $data=$this->db->get("data_kecamatan");

                                    $data=$data->result();

                                    foreach ($data as $key) {

                                        ?>

                                        <option value="<?php echo $key->id; ?>" ><?php  echo $key->nama_kecamatan; ?></option>

                                        <?php

                                    }

                                 ?>

                            </select>
                                <select class="form-control" required="" name="id_desa">

                            <option value="">-- Pilih Desa --</option>

                        </select>

                            </div>

                            <div class="form-group">

                                <button class="pull-right btn btn-primary">Filter</button>

                            </div>                            

                        </form>

                        </div>

                        <br>

                        <div class="table-responsive">

                        

                        <table class="table table-hover table-bordered table-striped box">

                            <thead>

                                <tr>

                                    <th rowspan="3" width="3%">No</th>

                                    <th rowspan="3" width="10%">NIK / Nama</th>

                                    <th colspan="3" width="27%">SK Pengangkatan</th>

                                    <th colspan="5" width="27%">Jabatan</th>

                                    <th rowspan="3" width="10%">Alamat</th>

                                    <th rowspan="3" width="5%">Aksi</th>

                                </tr>

                                <tr>

                                    <th rowspan="2">Nomor</th>

                                    <th rowspan="2">Tgl</th>

                                    <th rowspan="2">Tmt</th>

                                    <th rowspan="2">Lama</th>

                                    <th rowspan="2">Baru</th>

                                    <th colspan="3">SK Pengangkatan Jabatan Baru</th>

                                </tr>

                                <tr>

                                    <th>Nomor</th>

                                    <th>Tgl</th>

                                    <th>Tmt</th>

                                </tr>

                                

                            </thead>

                            <tbody>

                             <?php

                                if($this->input->post('id_kecamatan')!=NULL&&$this->input->post('id_desa')!=NULL){
                                    $this->db->where("id_kecamatan",$this->input->post('id_kecamatan'));
                                    $this->db->where("id_desa",$this->input->post('id_desa'));    
                                    $data=$this->db->get("data_perangkat_desa");
                                }else{
                                    $data=$this->db->get("data_perangkat_desa",0,50);

                                }  


                                $data=$data->result();

                                $x=1;

                                foreach ($data as $key) {

                                    ?>

                                    <tr>

                                        <td><?php echo $x; ?></td>

                                        <td class="issue-info"><?php echo $key->nama; ?><br> <small>NIK : <?php echo $key->nik; ?></small> </td>

                                        <!--<td><?php //echo $key->jenkel; ?></td>

                                        <td><?php //echo $key->tmp_lahir; ?>, <?php //echo date_format(date_create($key->tgl_lhr),'d M Y'); ?></td>

                                        <td><?php //echo $key->agama; ?></td>

                                        <td><?php //echo $key->pendidikan_terakhir; ?></td>-->

                                        <td class="issue-info"><?php echo $key->sk_no_pengangkatan; ?></td>

                                        <td class="issue-info"><?php echo date_format(date_create($key->sk_tgl_pengangkatan),'d M Y'); ?></td>

                                        <td class="issue-info"><?php echo date_format(date_create($key->sk_tmt_pengangkatan),'d M Y'); ?></td>

                                        <td class="issue-info"><?php echo $key->jabatan_lama; ?></td>

                                        <td class="issue-info"><?php echo $key->jabatan_baru; ?></td>

                                        <td class="issue-info"><?php echo $key->sk_baru_no_pengangkatan; ?></td>

                                        <td class="issue-info"><?php echo date_format(date_create($key->sk_baru_tgl_pengangkatan),'d M Y'); ?></td>

                                        <td class="issue-info"><?php echo date_format(date_create($key->sk_baru_tmt_pengangkatan),'d M Y'); ?></td>

                                        <!--<td><?php //echo $key->alamat; ?></td>-->

                                        <td class="issue-info"><?php echo $key->alamat; ?></td>

                                        <td>

                                        	<button type="button" data-id="<?php echo $key->id; ?>" onclick="detail(event)" class="btn btn-info btn-xs">View </button><br>

                                        	<button type="button" onclick="edit(event)" data-id="<?php echo $key->id; ?>" class="btn btn-warning btn-xs">Edit </button><br>

                                        	<button type="button" onclick="hps(event)" data-id="<?php echo $key->id; ?>" class="btn btn-danger btn-xs">Hapus</button>

                                        </td>

                                    </tr>

                                    <?php

                                    $x++;

                                }

                             ?>       

                            </tbody>

                        </table>

                        </div>

                    </div>



                </div>

</div>

<div class="modal fade hmodal-danger" id="hps" tabindex="-1" role="dialog" aria-hidden="true">

                    <div class="modal-dialog">

                        <div class="modal-content">

                            <div class="color-line"></div>

                            <div class="modal-header">

                                <h4 class="modal-title">Yakin Hapus Data ?</h4>

                                <small class="font-bold">Data yang terhapus akan hilang permanen</small>

                            </div>

                            <div class="modal-body" align="center">

                            	<form method="POST" action="<?php echo base_url(); ?>index.php/welcome/hapusdata">

                            		<input type="hidden" id="val" name="id" value="" required="">

                                	<button class="btn btn-danger btn-block">Hapus</button>

                            	</form>

                            </div>

                            <div class="modal-footer">

                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                            </div>

                        </div>

                    </div>

                </div>

<script type="text/javascript">

	function hps(e){

		$("#hps .modal-dialog .modal-content .modal-body #val").val($(e.target).attr('data-id'));

		$("#hps").modal("show");

	}

	function detail(e){

		window.open('<?php echo base_url(); ?>index.php/welcome/detail_perangkat_desa/'+$(e.target).attr('data-id'),'_blank');

	}

	function edit(e){

		window.open('<?php echo base_url(); ?>index.php/welcome/edit_perangkat_desa/'+$(e.target).attr('data-id'),'_blank');

	}
    function get_loc(e){

        $("select[name='id_desa']").html();

        $.post("<?php   echo base_url(); ?>index.php/welcome/get_desa",{id:$(e.target).val()},function(data){

            $("select[name='id_desa']").html(data); 

        }); 

    }

</script>