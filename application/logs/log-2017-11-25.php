<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2017-11-25 12:58:21 --> Query error: Unknown column 'b.id_kelas' in 'on clause' - Invalid query: SELECT 
                a.`id_pertemuan`,
                b.`nama_kelas`,
                c.`nama_pelajaran`,
                d.`hari`,
                TIME_FORMAT(d.`waktu_mulai`,'%H : %i') AS waktu_mulai,
                TIME_FORMAT(d.`waktu_selesai`,'%H : %i') AS waktu_selesai,
                e.`nama_guru`
             FROM rel_pertemuan a 
             LEFT JOIN sch_kelas b ON a.`id_kelas`=`b.id_kelas` 
             LEFT JOIN sch_pelajaran c ON a.`id_pelajaran`=c.`id_pelajaran` 
             LEFT JOIN sch_jadwal d ON a.`id_jadwal`=d.`id_jadwal` 
             LEFT JOIN data_guru e ON a.`id_guru`=e.`id_guru`
             WHERE a.`id_instansi`='1' AND d.`hari`='SENIN';
ERROR - 2017-11-25 12:58:21 --> Query error: Unknown column 'b.id_kelas' in 'on clause' - Invalid query: SELECT 
                a.`id_pertemuan`,
                b.`nama_kelas`,
                c.`nama_pelajaran`,
                d.`hari`,
                TIME_FORMAT(d.`waktu_mulai`,'%H : %i') AS waktu_mulai,
                TIME_FORMAT(d.`waktu_selesai`,'%H : %i') AS waktu_selesai,
                e.`nama_guru`
             FROM rel_pertemuan a 
             LEFT JOIN sch_kelas b ON a.`id_kelas`=`b.id_kelas` 
             LEFT JOIN sch_pelajaran c ON a.`id_pelajaran`=c.`id_pelajaran` 
             LEFT JOIN sch_jadwal d ON a.`id_jadwal`=d.`id_jadwal` 
             LEFT JOIN data_guru e ON a.`id_guru`=e.`id_guru`
             WHERE a.`id_instansi`='1' AND d.`hari`='SELASA';
ERROR - 2017-11-25 12:58:21 --> Query error: Unknown column 'b.id_kelas' in 'on clause' - Invalid query: SELECT 
                a.`id_pertemuan`,
                b.`nama_kelas`,
                c.`nama_pelajaran`,
                d.`hari`,
                TIME_FORMAT(d.`waktu_mulai`,'%H : %i') AS waktu_mulai,
                TIME_FORMAT(d.`waktu_selesai`,'%H : %i') AS waktu_selesai,
                e.`nama_guru`
             FROM rel_pertemuan a 
             LEFT JOIN sch_kelas b ON a.`id_kelas`=`b.id_kelas` 
             LEFT JOIN sch_pelajaran c ON a.`id_pelajaran`=c.`id_pelajaran` 
             LEFT JOIN sch_jadwal d ON a.`id_jadwal`=d.`id_jadwal` 
             LEFT JOIN data_guru e ON a.`id_guru`=e.`id_guru`
             WHERE a.`id_instansi`='1' AND d.`hari`='RABU';
ERROR - 2017-11-25 12:58:21 --> Query error: Unknown column 'b.id_kelas' in 'on clause' - Invalid query: SELECT 
                a.`id_pertemuan`,
                b.`nama_kelas`,
                c.`nama_pelajaran`,
                d.`hari`,
                TIME_FORMAT(d.`waktu_mulai`,'%H : %i') AS waktu_mulai,
                TIME_FORMAT(d.`waktu_selesai`,'%H : %i') AS waktu_selesai,
                e.`nama_guru`
             FROM rel_pertemuan a 
             LEFT JOIN sch_kelas b ON a.`id_kelas`=`b.id_kelas` 
             LEFT JOIN sch_pelajaran c ON a.`id_pelajaran`=c.`id_pelajaran` 
             LEFT JOIN sch_jadwal d ON a.`id_jadwal`=d.`id_jadwal` 
             LEFT JOIN data_guru e ON a.`id_guru`=e.`id_guru`
             WHERE a.`id_instansi`='1' AND d.`hari`='KAMIS';
ERROR - 2017-11-25 12:58:21 --> Query error: Unknown column 'b.id_kelas' in 'on clause' - Invalid query: SELECT 
                a.`id_pertemuan`,
                b.`nama_kelas`,
                c.`nama_pelajaran`,
                d.`hari`,
                TIME_FORMAT(d.`waktu_mulai`,'%H : %i') AS waktu_mulai,
                TIME_FORMAT(d.`waktu_selesai`,'%H : %i') AS waktu_selesai,
                e.`nama_guru`
             FROM rel_pertemuan a 
             LEFT JOIN sch_kelas b ON a.`id_kelas`=`b.id_kelas` 
             LEFT JOIN sch_pelajaran c ON a.`id_pelajaran`=c.`id_pelajaran` 
             LEFT JOIN sch_jadwal d ON a.`id_jadwal`=d.`id_jadwal` 
             LEFT JOIN data_guru e ON a.`id_guru`=e.`id_guru`
             WHERE a.`id_instansi`='1' AND d.`hari`='JUMAT';
ERROR - 2017-11-25 12:58:21 --> Query error: Unknown column 'b.id_kelas' in 'on clause' - Invalid query: SELECT 
                a.`id_pertemuan`,
                b.`nama_kelas`,
                c.`nama_pelajaran`,
                d.`hari`,
                TIME_FORMAT(d.`waktu_mulai`,'%H : %i') AS waktu_mulai,
                TIME_FORMAT(d.`waktu_selesai`,'%H : %i') AS waktu_selesai,
                e.`nama_guru`
             FROM rel_pertemuan a 
             LEFT JOIN sch_kelas b ON a.`id_kelas`=`b.id_kelas` 
             LEFT JOIN sch_pelajaran c ON a.`id_pelajaran`=c.`id_pelajaran` 
             LEFT JOIN sch_jadwal d ON a.`id_jadwal`=d.`id_jadwal` 
             LEFT JOIN data_guru e ON a.`id_guru`=e.`id_guru`
             WHERE a.`id_instansi`='1' AND d.`hari`='SABTU';
ERROR - 2017-11-25 12:58:21 --> Query error: Unknown column 'b.id_kelas' in 'on clause' - Invalid query: SELECT 
                a.`id_pertemuan`,
                b.`nama_kelas`,
                c.`nama_pelajaran`,
                d.`hari`,
                TIME_FORMAT(d.`waktu_mulai`,'%H : %i') AS waktu_mulai,
                TIME_FORMAT(d.`waktu_selesai`,'%H : %i') AS waktu_selesai,
                e.`nama_guru`
             FROM rel_pertemuan a 
             LEFT JOIN sch_kelas b ON a.`id_kelas`=`b.id_kelas` 
             LEFT JOIN sch_pelajaran c ON a.`id_pelajaran`=c.`id_pelajaran` 
             LEFT JOIN sch_jadwal d ON a.`id_jadwal`=d.`id_jadwal` 
             LEFT JOIN data_guru e ON a.`id_guru`=e.`id_guru`
             WHERE a.`id_instansi`='1' AND d.`hari`='MINGGU';
ERROR - 2017-11-25 12:58:30 --> 404 Page Not Found: Assets/vendor
ERROR - 2017-11-25 12:58:30 --> 404 Page Not Found: Assets/vendor
ERROR - 2017-11-25 12:58:38 --> 404 Page Not Found: Assets/vendor
ERROR - 2017-11-25 12:58:38 --> Query error: Unknown column 'b.id_kelas' in 'on clause' - Invalid query: SELECT 
                a.`id_pertemuan`,
                b.`nama_kelas`,
                c.`nama_pelajaran`,
                d.`hari`,
                TIME_FORMAT(d.`waktu_mulai`,'%H : %i') AS waktu_mulai,
                TIME_FORMAT(d.`waktu_selesai`,'%H : %i') AS waktu_selesai,
                e.`nama_guru`
             FROM rel_pertemuan a 
             LEFT JOIN sch_kelas b ON a.`id_kelas`=`b.id_kelas` 
             LEFT JOIN sch_pelajaran c ON a.`id_pelajaran`=c.`id_pelajaran` 
             LEFT JOIN sch_jadwal d ON a.`id_jadwal`=d.`id_jadwal` 
             LEFT JOIN data_guru e ON a.`id_guru`=e.`id_guru`
             WHERE a.`id_instansi`='1' AND d.`hari`='KAMIS';
ERROR - 2017-11-25 12:58:38 --> Query error: Unknown column 'b.id_kelas' in 'on clause' - Invalid query: SELECT 
                a.`id_pertemuan`,
                b.`nama_kelas`,
                c.`nama_pelajaran`,
                d.`hari`,
                TIME_FORMAT(d.`waktu_mulai`,'%H : %i') AS waktu_mulai,
                TIME_FORMAT(d.`waktu_selesai`,'%H : %i') AS waktu_selesai,
                e.`nama_guru`
             FROM rel_pertemuan a 
             LEFT JOIN sch_kelas b ON a.`id_kelas`=`b.id_kelas` 
             LEFT JOIN sch_pelajaran c ON a.`id_pelajaran`=c.`id_pelajaran` 
             LEFT JOIN sch_jadwal d ON a.`id_jadwal`=d.`id_jadwal` 
             LEFT JOIN data_guru e ON a.`id_guru`=e.`id_guru`
             WHERE a.`id_instansi`='1' AND d.`hari`='JUMAT';
ERROR - 2017-11-25 12:58:39 --> Query error: Unknown column 'b.id_kelas' in 'on clause' - Invalid query: SELECT 
                a.`id_pertemuan`,
                b.`nama_kelas`,
                c.`nama_pelajaran`,
                d.`hari`,
                TIME_FORMAT(d.`waktu_mulai`,'%H : %i') AS waktu_mulai,
                TIME_FORMAT(d.`waktu_selesai`,'%H : %i') AS waktu_selesai,
                e.`nama_guru`
             FROM rel_pertemuan a 
             LEFT JOIN sch_kelas b ON a.`id_kelas`=`b.id_kelas` 
             LEFT JOIN sch_pelajaran c ON a.`id_pelajaran`=c.`id_pelajaran` 
             LEFT JOIN sch_jadwal d ON a.`id_jadwal`=d.`id_jadwal` 
             LEFT JOIN data_guru e ON a.`id_guru`=e.`id_guru`
             WHERE a.`id_instansi`='1' AND d.`hari`='SABTU';
ERROR - 2017-11-25 12:58:39 --> Query error: Unknown column 'b.id_kelas' in 'on clause' - Invalid query: SELECT 
                a.`id_pertemuan`,
                b.`nama_kelas`,
                c.`nama_pelajaran`,
                d.`hari`,
                TIME_FORMAT(d.`waktu_mulai`,'%H : %i') AS waktu_mulai,
                TIME_FORMAT(d.`waktu_selesai`,'%H : %i') AS waktu_selesai,
                e.`nama_guru`
             FROM rel_pertemuan a 
             LEFT JOIN sch_kelas b ON a.`id_kelas`=`b.id_kelas` 
             LEFT JOIN sch_pelajaran c ON a.`id_pelajaran`=c.`id_pelajaran` 
             LEFT JOIN sch_jadwal d ON a.`id_jadwal`=d.`id_jadwal` 
             LEFT JOIN data_guru e ON a.`id_guru`=e.`id_guru`
             WHERE a.`id_instansi`='1' AND d.`hari`='RABU';
ERROR - 2017-11-25 12:58:39 --> Query error: Unknown column 'b.id_kelas' in 'on clause' - Invalid query: SELECT 
                a.`id_pertemuan`,
                b.`nama_kelas`,
                c.`nama_pelajaran`,
                d.`hari`,
                TIME_FORMAT(d.`waktu_mulai`,'%H : %i') AS waktu_mulai,
                TIME_FORMAT(d.`waktu_selesai`,'%H : %i') AS waktu_selesai,
                e.`nama_guru`
             FROM rel_pertemuan a 
             LEFT JOIN sch_kelas b ON a.`id_kelas`=`b.id_kelas` 
             LEFT JOIN sch_pelajaran c ON a.`id_pelajaran`=c.`id_pelajaran` 
             LEFT JOIN sch_jadwal d ON a.`id_jadwal`=d.`id_jadwal` 
             LEFT JOIN data_guru e ON a.`id_guru`=e.`id_guru`
             WHERE a.`id_instansi`='1' AND d.`hari`='SELASA';
ERROR - 2017-11-25 12:58:39 --> Query error: Unknown column 'b.id_kelas' in 'on clause' - Invalid query: SELECT 
                a.`id_pertemuan`,
                b.`nama_kelas`,
                c.`nama_pelajaran`,
                d.`hari`,
                TIME_FORMAT(d.`waktu_mulai`,'%H : %i') AS waktu_mulai,
                TIME_FORMAT(d.`waktu_selesai`,'%H : %i') AS waktu_selesai,
                e.`nama_guru`
             FROM rel_pertemuan a 
             LEFT JOIN sch_kelas b ON a.`id_kelas`=`b.id_kelas` 
             LEFT JOIN sch_pelajaran c ON a.`id_pelajaran`=c.`id_pelajaran` 
             LEFT JOIN sch_jadwal d ON a.`id_jadwal`=d.`id_jadwal` 
             LEFT JOIN data_guru e ON a.`id_guru`=e.`id_guru`
             WHERE a.`id_instansi`='1' AND d.`hari`='MINGGU';
ERROR - 2017-11-25 12:58:39 --> Query error: Unknown column 'b.id_kelas' in 'on clause' - Invalid query: SELECT 
                a.`id_pertemuan`,
                b.`nama_kelas`,
                c.`nama_pelajaran`,
                d.`hari`,
                TIME_FORMAT(d.`waktu_mulai`,'%H : %i') AS waktu_mulai,
                TIME_FORMAT(d.`waktu_selesai`,'%H : %i') AS waktu_selesai,
                e.`nama_guru`
             FROM rel_pertemuan a 
             LEFT JOIN sch_kelas b ON a.`id_kelas`=`b.id_kelas` 
             LEFT JOIN sch_pelajaran c ON a.`id_pelajaran`=c.`id_pelajaran` 
             LEFT JOIN sch_jadwal d ON a.`id_jadwal`=d.`id_jadwal` 
             LEFT JOIN data_guru e ON a.`id_guru`=e.`id_guru`
             WHERE a.`id_instansi`='1' AND d.`hari`='SENIN';
ERROR - 2017-11-25 12:58:39 --> 404 Page Not Found: Assets/vendor
ERROR - 2017-11-25 12:59:22 --> 404 Page Not Found: Assets/vendor
ERROR - 2017-11-25 12:59:22 --> 404 Page Not Found: Assets/vendor
ERROR - 2017-11-25 12:59:33 --> 404 Page Not Found: Assets/vendor
ERROR - 2017-11-25 12:59:33 --> 404 Page Not Found: Assets/vendor
ERROR - 2017-11-25 12:59:38 --> 404 Page Not Found: Assets/vendor
ERROR - 2017-11-25 12:59:38 --> 404 Page Not Found: Assets/vendor
ERROR - 2017-11-25 13:04:14 --> 404 Page Not Found: Assets/vendor
ERROR - 2017-11-25 13:04:14 --> 404 Page Not Found: Assets/vendor
ERROR - 2017-11-25 13:07:01 --> 404 Page Not Found: Assets/vendor
ERROR - 2017-11-25 13:07:02 --> 404 Page Not Found: Assets/vendor
ERROR - 2017-11-25 13:07:55 --> 404 Page Not Found: Assets/vendor
ERROR - 2017-11-25 13:07:55 --> 404 Page Not Found: Assets/vendor
ERROR - 2017-11-25 13:10:48 --> 404 Page Not Found: Assets/vendor
ERROR - 2017-11-25 13:10:49 --> 404 Page Not Found: Assets/vendor
ERROR - 2017-11-25 13:12:38 --> 404 Page Not Found: Assets/vendor
ERROR - 2017-11-25 13:12:38 --> 404 Page Not Found: Assets/vendor
ERROR - 2017-11-25 13:13:29 --> 404 Page Not Found: Assets/vendor
ERROR - 2017-11-25 13:13:29 --> 404 Page Not Found: Assets/vendor
ERROR - 2017-11-25 13:38:12 --> 404 Page Not Found: Login/auth
ERROR - 2017-11-25 13:38:21 --> 404 Page Not Found: Login/auth
ERROR - 2017-11-25 13:39:25 --> 404 Page Not Found: Login/auth
ERROR - 2017-11-25 14:33:49 --> 404 Page Not Found: Instansi/tagihan
ERROR - 2017-11-25 15:53:19 --> Severity: Notice --> Undefined property: mysqli::$id_jadwal D:\xampp\htdocs\sistemakademik\application\views\module\modal\tambah_jadwal.php 14
ERROR - 2017-11-25 15:53:19 --> Severity: Notice --> Undefined property: mysqli::$waktu_mulai D:\xampp\htdocs\sistemakademik\application\views\module\modal\tambah_jadwal.php 14
ERROR - 2017-11-25 15:53:19 --> Severity: Notice --> Undefined property: mysqli::$waktu_selesai D:\xampp\htdocs\sistemakademik\application\views\module\modal\tambah_jadwal.php 14
ERROR - 2017-11-25 15:53:19 --> Severity: Notice --> Undefined property: mysqli_result::$id_jadwal D:\xampp\htdocs\sistemakademik\application\views\module\modal\tambah_jadwal.php 14
ERROR - 2017-11-25 15:53:19 --> Severity: Notice --> Undefined property: mysqli_result::$waktu_mulai D:\xampp\htdocs\sistemakademik\application\views\module\modal\tambah_jadwal.php 14
ERROR - 2017-11-25 15:53:19 --> Severity: Notice --> Undefined property: mysqli_result::$waktu_selesai D:\xampp\htdocs\sistemakademik\application\views\module\modal\tambah_jadwal.php 14
ERROR - 2017-11-25 15:53:19 --> Severity: Notice --> Trying to get property of non-object D:\xampp\htdocs\sistemakademik\application\views\module\modal\tambah_jadwal.php 14
ERROR - 2017-11-25 15:53:19 --> Severity: Notice --> Trying to get property of non-object D:\xampp\htdocs\sistemakademik\application\views\module\modal\tambah_jadwal.php 14
ERROR - 2017-11-25 15:53:19 --> Severity: Notice --> Trying to get property of non-object D:\xampp\htdocs\sistemakademik\application\views\module\modal\tambah_jadwal.php 14
ERROR - 2017-11-25 15:53:19 --> Severity: Notice --> Trying to get property of non-object D:\xampp\htdocs\sistemakademik\application\views\module\modal\tambah_jadwal.php 14
ERROR - 2017-11-25 15:53:19 --> Severity: Notice --> Trying to get property of non-object D:\xampp\htdocs\sistemakademik\application\views\module\modal\tambah_jadwal.php 14
ERROR - 2017-11-25 15:53:19 --> Severity: Notice --> Trying to get property of non-object D:\xampp\htdocs\sistemakademik\application\views\module\modal\tambah_jadwal.php 14
ERROR - 2017-11-25 15:53:19 --> Severity: Notice --> Trying to get property of non-object D:\xampp\htdocs\sistemakademik\application\views\module\modal\tambah_jadwal.php 14
ERROR - 2017-11-25 15:53:19 --> Severity: Notice --> Trying to get property of non-object D:\xampp\htdocs\sistemakademik\application\views\module\modal\tambah_jadwal.php 14
ERROR - 2017-11-25 15:53:19 --> Severity: Notice --> Trying to get property of non-object D:\xampp\htdocs\sistemakademik\application\views\module\modal\tambah_jadwal.php 14
ERROR - 2017-11-25 15:53:19 --> Severity: Notice --> Trying to get property of non-object D:\xampp\htdocs\sistemakademik\application\views\module\modal\tambah_jadwal.php 14
ERROR - 2017-11-25 15:53:19 --> Severity: Notice --> Trying to get property of non-object D:\xampp\htdocs\sistemakademik\application\views\module\modal\tambah_jadwal.php 14
ERROR - 2017-11-25 15:53:19 --> Severity: Notice --> Trying to get property of non-object D:\xampp\htdocs\sistemakademik\application\views\module\modal\tambah_jadwal.php 14
ERROR - 2017-11-25 15:53:19 --> Severity: Notice --> Trying to get property of non-object D:\xampp\htdocs\sistemakademik\application\views\module\modal\tambah_jadwal.php 14
ERROR - 2017-11-25 15:53:19 --> Severity: Notice --> Trying to get property of non-object D:\xampp\htdocs\sistemakademik\application\views\module\modal\tambah_jadwal.php 14
ERROR - 2017-11-25 15:53:19 --> Severity: Notice --> Trying to get property of non-object D:\xampp\htdocs\sistemakademik\application\views\module\modal\tambah_jadwal.php 14
ERROR - 2017-11-25 15:53:19 --> Severity: Notice --> Trying to get property of non-object D:\xampp\htdocs\sistemakademik\application\views\module\modal\tambah_jadwal.php 14
ERROR - 2017-11-25 15:53:19 --> Severity: Notice --> Trying to get property of non-object D:\xampp\htdocs\sistemakademik\application\views\module\modal\tambah_jadwal.php 14
ERROR - 2017-11-25 15:53:19 --> Severity: Notice --> Trying to get property of non-object D:\xampp\htdocs\sistemakademik\application\views\module\modal\tambah_jadwal.php 14
ERROR - 2017-11-25 15:53:31 --> 404 Page Not Found: Assets/vendor
ERROR - 2017-11-25 15:54:55 --> 404 Page Not Found: Assets/vendor
ERROR - 2017-11-25 15:54:55 --> 404 Page Not Found: Assets/vendor
ERROR - 2017-11-25 16:10:34 --> 404 Page Not Found: Assets/vendor
ERROR - 2017-11-25 16:10:35 --> 404 Page Not Found: Assets/vendor
ERROR - 2017-11-25 16:10:38 --> 404 Page Not Found: Assets/vendor
ERROR - 2017-11-25 16:10:38 --> 404 Page Not Found: Assets/vendor
ERROR - 2017-11-25 16:10:42 --> 404 Page Not Found: Assets/vendor
ERROR - 2017-11-25 16:10:42 --> 404 Page Not Found: Assets/vendor
ERROR - 2017-11-25 16:13:59 --> 404 Page Not Found: Assets/vendor
ERROR - 2017-11-25 16:13:59 --> 404 Page Not Found: Assets/vendor
ERROR - 2017-11-25 16:14:47 --> 404 Page Not Found: Assets/vendor
ERROR - 2017-11-25 16:14:48 --> 404 Page Not Found: Assets/vendor
ERROR - 2017-11-25 16:14:54 --> 404 Page Not Found: Assets/vendor
ERROR - 2017-11-25 16:14:54 --> 404 Page Not Found: Assets/vendor
ERROR - 2017-11-25 16:16:06 --> 404 Page Not Found: Assets/vendor
ERROR - 2017-11-25 16:16:06 --> 404 Page Not Found: Assets/vendor
ERROR - 2017-11-25 16:34:15 --> Severity: Notice --> Undefined index: id_pelajaran D:\xampp\htdocs\sistemakademik\application\models\Global_model.php 46
ERROR - 2017-11-25 16:34:15 --> Query error: Unknown column 'id_kelas' in 'where clause' - Invalid query: SELECT *
FROM `sch_jadwal`
WHERE `id_instansi` = '1'
AND `id_kelas` = '1'
AND `id_jadwal` = '1'
AND `id_pelajaran` IS NULL
AND `id_guru` = '1'
ERROR - 2017-11-25 16:36:25 --> Query error: Unknown column 'id_kelas' in 'where clause' - Invalid query: SELECT *
FROM `sch_jadwal`
WHERE `id_instansi` = '1'
AND `id_kelas` = '1'
AND `id_jadwal` = '1'
AND `id_pelajaran` = '1'
AND `id_guru` = '1'
ERROR - 2017-11-25 18:40:23 --> Query error: Unknown column 'simpan' in 'field list' - Invalid query: INSERT INTO `sch_pertemuan` (`id_jadwal`, `id_kelas`, `id_pelajaran`, `id_guru`, `simpan`) VALUES ('4', '1', '4', '1', '1')
ERROR - 2017-11-25 18:47:37 --> 404 Page Not Found: Assets/vendor
ERROR - 2017-11-25 18:47:59 --> 404 Page Not Found: Assets/vendor
ERROR - 2017-11-25 18:47:59 --> 404 Page Not Found: Assets/vendor
ERROR - 2017-11-25 19:04:54 --> 404 Page Not Found: Assets/vendor
ERROR - 2017-11-25 19:04:55 --> 404 Page Not Found: Assets/vendor
ERROR - 2017-11-25 19:05:34 --> 404 Page Not Found: Assets/vendor
ERROR - 2017-11-25 19:05:34 --> 404 Page Not Found: Assets/vendor
ERROR - 2017-11-25 19:17:36 --> Severity: Error --> Call to undefined method Global_model::affected_rows() D:\xampp\htdocs\sistemakademik\application\models\Global_model.php 70
ERROR - 2017-11-25 19:20:33 --> Severity: Compile Error --> Cannot redeclare Global_model::editjadwal() D:\xampp\htdocs\sistemakademik\application\models\Global_model.php 72
ERROR - 2017-11-25 19:20:54 --> 404 Page Not Found: Assets/vendor
ERROR - 2017-11-25 19:20:54 --> 404 Page Not Found: Assets/vendor
ERROR - 2017-11-25 19:22:02 --> 404 Page Not Found: Assets/vendor
ERROR - 2017-11-25 19:22:02 --> 404 Page Not Found: Assets/vendor
ERROR - 2017-11-25 19:22:29 --> 404 Page Not Found: Assets/vendor
ERROR - 2017-11-25 19:22:29 --> 404 Page Not Found: Assets/vendor
