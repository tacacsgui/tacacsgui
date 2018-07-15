<div class="box box-solid">
	<div class="box-body">
		<div class="row">
			<div class="col-sm-6">
				<h4>Save all data as CSV table</h4>
				<div class="csv-link">
					<p>&lt;Link will appeared here&gt;</p>
				</div>
				<br>
				<button type="button" class="btn btn-success btn-flat" onclick="<?php echo $jsMainObjName; ?>.csvParser.csvDownload()">Save as CSV</button>
			</div>
			<div class="col-sm-6">
				<div class="form-group">
	        <label for="file">File input</label>
	        <input type="file" name="csv-file" id="csv-file">
	        <p class="help-block">file must have header</p>
	      </div>
				<div class="form-group">
	        <label for="file">Separator</label>
					<div class="">
						<label class="radio-inline"><input type="radio" name="separator" value="," checked>,</label>
						<label class="radio-inline"><input type="radio" name="separator" value=";">;</label>
					</div>
	      </div>
				<button type="button" class="btn btn-warning btn-flat" onclick="<?php echo $jsMainObjName; ?>.csvParser.read()">Upload CSV</button>
			</div>
		</div>
		<div class="csvParserOutput">
			<hr>
			<pre id="csvParserOutput">CSV Parser Output</pre>
		</div>
	</div>
</div>
