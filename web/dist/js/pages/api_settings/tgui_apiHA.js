var tgui_apiHA = {
  init: function() {
    var self = this;

    Promise.resolve(tgui_apiSettings.network.list( {ip: 1, section:'ha'} )).then(function(resp) {
      self.get();
    });
  },
  get: function(){
    var self = this;
    $('div.overlay').show();
    var ajaxProps = {
      url: API_LINK + "settings/ha/",
      type: "GET"
    };//ajaxProps END
    ajaxRequest.send(ajaxProps).then(function(resp) {
      if (resp.result.server) tgui_supplier.fulfillForm(resp.result.server, '#haForm');
      if (resp.result.server_list) self.fulfillha(resp.result.server_list, resp.result.server.role);
      $('.ha_conf').hide();
      if (resp.result.server) { $('.ha_conf_' + resp.result.server.role).show(); }
      $('div.overlay').hide();
    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps);
    });
  },
  status: function(o) {
    $('pre.ha_save_log').empty();
    var self = this;
    var role = $('#haForm select[name="role"]').val();
    var l = Ladda.create(o);
    l.start();
    var ajaxProps = {
      url: API_LINK + "settings/ha/status/",
    };//ajaxProps END

    ajaxRequest.send(ajaxProps).then(function(resp) {
      //console.log(resp);
      var log = (resp.status.log) ? resp.status.log : {};
      if (log.messages) log.messages.forEach(function(entry) { self.appendLog(entry, true) });
      if (resp.status.tableRefresh) self.get();
      l.stop();
    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps);
    });
  },
  fulfillha: function(list, role) {
    $('table[name="ha_list"] tr').remove();
    var header = '<tr><td>Role</td><td>Address</td><td>Location</td><td>Status</td><td>Last Check</td>'+ ( (role == 'master') ? '<td>Action</td>' : '' ) +'</tr>';
    $('table[name="ha_list"]').append(header);
    list = list || [];
    if (list.master) {
      $('table[name="ha_list"]').append('<tr><td>Master</td><td>' + list.master.ipaddr + '</td><td>' + list.master.location + '</td><td>' + list.master.status + '</td><td>' + list.master.lastchk + '</td></tr>');
    }
    if ( list && Object.keys(list.slave).length !== 0 ) {
      for (var sid in list.slave) {
        if (list.slave.hasOwnProperty(sid)) {
          el = list.slave[sid];
          var button = '<td><button class="btn btn-flat btn-sm btn-danger ladda-button" data-style="expand-right" onclick="tgui_apiHA.slave.del(this, '+"'"+el.slave_id+'\')"><span class="ladda-label">Del</span></button></td>';
          $('table[name="ha_list"]').append('<tr><td>Slave ('+sid+')</td><td>' + el.ipaddr + '</td><td>' + el.location + '</td><td>' + el.status + '</td><td>' + el.lastchk + '</td>'+ ( (role == 'master') ? button : '' ) +'</tr>');
        }
      }
    }
  },
  rootpw: function( close ){
    var self = this;
    if( close ) {
      $('#modal-rootpw').modal('hide');
      return false;
    }

    $('#haForm [name="rootpw"]').val( $('#rootpwForm [name="rootpw"]').val() );
    $('#modal-rootpw')
      .one('hidden.bs.modal', function(e) {
        self.save({ skip: true});
      })
      .modal('hide');
    return false;
  },
  save: function(o){
    o = o || { skip: false };
    o.skip = o.skip || false;
    $('div.overlay').show();
    var self = this;
    $('pre.ha_save_log').empty();
    if ( !o.skip && $('[name="role"]').val() !== 'disable' &&  $('[name="role"]').val() == $('[name="role_native"]').val() ) {
      if ( ! confirm('It looks like you already have configuration. Do you want to reset role?') ) { $('div.overlay').hide(); return;}
    }
    var formData = tgui_supplier.getFormData('#haForm', true);

    if ( Object.keys(formData).length == 0) {
      tgui_error.local.show({type:'warning', message: "Changes did not found"});
      $('div.overlay').hide();
      return;
    }
    formData = tgui_supplier.getFormData('#haForm', false);
    if (formData.interf_ip){
      var temp = formData.interf_ip.split("-");
      formData.interface = temp[0];
      formData.ipaddr = temp[1];
    }
    formData.step = 0;
    formData.debug = (window.location.hash.substr(1) == 'debug');
    var ajaxProps = {
      url: API_LINK + "settings/ha/",
      data: formData
    };//ajaxProps END

    var parser = function(ajaxProps){
      console.log(ajaxProps);
      ajaxProps.data.step += 1;
      Promise.resolve( self.saveRequest(ajaxProps) ).then(function(resp){

        var log = (resp.response.log) ? resp.response.log : {};
        //console.log(resp);
        if (log.messages) log.messages.forEach(function(entry) { self.appendLog(entry, true) });
        if ( log.error === true ) throw resp;
        if ( resp.response.slave_id) ajaxProps.data.slave_id = resp.response.slave_id;
        if (! resp.response.stop ) { parser(ajaxProps); return; }
        tgui_error.local.show({type:'success', message: "Settings saved"});
        self.get();
        $('div.overlay').hide();
      }).catch(function(resp) {
        console.log(resp, 'Error');
        tgui_error.local.show({type:'error', message: "Error appeared!"});
        if ( resp.response.rootpw === false ) $('#modal-rootpw').modal('show');
        $('div.overlay').hide();
      });
    };
    parser(ajaxProps);
  },
  saveRequest: function(ajaxProps) {

    return new Promise(
      function (resolve, reject) {
        ajaxRequest.send(ajaxProps).then(function(resp) {
          if (tgui_supplier.checkResponse(resp.error, '#timeSettings')){
            $('div.overlay').hide();
            return;
          }
          //console.log(resp);
          // if (resp.log && resp.log.error === false){
          //   reject(resp);
          //   return false;
          // }
          resolve(resp);
          return true;
        }).fail(function(err){
          tgui_error.getStatus(err, ajaxProps);
        });
      });
  },

  appendLog: function( text, newline ) {
    $('pre.ha_save_log').append( text + ((newline) ? "\n" : ''));
    return this;
  },
  slave:{
    del: function(o,sid) {
      var self = this;
      if ( ! confirm('Do you want to delete slave with id ' + sid + '?') ) return false;
      var l = Ladda.create(o);
      l.start();
      var ajaxProps = {
        url: API_LINK + "settings/ha/slave/delete/",
        data: { sid: sid}
      };//ajaxProps END

      ajaxRequest.send(ajaxProps).then(function(resp) {
        console.log(resp);
        if (! resp.status) {
          tgui_error.local.show({type:'error', message: "Error appeared!"});
          l.stop();
          return;
        }
        tgui_error.local.show({type:'success', message: "Slave was deleted!"});
        setTimeout( function () {tgui_apiHA.get()}, 2000 );
      }).fail(function(err){
        tgui_error.getStatus(err, ajaxProps);
      });
    }
  }
};
