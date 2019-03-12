<!DOCTYPE html>
<!---->
<?php
///CONFIGURATION FILE///
require __DIR__ . '/config.php';
///PAGE VARIABLES///START
$PAGE_HEADER = 'Configuration Manager Preview';
$PAGE_SUBHEADER = 'configuration preview and check diff';
$PAGE_TITLE = 'TacacsGUI';
$PAGE_SUBTITLE = 'Configuration Manager Preview';
$BREADCRUMB = array(
	'confM' => [
		'name' => 'Configuration Manager',
		'href' => '',
		'icon' => 'fa fa-copy',
		'class' => ''  //last item should have active class!!
	],
	'confM_main' => [
		'name' => 'Configuration Preview',
		'href' => '',
		'icon' => '', //leave empty if you won't put icon
		'class' => '' //last item should have active class!!
	],
);
///!!!!!////
$ACTIVE_MENU_ID=[1300,1310];
#$ACTIVE_SUBMENU_ID=525;
///!!!!!////
///PAGE VARIABLES///END
?>

<html>

<?php
require __DIR__ . '/templates/header.php';
?>
<!--ADDITIONAL CSS FILES START-->
  <!-- Select2 -->
  <link rel="stylesheet" href="bower_components/select2/dist/css/select2.min.css">

  <!-- main -->
  <link rel="stylesheet" href="/dist/css/pages/confM_/preview/main.css">
<!--ADDITIONAL CSS FILES END-->

<?php

require __DIR__ . '/templates/body_start.php';

?>
<!--MAIN CONTENT START-->
<a class="btn btn-default btn-flat" href="/confM_main.php"><i class="fa fa-arrow-left"></i> Back</a>
<p></p>
<div class="callout callout-danger" style="display:none;">
  <h4>Error!</h4>
  <p></p>
</div>
<div class="box box-info">
  <div class="box-header">
    <h4>Diff Preview for: <elName style="color:green;"></elName></h4>
  </div>
  <div class="box-body">
    <h4>General Diff</h4>
    <div class="row">
      <div class="col-sm-3">
        <div class="input-group">
              <span class="input-group-addon">
                <input type="radio" name="diffType" value='brief' checked disabled> Brief
              </span>
          <input type="number" class="form-control" name="context" placeholder="Number of context" value="3" min=3>
        </div>
      </div>
      <div class="col-sm-3">
        <div class="input-group">
              <span class="input-group-addon">
                <input type="radio" name="diffType" value='full' disabled> Full View
              </span>
          <input type="text" class="form-control" style="cursor: inherit;" disabled>
        </div>
      </div>
      <div class="col-sm-3">
        <div class="input-group">
              <span class="input-group-addon">
                <input type="radio" name="diffType" value='preview' disabled> Preview
              </span>
          <input type="text" class="form-control" style="cursor: inherit;" disabled>
        </div>
      </div>
      <div class="col-sm-3">
        <div class="input-group">
              <span class="input-group-addon">
                <input type="radio" name="diffType" value='native' disabled> Clear Diff
              </span>
          <input type="number" class="form-control" name="context_native" placeholder="Number of context" value="3" min=3>
        </div>
      </div>
    </div>
    <h4>Tacacs + Diff</h4>
    <div class="row">
      <div class="col-sm-3">
        <div class="input-group">
              <span class="input-group-addon">
                <input type="radio" name="diffType" value='tacgui' disabled> +TacacsGUI
              </span>
          <input type="text" class="form-control" style="cursor: inherit;" disabled>
        </div>
      </div>
    </div>
    <hr>
    <div class="row">
      <div class="col-sm-6 file_a_column">
        <label>Select Version of File A</label>
        <div class="input-group">
          <div class="input-group-btn">
            <a class="btn btn-default btn-flat file_a_download" href="#" target="_blank"><i class="fa fa-cloud-download"></i></a>
          </div>
          <select class="form-control select2 version_list select_a" style="width:100%"></select>
        </div>
      </div>
      <div class="col-sm-6 file_b_column">
        <label>Select Version of File B</label>
        <div class="input-group">
          <div class="input-group-btn">
            <a class="btn btn-default btn-flat file_b_download" href="#" target="_blank"><i class="fa fa-cloud-download"></i></a>
          </div>
          <select class="form-control select2 version_list select_b" style="width:100%"></select>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-6 file_a_column">
        <pre class="preview file_a">Loading...</pre>
      </div>
      <div class="col-sm-6 file_b_column">
        <pre class="preview file_b">Loading...</pre>
      </div>
    </div>
  </div>
</div>

<!--MAIN CONTENT END-->

<?php

require __DIR__ . '/templates/body_end.php';

?>


<?php

require __DIR__ . '/templates/footer_end.php';

?>
<!-- ADDITIONAL JS FILES START-->
  <!-- Select2 -->
  <script src="bower_components/select2/dist/js/select2.full.min.js"></script>

	<!-- main Object -->
	<script src="dist/js/pages/confM_/preview/cm_preview.js"></script>

	<!-- main js tac services MAIN Functions -->
  <script src="dist/js/pages/confM_/preview/main.js"></script>
<!-- ADDITIONAL JS FILES END-->
</body>
</html>
