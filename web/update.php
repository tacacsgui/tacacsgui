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
  <title>TacacsGUI | Updating...</title>
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

  </style>
</head>
<body style="background-color: #eee;">
<div class="update-title text-center">
<h3>Seems like we should make some updates...</h3>
</div>
<div class="container">
<div class="message-container"></div>
</div>

<!--<div id="version_info" class="text-center hidden"><b>tacacs</b> ver.<b><tacversion></tacversion></b> | <b>API</b> ver.<b><apiversion>11</apiversion></b> | <b>GUI</b> ver.<b><guiversion>11</guiversion></b></div>
<div class="text-center">Your IP address is <b><?php echo $_SERVER['REMOTE_ADDR'];?></b></div>-->
<!-- Link to API, you can set it in config.php -->
<script>var API_LINK = '<?php echo API_LINK;?>'</script>
<!-- TACGUI INFO -->
<script src="/dist/js/info.js"></script>
<!-- jQuery 3 -->
<script src="/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<script src="/dist/js/pages/update/main.js"></script>
<script>
 
</script>
</body>
</html>
