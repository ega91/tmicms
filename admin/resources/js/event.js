
var calendar = $('#calendar').fullCalendar({
  header: {
    left: 'prev,next today',
    center: 'title',
    right: 'month,agendaWeek,agendaDay,listMonth'
  },
  selectable: true,
  selectHelper: true,
  select: function(start, end) {
    // New event
    $('#event-container').html('<i class="fa fa-spinner fa-spin fa-fw"></i> Please wait...');
    $('#CalenderModal').modal('show');
    $.get(SITE_URL +'event/add', function(response){
      displayEventForm(response, start, end);
    });
  },
  eventClick: function(calEvent, jsEvent, view) {
    $('#event-container').html('<i class="fa fa-spinner fa-spin fa-fw"></i> Please wait...');
    $('#CalenderModal').modal('show');
    $.get(SITE_URL +'event/edit/'+ calEvent.id, function(response){
      displayEventForm(response);
    });
  },
  editable: true,
  eventDrop: function( event, delta, revertFunc ) {
    eventChanged(event, revertFunc);
  },
  eventResize: function(event, delta, revertFunc){
    eventChanged(event, revertFunc);
  },
  events: SITE_URL +'event/feed'
});


var eventChanged = function(event, revertFunc){
  if (!confirm("Apakah anda yakin ingin merubah tanggal acara?")) {
    revertFunc();
  } else {
    var _event = {};
    if ( typeof event.start != 'undefined' && event.start != null )
      _event.start = event.start.unix();
    if ( typeof event.end != 'undefined' && event.end != null )
      _event.end = event.end.unix();
    $.post(SITE_URL +'event/changedate/'+ event.id, _event);
  }
}


var displayEventForm = function(response, start, end){
  calendar.fullCalendar('unselect');
  $('#event-container').html(response);
  if ( typeof start != 'undefined' )
    $('#event_start').val(start.unix());
  if ( typeof end != 'undefined' )
    $('#event_end').val(end.unix());
  $('#event-container').unbind('submit').bind('submit', function(e){
    e.preventDefault();
    var $form = $(this);
    $form.ajaxSubmit({
      dataType: 'json',
      clearForm: false,
      resetForm: false,
      beforeSubmit: function(arr, $form, options){
        $('#upload-progress-header').find('.upload-progress-percent').hide();
        $('#upload-progress-header').show();
      },
      error: function(){
        $('#upload-progress-header').hide();
        $('#upload-progress-header').find('.upload-progress-percent').show();
        var message = 'Internal server error, contact administrator.';
        new PNotify({
            icon: false,
            title: 'Save Failed',
            text: message,
            type: 'error',
            styling: 'bootstrap3'
        });
      },
      success: function( response, statusText, xhr, $form ){
        $('#upload-progress-header').hide();
        $('#upload-progress-header').find('.upload-progress-percent').show();
        $('#upload-progress-2').fadeOut('fast');
        if ( response.status != 200 ){
            var message = (typeof response.message != 'undefined') ? response.message : 'Internal server error, contact administrator.';
            $form.find('.alert.alert-danger').html(message).show();
        } else {
          $('#CalenderModal').modal('hide');
          var allDay = (response.event.all_day == 1) ? true : false;
          calendar.fullCalendar('renderEvent', {
            id      : response.event.id,
            title   : response.event.name,
            start   : moment( parseFloat(response.event.event_date) *1000),
            end     : moment( parseFloat(response.event.end_date) *1000),
            allDay  : allDay
          });
          new PNotify({
              icon: false,
              title: 'Event Saved',
              text: 'Event successfully saved.',
              type: 'success',
              styling: 'bootstrap3'
          });
        }
      }
    });
  });
}

$(document).on('click', '.media-manager-event', function(e){
  e.preventDefault();
  var $el = $(this);
  $('#CalenderModal').modal('hide');
  window.setTimeout(function(){
    mediaManager(function( media ){
      $el.parent().find('.bgimage-input').val( media.id );
      $el.parent().parent().find('.bgimage-display img').attr('src', media.image);
      window.setTimeout(function(){
        $('#CalenderModal').modal('show');
      }, 700);
    }, 'single');
  }, 700);
});
$(document).on('click', '.bgimage-display-event img', function(e){
    e.preventDefault();
    $(this).parent().parent().parent().find( '.media-manager-event' ).trigger('click');
});

$(document).on('click', '.delete-event', function(e){
  e.preventDefault();
  var event_id = $(this).attr('event-id');
  if ( confirm('Apakah anda yakin ingin menghapus acara ini?') ){
    $('#CalenderModal').modal('hide');
    $.get(SITE_URL +'event/delete/'+ event_id, function(){
      calendar.fullCalendar('refetchEvents');
    })
  }
});

