
var tgui_apiUpdate = {
  init: function() {
    var self = this;
    $('[name="update_signin"]').on('ifClicked', function(){
    	self.autoCheck()
    })
    return Promise.resolve(this.getInfo());
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
        }).fail(function(err){
          tgui_error.getStatus(err, ajaxProps)
        })
      }
    );
  },
  newKey: function() {
    var self = this;
    if ( !confirm('Update the key? You will lost the previous one.') ) return;
    var ajaxProps = {
      url: API_LINK+"update/change/",
      data: {settings: 2 }
    };//ajaxProps END

    ajaxRequest.send(ajaxProps).then(function(resp) {
      self.getInfo();
    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps)
    })
  },
  autoCheck: function() {
    var self = this;

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
      url: API_LINK+"update/"
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
				$('pre.update_log').append('<p class="text-center"><b>Push button below to update</b></p>')
				$('div.upgrade').show();
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
  }
}
