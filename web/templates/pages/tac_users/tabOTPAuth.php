<input type="hidden" data-type="input" data-default="0" name="tab_event_status" value="0">
<div class="row ">
<div class="col-md-6">
<div class="form-group otp_enabled">
	<div class="checkbox icheck">
		<label>
			<input type="checkbox" name="mavis_otp_enabled" data-type="checkbox" data-default="" data-pickup="true" checked> Enable OTP Auth
			<input type="hidden" name="mavis_otp_enabled_native" value="">
		</label>
		<p class="help-block">if you check it, it will mean that that user can be authenticated only with this way</p>
	</div>
</div>
</div>
<div class="col-md-6">
<div class="form-group global_status">
		<label>Global Settings</label>
		<p>Status: <b>Loading...</b></p>
		<p class="help=block">you can change that status <a href="/mavis_otp.php">here</a></p>
</div>
</div>
</div>

<div class="row">
<div class="col-lg-12">
<div class="form-group">
	<label>Secret Key</label>
	<div class="input-group margin">
		<input type="text" class="form-control otp_secret" name="mavis_otp_secret" data-type="input" data-default="" data-pickup="true" disabled>
		<input type="hidden" name="mavis_otp_secret_native" value="">
		<span class="input-group-btn">
			<button type="button" class="btn btn-warning btn-flat" onclick="(confirm('Are you sure?')) ? tgui_tacUser.getOtpUrl('new') : console.log('ok')">Generate New</button>
		</span>
	</div>
</div>
</div>
</div>

<div class="row">
<div class="col-lg-12">
<div class="form-group">
	<label>QRCode</label>
	<div id="qrcode" class="text-center"><h2>Loading...</h2></div>
</div>
</div>
</div>

<div class="row">
	<div class="col-md-4">
		<div class="form-group mavis_otp_period">
			<label>Period</label>
			<input type="number" class="form-control period" name="mavis_otp_period" data-type="input" data-default="" data-pickup="true" onchange="tgui_tacUser.getOtpUrl()" placeholder="Period"/>
			<input type="hidden" name="mavis_otp_period_native" value="">
			<p class="help-block">period of generating OTP. By default, the period for a TOTP is 30 seconds</p>
        </div>
	</div>
	<div class="col-md-4">
		<div class="form-group mavis_otp_digits">
			<label>Digits</label>
			<input type="number" class="form-control digits" name="mavis_otp_digits" data-type="input" data-default="" data-pickup="true" onchange="tgui_tacUser.getOtpUrl()" placeholder="Digits"/>
			<input type="hidden" name="mavis_otp_digits_native" value="">
			<p class="help-block">by default the number of digits is 6, more than 10 may be difficult to use by the owner</p>
        </div>
	</div>
	<div class="col-md-4">
		<div class="form-group mavis_otp_digest">
			<label>Digest</label>
			<select class="form-control digest" name="mavis_otp_digest" data-type="select" data-default="" data-pickup="true" onchange="tgui_tacUser.getOtpUrl()">
				<option value="sha1" selected>sha1</option>
				<option value="md5">md5</option>
			</select>
			<input type="hidden" name="mavis_otp_digest_native" value="">
			<p class="help-block">if you don't know what to choose leave it as default (first value)</p>
        </div>
	</div>
</div>

<div class="form-group">
<div class="row">
<div class="col-lg-12 text-center">
	<div class="form-group">
		<p>It is time based parameter, synchronize your time before use it</p>
		<p>Current server time is <b><time class="current-time text-warning"></time></b></p>
		<button type="button"class="btn btn-warning btn-flat" onclick="tgui_tacUser.getTime()">Check it again</button>
	</div>
</div>
</div>
</div>
