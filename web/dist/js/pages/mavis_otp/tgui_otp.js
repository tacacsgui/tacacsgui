
var tgui_otp = {
  formSelector: '',
  init: function() {
    var self = this;
    this.getTime();

    return Promise.resolve(this.fulfill());
  },
  fulfill: function() {
    var self = this;
    var ajaxProps = {
      url: API_LINK+"mavis/otp/",
      type: "GET"
    };//ajaxProps END

    return new Promise(
      function (resolve, reject) {
        ajaxRequest.send(ajaxProps).then(function(resp) {
          tgui_supplier.fulfillForm(resp.OTP_Params, '');
          (resp.OTP_Params.enabled) ? $('div.disabled_shield').hide() : $('div.disabled_shield').show()
          resolve(true);
        }).fail(function(err){
          tgui_error.getStatus(err, ajaxProps)
        })
      }
    );
  },
  save: function() {
    console.log('Edit OTP Settings');
    var self = this;
    var formData = tgui_supplier.getFormData(self.formSelector, true);

    var ajaxProps = {
      url: API_LINK+"mavis/otp/",
      type: 'POST',
      data: formData
    };//ajaxProps END
    
    if ( ! tgui_supplier.checkChanges(ajaxProps.data, ['id']) ) return false;

    ajaxRequest.send(ajaxProps).then(function(resp) {
      if (tgui_supplier.checkResponse(resp.error, self.formSelector)){
        return;
      }
      tgui_error.local.show({type:'success', message: "OTP settings was saved"})
      tgui_status.changeStatus(resp.changeConfiguration)
      self.fulfill();
    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps)
    })
    return this;
  },
  getTime: function(){
    tgui_status.time().then(function(resp){
      $('time.current-time').text(resp.time);
    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps)
    });
  },
  tester: function() {
    $('pre.check_result').empty();
    $('pre.check_result').append( tgui_supplier.loadElement() );

    var self = this;
    var formData = {};
        formData.username = $('[name="username"]').val();
        formData.ot_password = $('[name="ot_password"]').val();

    var ajaxProps = {
      url: API_LINK+"mavis/otp/check/",
      type: 'POST',
      data: formData
    };//ajaxProps END

    ajaxRequest.send(ajaxProps).then(function(resp) {
      $('pre.check_result').empty();
      if (tgui_supplier.checkResponse(resp.error, self.formSelector)){
        $('pre.check_result').append('Error');
        return;
      }
			$('pre.check_result').append(resp.check_result);
    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps)
    })
    return this;

  }
}
