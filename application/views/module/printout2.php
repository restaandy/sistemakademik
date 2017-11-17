<?php
require('assets/fpdf/mc_table.php');
$pdf=new PDF_MC_Table();
$pdf->AddPage('L','Legal');
$pdf->SetFont('Times','',12);
$pdf->Image('assets/images/logo-tegal.png',1,1,15,20);
$pdf->Cell(340,8,'PEMERINTAH KABUPATEN TEGAL',0,1,'C');
$pdf->Cell(335,8,'DATA KEPALA DESA DAN PERANGKAT DESA',0,1,'C');
$pdf->Cell(345,8,'DESA : '.strtoupper($this->db->get_where("data_desa",array("id"=>$id_desa))->row()->nama_desa).' KECAMATAN : '.strtoupper($this->db->get_where("data_kecamatan",array("id"=>$id_kecamatan))->row()->nama_kecamatan),0,1,'C');
$pdf->Ln();
$pdf->Cell(8,5,' ','LTR',0,'L',0);
$pdf->Cell(20,5,' ','LTR',0,'L',0);
$pdf->Cell(30,5,' ','LTR',0,'L',0);
$pdf->Cell(10,5,' ','LTR',0,'L',0);
$pdf->Cell(20,5,' ','LTR',0,'L',0);
$pdf->Cell(15,5,' ','LTR',0,'L',0);
$pdf->Cell(35,5,' ','LTR',0,'L',0);   // empty cell with left,top, and right borders
$pdf->Cell(80,5,'SK Pengangkatan',1,0,'C',0);
$pdf->Cell(90,5,'Jabatan',1,0,'C',0);
$pdf->Cell(30,5,'','LTR',0,'C',0);

                $pdf->Ln();

$pdf->Cell(8,5,'No','LR',0,'C',0);
$pdf->Cell(20,5,'NIK KTP','LR',0,'C',0);
$pdf->Cell(30,5,'Nama','LR',0,'C',0);
$pdf->Cell(10,5,'JK','LR',0,'C',0);
$pdf->Cell(20,5,'TTL','LR',0,'C',0);
$pdf->Cell(15,5,'Agama','LR',0,'C',0);
$pdf->Cell(35,5,'Pendidikan Terakhir','LR',0,'C',0);  // cell with left and right borders
$pdf->Cell(27,5,'','LR',0,'L',0);
$pdf->Cell(26,5,'','LR',0,'L',0);
$pdf->Cell(27,5,'','LR',0,'L',0);
$pdf->Cell(15,5,'','LR',0,'L',0);
$pdf->Cell(15,5,'','LR',0,'L',0);
$pdf->Cell(20,5,'','LR',0,'L',0);
$pdf->Cell(20,5,'','LR',0,'L',0);
$pdf->Cell(20,5,'','LR',0,'L',0);
$pdf->Cell(30,5,'Alamat','LR',0,'C',0);
                $pdf->Ln();
$pdf->Cell(8,5,'','LBR',0,'L',0);
$pdf->Cell(20,5,'','LBR',0,'L',0);
$pdf->Cell(30,5,'','LBR',0,'L',0);
$pdf->Cell(10,5,'','LBR',0,'L',0);
$pdf->Cell(20,5,'','LBR',0,'L',0);
$pdf->Cell(15,5,'','LBR',0,'L',0);
$pdf->Cell(35,5,'','LBR',0,'L',0);   // empty cell with left,bottom, and right borders
$pdf->Cell(27,5,'No','LRB',0,'C',0);
$pdf->Cell(26,5,'Tgl','LRB',0,'C',0);
$pdf->Cell(27,5,'Tmt','LBR',0,'C',0);
$pdf->Cell(15,5,'Lama','LBR',0,'C',0);
$pdf->Cell(15,5,'Baru','LBR',0,'C',0);
$pdf->Cell(20,5,'No','LBR',0,'C',0);
$pdf->Cell(20,5,'Tgl','LBR',0,'C',0);
$pdf->Cell(20,5,'Tmt','LBR',0,'C',0);

$pdf->Cell(30,5,'','LBR',0,'L',0);
$pdf->Ln();
//Table with 20 rows and 4 columns
$namaBulan = array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
$pdf->SetWidths(array(8,20,30,10,20,15,35,27,26,27,15,15,20,20,20,30));

$data=$this->db->get_where("data_perangkat_desa",array("id_kecamatan"=>$id_kecamatan,"id_desa"=>$id_desa));

$data=$data->result();
$x=1;
foreach ($data as $key) {
    $pdf->Row(array($x,$key->nik,$key->nama,$key->jenkel=="L"?"Pria":"Wanita",$key->tmp_lhr.", ".date_format(date_create($key->tgl_lhr),'d M Y'),$key->agama,$key->pendidikan_terakhir,$key->sk_no_pengangkatan,date_format(date_create($key->sk_tgl_pengangkatan),'d M Y'),date_format(date_create($key->sk_tmt_pengangkatan),'d M Y'),$key->jabatan_lama,$key->jabatan_baru,$key->sk_baru_no_pengangkatan,date_format(date_create($key->sk_baru_tgl_pengangkatan),'d M Y'),date_format(date_create($key->sk_baru_tmt_pengangkatan),'d M Y'),$key->alamat));
$x++;
}
$r=explode("/",$tanggal);
$pdf->Ln();
$pdf->Cell(620,5,ucfirst(strtolower($this->db->get_where("data_desa",array("id"=>$id_desa))->row()->nama_desa)).", ".$r[0]." ".$namaBulan[$r[1]-1]." ".$r[2],0,1,'C');
$pdf->Cell(620,8,'Kepala Desa '.ucfirst(strtolower($this->db->get_where("data_desa",array("id"=>$id_desa))->row()->nama_desa)),0,1,'C');
$pdf->Ln();$pdf->Ln();
$kpl=$this->db->get_where("data_desa",array("id"=>$id_desa))->row();
$pdf->Cell(620,8,strtoupper(isset($kpl)?$kpl->nama_kepala_desa:""),0,1,'C');
$pdf->Output();
?>