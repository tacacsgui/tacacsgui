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

<!-- jqueryfiletree -->
<link rel="stylesheet" href="plugins/jQueryFileTree/jQueryFileTree.min.css">
<!-- iCheck -->
<link rel="stylesheet" href="/plugins/iCheck/square/blue.css">
<!-- Select2 -->
<link rel="stylesheet" href="bower_components/select2/dist/css/select2.min.css">
<!--ADDITIONAL CSS FILES END-->
<?php

require __DIR__ . '/templates/body_start.php';

?>
<!--MAIN CONTENT START-->

<div class="box box-solid">
	<div class="box-body">
		<div class="nav-tabs-custom">
            <ul class="nav nav-tabs api_settings">
							<li class="active"><a href="#time_settings" data-toggle="tab" data-section="time">Time settings</a></li>
							<li><a href="#smtp" data-toggle="tab" data-section="smtp">SMTP Server</a></li>
              <li><a href="#passwd_policy" data-toggle="tab" data-section="passwords">Password Policy</a></li>
              <li><a href="#network" data-toggle="tab" data-section="network">Network</a></li>
              <li><a href="#ha" data-toggle="tab" data-section="ha">High Availability</a></li>
              <li><a href="#logging" data-toggle="tab" data-section="logging">Logging</a></li>
            </ul>
            <div class="tab-content">
							<div class="tab-pane active" id="time_settings">
                <?php include __DIR__ . '/templates/pages/api_settings/tab_time.php';?>
              </div>
              <!-- /.tab-pane -->
							<div class="tab-pane" id="smtp">
                <?php include __DIR__ . '/templates/pages/api_settings/tab_smtp.php';?>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="passwd_policy">
                <?php include __DIR__ . '/templates/pages/api_settings/tab_passwd_policy.php';?>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="network">
                <?php include __DIR__ . '/templates/pages/api_settings/tab_network.php';?>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="ha">
                <?php include __DIR__ . '/templates/pages/api_settings/tab_ha.php';?>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="logging">
                <?php include __DIR__ . '/templates/pages/api_settings/tab_logging.php';?>
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
	<!-- jqueryfiletree -->
	<script src="plugins/jQueryFileTree/jQueryFileTree.min.js"></script>
	<!-- iCheck -->
	<script src="plugins/iCheck/icheck.min.js"></script>
	<!-- Select2 -->
	<script src="bower_components/select2/dist/js/select2.full.min.js"></script>

	<!-- Select2 Object -->
	<script src="dist/js/tgui_select2.js"></script>
	<script src="dist/js/tgui_expander.js"></script>
	<!-- main Object -->
  <script src="dist/js/pages/api_settings/tgui_apiSettings.js"></script>
  <script src="dist/js/pages/api_settings/tgui_apiHA.js"></script>
	<!-- main js MAIN Functions -->
  <script src="dist/js/pages/api_settings/main.js"></script>

<!-- ADDITIONAL JS FILES END-->
</body>

</html>
