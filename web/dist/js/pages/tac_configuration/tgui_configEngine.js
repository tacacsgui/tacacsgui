
var tgui_configEngine = {
  line_number_span: "",
  line_number: 0,
  init: function() {
    var self = this;

    this.fulfillForm();

    return Promise.resolve(this.getConfig());
  },
  fulfillForm: function() {
    var ajaxProps = {
      url: API_LINK+"backup/settings/",
      type: "GET",
    };//ajaxProps END
    ajaxRequest.send(ajaxProps).then(function(resp) {
      tgui_supplier.fulfillForm(resp.settings, '#testAndApplyForm');

    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps)
    })
  },
  getConfig: function(){
    var self = this;
    this.line_number_span = "";
    this.line_number = 0;
    var ajaxProps = {
      url: API_LINK+"tacacs/config/generate/",
      type: 'GET',
      data: {html: true}
    };//ajaxProps END
    return new Promise(
      function (resolve, reject) {
        ajaxRequest.send(ajaxProps).then(function(resp) {
    			//SPAWND //START//
    			$('pre.configurationFile').empty()
    			$('pre.configurationFile').append('<code class="tacacs_config language-none"></code>')
    			$('code.tacacs_config').append(self.lineNumber()).append('id = spawnd {').append('\n');
    			self.confParser(resp['spawndConfig'])
    			$('code.tacacs_config').append(self.lineNumber()).append('}').append('\n');
    			//SPAWND //END//
    			/////////////////////
    			//TACACS GENERAL CONF //START//
    			$('code.tacacs_config').append(self.lineNumber()).append('id = tac_plus {').append('\n');
    			self.confParser(resp['tacGeneralConfig'])
    			//TACACS GENERAL CONF //END//
    			/////////////////////
    			//MAVIS GENERAL SETTINGS //START//
    			self.confParser(resp['mavisGeneralConfig'])
    			//MAVIS GENERAL SETTINGS //END//
    			/////////////////////
    			//MAVIS Local SETTINGS //START//
    			self.confParser(resp['mavisLocalConfig'])
    			//MAVIS Local SETTINGS //END//
    			/////////////////////
    			//MAVIS OTP SETTINGS //START//
    			self.confParser(resp['mavisOTPConfig'])
    			//MAVIS OTP SETTINGS //END//
    			/////////////////////
    			//MAVIS SMS SETTINGS //START//
    			self.confParser(resp['mavisSMSConfig'])
    			//MAVIS SMS SETTINGS //END//
    			/////////////////////
    			//MAVIS LDAP SETTINGS //START//
    			self.confParser(resp['mavisLdapConfig'])
    			//MAVIS LDAP SETTINGS //END//
    			/////////////////////
    			//DEVICE GROUP LIST //START//
    			self.confParser(resp['deviceGroupsConfig'])
    			//DEVICE GROUP LIST //END//
    			/////////////////////
    			//DEVICE LIST //START//
    			self.confParser(resp['devicesConfig'])
    			//DEVICE LIST //END//
    			/////////////////////
    			//ACL LIST //START//
    			self.confParser(resp['tacACL'])
    			//ACL LIST //END//
    			/////////////////////
    			//USER GROUP LIST //START//
    			self.confParser(resp['userGroupsConfig'])
    			//USER GROUP LIST //END//
    			/////////////////////
    			/////////////////////
    			//USER LIST //START//
    			self.confParser(resp['usersConfig'])
    			//USER LIST //END//
    			///////////////////
    			$('code.tacacs_config').append(self.lineNumber()).append('}###END OF GLOBAL PARAMETERS').append('\n');
    			////END OF GLOBAL PARAMETERS////
    			$('code.tacacs_config').append('<span aria-hidden="true" class="line-numbers-rows"></span>')
    			$('span.line-numbers-rows').append(self.line_number_span)
          resolve(true);
        }).fail(function(err){
          tgui_error.getStatus(err, ajaxProps)
          resolve(true);
        })
      }
    );
  },
  confParser: function(arrayPart) {
    for (someArr = 0; someArr < arrayPart.length; someArr++)
    {
      var some = arrayPart[someArr];
      for (var someLine = 0; someLine < some.length; someLine++)
      {
        if (someLine == 0)
        {
          $('code.tacacs_config').append(this.lineNumber()).append(some[someLine]['name'])
            .append('\n');
          continue;
        }
        if (someLine == 1)
        {
          $('code.tacacs_config').append(this.lineNumber()).append('\t').append(some[someLine].replace(/\n/g,''))
            .append('\n')
          continue;
        }
        if (some.length == someLine+1)
        {
          $('code.tacacs_config').append(this.lineNumber()).append('\t').append(some[someLine].replace(/\n/g,''))
            .append('\n');
        } else
        {
          $('code.tacacs_config')
            .append(this.lineNumber())
            .append('\t')
            .append(some[someLine].replace(/\n/g,''))
            .append('\n');
        }
      }
    }
  },
  lineNumber: function() {
    this.line_number_span+='<span></span>';
  	this.line_number++
  	return '<line class="text-red" id="line_num_'+this.line_number+'"></line>';
  },
  testConfMethod: function(status,text) {
    var mainIcon = $('.testConfigurationItem i.testIcon')
    var successIcon = $('.testConfigurationItem i.testSuccess')
    var errorIcon = $('.testConfigurationItem i.testError')
    var messageBody = $('.testConfigurationItem div.testItemBody')

    mainIcon.removeClass('bg-green').removeClass('bg-red').addClass('bg-grey')
    successIcon.hide(); errorIcon.hide();
    messageBody.empty().append('Output of test will appear here...');

    if (status == 'hide') return true;

    if (status == 'success')
    {
      mainIcon.addClass('bg-green').removeClass('bg-red').removeClass('bg-grey')
      successIcon.show();
      messageBody.empty().append(text);
      return true;
    }
    if (status == 'error')
    {
      mainIcon.removeClass('bg-green').addClass('bg-red').removeClass('bg-grey')
      errorIcon.show();
      messageBody.empty().append('<pre>'+text+'</pre>');
      return false;
    }

    return false;
  },
  applyConfMethod: function(status,text) {
    var mainIcon = $('.applyConfigurationItem i.applyIcon')
    var endofTimelineIcon = $('.endOfTimeine i')
    var successIcon = $('.applyConfigurationItem i.applySuccess')
    var errorIcon = $('.applyConfigurationItem i.applyError')
    var messageBody = $('.applyConfigurationItem div.applyItemBody')
    var slaves = text.slaves || [];
    text = text.text || text;

    mainIcon.removeClass('bg-green').removeClass('bg-red').addClass('bg-grey')
    endofTimelineIcon.removeClass('bg-green fa-check').addClass('bg-grey fa-clock-o')
    successIcon.hide(); errorIcon.hide();
    messageBody.empty().append('Output of the save process will appear here...');

    if (status == 'hide') return true;
    messageBody.empty().append('<pre>'+text+'</pre>');
    if (slaves.length)
    {
      console.log(slaves);
      messageBody.append('<h4>Apply Configuration for Slave</h4><table class="table table-striped tableSlavesHa"><tr><td>Address</td><td>Status</td><td>API Check</td><td>DB Check</td><td>Apply Status</td></tr></table>');
      for (var i = 0, len = slaves.length; i < len; i++) {
        slaves[i].response = slaves[i].response || [];
        if ( ! slaves[i].response[0] ) slaves[i].response[0] = { applyStatus: {} };
        if ( ! slaves[i].response[0].applyStatus ) slaves[i].response[0].applyStatus = { error: undefined };
        $('table.tableSlavesHa').append(
          '<tr><td>'+slaves[i].ip+'</td><td>'+
          ((slaves[i].response[1]) ? slaves[i].response[1] : 'Unreachable!!') +'</td><td><b>'+
          ((slaves[i].response[0].version_check) ? '<text class="text-success">Ok':'<text class="text-danger">Error')+'</text></b></td><td><b>'+
          ((slaves[i].response[0].db_check) ? '<text class="text-success">Ok':'<text class="text-danger">Error')+'</text></b></td><td><b>'+
          ((slaves[i].response[0].applyStatus.error!=undefined && !slaves[i].response[0].applyStatus.error) ? '<text class="text-success">Ok':'<text class="text-danger">Error')+'</text></b></td></tr>');
      }

    }
    if (status == 'success')
    {
      mainIcon.addClass('bg-green').removeClass('bg-red').removeClass('bg-grey')
      successIcon.show();
      //messageBody.empty().append(text);
      endofTimelineIcon.removeClass('bg-grey fa-clock-o').addClass('bg-green fa-check')
      return true;
    }
    if (status == 'error')
    {
      mainIcon.removeClass('bg-green').addClass('bg-red').removeClass('bg-grey')
      errorIcon.show();
      //messageBody.empty().append('<pre>'+text+'</pre>');
      return false;
    }
    return false;
  },
  testConf: function(){
    $('errorMessage').remove()
    var self = this;
    this.testConfMethod('hide','false')
    this.applyConfMethod('hide','false')

    var ajaxProps = {
      url: API_LINK+"tacacs/config/generate/file/",
      type: 'GET',
      data: {contentType: 'json', confTest: "on",}
    };//ajaxProps END

    ajaxRequest.send(ajaxProps).then(function(resp) {
      if (!resp.confTest.error)
      {
        self.testConfMethod('success',resp.confTest.message)
        return;
      }
      var someErrorText = (resp.confTest.message) ? resp.confTest.message : 'Unknown error :(';
      self.applyConfMethod('error',someErrorText)
      if (resp.confTest.errorLine != undefined) {
        $('line#line_num_'+resp.confTest.errorLine).append('<errorMessage><i class="fa  fa-exclamation-triangle"></i> Error here!</errorMessage>')
        $('errorMessage').addClass('shakeIt');
      }
    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps)
    })

  },
  applyConf: function() {
    $('errorMessage').remove()
    self = this;
    this.testConfMethod('hide','false')
    this.applyConfMethod('hide','false')

    var ajaxProps = {
      url: API_LINK+"tacacs/config/generate/file/",
      type: 'GET',
      data: {
        contentType: 'json',
        confTest: "on",
        confSave: "yes",
        doBackup: $('input[name="tcfgSet"]').prop('checked')
      }
    };//ajaxProps END

    ajaxRequest.send(ajaxProps).then(function(resp) {
      if (resp.confTest.error)
      {
        self.testConfMethod('error',resp.confTest.message)
        if (resp.confTest.errorLine != undefined) {
          $('line#line_num_'+resp.confTest.errorLine).append('<errorMessage><i class="fa  fa-exclamation-triangle"></i> Error here!</errorMessage>')
          $('errorMessage').addClass('shakeIt');
        }
        return;
      }

      self.testConfMethod('success',resp.confTest.message)

      if (resp.applyStatus.error)
      {
        self.applyConfMethod('error',resp.applyStatus.message)
        return;
      }

      var params = { text: resp.applyStatus.message };

      if (resp.server_list_response) params.slaves = resp.server_list_response;
      console.log(params);
      self.applyConfMethod('success', params)
      tgui_status.changeStatus(0)
    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps)
    })
  }
}
