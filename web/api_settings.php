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