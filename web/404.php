<!DOCTYPE html>
<!---->
<?php
///CONFIGURATION FILE///
require __DIR__ . '/config.php';
///PAGE VARIABLES///START
$PAGE_HEADER = 'Page not found';
$PAGE_SUBHEADER = '';
$PAGE_TITLE = 'TacacsGUI';
$PAGE_SUBTITLE = 'Page not found';
$BREADCRUMB = array();
///!!!!!////
$ACTIVE_MENU_ID=0;
$ACTIVE_SUBMENU_ID=0;
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

<div class="error-page">
	<h2 class="headline text-yellow"> 404</h2>

	<div class="error-content">
		<h3><i class="fa fa-warning text-yellow"></i> Oops! Page not found.</h3>

		<p>
			We could not find the page you were looking for.
			Meanwhile, you may <a href="/">return to home page</a>.
		</p>
	</div>
	<!-- /.error-content -->
</div>

<!--MAIN CONTENT END-->

<?php

require __DIR__ . '/templates/body_end.php';

?>


<?php

require __DIR__ . '/templates/footer_end.php';

?>
<!-- ADDITIONAL JS FILES START-->

<script src="dist/js/pages/404/main.js"></script>

<!-- ADDITIONAL JS FILES END-->
</body>

</html>
