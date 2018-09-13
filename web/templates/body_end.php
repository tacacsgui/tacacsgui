	 <!-- MAIN CONTENT -->
	</section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

      <!-- Your Page Content Here -->
<?php require __DIR__ . '/parts/footer.php';?>

<?php require __DIR__ . '/parts/sidebar_right.php';?>

</div>
<!-- ./wrapper -->

<div class="modal modal-warning fade" id="ha-attention">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title text-center">Attention!</h4>
      </div>
      <div class="modal-body text-center">
				<form class="" method="post">
					<h1>Server in <u>Read ONLY mode</u>.</h1>
					<h1>High Availability role: <u>Slave</u>.</h1>
					<h3>Status: <u class="ha_status"></u></h3>
					<p class="ha_status_mysql"></p>
				</form>
      </div>
			<div class="modal-footer">
        <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


<!-- Link to API, you can set it in config.php -->
<script>var API_LINK = '<?php echo API_LINK;?>'</script>
