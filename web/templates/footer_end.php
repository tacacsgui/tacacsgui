<!-- REQUIRED JS SCRIPTS -->
<!-- TACGUI INFO -->
<script src="dist/js/info.js"></script>
<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- bootstrap-toggle -->
<script src="plugins/bootstrap-toggle/js/bootstrap-toggle.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- toastr -->
<script src="plugins/toastr/toastr.min.js"></script>
<!-- idle-Timer -->
<script src="plugins/idle-Timer/idle-Timer.js"></script>
<!-- tgui_expander -->
<script src="dist/js/tgui_expander.js"></script>


<!-- TACGUI MAIN -->
<script src="dist/js/main.js"></script>

<?php
  if ( is_dir('/opt/tgui_data/dev/inc/js/') ){
    $path='/opt/tgui_data/dev/inc/js/';
    $scaner=scandir($path);
    unset($scaner[1]);
    unset($scaner[0]);
    $scaner = (count($scaner)) ? array_values($scaner) : false;
    $output='';
    if ($scaner) foreach ($scaner as $file) {
      $output.=file_get_contents($path.$file);
    }
    echo $output;
  }
 ?>
