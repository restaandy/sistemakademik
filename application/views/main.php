<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Page title -->
    <title>Sistem Akademik Sekolah</title>

    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <!--<link rel="shortcut icon" type="image/ico" href="favicon.ico" />-->
    <!-- Vendor styles -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/fontawesome/css/font-awesome.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/metisMenu/dist/metisMenu.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/animate.css/animate.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/bootstrap/dist/css/bootstrap.css" />
    <!-- App styles -->
    <?php
    if(isset($gcrud)){
        foreach($css_files as $file): ?>
            <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
        <?php endforeach;
    } ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/fonts/pe-icon-7-stroke/css/helper.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/styles/style.css">
    
    <style type="text/css">
.footer {
    padding: 10px 18px;
    background: #fff;
    border-top: 1px solid #eaeaea;
    transition: margin .4s ease 0s;
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
}
    </style>
<script src="<?php echo base_url(); ?>assets/vendor/jquery/dist/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/jquery-ui/jquery-ui.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/metisMenu/dist/metisMenu.min.js"></script>
<script src="<?php echo base_url(); ?>assets/scripts/homer.js"></script>
 <?php 
    if(isset($gcrud)){
        foreach($js_files as $file): ?>
            <script src="<?php echo $file; ?>"></script><?php 
        endforeach;
    } ?>
</head>
<body>
<?php $this->load->view("layout/splash"); ?>
<!-- Header -->
<?php $this->load->view("layout/header"); ?>
<!-- Navigation -->
<?php $this->load->view("layout/sidebar"); ?>
<!-- Main Wrapper -->
<div id="wrapper">
<div class="content animate-panel">
<?php if(isset($var_other['headerinfo'])){$this->load->view("layout/headerinfo",$var_other);} ?>
<?php if(isset($gcrud)){echo $output;}else{$this->load->view("module/".$var_module,$var_other); }?>
</div>
<?php $this->load->view("layout/footer"); ?>
</div>
<?php  
if($this->session->flashdata("notif")!=NULL){
?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/toastr/build/toastr.min.css" />
<script src="<?php echo base_url(); ?>assets/vendor/toastr/build/toastr.min.js"></script><?php }?>
<script>
<?php  
    if($this->session->flashdata("notif")!=NULL){
        ?>
                 toastr.options = {
                    "debug": false,
                    "newestOnTop": false,
                    "positionClass": "toast-top-right",
                    "closeButton": true,
                    "toastClass": "animated fadeInDown",
                };
            <?php  
            if($this->session->flashdata("notif")["type"]=="success"){
                ?>
                    toastr.success('<?php echo $this->session->flashdata("notif")["msg"]; ?>');
                <?php
            }
            if($this->session->flashdata("notif")["type"]=="info"){
                ?>
                    toastr.info('<?php echo $this->session->flashdata("notif")["msg"]; ?>');
                <?php
            }
            if($this->session->flashdata("notif")["type"]=="warning"){
                ?>
                    toastr.warning('<?php echo $this->session->flashdata("notif")["msg"]; ?>');
                <?php
            }
            if($this->session->flashdata("notif")["type"]=="error"){
                ?>
                    toastr.error('<?php echo $this->session->flashdata("notif")["msg"]; ?>');
                <?php
            }
            ?>
        <?php
    }
    ?>
</script>
</body>
</html>