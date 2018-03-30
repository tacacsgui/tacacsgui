<div class="row otp_enabled">
<div class="col-lg-12">
<div class="form-group">
	<div class="checkbox icheck">
		<label>
			<input type="checkbox" name="otp_enabled" checked> Enable OTP Auth
		</label>
		<p class="help-block">if you check it, it will mean that that user can be authenticated only with this way</p>
	</div>
</div>
</div>
</div>

<div class="row">
<div class="col-lg-12">
<div class="form-group">
	<label>Secret Key</label>
	<div class="input-group margin">
		<input type="text" class="form-control otp_secret" name="otp_secret" disabled>
		<span class="input-group-btn">
			<button type="button" class="btn btn-warning btn-flat" onclick="(confirm('Are you sure?')) ? generateOTPSecret('') : console.log('ok')">Generate New</button>
		</span>
	</div>
</div>
</div>
</div>

<div class="row">
<div class="col-lg-12">
<div class="form-group">
	<label>QRCode</label>
	<div id="qrcode" class="text-center"></div>
</div>
</div>
</div>

<div class="row">
	<div class="col-md-4">
		<div class="form-group period">
			<label>Period</label>
			<input type="number" class="form-control period" onchange="generateOTPSecret('')" placeholder="Period"/>
			<p class="help-block">period of generating OTP. By default, the period for a TOTP is 30 seconds</p>
        </div>
	</div>
	<div class="col-md-4">
		<div class="form-group digits">
			<label>Digits</label>
			<input type="number" class="form-control digits" onchange="generateOTPSecret('')" placeholder="Digits"/>
			<p class="help-block">by default the number of digits is 6, more than 10 may be difficult to use by the owner</p>
        </div>
	</div>
	<div class="col-md-4">
		<div class="form-group digest">
			<label>Digest</label>
			<select class="form-control digest" onchange="generateOTPSecret('')">
				<option value="sha1" selected>sha1</option>
				<option value="md5">md5</option>
			</select>
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
		<button type="button"class="btn btn-warning btn-flat" onclick="getCurrentTime()">Check it again</button>
	</div>
</div>
</div>
</div>