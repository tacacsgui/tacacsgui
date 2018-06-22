
var tgui_tacGlobal = {
  formSelector: '',
  init: function(resolve, reject){
    var self = this;
    this.daemon();

    return Promise.resolve(this.fulfill());
  },
  edit: function(){
    console.log('Edit Global Settings');
    var self = this;
    var formData = tgui_supplier.getFormData(self.formSelector, true);

    var ajaxProps = {
      url: API_LINK+"tacacs/config/global/edit",
      type: 'POST',
      data: formData
    };//ajaxProps END
    if ( Object.keys(ajaxProps.data).length <= 0) {
      tgui_error.local.show({type:'warning', message: "Changes did not found"})
      return;
    }
    ajaxRequest.send(ajaxProps).then(function(resp) {
      if (tgui_supplier.checkResponse(resp.error, self.formSelector)){
        return;
      }
      tgui_error.local.show({type:'success', message: "Global settings was saved"})
      tgui_status.changeStatus(resp.changeConfiguration)
      self.fulfill();
    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps)
    })
    return this;
  },
  daemon: function(action) {
    $('input[name="deamon_status"]').val('Loading...');
    var self = this;
    action = action || '';

    var ajaxProps = {
      url: API_LINK+"tacacs/config/deamon/",
      type: 'POST',
      data: {action: action}
    };//ajaxProps END

    ajaxRequest.send(ajaxProps).then(function(resp) {
      $('input[name="deamon_status"]').val(resp.tacacsStatusMessage);
    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps)
    })

    return true;
  },
  fulfill: function() {
    var self = this;
    var ajaxProps = {
      url: API_LINK+"tacacs/config/global/edit",
      type: "GET"
    };//ajaxProps END

    return new Promise(
      function (resolve, reject) {
        ajaxRequest.send(ajaxProps).then(function(resp) {
          tgui_supplier.fulfillForm(resp.global_variables, '');
          resolve(true);
        }).fail(function(err){
          tgui_error.getStatus(err, ajaxProps)
        })
      }
    );
  }
}
