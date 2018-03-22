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
  <title>TacacsGUI | Lockscreen</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  
    <!-- MAIN CSS FOR TGUI -->
  <link rel="stylesheet" href="/dist/css/main.css">

  <link rel="shortcut icon" href="dist/img/favicon.ico">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
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
		.lockscreen-credentials {
			position: relative;
		}
		.form_block text{
			color: #ffff;
			background-color: #44444440;
			position: absolute;
			height: 100%;
			width: 100%;
		}
  
	</style>
  </head>
<body class="hold-transition lockscreen">
<div class="loading"><p class="loading_text text-center">Loading...</p></div>
<!-- Automatic element centering -->
<div class="lockscreen-wrapper">
  <div class="lockscreen-logo">
    <a href="/"><b>tacacs</b>GUI</a>
  </div>
  <div class="alert alert-danger" style="display:none"></div>
  <!-- User name -->
  <div class="lockscreen-name"><firstname_info></firstname_info> <surname_info></surname_info></div>

  <!-- START LOCK SCREEN ITEM -->
  <div class="lockscreen-item">
    <!-- lockscreen image -->
    <div class="lockscreen-image">
      <img src="dist/img/User-icon-colored-3.png" alt="User Image">
    </div>
    <!-- /.lockscreen-image -->

    <!-- lockscreen credentials (contains the form) -->
    <form class="lockscreen-credentials">
		<div class="form_block"><text class="text-center">Loading...</text></div>
      <div class="input-group">
        <input type="password" class="form-control" id="password" placeholder="password" value="">
        <input type="hidden" id="username" value="">

        <div class="input-group-btn">
          <button type="submit" class="btn" id="submit_btn"><i class="fa fa-arrow-right text-muted"></i></button>
        </div>
      </div>
    </form>
    <!-- /.lockscreen credentials -->

  </div>
  <!-- /.lockscreen-item -->
  <div class="help-block text-center">
    Enter your password to retrieve your session
  </div>
  <div class="text-center">
    <a href="/">Or sign in as a different user</a>
  </div>
  <!--<div class="lockscreen-footer text-center">
    Copyright &copy; 2018 <b><a href="https://tacacsgui.com" class="text-black">TacacsGUI</a></b><br>
    All rights reserved
  </div> -->
</div>
<!-- /.center -->
<!-- Link to API, you can set it in config.php -->
<script>var API_LINK = '<?php echo API_LINK;?>'</script>
<!-- TACGUI INFO -->
<script src="/dist/js/info.js"></script>
<div id="version_info" class="text-center" style="display:none"><b>tacacs</b> ver.<b><tacversion></tacversion></b> | <b>API</b> ver.<b><apiversion>11</apiversion></b> | <b>GUI</b> ver.<b><guiversion>11</guiversion></b></div>
<div class="text-center">Your IP address is <b><?php echo $_SERVER['REMOTE_ADDR'];?></b></div>
<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- main -->
<script src="dist/js/pages/lockscreen/main.js"></script>
</body>
</html>