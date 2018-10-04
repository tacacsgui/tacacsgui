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
      if (resp.result.server_list) self.fulfillha(resp.result.server_list);
      $('.ha_conf').hide();
      if (resp.result.server) { $('.ha_conf_' + resp.result.server.role).show(); }
      $('div.overlay').hide();
    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps);
    });
  },
  status: function() {
    $('pre.ha_save_log').empty();
    var self = this;
    var role = $('#haForm select[name="role"]').val();

    var ajaxProps = {
      url: API_LINK + "settings/ha/status/",
    };//ajaxProps END

    ajaxRequest.send(ajaxProps).then(function(resp) {
      console.log(resp);
      if (resp.status.role){
        $('pre.ha_save_log').append("\t"+'___ Server Role is '+resp.status.role+' ___'+"\n");
      }
      if (resp.status.my_cnf){
        $('pre.ha_save_log').append("\t"+'___ my.cnf ___'+"\n"+resp.status.my_cnf+"\n");
      }
      if (resp.status.ha_status){
        $('pre.ha_save_log').append("\t"+'___ Status ___'+"\n"+resp.status.ha_status+"\n");
      }
    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps);
    });
  },
  fulfillha: function(list) {
    $('table[name="ha_list"] tr').remove();
    $('table[name="ha_list"]').append('<tr><td>Role</td><td>Address</td><td>Location</td><td>Status</td><td>Last Check</td></tr>');
    list = list || [];
    if (list.master) {
      $('table[name="ha_list"]').append('<tr><td>Master</td><td>' + list.master.ipaddr + '</td><td>' + list.master.location + '</td><td>' + list.master.status + '</td><td>' + list.master.lastchk + '</td></tr>');
    }
    if (list.slave[0]) {
      list.slave.forEach(function(el) {
        $('table[name="ha_list"]').append('<tr><td>Slave</td><td>' + el.ipaddr + '</td><td>' + el.location + '</td><td>' + el.status + '</td><td>' + el.lastchk + '</td></tr>');
      });
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
        self.save();
      })
      .modal('hide');
    return false;
  },
  save: function(){
    $('div.overlay').show();
    var self = this;
    $('pre.ha_save_log').empty();
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
        switch (ajaxProps.data.role) {
          case 'slave':
            self.slave_step_parser(resp.response);
            break;
          case 'master':
            self.master_step_parser(resp.response);
            break;
          case 'disabled':
              $('pre.ha_save_log').empty().append('High Availability was Disabled');
            break;
          default:

        }
        if (! resp.response.stop ) { parser(ajaxProps); return; }
        tgui_error.local.show({type:'success', message: "Settings saved"});
        self.get();
        $('div.overlay').hide();
      }).catch(function(resp) {
        console.log(resp, 'Error');
        switch (resp.response.type) {
          case 'rootpw':
            $('#modal-rootpw').modal('show');
            $('pre.ha_save_log').append('MySQL root password required');
            tgui_error.local.show({type:'error', message: "Incorrect password"});
            break;
          case 'message':
            $('pre.ha_save_log').append(resp.response.message);
            tgui_error.local.show({type:'error', message: resp.response.message});
            $('div.overlay').hide();
            throw new Error('skipme');
          default:
          tgui_error.local.show({type:'error', message: "Unrecognized error"});
        }
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
          if (resp.response.status == 'error'){
            reject(resp);
            return false;
          }
          resolve(resp);
          return true;
        }).fail(function(err){
          tgui_error.getStatus(err, ajaxProps);
        });
      });
  },
  slave_step_parser: function(resp) {
    switch (resp.step) {
      case '1':
        if (resp.role){
          $('pre.ha_save_log').append('###  Role is ' + resp.role + ' ###'+"\n"+
           "Master Available"+"\n"+
           "Downloading dump from master..."+"\n");
        }
        break;
      case '2':
        //console.log(resp);
        if (resp.dump) {
          $('pre.ha_save_log').append('Dump file Uploaded'+"\n");
        }
        break;
      case '3':
        if (resp['my.cnf']){
          $('pre.ha_save_log').append('###  my.cnf  ###'+"\n").append(resp['my.cnf']+"\n");
        }
        if (resp.slave_start) {
          $('pre.ha_save_log').append(resp.slave_start+"\n");
        }
        break;
      case '4':
        if (resp.timezone_settings){
          $('pre.ha_save_log').append('Time Settings was applied'+"\n");
        }
        break;
      default:
        if (resp.ha_status){
          $('pre.ha_save_log').append('###  HA Status  ###'+"\n").append(resp.ha_status +"\n");
        }
    }
  },
  master_step_parser: function(resp) {
    switch (resp.step) {
      case '1':
        if (resp.role){
          $('pre.ha_save_log').append('###  Role is ' + resp.role + ' ###'+"\n");
        }
        if (resp['my.cnf']){
          $('pre.ha_save_log').append('###  my.cnf  ###'+"\n").append(resp['my.cnf']+"\n");
        }
        break;
      case '2':
        if (resp.replication){
          $('pre.ha_save_log').append('###  replication user  ###'+"\n").append(resp.replication + "\n");
        }
        break;
      default:
        if (resp.ha_status){
          $('pre.ha_save_log').append('###  HA Status  ###'+"\n").append(resp.ha_status +"\n");
        }
    }
  }
};
