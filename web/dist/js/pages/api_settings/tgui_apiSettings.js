
var tgui_apiSettings = {
  init: function(){

    var self = this;
    $('.nav-tabs a').on('hide.bs.tab', function(event){
      $('div.overlay').show();
    });

    $('.nav-tabs.api_settings a').on('shown.bs.tab', function(event){
      console.log(event.target.dataset.section);
      switch (event.target.dataset.section) {
        case 'time':

          break;
        case 'smtp':
          self.smtp.get();
          break;
        case 'passwords':
          self.passwordPolicy.get();
          break;
        case 'logging':
          self.loogging();
          break;
        default:
        tgui_error.local.show({type:'error', message: 'Server Error'});
      }
    });

  },
  smtp: {
    get: function(){
      $('div.overlay').show();
      var self = this;

      var ajaxProps = {
        url: API_LINK + "settings/smtp/",
        type: "GET"
      };//ajaxProps END

      ajaxRequest.send(ajaxProps).then(function(resp) {
        tgui_supplier.fulfillForm(resp.smtp, '#smtpForm');
        $('div.overlay').hide();
      }).fail(function(err){
        tgui_error.getStatus(err, ajaxProps)
      })
    },
    save: function(){
      var self = this;
      var formData = tgui_supplier.getFormData('#smtpForm', true);
      var ajaxProps = {
        url: API_LINK + "settings/smtp/",
        data: formData
      };//ajaxProps END
      if ( Object.keys(ajaxProps.data).length <= 1) {
        if (Object.keys(ajaxProps.data)[0] == "id") {
          tgui_error.local.show({type:'warning', message: "Changes did not found"})
          return;
        }
        if ( !Object.keys(ajaxProps.data).length ){
          tgui_error.local.show({type:'warning', message: "Changes did not found"})
          return;
        }
      }
      ajaxRequest.send(ajaxProps).then(function(resp) {
        if (tgui_supplier.checkResponse(resp.error, '#smtpForm')){
          return;
        }
        tgui_error.local.show({type:'success', message: "Policy Settings were saved"})
        self.get();
      }).fail(function(err){
        tgui_error.getStatus(err, ajaxProps)
      })
    },
    test: function(){
      var self = this;
      $('pre.smtp_test_output').empty().append( tgui_supplier.loadElement() );
      var formData = tgui_supplier.getFormData('#testSmtpForm', true);
      var ajaxProps = {
        url: API_LINK + "settings/smtp/test/",
        data: formData
      };//ajaxProps END

      ajaxRequest.send(ajaxProps).then(function(resp) {
        if (tgui_supplier.checkResponse(resp.error, '#testSmtpForm')){
          return;
        }
        $('pre.smtp_test_output').empty().append(resp.result)
      }).fail(function(err){
        tgui_error.getStatus(err, ajaxProps)
      })
    }
  },
  loogging: function(){
    $('#logging-folder-tree').fileTree({
      root: '/',
      script: API_LINK + 'tacacs/reports/tree/',
    });
    $('div.overlay').hide();
  },
  delete: {
    api_log: function() {
      var self = this;
      var period = $('select[name="api_log_date"]').val();
      if (!confirm('Do you want to do that?')) return;
      if (!confirm('Really?')) return;
      var ajaxProps = {
        url: API_LINK + "logging/delete/",
        data: {
          period: period,
        }
      };//ajaxProps END

      ajaxRequest.send(ajaxProps).then(function(resp) {
        if (resp.result == 0){
          tgui_error.local.show({type:'warning', message: 'Entries not Found'});
          return;
        }
        if (parseInt(resp.result) > 0){
          tgui_error.local.show({type:'success', message: resp.result + ' entries were deleted'});
          return;
        }
        tgui_error.local.show({type:'error', message: 'Server Error'});
      }).fail(function(err){
        tgui_error.getStatus(err, ajaxProps)
      })
    },
    tac_log: function(target) {
      var self = this;
      var target = target || '';
      var period = $('select[name="tac_log_'+target+'"]').val();
      if (!confirm('Do you want to do that?')) return;
      if (!confirm('Really?')) return;
      var ajaxProps = {
        url: API_LINK + "tacacs/reports/delete/",
        data: {
          period: period,
          target: target,
        }
      };//ajaxProps END

      ajaxRequest.send(ajaxProps).then(function(resp) {
        if (resp.result == 0){
          tgui_error.local.show({type:'warning', message: 'Entries not Found'});
          return;
        }
        if (parseInt(resp.result) > 0){
          tgui_error.local.show({type:'success', message: resp.result + ' entries were deleted'});
          return;
        }
        tgui_error.local.show({type:'error', message: 'Server Error'});
      }).fail(function(err){
        tgui_error.getStatus(err, ajaxProps)
      })
    }
  },
  passwordPolicy: {
    get: function(){
      $('div.overlay').show();
      var self = this;

      var ajaxProps = {
        url: API_LINK + "settings/pwpolicy/",
        type: "GET"
      };//ajaxProps END

      ajaxRequest.send(ajaxProps).then(function(resp) {
        tgui_supplier.fulfillForm(resp.policy, '#passwordPolicyForm');
        $('div.overlay').hide();
      }).fail(function(err){
        tgui_error.getStatus(err, ajaxProps)
      })
    },
    save: function(){
      var self = this;
      var formData = tgui_supplier.getFormData('#passwordPolicyForm', true);
      var ajaxProps = {
        url: API_LINK + "settings/pwpolicy/",
        data: formData
      };//ajaxProps END
      if ( Object.keys(ajaxProps.data).length <= 1) {
        if (Object.keys(ajaxProps.data)[0] == "id") {
          tgui_error.local.show({type:'warning', message: "Changes did not found"})
          return;
        }
        if ( !Object.keys(ajaxProps.data).length ){
          tgui_error.local.show({type:'warning', message: "Changes did not found"})
          return;
        }
      }
      ajaxRequest.send(ajaxProps).then(function(resp) {
        if (tgui_supplier.checkResponse(resp.error, '#passwordPolicyForm')){
          return;
        }
        tgui_error.local.show({type:'success', message: "Policy Settings were saved"})
        self.get();
      }).fail(function(err){
        tgui_error.getStatus(err, ajaxProps)
      })
    }
  }
}
