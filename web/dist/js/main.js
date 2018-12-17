var tgui_user = {};
//AJAX Request Function//
var ajaxRequest = {
    send: function (props){
      input = {
        type: props.type || "POST",
        url: props.url || API_LINK+"user/info/",
        dataType: props.dataType || "json",
        cache: (props.cache != undefined) ? false : true,
        processData: (props.processData != undefined) ? false : true,
        contentType : (props.contentType != undefined) ? false : 'application/x-www-form-urlencoded; charset=UTF-8',
        timeout: props.timeout || 60000,
        data: props.data || {}
      }
      if (props.xhr) input.xhr = props.xhr;
      var ajax = $.ajax(input);
      tgui_error.debug({},'ajaxProps: ',input, 'ajaxResp: ',ajax);
      return ajax
    }
}//AJAX Request Function//end
/*---*/
//Tacgui Error Object//
var tgui_error = {
      status:704, //default status code
      errMessage: "Unexpected Error (default message)", //default message
      errType: "error", //default error type
      global: { //glbal error message
        show: function(message){
          if (message) $('div.error-message-body').empty();
          message = message || '';
          $('div.error-message-body').append(message);
          $('div.server-error').show();
          }
      },//global error message//end
      local: { //local error message
        show:function(err) {
          err = err || {};
          type = err.type || this.errType;
          message = err.message || this.errMessage;
          toastr[type](message);
        }
      },//local error message//end
      getStatus:function(err, extra, signin){
        signin = signin || false;
        err = err || {};
        //console.log(err);
        //this.status = err.status || this.status;
        if (window.location.hash.substr(1) == 'debug') console.log(err);
        if ( !err.status ) {
          this.local.show({type:"error", message: "Server Unreachable!"});
          return this;
        }
        if (signin) return true;
        switch(err.status)
      	{
          case 400:
            if (err.responseJSON && err.responseJSON.error && err.responseJSON.error.message){
              this.local.show({type:"error", message: err.responseJSON.error.message});
              break;
            }
            this.local.show({type:"error", message: "Bad Request!"});
      			break;
      		case 401:
            this.local.show({type:"error", message: "You are not authorised!"});
      			window.location.replace('/')
      			break;
      		case 403:
            this.local.show({type:"warning", message: "You do not have enough rights to do that!"});
      			break;
      		case 404:
            this.local.show({type:"error", message: "Server not found!"});
      			break;
      		case 504:
            this.local.show({type:"error", message: "Server Unreachable!"});
      			break;
      		default:
      			toastr['error']('Oops! Unknown error appeared, try to move to home page. :(');
            var message = '<p>Type: '+ ((err.name) ? err.name : '_undefined_') +': '+ ((err.stack) ? err.stack : '_undefined_') +'</p>';
                message += '<p>Status: '+ this.status +'</p>';
                message += '<p>Status Text: '+ ( (err.statusText)? err.statusText : 'Undefined') +'</p>';
                message += '<p>Response Text: '+ ( (err.responseText)? err.responseText.replace(/\t+/g, "\t").replace(/\r+/g, "\r").replace(/\s+/g, " ").replace(/<style.*style>/g, '').replace(/<.*?>/g, '').replace(/<\/.*>/g, '') : 'Undefined') +'</p>';
            if (err.responseJSON) for (var objProp in err.responseJSON) {
              if (err.responseJSON.hasOwnProperty(objProp)) {
                message += '<p>' + objProp + ': ' + print_r(err.responseJSON[objProp])+ '</p>';
              }
            }
            if (extra) for (var objProp in extra) {
              if (extra.hasOwnProperty(objProp)) {
                message += '<p>' + objProp + ': ' + print_r(extra[objProp])+ '</p>';
              }
            }
            this.global.show(message);
            return this;
      			//window.location.replace('/')
      	}
      	return this;
      },
      debug: function(){
        if (window.location.hash.substr(1) != 'debug') return;
        //if (arguments.length <= 1) console.log('Debug with empty output.'); return;
        for (var i = 1, len = arguments.length; i < len; i++) {
          console.log(arguments[i]);
        }
      }
};//Tacgui Error Object//end
/*---*/
//Tacgui User Object//
var tgui_apiUser = {
  id:0,
  username:'',
  grpId:0,
  grpAccess:0,
  ajaxProps:{
    url:API_LINK+"user/info/",
    type: "GET"
  },
  getInfo: function(props){
    props = props || {};
    for (var prop in props) {
      if (props.hasOwnProperty(prop)) {
        this.ajaxProps[prop] = props[prop];
      }
    }
    var info = ajaxRequest.send(this.ajaxProps);
    return info;
  },
  fulfill: function(resp) {
    tgui_user = resp.user;
    $('firstname_info').text(resp.user.firstname + ' ');
    $('surname_info').text(resp.user.surname);
    $('position_info').text(resp.user.position);
    $('li.user span.username').text(resp.info.user.username);
    if (resp && resp.ha_role == 'slave') {
      tgui_status.ha();
      $('div#ha-attention').modal('show');
    }
    //console.log(resp.info.user.groupRights.toString(2).split("").reverse());
    return this;
  },
  signout: function(){
    var props = {url: API_LINK+"auth/singout/", type:"GET"};
    ajaxRequest.send(props).then( function(resp){
      if (!resp.authorised) window.location.replace('/');
      else throw {name: "Signout", stack:"Something goes wrong!"};
    }).fail( function(err){
      tgui_error.getStatus(err, props);
    });
    return true;
  },

};//Tacgui User Object//end
/*---*/
//Tacgui Status Object//
var tgui_status = {
  id:0,
  username:'',
  grpId:0,
  grpAccess:0,
  api_version:0,
  ajaxProps:{
    url:API_LINK+"apicheck/database/",
    type: "GET"
  },
  getStatus: function(props, idle) {
    idle = idle || true;
    if (idle != 'signin') tguiInit.idle();
    props = props || {};
    for (var prop in props) {
      if (props.hasOwnProperty(prop)) {
        this.ajaxProps[prop] = props[prop];
      }
    }
    var info = ajaxRequest.send(this.ajaxProps);

    return info;
  },
  fulfill: function(resp) {
    this.api_version = resp.info.version.APIVER;
    $('tacversion').text(resp.info.version.TACVER);
    $('apiversion').text(resp.info.version.APIVER);
    $('guiversion').text(GUIVER);
    $('li.user span.username').text(resp.info.user.username);
    this.changeStatus(resp.configuration.changeFlag);
    return this;
  },
  changeStatus: function(status) {
    if (status == 1)
  	{
  		$('header li.applyBtn').show()
  		$('ul.timeline li span.configurationStatus').empty().text('Configuration was changed, you can test and apply it').removeClass('bg-green').addClass('bg-yellow')
  	}
  	if (status == 0)
  	{
  		$('header li.applyBtn').hide()
  		$('ul.timeline li span.configurationStatus').empty().text('No changes detected').removeClass('bg-yellow').addClass('bg-green')
  	}
  },
  time: function() {
    var ajaxProps = {
      url:API_LINK+"apicheck/time/",
      type: "GET"
    };

    return ajaxRequest.send(ajaxProps);
  },
  ha: function() {
    var ajaxProps = {
      url:API_LINK+"settings/ha/status/",
    };

    ajaxRequest.send(ajaxProps).then(function(resp) {
      $('.ha_status_mysql').text(resp.status.ha_status_brief);
      $('.ha_status').text( (resp.status.ha_status_brief.includes('Waiting for')) ? 'Active' : 'Error');
    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps);
    });
  }
};//Tacgui Status Object//end
/*---*/
//Tacacs Initiator Object
var tguiInit = {
  tooltips: function(selector){
    selector = selector || '[data-toggle="tooltip"]';
    $(selector).tooltip();
    return this;
  },
  popover: function(selector){
    selector = selector || '[data-toggle="popover"]';
    $(selector).popover({container: 'body'});
    return this;
  },
  iCheck: function(){
    $('div.icheck input[type="checkbox"]').iCheck({
    	checkboxClass: 'icheckbox_square-blue',
    	radioClass: 'iradio_square-blue',
    	increaseArea: '20%' // optional
    });
    return this;
  },
  slider: function(o) {
    o = o || {};
    var p = {
      tooltip: o.tooltip || "always"
    }
    $('input.slider').slider(p)
    return this;
  },
  toggleMavis: function() {
    $('input[name="enabled"]').on('change', function(event){
      ( $('input[name="enabled"]').prop( "checked" ) ) ? $('div.disabled_shield').hide() : $('div.disabled_shield').show()
    });
    return this;
  },
  idle: function(){
    var timeoutset=1500*60*5;
    $.idleTimer(timeoutset);
    $(document).bind("idle.idleTimer", function(){
    	window.open( "./lockscreen.php","_self");
    });
  },
  tgui_expander: function() {
    tgui_expander.init();
    return this;
  },
  datetimepicker: function(){
    moment.updateLocale('en', {
        week: { dow: 1 } // Monday is the first day of the week
    });
    $('div.datetimepicker').datetimepicker({
      calendarWeeks: false,
      format: 'YYYY-MM-DD HH:mm',
    });
    return this;
  },
  bootstrap_toggle: function(o){
    o = o || {}
    $('.bootstrap-toggle').bootstrapToggle();
    return this;
  },
  tgui_search_bar: function(){
    $('.tgui-search-bar').tgui_search_bar();
    return this;
  }
}//Tacacs Initiator Object//end
/*-
-
-
*/
var tgui_supplier = { //Tacacs Supplier Object
  getFormData: function(form, reference) {
    reference = reference || false;
    form = form || '';
    form = (form != '') ? form + ' ' : form;
    var obj = {};
    var el = {};
    for (var i = 0, len = $(form + '[data-pickup="true"]').length; i < len; i++) {
      el = $(form + '[data-pickup="true"]')[i];
      tgui_error.debug({},'Element: ', el);
      switch ($(el).attr('data-type')) {
        case 'input':
          if (reference) {
            obj[$(el).attr('name')] = $(el).val();
            tgui_error.debug({},$(el).attr('name')+': ' + obj[$(el).attr('name')]);
            if ( $(form + '[name="'+$(el).attr('name') + '_native'+'"]').length ){
              if ($(form + '[name="'+$(el).attr('name') + '_native'+'"]').val() == $(el).val()){
                tgui_error.debug({},$(el).attr('name')+' was deleted');
                delete obj[$(el).attr('name')];
                delete obj[$(el).attr('name')+'_native'];
              }
            }
            break;
          }
          obj[$(el).attr('name')] = $(el).val();
          tgui_error.debug({},$(el).attr('name')+': ' + obj[$(el).attr('name')]);
          if ( obj[$(el).attr('name')] == '' ) {
            tgui_error.debug({},$(el).attr('name')+' was deleted, it was empty');
            delete obj[$(el).attr('name')];
          }
          break;
        case 'select':
          if (reference) {
            obj[$(el).attr('name')] = ( $(el).val() );
            tgui_error.debug({},$(el).attr('name')+': ' + obj[$(el).attr('name')]);
            if ( $(form + '[name="'+$(el).attr('name') + '_native'+'"]').length ){
              if ($(form + '[name="'+$(el).attr('name') + '_native'+'"]').val() == $(el).val()){
                tgui_error.debug({},$(el).attr('name')+' was deleted');
                delete obj[$(el).attr('name')];
                delete obj[$(el).attr('name')+'_native'];
              }
            }
            break;
          }
          obj[$(el).attr('name')] = $(el).val();
          tgui_error.debug({},$(el).attr('name')+': ' + obj[$(el).attr('name')]);
          break;
        case 'checkbox':
          if (reference) {
            obj[$(el).attr('name')] = ( $(el).prop('checked') ) ? 1 : 0;
            if ( $(form + '[name="'+$(el).attr('name') + '_native'+'"]').length ){
              if ($(form + '[name="'+$(el).attr('name') + '_native'+'"]').val() == obj[$(el).attr('name')]){
                delete obj[$(el).attr('name')];
                delete obj[$(el).attr('name')+'_native'];
              }
            }
            break;
          }
          obj[$(el).attr('name')] = ($(el).prop('checked')) ? 1 : 0;
          tgui_error.debug({},$(el).attr('name')+': ' + obj[$(el).attr('name')]);
          break;
        default:
          obj[$(el).attr('name')] = $(el).val();
          tgui_error.debug({},$(el).attr('name')+': ' + obj[$(el).attr('name')] + '. Default choice!! Please check!');
          if ( obj[$(el).attr('name')] == '' ) {
            tgui_error.debug({},$(el).attr('name')+' was deleted, it was empty'+ '. Default choice!! Please check!');
            delete obj[$(el).attr('name')];
          }
      }
    }

    return obj;
  },
  checkChanges: function(o, params){
    o = o || {}
    params = params || [];
    var keys = Object.keys(o);
    var new_keys = keys.filter(function( el ){
      if ( params.includes(el) ) return false;
      return true;
    })
    if (!new_keys.length) tgui_error.local.show({type:'warning', message: "No Changes Detected"})
    return !!new_keys.length;
  },
  checkResponse: function(error, form){
    $('.form-group.has-error').removeClass('has-error');
  	$('.form-group p.text-red').remove();
  	$('.form-group p.help-block').show();
    if (error.status){
      for (v in error.validation){
        if (!(error.validation[v] == null)){
          $(form +' div.'+v).addClass('has-error')
          $('div.form-group.'+v+' p.help-block').hide()
          var error_message='';
          for (num in error.validation[v]){
            error_message+='<p class="text-red">'+error.validation[v][num]+'</p>';
            tgui_error.local.show({type:'error', message: error.validation[v][num]})
          }
          $('div.form-group.'+v).append(error_message)
        }
      }
      return true;
    }
    return false;
  },
  clearForm: function(form){
    $('.form-group.has-error').removeClass('has-error');
  	$('.form-group p.text-red').remove();
  	$('.form-group p.help-block').show();
    $('.nav.nav-tabs a[href="#general_info"]').tab('show');//select first tab
  	$('.nav.nav-tabs a[href="#general_info_edit"]').tab('show');//select first tab
    Ladda.stopAll();
    //clear pre-defined elements
    for (var i = 0, len = $('[data-default]').length; i < len; i++) {
      element = $($('[data-default]')[i])
      switch (element.attr('data-type')) {
        case 'input':
          element.val(element.attr('data-default'))
          break;
        case 'select':
          if (element.hasClass('select2')) {
            //console.log(element);
            element.val(null).trigger("change");
            element.empty();
            break;
          }
          else element.val(element.attr('data-default'));
          break;
        case 'checkbox':
          if ( $(element).data('toggle') == 'toggle'){
            element.prop( 'checked', (element.attr('data-default') == 'checked') )
            element.change();
            break;
          }
          if (element.iCheck) {
            element.iCheck( (element.attr('data-default') == 'checked') ? 'check' : 'uncheck');
            break;
          }
          element.prop( 'checked', (element.attr('data-default') == 'checked') )
          element.change();
          break;
      }
    }
    return this;
  },
  fulfillForm: function(obj, form) {
    form = form || "";
    form = (form != '') ? form + ' ' : form;
    obj = obj || {};

    var el = {}, el_n = {};
    for (var param in obj) {
      if (obj.hasOwnProperty(param)) {
        if ( $(form + '[name="'+param+'"][data-pickup="true"]').length ){
          el = $(form + '[name="'+param+'"][data-pickup="true"]');
          el_n = $(form + '[name="'+param+'_native"]');
          tgui_error.debug({}, 'Fulfill. Element: ', el, 'Value: '+obj[param]);
          switch ($(el).attr('data-type')) {
            case 'input':
              el.val(obj[param]);
              //console.log(el, obj[param]);
              if (el_n.length) el_n.val(obj[param]);
              break;
            case 'select':
              el.val(obj[param]);
              if (el_n.length) el_n.val(obj[param]);
              break;
            case 'checkbox':
              tgui_error.debug({}, 'Fulfill. Checkbox: ', el, 'Value: '+obj[param]);
              if (el.iCheck && !$(el).hasClass('bootstrap-toggle')) {
                el.iCheck( (obj[param] == 1) ? 'check' : 'uncheck');
                if (el_n.length) el_n.val(obj[param]);
                break;
              }
              el.prop('checked', (obj[param] == 1) );
              el.change();
              if (el_n.length) el_n.val(obj[param]);
              //console.log(el_n);
              break;
          }
        }
      }
    }
    if ( $('elName').length && (obj.name || obj.username)) $('elName').text( (obj.name || obj.username) );
    if ( $('.created_at').length && obj.created_at) $('.created_at').text('Created at: ' + obj.created_at);
    if ( $('.updated_at').length && obj.updated_at) $('.updated_at').text('Updated at: ' + obj.updated_at);
    return true;
  },
  toggle: function(button){
    if (button == 'reload'){
      $('input[name="disabled"]').val('0');
      $('.disable-toggle').removeClass('btn-warning btn-success').addClass('btn-success').text('Enabled');
      return;
    }
    if (button == 'disabled'){
      $('.disable-toggle').removeClass('btn-warning btn-success').addClass('btn-warning').text('Disabled');
      return;
    }
    var form = $(button).parents('form')[0]
    var button = $(button)
  	var input = $('form#'+ $(form).attr('id') +' input[name="disabled"]')
		if (input.val() == '0'){
			button.removeClass('btn-success').addClass('btn-warning').text('Disabled');
			input.val('1')
		}
		else if (input.val() == '1'){
			button.removeClass('btn-warning').addClass('btn-success').text('Enabled');
			input.val('0')
		}
    return;
  },
  privLvl: function(action, button, form) {
    action = action || 'unset';
    button = button || -1;
    form = form || $(button).parents('form')[0];
    input = $('form#' + $(form).attr('id') + ' input[name="priv-lvl"]')
    input_preview = $('form#' + $(form).attr('id') + ' input[name="priv-lvl-preview"]')
    switch (action) {
      case '+':
        val = parseInt($(input).val());
        if (val == 15 ) break;
        $(input).val( val + 1 )
        $(input_preview).val( $(input).val() )
        break;
      case '-':
        val = parseInt($(input).val());
        if (val == -1 ) { $(input_preview).val( 'Undefined' ); break;}
        $(input).val( val - 1 )
        $(input_preview).val( $(input).val() )
        if (parseInt($(input).val()) == -1 ) $(input_preview).val( 'Undefined' )
        break;
      case 'set':
        //
        break;
      default:
        $(input).val(-1)
        $(input_preview).val( 'Undefined' )
    }
  },
  validateIp: function(address){
    address = address || false;
    if (address=='0.0.0.0/0') return true;
    if (/^([1-9]|[1-9][0-9]|[1-9][0-9][0-9])\.([0-9]|[1-9][0-9]|[1-9][0-9][0-9])\.([0-9]|[1-9][0-9]|[1-9][0-9][0-9])\.([0-9]|[1-9][0-9]|[1-9][0-9][0-9])\/([1-9]|[1-3][0-9])$/.test(address)) return true;
    //console.log(/^([1-9]|[1-9][0-9]|[1-9][0-9][0-9])\.([0-9]|[1-9][0-9]|[1-9][0-9][0-9])\.([0-9]|[1-9][0-9]|[1-9][0-9][0-9])\.([0-9]|[1-9][0-9]|[1-9][0-9][0-9])\/([1-9]|[1-3][0-9])$/.test(address))
    return false;
  },
  loadElement: function(param) {
    param = param || {};
    param.color = param.color || 'black';
    param.size = param.size || 'small';
    param.type = param.type || 'lds';
    var el_class = '';
    if (param.type == 'lds'){
      el_class += ( param.size == 'small') ? " lds-dual-ring-small " : " lds-dual-ring ";
      el_class += ( param.color == 'black') ? " lds-black " : "";
    }

    return '<div class="'+el_class+'"></div>';
  },
  showConfiguration: function(rowData, target) {
    target = target || '';
    rowData = rowData || {};
    var self = this;
    var pre = '';
    var ajaxProps = {
      url: API_LINK+"tacacs/config/part/",
      data: {
        target: target,
        id: rowData.id || 0,
        name: rowData.name || '',
        username: rowData.username || ''
      }
    };//ajaxProps END
    ajaxRequest.send(ajaxProps).then(function(resp) {
      //console.log(resp);
      for (var target in resp.output) {
        if (resp.output.hasOwnProperty(target)) {
          el = resp.output[target];
          //console.log(el);
          for (var someLine = 0; someLine < el.length; someLine++)
          {
            if (someLine > 0)
            {
              pre += el[someLine] + '\n';
              continue;
            }
          }
        }
      }
      $('pre.partial_config_'+rowData.id).empty().append(pre);
    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps)
    })
  },
  random: function( len ){
    len = len || 16;
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    for (var i = 0; i < len; i++)
      text += possible.charAt(Math.floor(Math.random() * possible.length));

    return text;
  },
  clone_login: '#clone_login_password',
  selector: function(a){
    a = a || {}
    if ( ! a.select ) return false;

    var form_id = '#' + $($(a.select).parents('form')[0]).attr('id');
    var o = {
      input: $(form_id + ' input[name="'+$(a.select).data('object')+'"]'),
      input_native: $(form_id + ' input[name="'+$(a.select).data('object')+'_native"]'),
      flag_native: $(form_id + ' input[name="'+$(a.select).data('object')+'_flag_native"]').val(),
      hash: $(form_id + ' div.'+$(a.select).data('object')+'_encrypt_section'),
      passwd_change: $(form_id + ' div.'+$(a.select).data('object')+'_change'),
      flag: ( (a.flag != undefined) ? a.flag : $(a.select).val() ),
      name: $(a.select).data('object'),
    }
    o.input.val( (o.flag == o.flag_native) ? o.input_native.val() : '' );
    o.input.attr('onfocus', "").attr('onfocusout', "");
    switch (o.flag.toString()) {
      case '0':
        //Clear text//
        o.input.attr('type', 'text');
        $(o.input).prop('disabled', false);
        o.hash.hide();
        o.passwd_change.hide();
        break;
      case '1':
        //MD5 hash//
        o.input.attr('type', 'text');
        $(o.input).prop('disabled', false);
        o.passwd_change.hide();
        o.hash.show();
        break;
      case '2':
        //DES deprecated//
        break;
      case '3':
        //Local database//
        o.input.attr('type', 'password');
        o.input.attr('onfocus', "tgui_supplier.clearOnFocus(this)").attr('onfocusout', "tgui_supplier.clearOnFocus(this,'out')");
        $(o.input).prop('disabled', false);
        o.passwd_change.show();
        o.hash.hide();
        break;
      case '4':
        //Clone login//
        $(o.input).prop('disabled', true);
        o.input.attr('type', 'text');
        $(o.input).val(tgui_supplier.clone_login);
        o.passwd_change.hide();
        o.hash.hide();
        break;
    }
  },
  clearOnFocus: function(o, type) {
    type = type || 'in'
    if (type == 'out' && $(o).val() == ''){
      $(o).val( $(o).next('input').val() );
      return true;
    }
    if (type == 'in' && $(o).val() == $(o).next('input').val() ){
      $(o).val('');
      return true;
    }
    return false;
  }
}//Tacacs Supplier Object//end

tguiInit.tooltips();

///////TOASTR///GLOBAL OPTIONS///
toastr.options = {
	"positionClass": "toast-bottom-right",
}
///////////////////////////////

function print_r(arr, level) {
    var print_red_text = "";
    if(!level) level = 0;
    var level_padding = "";
    for(var j=0; j<level+1; j++) level_padding += "    ";
    if(typeof(arr) == 'object') {
        for(var item in arr) {
            var value = arr[item];
            if(typeof(value) == 'object') {
                print_red_text += level_padding + "'" + item + "' :\n";
                print_red_text += print_r(value,level+1);
		}
            else
                print_red_text += level_padding + "'" + item + "' => \"" + value + "\"\n";
        }
    }

    else  print_red_text = "===>"+arr+"<===("+typeof(arr)+")";
    return print_red_text;
}
