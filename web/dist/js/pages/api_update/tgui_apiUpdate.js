
var tgui_apiUpdate = {
  init: function() {
    var self = this;
    this.getInfo()

    return true;
  },
  getInfo: function() {
    var self = this;

    var ajaxProps = {
      url: API_LINK+"update/info/",
      type: 'GET'
    };//ajaxProps END

    return new Promise(
      function (resolve, reject) {
        ajaxRequest.send(ajaxProps).then(function(resp) {
          tgui_supplier.fulfillForm(resp.info, '');
          $('span.activated').text( (resp.info.update_activated) ? 'Activated' : 'Not Activated' );
          $('[name="update_signin"]').on('ifChanged', function(){
            self.autoCheck()
          })
          if(resp.slaves && resp.slaves.length){
            console.log(resp.slaves);
            for (var i = 0, len = resp.slaves.length; i < len; i++) {
              var slave = resp.slaves[i];
              var slave_info = {id: i, ip: slave.ipaddr, unique_id:slave.unique_id };
              $('table.ha_slave_table').append('<tr><td>'+slave.ipaddr+'</td><td>'+slave.api_version+'</td><td>'+slave.lastchk+'</td><td>'+slave.status+'</td><td><a class="btn btn-flat btn-info btn-sm" onclick="tgui_apiUpdate.getInfoSlave(this)" data-slave_id="'+i+'" data-ip="'+slave.ipaddr+'" data-unique_id="'+slave.unique_id+'">Get Info</a></td></tr>')
            }
            $('div.ha_slave_update').show();
          }
        }).fail(function(err){
          tgui_error.getStatus(err, ajaxProps)
        })
      }
    );
  },
  getInfoSlave: function(row, slave) {
    $('tr.slave_info').remove();
    var data = {id: $(row).data('slave_id'), ipaddr: $(row).data('ip'), unique_id: $(row).data('unique_id')}
    $(row).closest('tr').after('<tr class="slave_info"><td colspan="4"><pre class="slave_info">Loading...</pre></td><td><a class="btn btn-sm btn-flat btn-warning" data-slave_id="'+data.id+'" data-ipaddr="'+data.ipaddr+'" data-unique_id="'+data.unique_id+'" onclick="tgui_apiUpdate.upgradeSlave(this)">Update</a></td></tr>');
    var self = this;
    var ajaxProps = {
      url: API_LINK+"update/info/slave/",
      data: data
    };//ajaxProps END

    ajaxRequest.send(ajaxProps).then(function(resp) {
      if (!resp.gclient){
        $('pre.slave_info').empty().append('Error!'); return false;
      }
      $('pre.slave_info').empty().append('### Slave '+resp.gclient.serverip+' ###'+"\n"+
      'Server API version: '+resp.gclient.output.client_version+"\n"+
      'Last available API version: '+resp.gclient.output.last_version.version+"\n"
      ).append( ((resp.gclient.output.last_version.reinstall)? '' : "Re-install required!"));
    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps)
    })
  },
  // newKey: function() {
  //   var self = this;
  //   if ( !confirm('Update the key? You will lost the previous one.') ) return;
  //   var ajaxProps = {
  //     url: API_LINK+"update/change/",
  //     data: {settings: 2 }
  //   };//ajaxProps END
  //
  //   ajaxRequest.send(ajaxProps).then(function(resp) {
  //     self.getInfo();
  //   }).fail(function(err){
  //     tgui_error.getStatus(err, ajaxProps)
  //   })
  // },
  autoCheck: function() {
    var self = this;
    console.log($('[name="update_signin"]').prop('checked'));
    var ajaxProps = {
      url: API_LINK+"update/change/",
      data: {settings: 1, update_signin: ( ( $('[name="update_signin"]').prop('checked') ) ? 1 : 0 ) }
    };//ajaxProps END

    ajaxRequest.send(ajaxProps).then(function(resp) {
      if (resp.change_status) tgui_error.local.show({type:'success', message: "Settings saved"})
    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps)
    })
  },
  checkUpdate: function() {
    $('div.update_output').show();
    var self = this;

    var ajaxProps = {
      url: API_LINK+"update/",
      data: { version: tgui_status.api_version }
    };//ajaxProps END

    ajaxRequest.send(ajaxProps).then(function(resp) {
      $('pre.update_log').empty();
			if (resp.output == null || resp.output == undefined){
				$('pre.update_log').append('<p>Error appeared</p>')
					.append('<p>Reason: Didn\'t get response form server</p>');
        tgui_error.local.show({type:'error', message: "Error appeared"})
				$('div.update_output').hide();
				return;
			}
			if (resp.output.error.message !== undefined){
				$('pre.update_log').append('<p>Error appeared</p>')
					.append('<p>Reason: '+resp.output.error.message+'</p>');
        tgui_error.local.show({type:'error', message: resp.output.error.message})
				$('div.update_output').hide();
				return;
			}
			$('pre.update_log').append('<p>Hello '+resp.output.user.username+'</p>')
				.append('<p>Your api version: '+resp.info.version.APIVER+'</p>')
				.append('<p>Last availabel version: '+resp.output.last_version.version+'</p>')
				.append('<p>Brief description: '+resp.output.last_version.description_brief+'</p>')
				.append('<p>More description: '+resp.output.last_version.description_more+'</p>')
			if (resp.info.version.APIVER !== resp.output.last_version.version){
				if (!resp.output.reinstall){ $('pre.update_log').append('<p class="text-center"><b>Push button below to update</b></p>')
				 $('div.upgrade').show(); }
        else $('pre.update_log').append('<h4 class="text-center bg-danger" ><b>To get the new version follow the instruction <a href="https://tacacsgui.com/documentation/system-reinstallation/" target="_blank">here</a></b></h4>')
			} else {
				$('pre.update_log').append('<p class="text-center"><b>Your have newest version</b></p>')
			}
      self.getInfo();
			$('div.update_output').hide();
    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps)
    })
  },
  upgrade: function() {
    var self = this;

    var ajaxProps = {
      url: API_LINK+"update/upgrade/"
    };//ajaxProps END

    ajaxRequest.send(ajaxProps).then(function(resp) {
      console.log(resp);
      tgui_apiUser.signout();
    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps)
    })
  },
  upgradeSlave: function(row) {
    var self = this;
    var data = {id: $(row).data('slave_id'), ipaddr: $(row).data('ip'), unique_id: $(row).data('unique_id')}
    $('pre.slave_info').empty().append('Loading...');
    var ajaxProps = {
      url: API_LINK+"update/upgrade/slave/",
      data: data
    };//ajaxProps END

    ajaxRequest.send(ajaxProps).then(function(resp) {
      console.log(resp);
      $('pre.slave_info').empty().append(resp.gclient.gitPull);
    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps)
    })
  }
}
