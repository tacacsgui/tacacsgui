<!DOCTYPE html>
<!---->
<?php
///CONFIGURATION FILE///
require __DIR__ . '/config.php';
///PAGE VARIABLES///START
$PAGE_HEADER = 'API Settings';
$PAGE_SUBHEADER = 'Change general settings of api';
$PAGE_TITLE = 'TacacsGUI';
$PAGE_SUBTITLE = 'API Settings';
$BREADCRUMB = array(
	'Home' => [
		'name' => 'Administration', 
		'href' => '', 
		'icon' => 'fa fa-cog', 
		'class' => ''  //last item should have active class!!
	], 
	'Tacacs' => [
		'name' => 'API Settings', 
		'href' => '', 
		'icon' => 'fa fa-cog', 
		'class' => 'active'  //last item should have active class!!
	], 
);
///!!!!!////
$ACTIVE_MENU_ID=1000;
$ACTIVE_SUBMENU_ID=1030;
///!!!!!////
///PAGE VARIABLES///END
?>
<html>

<?php
require __DIR__ . '/templates/header.php';
?>
<!--ADDITIONAL CSS FILES START-->

<!--ADDITIONAL CSS FILES END-->

<?php 

require __DIR__ . '/templates/body_start.php'; 

?>
<!--MAIN CONTENT START-->

<div class="box box-solid">
	<div class="box-body">
		<div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#general" data-toggle="tab">General</a></li>
              <li><a href="#time_settings" data-toggle="tab">Time settings</a></li>
              <li><a href="#logging" data-toggle="tab">Logging</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="general">
                It will be added soon
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="time_settings">
                It will be added soon
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="logging">
                It will be added soon
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
	</div>
	<!-- /.box-body -->
</div>

<!--MAIN CONTENT END-->

<?php 

require __DIR__ . '/templates/body_end.php'; 

?>


<?php

require __DIR__ . '/templates/footer_end.php';

?>
<!-- ADDITIONAL JS FILES START-->

	<!-- main js MAIN Functions -->
    <script src="dist/js/pages/api_settings/main.js"></script>

<!-- ADDITIONAL JS FILES END-->
</body>

</html>