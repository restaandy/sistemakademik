<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sistem Akademik Sekolah</title>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/fontawesome/css/font-awesome.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/metisMenu/dist/metisMenu.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/animate.css/animate.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/bootstrap/dist/css/bootstrap.css" />
    <?php
    if(isset($gcrud)){
        foreach($css_files as $file): ?>
    <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
        <?php endforeach;
    } ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/fonts/pe-icon-7-stroke/css/helper.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/styles/style.css">
    <?php $this->load->view("assets/css/main"); ?>
    <script src="<?php echo base_url(); ?>assets/vendor/jquery/dist/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/vendor/jquery-ui/jquery-ui.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/vendor/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/vendor/metisMenu/dist/metisMenu.min.js"></script>
     <?php 
        if(isset($gcrud)){
            foreach($js_files as $file): ?>
    <script src="<?php echo $file; ?>"></script><?php 
            endforeach;
        } ?>
    <script src="<?php echo base_url(); ?>assets/scripts/homer.js"></script>
</head>
<body>
<?php $this->load->view("layout/splash"); ?><?php $this->load->view("layout/header"); ?><?php $this->load->view("layout/sidebar"); ?>
<div id="wrapper">
<div class="content animate-panel">
<?php if(isset($var_other['headerinfo'])){$this->load->view("layout/headerinfo",$var_other);} ?>
<?php if(isset($gcrud)){echo $output;}else{$this->load->view("module/".$var_module,$var_other); }?>
</div>
<?php $this->load->view("layout/footer"); ?>
</div>
<?php $this->load->view("assets/js/main"); ?>
</body>
</html>