
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
    			$('code.tacacs_config').append(self.lineNumber()).append('} <tac_comment>##END OF SPAWND</tac_comment>').append('\n');
    			//SPAWND //END//
    			/////////////////////
    			//TACACS GENERAL CONF //START//
    			$('code.tacacs_config').append(self.lineNumber()).append('id = tac_plus { <tac_comment>##START GLOBAL CONFIGURATION</tac_comment>').append('\n');
    			self.confParser(resp['tacGeneralConfig'])
    			//TACACS GENERAL CONF //END//
    			/////////////////////
    			//MAVIS GENERAL SETTINGS //START//
    			self.confParser(resp['mavisGeneralConfig'])
    			//MAVIS GENERAL SETTINGS //END//
          /////////////////////
    			//ACL LIST //START//
    			self.confParser(resp['tacACL'])
    			//ACL LIST //END//
    			/////////////////////
    			//DEVICE GROUP LIST //START//
    			self.confParser(resp['deviceGroupsConfig'])
    			//DEVICE GROUP LIST //END//
    			/////////////////////
    			//DEVICE LIST //START//
    			self.confParser(resp['devicesConfig'])
    			//DEVICE LIST //END//
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
    			$('code.tacacs_config').append(self.lineNumber()).append('}##END GLOBAL CONFIGURATION').append('\n');
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
          $('code.tacacs_config').append(this.lineNumber()).append(some[someLine].replace(/\n/g,'\n'))
            .append('\n')
          continue;
        }
        if (some.length == someLine+1)
        {
          $('code.tacacs_config').append(this.lineNumber()).append(some[someLine].replace(/\n/g,'\n'))
            .append('\n');
        } else
        {
          //console.log(some);
          var s_lines = some[someLine].split("\n");
          for (var i = 0; i < s_lines.length; i++) {
            $('code.tacacs_config').append(this.lineNumber()).append(s_lines[i]).append('\n');
          }
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

    mainIcon.removeClass('bg-green bg-red bg-gray fa-gears fa-circle-o-notch fa-spin fa-exclamation-circle')
    successIcon.hide(); errorIcon.hide();
    messageBody.empty().append('Output of test will appear here...');

    if (status == 'loading') {
      mainIcon.addClass('bg-gray fa-circle-o-notch fa-spin');
      return true;
    }
    if (status == 'hide') {
      mainIcon.addClass('bg-gray fa-gears');
      return true;
    }
    if (status == 'success')
    {
      mainIcon.addClass('bg-green fa-gears');
      successIcon.show();
      messageBody.empty().append(text);
      return true;
    }
    if (status == 'error')
    {
      mainIcon.addClass('bg-red fa-exclamation-circle')
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

    mainIcon.removeClass('bg-green bg-red bg-gray fa-save fa-circle-o-notch fa-spin fa-exclamation-circle')
    endofTimelineIcon.removeClass('bg-green fa-check').addClass('bg-gray fa-clock-o')
    successIcon.hide(); errorIcon.hide();
    messageBody.empty().append('Output of the save process will appear here...');

    if (status == 'hide') {
      mainIcon.addClass('bg-gray fa-save')
      return true;
    }
    if (status == 'loading') {
      mainIcon.addClass('bg-gray fa-circle-o-notch fa-spin')
      return true;
    }
    messageBody.empty().append('<pre>'+text+'</pre>');
    // if (slaves.length)
    // {
    //   console.log(slaves);
    //   messageBody.append('<h4>Apply Configuration for Slave</h4><table class="table table-striped tableSlavesHa"><tr><td>Address</td><td>Status</td><td>API Check</td><td>DB Check</td><td>Apply Status</td></tr></table>');
    //   for (var i = 0, len = slaves.length; i < len; i++) {
    //     slaves[i].response = slaves[i].response || [];
    //     if ( ! slaves[i].response[0] ) slaves[i].response[0] = { applyStatus: {} };
    //     if ( ! slaves[i].response[0].applyStatus ) slaves[i].response[0].applyStatus = { error: undefined };
    //     $('table.tableSlavesHa').append(
    //       '<tr><td>'+slaves[i].ip+'</td><td>'+
    //       ((slaves[i].response[1]) ? slaves[i].response[1] : 'Unreachable!!') +'</td><td><b>'+
    //       ((slaves[i].response[0].version_check) ? '<text class="text-success">Ok':'<text class="text-danger">Error')+'</text></b></td><td><b>'+
    //       ((slaves[i].response[0].db_check) ? '<text class="text-success">Ok':'<text class="text-danger">Error')+'</text></b></td><td><b>'+
    //       ((slaves[i].response[0].applyStatus.error!=undefined && !slaves[i].response[0].applyStatus.error) ? '<text class="text-success">Ok':'<text class="text-danger">Error')+'</text></b></td></tr>');
    //   }
    //
    // }
    if (status == 'success')
    {
      mainIcon.addClass('bg-green fa-save')
      successIcon.show();
      //messageBody.empty().append(text);
      endofTimelineIcon.removeClass('bg-gray fa-clock-o').addClass('bg-green fa-check')
      return true;
    }
    if (status == 'error')
    {
      mainIcon.addClass('bg-red fa-exclamation-circle')
      errorIcon.show();
      //messageBody.empty().append('<pre>'+text+'</pre>');
      return false;
    }
    return false;
  },
  testConf: function(o){
    $('errorMessage').remove()
    var l = (o) ? Ladda.create(o) : {start: function() {return false;}, stop: function() {return false;}};
    l.start();
    var self = this;
    this.testConfMethod('loading','false')
    this.applyConfMethod('hide','false')

    return new Promise(
      function (resolve, reject) {
        var ajaxProps = {
          url: API_LINK+"tacacs/config/apply/",
          type: 'GET',
          data: {contentType: 'json', confTest: "on",}
        };//ajaxProps END

        ajaxRequest.send(ajaxProps).then(function(resp) {
          l.stop();
          if (!resp.confTest.error)
          {
            self.testConfMethod('success',resp.confTest.message)
            resolve(true);
            return;
          }
          var someErrorText = (resp.confTest.message) ? resp.confTest.message : 'Unknown error :(';
          //self.applyConfMethod('error',someErrorText)
          self.testConfMethod('error',someErrorText)
          if (resp.confTest.errorLine != undefined) {
            $('line#line_num_'+resp.confTest.errorLine).append('<errorMessage><i class="fa  fa-exclamation-triangle"></i> Error here!</errorMessage>')
            $('errorMessage').addClass('shakeIt');
          }
          reject(true);
        }).fail(function(err){
          reject(true);
          tgui_error.getStatus(err, ajaxProps)
        })
      })

  },
  applyConf: function(o) {
    $('errorMessage').remove()
    self = this;
    var l = (o) ? Ladda.create(o) : {start: function() {return false;}, stop: function() {return false;}};
    l.start();
    this.testConfMethod('hide','false')
    this.applyConfMethod('hide','false')

    Promise.resolve( self.testConf() )
      .then( function(){
        self.applyConfMethod('loading','false')
        Promise.resolve( self.applyConfigMain() )
        .then( function(resp){
          console.log(resp, 'success');
          if (resp.ha_role == "master") {
            $('.applyConfigurationItem div.applyItemBody').append('</hr><h4>High Availability status: <u>Master</u></h4>');
            if ( jQuery.isEmptyObject(resp.server_list.slave) ){
              $('.applyConfigurationItem div.applyItemBody').append('<div class="callout callout-warning"><h4><i class="icon fa fa-warning"></i>There is no connected slave!</h4></div>');
              l.stop();
              return;
            } ///no slaves. Exit!
            console.log('There are slaves.');
            self.slaveTable(resp.server_list.slave);
          }
          l.stop();
        })
        .catch( function(resp){
          console.log(resp, 'bad');
          l.stop();
        })
        //
      })
      .catch(function() {
        l.stop();
      });



  },
  applyConfigMain: function() {
    return new Promise(
      function (resolve, reject) {
        var ajaxProps = {
          url: API_LINK+"tacacs/config/apply/",
          type: 'GET',
          data: {
            contentType: 'json',
            confTest: "on",
            confSave: "yes",
            doBackup: $('input[name="tcfgSet"]').prop('checked')
          }
        };//ajaxProps END

        ajaxRequest.send(ajaxProps).then(function(resp) {

          if (resp.applyStatus.error)
          {
            reject(resp)
            self.applyConfMethod('error',resp.applyStatus.message)
            return;
          }

          var params = { text: resp.applyStatus.message };

          //if (resp.server_list_response) params.slaves = resp.server_list_response;
          //resp.server_list.slave = [];
          //onsole.log(resp);
          resolve(resp);
          self.applyConfMethod('success', params)
          tgui_status.changeStatus(0)
        }).fail(function(err){
          tgui_error.getStatus(err, ajaxProps)
        })
      }
    )//end of new promise
  },//end of method
  slaveTable: function(slaves) {
    slaves = slaves || {}
    var table = "</hr>"+'<div class="table-responsive"><table class="table table-striped slave-list" style="font-size:18px;"><thead><tr><td>ID</td><td>IP</td><td>DB</td><td>API</td><td>Apply</td></tr></thead><tbody>';
    for (var slave in slaves) {
      if (slaves.hasOwnProperty(slave)) {
        console.log(slave, slaves[slave]);
        table += '<tr class="slave_'+ slave +'"><td>'+ slave +'</td> <td class="ipddr">'+ slaves[slave]['ipaddr'] +'</i></td> <td class="db_check"><i class="fa fa-thumbs-o-down fa-spin"></i></td> <td class="api_check"><i class="fa fa-thumbs-o-down fa-spin"></i></td> <td class="apply_check"><i class="fa fa-thumbs-o-down fa-spin"></i></td></tr>'
      }
    }
    $('.applyConfigurationItem div.applyItemBody').append(table + '</tbody></table></div>');
    for (var slave in slaves) {
      if (slaves.hasOwnProperty(slave)) {
        this.applyConfigSlave(slave);
      }
    }
  },
  applyConfigSlave: function(sid){
    var ajaxProps = {
      url: API_LINK+"tacacs/config/apply/slave/",
      data: { sid: sid }
    };//ajaxProps END

    ajaxRequest.send(ajaxProps).then(function(resp) {
      console.log(resp);
      if ( ! resp.server_response.responce ){

      }
      var s_resp = resp.server_response.responce;
      var table = 'table.slave-list';
      var sid = s_resp.slave_cfg.slave_id;
      var tr = table + ' tr.slave_'+sid+' '
      var db_check = tr +' td.db_check i';
      var db_check = tr +' td.db_check i';
      var api_check = tr +' td.api_check i';
      var apply_check = tr +' td.apply_check i';

      if ( s_resp.db_check ) $(db_check).removeClass('fa-thumbs-o-down fa-spin').addClass('fa-thumbs-o-up text-success');
      else $(db_check).removeClass('fa-spin').addClass('text-danger');
      if ( s_resp.api_check ) $(api_check).removeClass('fa-thumbs-o-down fa-spin').addClass('fa-thumbs-o-up text-success');
      else $(api_check).removeClass('fa-spin').addClass('text-danger');
      if ( !s_resp.db_check || !s_resp.api_check ) {
        $(apply_check).removeClass('fa-spin').addClass('text-warning');
        var message = 'Unknown Error! :( ';
        if ( !s_resp.db_check ) message = 'Database does not synced! Sorry.';
        if ( !s_resp.api_check ) message = 'Slave use different api version with master! Sorry.'+"\n Master version: "+resp.info.version.APIVER+"\n Slave version: "+s_resp.apiver;
        $('<tr class="bg-danger"><td colspan="5">Message from Slave: </p><pre>'+message+'</pre></td></tr>').insertAfter( $(tr) );
        return false;
      }
      if ( s_resp.applyStatus && !s_resp.applyStatus.error ) {
        $(apply_check).removeClass('fa-thumbs-o-down fa-spin').addClass('fa-thumbs-o-up text-success');
        $(tr).addClass('bg-success');
        $('<tr class="bg-success"><td colspan="5">Message from Slave: </p><pre>'+s_resp.applyStatus.message+'</pre></td></tr>').insertAfter( $(tr) );
        return true;
      }
      var message = 'Unknown Error! :( ';
      if ( s_resp.applyStatus && s_resp.applyStatus.message ){
        message = s_resp.applyStatus.message;
      }
      $('<tr class="bg-danger"><td colspan="5">Message from Slave: </p><pre>'+message+'</pre></td></tr>').insertAfter( $(tr) );
      //console.log(resp);
    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps)
    })
  }
}
