var confM_set = {
  formSelector_edit_cron: ' form#cronForm ',
  init: function() {
    $('.cm_scheduler_time').datetimepicker({
        format: 'HH:mm',
        stepping: 10
    });

    $('input[name="cm_period"]').on('change', function() {
      //console.log($('input[name="diffType"]:checked').val());
      if ( $('input[name="cm_period"]:checked').val() == 'week')
        $('select[name="week"]').prop('disabled', false);
      else
        $('select[name="week"]').prop('disabled', true);
    });

    this.getCron()
    this.info()
  },
  getCron: function() {

    var ajaxProps = {
      url: API_LINK + "confmanager/settings/cron/",
      type: "GET"
    };//ajaxProps END

    ajaxRequest.send(ajaxProps).then(function(resp) {
      console.log(resp);
      if ( !resp.cron || !resp.cron.cm || !resp.cron.git ){
        tgui_error.local.show({type:'error', message: "Server error. Cron Settings not found!"})
      }

      $('input[name="cm_period"][value="' + resp.cron.cm.period + '"]').prop('checked', true).trigger("change");
      $('input[name="cm_period_native"]').val(resp.cron.cm.period);
      $(".cm_scheduler_time input").val(resp.cron.cm.time);
      $('select[name="week"]').val(resp.cron.cm.week);
      $('select[name="git_period"]').val(resp.cron.git.period);

    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps);
    });
  },
  editCron: function(o) {
    var self = this;
    var lui = Ladda.create(o)
    lui.start(); //button loading start
    var ajaxProps = {
      url: API_LINK + "confmanager/settings/cron/",
      data: {
        cm: {
          period: $('input[name="cm_period"]:checked').val(),
          time: $(".cm_scheduler_time input").val(),
          week: $('select[name="week"]').val()
        },
        git: {
          period: $('select[name="git_period"]').val()
        }
      }
    };//ajaxProps END

    ajaxRequest.send(ajaxProps).then(function(resp) {
      lui.stop(); //button loading stop
      console.log(resp);
      if ( resp.crontab != 'done'){
        tgui_error.local.show({type:'error', message: "Server Error!"})
        return;
      }
      tgui_error.local.show({type:'success', message: "Cron configuration applied"})
      self.info()
    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps);
    });
  },
  toggle: function(action, o) {
    var self = this;
    var lui = Ladda.create(o)
    lui.start(); //button loading start
    $('[name="deamon_status"]').val('Loadind...')
    var ajaxProps = {
      url: API_LINK + "confmanager/toggle/",
      data: { action: action }
    };//ajaxProps END

    ajaxRequest.send(ajaxProps).then(function(resp) {
      console.log(resp);
      if (action == 'start') if ( /^ready.*\d+\sPlanned|^running.*\d+\sPlanned/.test(resp.info)){
        tgui_error.local.show({type:'warning', message: "Already Planned"})
      } else if (resp.status == 'done') {
        tgui_error.local.show({type:'success', message: "Successfully Planned"})
      } else {
        tgui_error.local.show({type:'error', message: "Something is going wrong"})
      }
      if (action == 'stop' && resp.status == 'done') tgui_error.local.show({type:'success', message: "Unplanned"})
      if (action == 'force' && resp.status == '') tgui_error.local.show({type:'success', message: 'Force Start <i class="fa fa-rocket"></i> Activated!'})

      lui.stop(); //button loading stop
      self.info()
    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps);
    });
    return false;
  },
  info: function(o) {
    var self = this
    if (o){
      var lui = Ladda.create(o)
      lui.start(); //button loading start
    }
    $('[name="deamon_status"]').val('Loadind...')
    var ajaxProps = {
      url: API_LINK + "confmanager/info/",
      type: "GET"
    };//ajaxProps END

    ajaxRequest.send(ajaxProps).then(function(resp) {
      console.log(resp);
      if (o){
        lui.stop(); //button loading start
      }
      $('[name="deamon_status"]').val(resp.info)
    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps);
    });
  },
  getPreview: function(o) {
    var self = this;
    var lui = Ladda.create(o)
    lui.start(); //button loading start
    $('.cm-settings-preview').empty().append('Loadind...');
    var ajaxProps = {
      url: API_LINK + "confmanager/settings/preview/",
      type: "GET"
    };//ajaxProps END

    ajaxRequest.send(ajaxProps).then(function(resp) {
      lui.stop(); //button loading stop
      console.log(resp);
      $('.cm-settings-preview').empty().append(resp.preview)
    }).fail(function(err){
      tgui_error.getStatus(err, ajaxProps);
    });
  }
}
