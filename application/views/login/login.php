<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="shortcut icon" href="<?php echo base_url() ?>images/favicon.ico" type="image/png">

  <title>Cherry</title>

  <link href="<?php echo base_url() ?>css/style.default.css" rel="stylesheet">
  <link href="<?php echo base_url() ?>css/jquery.datatables.css" rel="stylesheet">
  <link href='http://fonts.googleapis.com/css?family=Lato:400,300' rel='stylesheet' type='text/css'>

  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
  <script src="js/html5shiv.js"></script>
  <script src="js/respond.min.js"></script>
  <![endif]-->
</head>

<body class="signin">

<!-- Preloader -->
<div id="preloader">
    <div id="status"><i class="fa fa-spinner fa-spin"></i></div>
</div>

<section>
  
  <div class="signinpanel">
        
        <div class="row">            
            <div class="col-md-12">
           <div class="loginlogo"> <img src="<?php echo base_url() ?>images/logo.jpg" alt=""/> </div>
                
                <form method="post" action="<?php echo base_url('login/index')?>">
                    
                    <h4 class="nomargin">Sign In</h4>
                    <p class="mt5 mb20">Login to access your account.</p>
                    <hr>
                    <?php 
                      if($this->session->flashdata('msg'))
                      {
                          echo $this->session->flashdata('msg');    
                      } 
                  ?>
                    <input type="text" class="form-control uname" placeholder="Username" id="exampleInputEmail1" name="emailid" value="<?php echo set_value('email', $this->input->cookie('email')); ?>" required/>

                    <input type="password" class="form-control pword" placeholder="Password" id="exampleInputPassword1" name="password" value="<?php echo set_value('password', $this->input->cookie('password')); ?>" required/>
                    
                    <button class="btn btn-maroon btn-block" type="submit">Sign In</button>
                     </form>

                    <div class="forgot">
                    <label class="checkbox"><input type="checkbox" style="width:20px" class="uniform" name="remember_me" checked>Remember me</label>
                    <a href="<?php echo site_url('login/forgot_password');?>">Forgot Your Password?</a>
                    </div>
                    
               
            </div><!-- col-sm-5 -->
            
        </div><!-- row -->
        
        <div class="signup-footer">
            <div class="text-center">
                &copy; 2016 Cherry All Rights Reserved. 
            </div>
           
        </div>
        
    </div>
 
  
</section>


<script src="<?php echo base_url() ?>js/jquery-1.10.2.min.js"></script>
<script src="<?php echo base_url() ?>js/jquery-migrate-1.2.1.min.js"></script>
<script src="<?php echo base_url() ?>js/bootstrap.min.js"></script>
<script src="<?php echo base_url() ?>js/modernizr.min.js"></script>
<script src="<?php echo base_url() ?>js/jquery.sparkline.min.js"></script>
<script src="<?php echo base_url() ?>js/toggles.min.js"></script>
<script src="<?php echo base_url() ?>js/retina.min.js"></script>
<script src="<?php echo base_url() ?>js/jquery.cookies.js"></script>

<script src="<?php echo base_url() ?>js/flot/flot.min.js"></script>
<script src="<?php echo base_url() ?>js/flot/flot.resize.min.js"></script>
<script src="<?php echo base_url() ?>js/morris.min.js"></script>
<script src="<?php echo base_url() ?>js/raphael-2.1.0.min.js"></script>

<script src="<?php echo base_url() ?>js/jquery.datatables.min.js"></script>
<script src="<?php echo base_url() ?>js/chosen.jquery.min.js"></script>

<script src="<?php echo base_url() ?>js/custom.js"></script>
<script src="<?php echo base_url() ?>js/dashboard.js"></script>

</body>
</html>
