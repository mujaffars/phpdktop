<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>AdminLTE 2 | Log in</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <?php $this->load->view("common/css"); ?>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    
    <!-- iCheck -->
    

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="hold-transition login-page">
    <div class="login-box">
      <div class="login-logo">
       <b>Gold Billing </b>
	   
	   <?php
	   
	   echo '<pre>';
print_r($_ENV);
echo '</pre>';
$output = shell_exec("echo | {$_ENV['SystemRoot']}\System32\wbem\wmic.exe path win32_computersystemproduct get uuid");
if ($output) echo "Command succeeded. Output=".$output;
else echo "Command failed.";
?>
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        <p class="login-box-msg">Sign in to start your session</p>
       
          <div class="form-group has-feedback">
            <input type="email" class="form-control" placeholder="Email">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" class="form-control" placeholder="Password">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-8">
              <div class="checkbox icheck">
                <label>
                  <input type="checkbox"> Remember Me
                </label>
              </div>
            </div><!-- /.col -->
            <div class="col-xs-4">
              <button type="button" class="btn btn-primary btn-block btn-flat" onclick="goToLogin();">Sign In</button>
            </div><!-- /.col -->
          </div>
        

       

        <a href="#">I forgot my password</a><br>
       

      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->
    
<form action="<?php echo base_url();?>index.php/viewLoginPage" id="goLogin">
</form>
    <?php $this->load->view("common/jsfiles"); ?>
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
     function goToLogin()
    {
      $("#goLogin").submit();
    }
    </script>
    
  </body>
</html>
