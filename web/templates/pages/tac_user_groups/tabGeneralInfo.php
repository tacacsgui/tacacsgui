			<div class="row">
			<div class="col-lg-6 col-md-6">
				<div class="form-group name">
					<label for="name">Name</label>
					<input type="text" class="form-control" name="name" data-type="input" data-default="" data-pickup="true" placeholder="Enter Group Name" autocomplete="off">
					<p class="help-block">it should be unique and you can change it later</p>
					<input type="hidden" name="name_native" data-type="input" data-default="" value="">
					<input type="hidden" name="id" data-type="input" data-default="" data-pickup="true" value="">
        </div>
      </div>
      </div>
			<div class="row">
				<div class="col-lg-6 col-md-6">
					<div class="form-group enable">
						<label for="enable">Enable Password</label>
						<input type="text" class="form-control" name="enable" data-type="input" data-default="" data-pickup="true" placeholder="Write Enable Password" value="" autocomplete="off">
						<input type="hidden" name="enable_native" value="">
					</div>
				</div>
				<div class="col-lg-6 col-md-6">
					<div class="form-group enable_flag">
						<label for="enable_flag">Enable Encryption</label>
						<select class="form-control" name="enable_flag" data-objtype="password" data-object="enable" data-type="select" data-default="1" data-pickup="true">
							<option value="0">Clear Text</option>
							<option value="1" selected>MD5</option>
							<!-- <option value="2">DES</option> -->
						</select>
						<input type="hidden" name="enable_flag_native" value="">
					</div>
				</div>
			</div>
			<div class="row enable_encrypt_section">
				<div class="col-lg-12">
					<div class="checkbox icheck">
						<label>
							<input type="checkbox" name="enable_encrypt" data-type="checkbox" data-default="checked" data-pickup="true" checked> Encrypt the enable password (hashing), uncheck it if you put hash
						</label>
						<p class="help-block">unchecked box will mean that you put encrypted (hashed) password</p>
						<input type="hidden" name="enable_encrypt_native" value="1">
					</div>
				</div>
			</div>
