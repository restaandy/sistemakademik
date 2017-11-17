<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Page title -->
    <title>Login Sistem Akademik</title>
    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <!--<link rel="shortcut icon" type="image/ico" href="favicon.ico" />-->
    <!-- Vendor styles -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/fontawesome/css/font-awesome.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/metisMenu/dist/metisMenu.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/animate.css/animate.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/bootstrap/dist/css/bootstrap.css" />
    <!-- App styles -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/fonts/pe-icon-7-stroke/css/helper.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/styles/style.css">
</head>
<body class="blank">
<?php $this->load->view("layout/splash"); ?>
<div class="color-line"></div>
<div class="login-container">
    <div class="row">
        <div class="col-md-12">
            <div class="text-center m-b-md">
            <img src="<?php echo base_url(); ?>assets/images/logo-tegal.png" width="40" height="50">
                <h3>Login System</h3>
                <small>Sistem Akademik Semua Sekolah</small>
            </div>
            <div class="hpanel">
                <div class="panel-body">
                    <form action="<?php echo base_url(); ?>index.php/login/auth" method="POST" id="loginForm">
                            <div class="form-group">
                                <label class="control-label" for="username">Username</label>
                                <input type="text" placeholder="example@gmail.com" title="Please enter you username" required="" value="" name="username" id="username" class="form-control">
                                <span class="help-block small">Your unique username to app</span>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="password">Password</label>
                                <input type="password" title="Please enter your password" placeholder="******" required="" value="" name="password" id="password" class="form-control">
                                <span class="help-block small">Yur strong password</span>
                            </div>
                            <button class="btn btn-success btn-block" type="submit">Login</button>
                        </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 text-center">
            <strong>Kab Tegal</strong> - Sistem Perangkat Desa Kabupaten Tegal <br/> 2016 Copyright Restasolution
        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>assets/vendor/jquery/dist/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/jquery-ui/jquery-ui.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/bootstrap/dist/js/bootstrap.min.js"></script>
<!--<script src="<?php //echo base_url(); ?>assets/vendor/slimScroll/jquery.slimscroll.min.js"></script>
<script src="<?php //echo base_url(); ?>assets/vendor/jquery-flot/jquery.flot.js"></script>
<script src="<?php //echo base_url(); ?>assets/vendor/jquery-flot/jquery.flot.resize.js"></script>
<script src="<?php //echo base_url(); ?>assets/vendor/jquery-flot/jquery.flot.pie.js"></script>
<script src="<?php //echo base_url(); ?>assets/vendor/flot.curvedlines/curvedLines.js"></script>
<script src="<?php //echo base_url(); ?>assets/vendor/jquery.flot.spline/index.js"></script>
<script src="<?php //echo base_url(); ?>assets/vendor/metisMenu/dist/metisMenu.min.js"></script>
<script src="<?php //echo base_url(); ?>assets/vendor/iCheck/icheck.min.js"></script>
<script src="<?php //echo base_url(); ?>assets/vendor/peity/jquery.peity.min.js"></script>
<script src="<?php //echo base_url(); ?>assets/vendor/sparkline/index.js"></script>
-->
<!-- App scripts -->
<script src="<?php echo base_url(); ?>assets/scripts/homer.js"></script>
<script src="<?php echo base_url(); ?>assets/scripts/charts.js"></script>
</body>
</html>