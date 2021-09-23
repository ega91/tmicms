
$(document).on('click', '.delete-stock', function(e){
    e.preventDefault();
    var $el = $(this); var stock_id = $el.attr('data-id');
    var $parent = $el.parents('tr');
    (new PNotify({
        title: 'Confirmation Needed',
        text: 'Are you sure you want delete this item? this action can\'t be undone.',
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
        $parent.fadeOut();
        $('.ui-pnotify-modal-overlay').fadeOut( 'normal', function(){
            $(this).remove();
            $.getJSON(SITE_URL +'stocks/delete/'+ stock_id, function(response){
                if ( response.status == 200 ){
                    $parent.remove();
                } else {
                    $parent.fadeIn();
                    new PNotify({
                        icon: false,
                        title: 'Delete Failed',
                        text: 'Internal server error, please try again later',
                        type: 'error',
                        styling: 'bootstrap3'
                    });
                }
            });
        });
    }).on('pnotify.cancel', function() {
        $('.ui-pnotify-modal-overlay').fadeOut('normal', function(){
            $(this).remove();
        });
    });
});


$(document).on('click', '.delete-rewards', function(e){
    e.preventDefault();
    var $el = $(this); var stock_id = $el.attr('data-id');
    var $parent = $el.parents('tr');
    (new PNotify({
        title: 'Confirmation Needed',
        text: 'Are you sure you want delete this reward item? this action can\'t be undone.',
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
        $parent.fadeOut();
        $('.ui-pnotify-modal-overlay').fadeOut( 'normal', function(){
            $(this).remove();
            $.getJSON(SITE_URL +'rewards/delete/'+ stock_id, function(response){
                if ( response.status == 200 ){
                    $parent.remove();
                } else {
                    $parent.fadeIn();
                    new PNotify({
                        icon: false,
                        title: 'Delete Failed',
                        text: 'Internal server error, please try again later',
                        type: 'error',
                        styling: 'bootstrap3'
                    });
                }
            });
        });
    }).on('pnotify.cancel', function() {
        $('.ui-pnotify-modal-overlay').fadeOut('normal', function(){
            $(this).remove();
        });
    });
});

