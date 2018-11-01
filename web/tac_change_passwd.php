<!DOCTYPE html>
<html>
<head>
<?php
//////////////////////////////////////////////////
/*CONFIGURATION FILE*/require __DIR__ . '/config.php';
//////////////////////////////////////////////////
?>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>TacacsGUI | Change Password Page</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
   <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="/plugins/iCheck/square/blue.css">
  <!-- toastr -->
  <link rel="stylesheet" href="plugins/toastr/toastr.min.css">
  <!-- MAIN CSS FOR TGUI -->
  <link rel="stylesheet" href="/dist/css/main.css">

  <link rel="shortcut icon" href="dist/img/favicon.ico">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <style>
  .form_block {
    width: 100%;
    height: 100%;
    position: absolute;
    top: 0px;
    right: 0;
	background-color: #4c4c4c61;
    z-index: 10;
	display: none;
  }
  .login-box-body {
	  position: relative;
  }
  .form_block h3{
	color: #ffff;
    background-color: #444444ed;
    top: 20%;
    position: relative;
    padding: 5px;
  }

  </style>
</head>
<body class="hold-transition login-page">
<div class="loading"><p class="loading_text text-center">Loading...</p></div>
<div class="login-box">
  <div class="login-logo">
    <a href="/"><b>tacacs</b>GUI</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
	<div class="form_block text-center"> <h3>Loading...</h3> </div>
    <p class="login-box-msg">Change Tacacs Password</p>
	<div class="alert alert-danger" style="display:none;"></div>
	<div class="alert alert-warning changePasswd" style="display:none">Hello <username><i></i></username>. Please change your password</div>
    <form id="tac_change_passwd_Form" onsubmit="return tgui_change_passwd.login()">
      <div class="form-group username">
        <div class="input-group">
          <input type="text" class="form-control" placeholder="Tacacs Username" name="username" data-type="input" data-default="" data-pickup="true" value='' autocomplete="username">
          <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
        </div>
      </div>
      <div class="form-group" style="display: none;">
        <select class="form-control" name="object" data-type="select" data-pickup="true">
          <option value="login"selected>Login Password</option>
          <option value="enable">Enable Password</option>
        </select>
      </div>
      <div class="form-group password">
        <div class="input-group">
          <input type="password" class="form-control" placeholder="Old Password" name="password" data-type="input" data-default="" data-pickup="true" value='' autocomplete="new-password">
          <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
        </div>
      </div>
      <div class="form-group new_password">
        <div class="input-group">
          <input type="password" class="form-control" placeholder="New Password" name="new_password" data-type="input" data-default="" data-pickup="true" value='' autocomplete="new-password">
          <span class="input-group-addon"><i class="glyphicon glyphicon-fire"></i></span>
        </div>
      </div>
      <div class="form-group new_password_repeat">
        <div class="input-group">
          <input type="password" class="form-control" placeholder="Repeat New Password" name="new_password_repeat" data-type="input" data-default="" data-pickup="true" value='' autocomplete="new-password">
          <span class="input-group-addon"><i class="glyphicon glyphicon-repeat"></i></span>
        </div>
      </div>
      <div class="row">
        <!-- /.col -->
        <div class="col-xs-12">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Change</button>
        </div>
        <!-- /.col -->
      </div>
      <hr>
      <p class="help-block text center">log in to change your tacacs password</p>
      <a href="/">Go back</a>
    </form>
	<!-- CHANGE PASSWORD FORM-->
	<form id="chngPaswdForm" style="display:none">
    <div class="callout callout-success">
      <h4>Successfully Changed!</h4>

      <p>Hello<username></username>! Your <password_type></password_type>password was changed.</p>
    </div>
  </form>
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
<div id="version_info" class="text-center hidden"><b>tacacs</b> ver.<b><tacversion></tacversion></b> | <b>API</b> ver.<b><apiversion>0</apiversion></b></div>
<div class="text-center">Your IP address is <b><?php echo $_SERVER['REMOTE_ADDR'];?></b></div>
<!-- Link to API, you can set it in config.php -->
<script>var API_LINK = '<?php echo API_LINK;?>'</script>
<!-- TACGUI INFO -->
<script src="/dist/js/info.js"></script>
<!-- jQuery 3 -->
<script src="/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- toastr -->
<script src="plugins/toastr/toastr.min.js"></script>

<!-- Main Object -->
<script src="dist/js/main.js"></script>
<!-- iCheck -->
<script src="/plugins/iCheck/icheck.min.js"></script>
<!-- change_passwd object -->
<script src="/dist/js/pages/tac_change_passwd/tac_change_passwd.js"></script>
<!-- change_passwd main -->
<script src="/dist/js/pages/tac_change_passwd/main.js"></script>

</body>
</html>
