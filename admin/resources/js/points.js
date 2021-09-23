
$(document).on('click', '.redeem-point', function(e){
  e.preventDefault();
  var playerID = $(this).attr('player-id'),
  $player = $('#player-table .player-'+ playerID),
  playerName = $player.find('h3.td-title').html();
  var sortval = $('#RedeemModal').attr('sortval');
  if ( typeof sortval == 'undefined' ) sortval == 'latest';

  $('.rdm-pts').html('...');
  $.getJSON(SITE_URL +'player/infojson/'+ playerID, function(response){
    if ( response.status != 200 ){
      $('.rdm-pts').html(0);
    } else {
      $('.rdm-pts').html(response.player.redeemable_points);
    }
  });

  $('.rdm-player').html(playerName);
  $('#RedeemModal .modal-body').html('<h3 style="text-align: center;padding-top: 40px;"><i class="fa fa-spinner fa-spin fa-fw"></i> loading...</h3>');
  $('#RedeemModal').attr('player-id', playerID);
  $('#RedeemModal').modal('show');

  $.get('/admin/rewards/redeem/'+ playerID +'/'+ sortval, function(response){
    $('#RedeemModal .modal-body').html(response);
  });
});

$(document).on('click', '.change-rr-sort', function(e){
  e.preventDefault();
  var playerID = $('#RedeemModal').attr('player-id');
  var sortval = $(this).attr('sortval');

  $('#RedeemModal').attr('sortval', sortval);
  $('.reward-order .sort-val').html($(this).html());
  $('#RedeemModal .modal-body').html('<h3 style="text-align: center;padding-top: 40px;"><i class="fa fa-spinner fa-spin fa-fw"></i> loading...</h3>');
  $.get('/admin/rewards/redeem/'+ playerID +'/'+ sortval, function(response){
    $('#RedeemModal .modal-body').html(response);
  });
})

$('#form-redeem-single').submit(function(e){
  e.preventDefault();
  $(this).ajaxSubmit({
    clearForm: false,
    resetForm: false,
    beforeSubmit: function(arr, $form, options){
      $('#RedeemCode').modal('show');
      $('#RedeemCode .modal-content').html('<div class="modal-body text-center"><h3><i class="fa fa-spinner fa-spin fa-fw"></i> loading...</h3></div>');
    },
    error: function(){
      $('#RedeemCode').modal('hide');
      var message = 'Internal server error, contact administrator.';
      new PNotify({
          icon: false,
          title: 'Error',
          text: message,
          type: 'error',
          styling: 'bootstrap3'
      });
    },
    success: function( response, statusText, xhr, $form ){
      $('#RedeemCode .modal-content').html(response);
    }
  });
});

$(document).on('click', '.accept-rdm-status', function(e){
  e.preventDefault();
  var $el = $(this);
  var redeemID = $el.attr('redeem-id');

  $('#RedeemCode .modal-content').html('<div class="modal-body text-center"><h3><i class="fa fa-spinner fa-spin fa-fw"></i> loading...</h3></div>');
  $.getJSON('/admin/redeem/accept/'+ redeemID, function(response){
    if ( response.status != 200 ){
      if ( typeof response.message == 'undefined' ) response.message = 'Internal server error, please try again later.';
      $('#RedeemCode .modal-content').html('<div class="modal-body"><div class="redeem-error text-center"><div class="alert alert-danger">'+ response.message +'</div><button class="btn btn-default btn-lg btn-block" data-dismiss="modal">Close</button></div></div>');
    } else {
      new PNotify({
          icon: false,
          title: 'Redeem Code Status',
          text: 'Redeem code status is now received by player.',
          type: 'success',
          styling: 'bootstrap3'
      });
      $('#RedeemCode').modal('hide');
    }
  })
});

$(document).on('click', '.redeem-now', function(e){
  e.preventDefault();
  var $el = $(this);
  var playerID = $(this).attr('player-id'),
  rewardID = $(this).attr('reward-id');

  (new PNotify({
      title: 'Confirmation Needed',
      text: 'Are you sure you want redeem player\'s points for this item?',
      icon: 'glyphicon glyphicon-question-sign',
      hide: false,
      confirm: {
          confirm: true
      },
      buttons: {
          closer: false,
          sticker: false
      },
      history: {
          history: false
      },
      stack: {
          'dir1': 'down',
          'dir2': 'left',
          'modal': true
      },
      styling: 'bootstrap3'
  })).get().on('pnotify.confirm', function() {
      $('.ui-pnotify-modal-overlay').fadeOut( 'normal', function(){
        $(this).remove();

        $('#RedeemModal').css('z-index', 99);
        $('#RedeemSuccess').modal('show');
        $('#RedeemSuccess .modal-content').html('<div class="modal-body text-center"><h3><i class="fa fa-spinner fa-spin fa-fw"></i> loading...</h3></div>');
        $.get(SITE_URL +'rewards/redeemnow/'+ playerID +'/'+ rewardID, function(response){
          $('#RedeemSuccess').modal('show');
          $('#RedeemSuccess .modal-content').html(response);
          $('#RedeemModal .modal-body').html('<h3 style="text-align: center;padding-top: 40px;"><i class="fa fa-spinner fa-spin fa-fw"></i> loading...</h3>');
          $('.rdm-pts').html('...');
          $.get('/admin/rewards/redeem/'+ playerID, function(response){
            $('#RedeemModal .modal-body').html(response);
          });
        });
      });
  }).on('pnotify.cancel', function() {
      $('.ui-pnotify-modal-overlay').fadeOut('normal', function(){
          $(this).remove();
      });
  });
});

$(document).on('click', '.close-redeem-scs', function(e){
  e.preventDefault();
  var playerID = $(this).attr('player-id'),
  $player = $('#player-table .player-'+ playerID);

  $('#RedeemSuccess').modal('hide');
  $('#RedeemModal').css('z-index', 9999);

  // Refresh player points
  $('.rdm-pts').html('...');
  $.getJSON(SITE_URL +'player/infojson/'+ playerID, function(response){
    if ( response.status != 200 ){
      window.location.reload();
    } else {
      if ( $player.length > 0 ){
        $player.find('.current-point').val( response.player.redeemable_points );
        $player.find('.current-point-label').html( response.player.redeemable_points );
      }

      $('.rdm-pts').html(response.player.redeemable_points);
    }
  });
});


var changeStatus = function($el, value){
  var $parent = $el.parents('.btn-group'),
  currentState = '';
  if ( $parent.find('.btn-danger').length > 0 )
    currentState = 'rejected';
  else if ( $parent.find('.btn-warning').length > 0 )
    currentState = 'waiting';
  else if ( $parent.find('.btn-success').length > 0 )
    currentState = 'accepted';

  if ( value == 'accepted' ){
    $parent.find('.btn')
      .removeClass('btn-warning btn-danger')
      .addClass('btn-success')
      .html('Received <span class="caret"></span>');

  } else if ( value == 'waiting' ){
    $parent.find('.btn')
      .removeClass('btn-danger btn-success')
      .addClass('btn-warning')
      .html('Waiting <span class="caret"></span>');

  } else if ( value == 'rejected' ){
    $parent.find('.btn')
      .removeClass('btn-warning btn-success')
      .addClass('btn-danger')
      .html('Rejected <span class="caret"></span>');
  }

  $.getJSON('/admin/redeem/status/'+ redeemID +'/'+ value, function(response){
    if ( response.status == 200 ){
      new PNotify({
          icon: false,
          title: 'Status Changed',
          text: 'Change redeem request status success.',
          type: 'success',
          styling: 'bootstrap3'
      });      
    } else {
      if ( currentState == 'accepted' ){
        $parent.find('.btn')
          .removeClass('btn-warning btn-danger')
          .addClass('btn-success')
          .html('Received <span class="caret"></span>');

      } else if ( currentState == 'waiting' ){
        $parent.find('.btn')
          .removeClass('btn-danger btn-success')
          .addClass('btn-warning')
          .html('Waiting <span class="caret"></span>');

      } else if ( currentState == 'rejected' ){
        $parent.find('.btn')
          .removeClass('btn-warning btn-success')
          .addClass('btn-danger')
          .html('Rejected <span class="caret"></span>');
      }

      var message = (typeof response.message != 'undefined') ? message : 'Internal server error, please contact developer.';
      new PNotify({
          icon: false,
          title: 'Change Status Failed!',
          text: message,
          type: 'error',
          styling: 'bootstrap3'
      });
    }
  })
}

$(document).on('click', '.rdm-status-btn', function(e){
  e.preventDefault();
  var $el = $(this);
  value = $el.attr('value'), redeemID = $el.attr('redeem-id');
  if ( value == 'rejected' ){
    (new PNotify({
        title: 'Confirmation Needed',
        text: 'Are you sure you want to reject this request?',
        icon: 'glyphicon glyphicon-question-sign',
        hide: false,
        confirm: {
            confirm: true
        },
        buttons: {
            closer: false,
            sticker: false
        },
        history: {
            history: false
        },
        stack: {
            'dir1': 'down',
            'dir2': 'left',
            'modal': true
        },
        styling: 'bootstrap3'
    })).get().on('pnotify.confirm', function() {
        $('.ui-pnotify-modal-overlay').fadeOut( 'normal', function(){
          $(this).remove();
          changeStatus($el, value);
        });
    }).on('pnotify.cancel', function() {
        $('.ui-pnotify-modal-overlay').fadeOut('normal', function(){
            $(this).remove();
        });
    });
  } else {
    changeStatus($el, value);
  }
});

$(document).on('click', '.open-player-info', function(e){
  e.preventDefault();
  var playerID = $(this).attr('player-id');

  $('#player-info').html('<i class="fa fa-spinner fa-spin fa-fw"></i> loading...');
  $('#PlayerInfo .modal-title').html($(this).find('.td-title').html());
  $('#PlayerInfo').modal('show');
  $.get('/admin/player/info/'+ playerID, function(response){
    $('#player-info').html(response);
  });
})

$(document).on('click', '.show-point-history', function(e){
  e.preventDefault();
  var playerID = $('#PlayerModal .p-player').val();
  $(this).hide();
  $('#player-history').show();
  $.get('/admin/player/history/'+ playerID, function(response){
    $('#player-history').html(response);
  })
});

$(document).on('click', '.player-point', function(e){
  e.preventDefault();
  var $el = $(this);
  var playerID = $el.attr('player-id'), type = $el.attr('type'),
  $player = $('#player-table .player-'+ playerID);

  $('#PlayerModal .current-points').html(0);
  $('#PlayerModal .redeemed-points').html(0);
  $('#PlayerModal .points-earned').html(0);
  $.getJSON(SITE_URL +'player/infojson/'+ playerID, function(response){
    if ( response.status != 200 ){
      $('#PlayerModal .current-points').html(0);
      $('#PlayerModal .redeemed-points').html(0);
      $('#PlayerModal .points-earned').html(0);
    } else {
      $('#PlayerModal .current-points').html(response.player.redeemable_points);
      $('#PlayerModal .redeemed-points').html(response.player.all_points - response.player.redeemable_points);
      $('#PlayerModal .points-earned').html(response.player.all_points);
    }
  });  

  $('#player-history').html('<i class="fa fa-spinner fa-spin fa-fw"></i> loading...').hide();
  $('#PlayerModal .show-point-history').show();
  $('#PlayerModal .p-type').val(type);
  $('#PlayerModal .p-player').val(playerID);
  $('#PlayerModal .points-input').val('');

  if ( type == 'plus' ){
    $('#PlayerModal .modal-title').html( 'Tambah poin: '+ $player.find('h3.td-title').html() );
    $('#PlayerModal .type-label').html('Tambah poin');
  } else {
    $('#PlayerModal .modal-title').html( 'Kurangi poin: '+ $player.find('h3.td-title').html() );
    $('#PlayerModal .type-label').html('Kurangi poin');
  }

  $('#PlayerModal').modal('show');
  $('#player-point').unbind('submit').bind('submit', function(e){
    e.preventDefault();
    var $form = $(this);
    $form.ajaxSubmit({
      dataType: 'json',
      clearForm: false,
      resetForm: false,
      beforeSubmit: function(arr, $form, options){
        $form.find('.alert.alert-danger').hide();
      },
      error: function(){
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
        if ( response.status != 200 ){
            var message = (typeof response.message != 'undefined') ? response.message : 'Internal server error, contact administrator.';
            $form.find('.alert.alert-danger').html(message).show();
        } else {
          $player.find('.current-point').val( response.redeemable_points );
          $player.find('.current-point-label').html( response.redeemable_points );
          $('#PlayerModal').modal('hide');
          new PNotify({
              icon: false,
              title: 'Point Changed',
              text: 'Point change successfully saved.',
              type: 'success',
              styling: 'bootstrap3'
          });
        }
      }
    });
  });
});

