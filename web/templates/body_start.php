
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
        page. However, you can choose any other skin. Make sure you
        apply the skin class to the body tag so the changes take effect. -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.css">
  <!-- MAIN CSS FOR TGUI -->
  <link rel="stylesheet" href="dist/css/main.css">
  <!-- m-progress -->
  <link rel="stylesheet" href="dist/css/m-progress.css">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <link rel="shortcut icon" href="dist/img/favicon.ico">

   <!-- Google Font-->
  <link rel="stylesheet" href="dist/css/fonts/main.css">
  <!-- bootstrap-toggle -->
  <link rel="stylesheet" href="plugins/bootstrap-toggle/css/bootstrap-toggle.min.css">
  <!-- ladda-ui -->
  <link rel="stylesheet" href="plugins/ladda-ui/ladda-themeless.min.css">
</head>
<!-- !!!!BODY START HERE!!!! -->
<body class="hold-transition <?php echo GUI_SKIN;?> sidebar-mini">
<div class="loading">
	<div class="text-center"><p class="loading_text">Loading...</p>
	</div>
</div>
<div class="server-error">
  <div class="error-body">
    <div class="error-header"><h2>Server Error Appeared!</h2></div>
    <div class="error-message"><h4>Description:</h4>
      <div class="error-message-body">Unexpected Error (Template Message)</div>
    </div>
    <hr>
    <div class="error-footer">
      <p>Please try to reload the page with <kbd> Ctrl </kbd> <b>+</b> <kbd> Shift </kbd> <b>+</b> <kbd> R </kbd>.</p>
      <p>If error appered againg you can concat the developer - <a href="mailto:developer@tacacsgui.com">developer@tacacsgui.com</a></p>
    </div>
  </div>
</div>
<div class="wrapper">

<?php
	require __DIR__ . '/parts/header_menu.php';
?>

<?php
	require __DIR__ . '/parts/sidebar.php';
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php echo $PAGE_HEADER;?>
        <small><?php echo $PAGE_SUBHEADER;?></small>
      </h1>
      <ol class="breadcrumb">
		<?php
		foreach ($BREADCRUMB as $item){
			//echo '<li><a href="'.$item['href'].'"><i class="'.$item['icon'].'"></i> '.$item['name'].'</a></li>';
			echo '<li';
			echo ($item['class']!='') ? ' class="'.$item['class'].'">': '>';
			echo ($item['href']!='') ? '<a href="'.$item['href'].'">': '';
			echo ($item['icon']!='') ? '<i class="'.$item['icon'].'"></i> ': '';
			echo  $item['name'];
			echo ($item['href']!='') ? '</a>': '';
			echo '</li>';
		}
		?>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

    <?php

    require __DIR__ . '/parts/patreon_support.php';

    ?>
