<?php  

header("Content-Type:   application/vnd.ms-excel; charset=utf-8");

header("Content-Disposition: attachment; filename=perangkat_desa.xls");  //File name extension was wrong

header("Expires: 0");

header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

header("Cache-Control: private",false);

?>
<?php  
$namaBulan = array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Cetak PDF Perangkat Desa</title>
<style type="text/css">
	thead:before, thead:after { display: none; }
	tbody:before, tbody:after { display: none; }
	table th{
		text-align: center;
	}
	table, td, th {
    border: 1px solid black;
}
table {
    border-collapse: collapse;
    width: 100%;
    font-size: 14px;
}
th {
    height: 15px;
}
td{
    font-size: 12px;
}
</style>
</head>
<body>


<img style="position:absolute;" src="http://www.andyresta.my.id/perangkatdesa/assets/images/logo-tegal.png" width="50" height="50">
<div align="center">
<p style="font-size: 15px;"><strong>PEMERINTAH KABUPATEN TEGAL</strong></p>    
<p style="font-size: 14px;"><strong>DATA KEPALA DESA DAN PERANGKAT DESA</strong></p>
<p style="font-size: 14px;"><strong>DESA : <?php echo strtoupper($this->db->get_where("data_desa",array("id"=>$id_desa))->row()->nama_desa); ?></strong>  <strong>KECAMATAN : <?php echo strtoupper($this->db->get_where("data_kecamatan",array("id"=>$id_kecamatan))->row()->nama_kecamatan); ?></strong></p>
</div>
<table border="1">
                            <thead>
                                <tr>
                                    <th rowspan="3" width="3%">No</th>

                                    <th rowspan="3" width="8%">NIK KTP</th>

                                    <th rowspan="3" width="8%">Nama</th>

                                    <th rowspan="3" width="3%">Jenis Kelamin</th>

                                    <th rowspan="3" width="10%">Tempat, Tanggal Lahir</th>

                                    <th rowspan="3" width="3%">Agama</th>

                                    <th rowspan="3" width="8%">Pendidikan Terakhir</th>

                                    <th colspan="3">SK Pengangkatan</th>

                                    <th colspan="5">Jabatan</th>

                                    <th rowspan="3" width="10%">Alamat</th>

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

                                if(isset($_GET['q'])){

                                    $this->db->where("");



                                }  

                                $data=$this->db->get_where("data_perangkat_desa",array("id_kecamatan"=>$id_kecamatan,"id_desa"=>$id_desa));

                                $data=$data->result();

                                $x=1;

                                foreach ($data as $key) {

                                    ?>

                                    <tr>

                                        <td><?php echo $x; ?></td>

                                        <td><?php echo $key->nik; ?></td>

                                        <td><?php echo $key->nama; ?></td>

                                        <td><?php echo $key->jenkel=="L"?"Pria":"Wanita"; ?></td>

                                        <td><?php echo $key->tmp_lhr; ?>, <?php echo date_format(date_create($key->tgl_lhr),'d M Y'); ?></td>

                                        <td><?php echo $key->agama; ?></td>

                                        <td><?php echo $key->pendidikan_terakhir; ?></td>

                                        <td><?php echo $key->sk_no_pengangkatan; ?></td>

                                        <td><?php echo date_format(date_create($key->sk_tgl_pengangkatan),'d M Y'); ?></td>

                                        <td><?php echo date_format(date_create($key->sk_tmt_pengangkatan),'d M Y'); ?></td>

                                        <td><?php echo $key->jabatan_lama; ?></td>

                                        <td><?php echo $key->jabatan_baru; ?></td>

                                        <td><?php echo $key->sk_baru_no_pengangkatan; ?></td>

                                        <td><?php echo date_format(date_create($key->sk_baru_tgl_pengangkatan),'d M Y'); ?></td>

                                        <td><?php echo date_format(date_create($key->sk_baru_tmt_pengangkatan),'d M Y'); ?></td>

                                        <td><?php echo $key->alamat; ?></td>

                                    </tr>

                                    <?php

                                    $x++;

                                }

                             ?>       

                            </tbody>

                        </table>
                        <br>
                        <table border='0'>
                            <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>    
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                                <td style="font-size: 15px;">
                                    <?php echo ucfirst(strtolower($this->db->get_where("data_desa",array("id"=>$id_desa))->row()->nama_desa)); ?>, 
                                <?php $r=explode("/",$tanggal); ?><?php echo $r[0]; ?> <?php echo $namaBulan[$r[1]-1]; ?> <?php echo $r[2]; ?><br>
                                Kepala Desa <?php echo ucfirst(strtolower($this->db->get_where("data_desa",array("id"=>$id_desa))->row()->nama_desa)); ?>
                                </td>
                            </tr>
                            <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>

                            <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                                        <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                                <td></td>
                                                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>

                            </tr>
                            <tr>
                                                        <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                                <td></td>
                                                        <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            </tr>
                            <tr>
                                                        <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                                <td style="font-size: 14px;">
                                    <?php echo strtoupper($this->db->get_where("data_desa",array("id"=>$id_desa))->row()->nama_kepala_desa); ?>
                                </td>
                            </tr>                                
                        </table>
                                          
</body>
</html>