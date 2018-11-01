var tgui_change_passwd = {
  formId: '#tac_change_passwd_Form',
  formChangePWId: '#chngPaswdForm',
  init: function() {
    this.getInfo();
  },
  getInfo: function(){
    var self = this;
    var ajaxProps = {
      url: API_LINK+"auth/singin/",
      type: "GET"
    };//ajaxProps END
    ajaxRequest.send(ajaxProps).then(function(resp) {
      if ( !resp.tacacs ) window.location.replace('/');
      if (resp.authorised) window.location.replace('/dashboard.php');
    }).fail(function(err){
      if (! err.responseJSON.tacacs) window.location.replace('/');
      $('tacversion').text(err.responseJSON.info.version.TACVER);
      $('apiversion').text(err.responseJSON.info.version.APIVER);
      $('guiversion').text(GUIVER);
      $('div#version_info').removeClass('hidden');
      if ( err.responseJSON.tacacs ) $('div.loading').hide();
      //self.blockForm();
    })
  },
  login: function(){
    this.blockForm(true);
		this.errorBanner();
		var self = this;
    var formData = tgui_supplier.getFormData(self.signinForm);
    //formData.object = 'login';
    var self = this;
    var ajaxProps = {
      url: API_LINK+"tacacs/user/change_passwd/change/",
      type: "POST",
      data: formData
    };//ajaxProps END
    ajaxRequest.send(ajaxProps).then(function(resp) {
      if ( tgui_supplier.checkResponse(resp.error, self.formId )){
				self.blockForm();
				if (resp.error.message) self.errorBanner(resp.error.message);
			  return;
      }
      if (!resp.success) self.errorBanner('Internal Error!');
      $('username').text(' ' + formData.username)
      $('password_type').text(formData.object + ' ')
      $(self.formId).hide();
      $(self.formChangePWId).show();

      self.blockForm();
    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps)
    })
    return false;
  },
  blockForm: function(action){
    action = action || false;
    if (action) $('div.form_block').show();
    else $('div.form_block').hide();
    return true;
  },
  errorBanner: function(message){
    message = message || false
    if (!message) { $('div.alert.alert-danger').hide(); return; }
    $('div.alert.alert-danger').empty().append('<p>'+message+'</p>').show();
  },
}
