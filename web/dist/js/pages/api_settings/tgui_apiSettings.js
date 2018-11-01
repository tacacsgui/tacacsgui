var tgui_apiSettings = {
  init: function(){

    var self = this;
    $('.nav-tabs a').on('hide.bs.tab', function(event){
      $('div.overlay').show();
    });

    this.time.init();

    $('div.icheck input[name="smtp_auth"]').on('ifChanged', function (event) {
      ( $(event.target).prop('checked') ) ? $('div.auth_params').show() : $('div.auth_params').hide();
    });

    $('.nav-tabs.api_settings a').on('shown.bs.tab', function(event){
      console.log(event.target.dataset.section);
      switch (event.target.dataset.section) {
        case 'time':
          self.time.init();
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
        case 'network':
          self.network.init();
          break;
        case 'ha':
          tgui_apiHA.init();
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
        ( resp.smtp.smtp_auth ) ? $('div.auth_params').show() : $('div.auth_params').hide();
        tgui_supplier.fulfillForm(resp.smtp, '#smtpForm');
        $('div.overlay').hide();
      }).fail(function(err){
        tgui_error.getStatus(err, ajaxProps);
      });
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
          tgui_error.local.show({type:'warning', message: "Changes did not found"});
          return;
        }
        if ( !Object.keys(ajaxProps.data).length ){
          tgui_error.local.show({type:'warning', message: "Changes did not found"});
          return;
        }
      }
      ajaxRequest.send(ajaxProps).then(function(resp) {
        if (tgui_supplier.checkResponse(resp.error, '#smtpForm')){
          return;
        }
        tgui_error.local.show({type:'success', message: "Policy Settings were saved"});
        self.get();
      }).fail(function(err){
        tgui_error.getStatus(err, ajaxProps);
      });
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
        $('pre.smtp_test_output').empty().append(resp.result);
      }).fail(function(err){
        tgui_error.getStatus(err, ajaxProps);
      });
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
        tgui_error.getStatus(err, ajaxProps);
      });
    },
    tac_log: function(target) {
      var self = this;
      target = target || '';
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
        tgui_error.getStatus(err, ajaxProps);
      });
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
        tgui_error.getStatus(err, ajaxProps);
      });
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
          tgui_error.local.show({type:'warning', message: "Changes did not found"});
          return;
        }
        if ( !Object.keys(ajaxProps.data).length ){
          tgui_error.local.show({type:'warning', message: "Changes did not found"});
          return;
        }
      }
      ajaxRequest.send(ajaxProps).then(function(resp) {
        if (tgui_supplier.checkResponse(resp.error, '#passwordPolicyForm')){
          return;
        }
        tgui_error.local.show({type:'success', message: "Policy Settings were saved"});
        self.get();
      }).fail(function(err){
        tgui_error.getStatus(err, ajaxProps);
      });
    }
  },
  time: {
    init: function(){
      this.timezones.init();
      this.get();
    },
    timezones:{
      init: function(){
        this.timezoneSelect2 = new tgui_select2({
          ajaxUrl : API_LINK+"settings/time/timezones/",
          template: this.selectionTemplate,
          add: '.select_timezone',
          edit: '',
        });

        $('.select_timezone').select2( this.timezoneSelect2.select2Data() );
      },
      selectionTemplate: function( data ){
        var output='<div class="selectAclOption">';
      		output += '<text>'+data.text+'</text>';
      		output += '</div>'
      	return output;
      }
    },
    getTime: function(){
      tgui_status.time().then(function(resp){
        $('time.current-time').text(resp.time);
      }).fail(function(err){
        tgui_error.getStatus(err, ajaxProps);
      });
    },
    get: function() {
      $('div.overlay').show();
      var self = this;

      var ajaxProps = {
        url: API_LINK + "settings/time/",
        type: "GET"
      };//ajaxProps END

      ajaxRequest.send(ajaxProps).then(function(resp) {
        tgui_supplier.fulfillForm(resp.time, '#timeSettings');
        self.timezones.timezoneSelect2.preSelection(resp.time.timezone, 'add');
        $('#timeSettings' + ' input[name="timezone_native"]').val(resp.time.timezone);
        self.getTime();
        $('div.overlay').hide();
      }).fail(function(err){
        tgui_error.getStatus(err, ajaxProps);
      });
    },
    save: function() {
      $('div.overlay').show();
      var self = this;

      var formData = tgui_supplier.getFormData('#timeSettings', true);
          if ($('.select_timezone').select2('data').length && ( parseInt($('.select_timezone').select2('data')[0].id) != parseInt($('#timeSettings' + ' [name="timezone_native"]').val() ) ) ) {formData.timezone = $('.select_timezone').select2('data')[0].id;}

      var ajaxProps = {
        url: API_LINK + "settings/time/",
        data: formData
      };//ajaxProps END

      if ( Object.keys(ajaxProps.data).length == 0) {
        tgui_error.local.show({type:'warning', message: "Changes did not found"});
        $('div.overlay').hide();
        return;
      }

      ajaxRequest.send(ajaxProps).then(function(resp) {
        if (tgui_supplier.checkResponse(resp.error, '#timeSettings')){
          return;
        }
        tgui_error.local.show({type:'success', message: "Settings saved"});
        self.get();
        $('div.overlay').hide();
      }).fail(function(err){
        tgui_error.getStatus(err, ajaxProps);
      });
    },
    status: function() {
      var ajaxProps = {
        url: API_LINK + "settings/time/status/",
        type: 'get'
      };//ajaxProps END

      ajaxRequest.send(ajaxProps).then(function(resp) {
        $('pre.ntp-check').empty().append(resp.output);
      }).fail(function(err){
        tgui_error.getStatus(err, ajaxProps);
      });
    }
  },
  network: {
    init: function() {
      var self = this;

      Promise.resolve(this.list()).then(function(resp) {
        self.get();
      });


    },
    list: function( o ) {
      o = o || {};
      o.ip = o.ip || 0;
      o.section = o.section || 'default';
      var self = this;
      $('[name="network_interface"]').empty();
      var ajaxProps = {
        url: API_LINK + "settings/network/interface/list/",
        type: "GET",
        data: { ip: o.ip }
      };//ajaxProps END
      return new Promise(
        function (resolve, reject) {
          ajaxRequest.send(ajaxProps).then(function(resp) {
            switch (o.section) {
              case 'ha':
                $.each(resp.list, function(key, value) {
                  var temp = value.split("-");
                  $('[name="interf_ip"]').empty().append($("<option></option>").attr("value",value).attr("data-interf",temp[0]).text(value));
                });
                break;
              default:
                $.each(resp.list, function(key, value) {
                  $('[name="network_interface"]').append($("<option></option>").attr("value",value).text(value));
                });
            }
            resolve(true);
          }).fail(function(err){
            tgui_error.getStatus(err, ajaxProps);
            resolve(true);
          }
        );
      });
    },
    get: function(){
      $('div.overlay').show();
      this.clearForm();
      var ajaxProps = {
        url: API_LINK + "settings/network/interface/",
        type: "GET",
        data: { interface: $('[name="network_interface"]').val() }
      };//ajaxProps END
        ajaxRequest.send(ajaxProps).then(function(resp) {
          tgui_supplier.fulfillForm(resp.interface, '#networkForm');
          $('div.overlay').hide();
        }).fail(function(err){
          tgui_error.getStatus(err, ajaxProps);
        });
    },
    save: function(){
      $('div.overlay').show();
      var self = this;

      var formData = tgui_supplier.getFormData('#networkForm', true);

      delete formData.network_interface;

      if ( Object.keys(formData).length == 0) {
        tgui_error.local.show({type:'warning', message: "Changes did not found"});
        $('div.overlay').hide();
        return;
      }

      var ajaxProps = {
        url: API_LINK + "settings/network/interface/",
        data: tgui_supplier.getFormData('#networkForm', false)
      };//ajaxProps END

      ajaxRequest.send(ajaxProps).then(function(resp) {
        if (tgui_supplier.checkResponse(resp.error, '#timeSettings')){
          $('div.overlay').hide();
          return;
        }
        tgui_error.local.show({type:'success', message: "Settings saved"});
        self.get();
        $('div.overlay').hide();
      }).fail(function(err){
        tgui_error.getStatus(err, ajaxProps);
      });
    },
    clearForm: function() {
      tgui_supplier.clearForm();
      /*---*/
    },
  }
};
