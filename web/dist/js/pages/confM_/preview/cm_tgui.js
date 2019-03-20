var cm_tgui = {
  initiated: false,
  init: function() {
    var self = this;
    $('ul.tgui_user_list > li').click(function(e) {
      if ( $(this).hasClass('selected') ) return;
      $('ul.tgui_user_list > li.selected').removeClass('selected');
      $(this).addClass('selected');
      self.fill_tab_counters()
      self.get_aaa()
    })
    if (!this.initiated){
      $('ul.aaa-logging a').on('shown.bs.tab', function (e) {
        self.get_aaa()
      });
      this.initiated = true;
    }

  },
  get_user_list: function() {
    var self = this
    this.clear()
    if ( $('[name="tgui_device_ip"]').val() == '' ){
      $('div.message h3').show().text('Does not match any tacacs device')
      return;
    }

    var ajaxProps = {
      url: API_LINK+"confmanager/diff/tacgui/users/",
      data: {
        "date_a": $('[name="tgui_date_a"]').val(),
        "date_b": $('[name="tgui_date_b"]').val(),
        "ip": $('[name="tgui_device_ip"]').val(),
      }
    };//ajaxProps END

    ajaxRequest.send(ajaxProps).then(function(resp) {
      //console.log(resp);
      if (resp.users.length){
        for (var i = 0; i < resp.users.length; i++) {
          if ( i == 0 ) resp.users[i].active = 'selected';
          $('ul.tgui_user_list').append( self.template_user(resp.users[i]) )
        }
        self.fill_tab_counters()
        self.get_aaa()
        self.init()
        $('div.message h3').hide()
        $('div.aaa-tgui-ready').show()
      } else {
        $('div.message h3').show().text('No one users found');
      }
    })
  },
  fill_tab_counters: function(o) {
    $('ul.aaa-logging li a[href="#authe"] > span.label').text( $('ul.tgui_user_list li.selected').data('authe') )
    $('ul.aaa-logging li a[href="#autho"] > span.label').text( $('ul.tgui_user_list li.selected').data('autho') )
    $('ul.aaa-logging li a[href="#acc"] > span.label').text( $('ul.tgui_user_list li.selected').data('acc') )
  },
  get_aaa: function() {
    var self = this
    $('table.aaa-table tr.aaa-row').remove()
    $('div.aaa-report div.overlay').show()
    var ajaxProps = {
      url: API_LINK+"confmanager/diff/tacgui/aaa/",
      data: {
        "date_a": $('[name="tgui_date_a"]').val(),
        "date_b": $('[name="tgui_date_b"]').val(),
        "ip": $('[name="tgui_device_ip"]').val(),
        "username": $('ul.tgui_user_list li.selected').data('uname'),
        "section": $('ul.aaa-logging li.active').data('aaa'),
      }
    };//ajaxProps END

    ajaxRequest.send(ajaxProps).then(function(resp) {
      //console.log(resp);
      for (var i = 0; i < resp.log.length; i++) {
        $('table.'+ajaxProps.data.section).append(self.template_table_log(resp.log[i], ajaxProps.data.section) )
      }
      $('div.aaa-report div.overlay').hide()
    })
  },
  clear: function() {
    console.log('clear');
    $('ul.tgui_user_list').empty()
    $('table.aaa-table tr.aaa-row').remove()
    $('ul.aaa-logging li a[href="#authe"] > span.label').text( 0 )
    $('ul.aaa-logging li a[href="#autho"] > span.label').text( 0 )
    $('ul.aaa-logging li a[href="#acc"] > span.label').text( 0 )
    $('div.message h3').show().text('Loading...');
    $('div.aaa-tgui-ready').hide();
  },
  get_log_list: function() {

  },
  template_user: function(o) {
    o.username = o.username || 'undefined';
    o.authe = o.authe || 0;
    o.autho = o.autho || 0;
    o.acc = o.acc || 0;
    o.active = o.active || '';
    return '<li class="'+o.active+'" data-uname="'+o.username+'" data-authe="'+o.authe+'" data-autho="'+o.autho+'" data-acc="'+o.acc+'">'+
    o.username+' <aaa class="pull-right"><span class="label label-success" title="Authentication">'+o.authe+'</span><span class="label label-warning" title="Authorization">'+o.autho+'</span><span class="label label-info" title="Accounting">'+o.acc+'</span></aaa></li>';
  },
  template_table_log: function(o, section) {
    o.date = o.date || 'unknown';
    o.nac = o.nac || 'unknown';
    o.cmd = o.cmd || 'unknown';
    o.action = o.action || 'unknown';
    section = section || 'authentication';
    if ( section == 'authentication' )
      return '<tr class="aaa-row"><td>'+o.date+'</td><td>'+o.nac+'</td><td>'+o.action+'</td></tr>';
    return '<tr class="aaa-row"><td>'+o.date+'</td><td>'+o.nac+'</td><td>'+o.cmd.replace(/\s\|\s/g, ' ')+'</td></tr>';

  },
}
