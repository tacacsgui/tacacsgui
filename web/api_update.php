<!DOCTYPE html>
<!---->
<?php
///CONFIGURATION FILE///
require __DIR__ . '/config.php';
///PAGE VARIABLES///START
$PAGE_HEADER = 'API Update';
$PAGE_SUBHEADER = 'Get update of api';
$PAGE_TITLE = 'TacacsGUI';
$PAGE_SUBTITLE = 'API Update';
$BREADCRUMB = array(
	'Home' => [
		'name' => 'Administration',
		'href' => '',
		'icon' => 'fa fa-cog',
		'class' => ''  //last item should have active class!!
	],
	'Tacacs' => [
		'name' => 'API Update',
		'href' => '',
		'icon' => 'fa fa-database',
		'class' => 'active'  //last item should have active class!!
	],
);
///!!!!!////
$ACTIVE_MENU_ID=1000;
$ACTIVE_SUBMENU_ID=1040;
///!!!!!////
///PAGE VARIABLES///END
?>
<html>

<?php
require __DIR__ . '/templates/header.php';
?>
<!--ADDITIONAL CSS FILES START-->

	<!-- iCheck -->
	<link rel="stylesheet" href="/plugins/iCheck/square/blue.css">

<!--ADDITIONAL CSS FILES END-->

<?php

require __DIR__ . '/templates/body_start.php';

?>
<!--MAIN CONTENT START-->

<div class="box box-success">
	<div class="box-header with-border">
		<h3 class="box-title">General Update Settings</h3>
	</div>
	<!-- /.box-header -->
	<!-- form start -->
	<div class="box-body">
		<div class="form-group">
			<label>Update URL</label>
			<input type="text" class="form-control" name="update_url" data-type="input" data-default="" data-pickup="true" disabled>
		</div>
		<div class="form-group">
			<label>Check after sign in</label>
			<div class="checkbox icheck">
				<label>
					<input type="checkbox" name="update_signin" data-type="checkbox" data-default="uncheck" data-pickup="true"> Check update after sign in
				</label>
			</div>
		</div>
		<div class="form-group">
			<label>Update Key</label>
			<div class="input-group margin">
				<span class="input-group-addon activated"></span>
                <input type="text" class="form-control" name="update_key" data-type="input" data-default="" data-pickup="true" disabled>
                    <span class="input-group-btn">
                      <button type="button" class="btn btn-warning btn-flat" onclick="tgui_apiUpdate.newKey()">Generate New</button>
                    </span>
			</div>
			<p class="help-block"> add that key to your <a href="https://tacacsgui.com/profile/" target="_blank">tacacsgui.com</a> profile</p>
		</div>
	</div>
	<!-- /.box-body -->

	<!-- <div class="box-footer">
		<button type="submit" class="btn btn-success btn-flat">Apply</button>
	</div> -->
</div>

<div class="box box-success">
	<div class="box-header with-border">
		<h3 class="box-title">Update Output</h3>
	</div>
	<!-- /.box-header -->
	<!-- form start -->
	<div class="box-body">
		<div class="form-group">
			<button class="btn btn-success btn-flat" onclick="tgui_apiUpdate.checkUpdate()">Check Update</button>
		</div>
		<div class="form-group">
<pre class="update_log">
<p class="text-center">Info will appeared here</p>
</pre>
		</div>
<p>The last 6 updates list you can find <a href="https://tacacsgui.com/updates/" target="_blank">here</a></p>
	</div>
	<!-- /.box-body -->

	<div class="box-footer upgrade text-center" style="display:none">
		<button class="btn btn-success btn-flat" onclick="tgui_apiUpdate.upgrade()">Update</button>
	</div>
	<div class="overlay update_output" style="display:none;">
		<i class="fa fa-refresh fa-spin"></i>
    </div>
</div>

<div class="callout callout-warning">
  <h4>Important Info</h4>

  <p>If you have some problems after update, please push <kbd>Ctrl</kbd> <t class="text-black">+</t> <kbd>Shift</kbd> <t class="text-black">+</t> <kbd>R</kbd> on the problem page.</p>
</div>

<!--MAIN CONTENT END-->

<?php

require __DIR__ . '/templates/body_end.php';

?>


<?php

require __DIR__ . '/templates/footer_end.php';

?>
<!-- ADDITIONAL JS FILES START-->

	<!-- iCheck -->
	<script src="/plugins/iCheck/icheck.min.js"></script>

	<!-- main Object -->
  <script src="dist/js/pages/api_update/tgui_apiUpdate.js"></script>
	<!-- main js MAIN Functions -->
  <script src="dist/js/pages/api_update/main.js"></script>

<!-- ADDITIONAL JS FILES END-->
</body>

</html>
