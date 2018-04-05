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
  <title>TacacsGUI | Sing in</title>
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
    <p class="login-box-msg">Sign in to get control</p>
	<div class="alert alert-danger hidden"></div>
	<div class="alert alert-warning changePasswd" style="display:none">Hello <username><i></i></username>. Please change your password</div>
    <form method="post" class="signin">
      <div class="form-group has-feedback input-group">
        <input type="text" class="form-control" placeholder="Login" id="username" required="true" value=''>
        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
      </div>
      <div class="form-group has-feedback input-group">
        <input type="password" class="form-control" placeholder="Password" id="password" required="true" value=''>
        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox" disabled> Remember Me
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat" id="submit_btn">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
	<!-- CHANGE PASSWORD FORM-->
	<form method="post" class="changePasswd" style="display:none">
		<div class="form-group has-feedback input-group">
			<input type="password" class="form-control" placeholder="Password" id="change_password" required="true" value=''>
			<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
		</div>
		<div class="form-group has-feedback input-group">
			<input type="password" class="form-control" placeholder="Repeat Password" id="change_reppassword" required="true" value=''>
			<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
		</div>
		<div class="row">
			<!-- /.col -->
			<div class="col-xs-12 text-center">
				<button type="submit" class="btn btn-primary btn-flat" id="change_submit_btn">Change Password</button>
			</div>
			<!-- /.col -->
		</div>
    </form>
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
<div id="version_info" class="text-center hidden"><b>tacacs</b> ver.<b><tacversion></tacversion></b> | <b>API</b> ver.<b><apiversion>11</apiversion></b> | <b>GUI</b> ver.<b><guiversion>11</guiversion></b></div>
<div class="text-center">Your IP address is <b><?php echo $_SERVER['REMOTE_ADDR'];?></b></div>
<!-- Link to API, you can set it in config.php -->
<script>var API_LINK = '<?php echo API_LINK;?>'</script>
<!-- TACGUI INFO -->
<script src="/dist/js/info.js"></script>
<!-- jQuery 3 -->
<script src="/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="/plugins/iCheck/icheck.min.js"></script>
<!-- singin main file -->
<script src="/dist/js/pages/singin/singin.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
</body>
</html>
