
// var script = document.createElement("script");
// script.type = "text/javascript";
// script.src = "https://maps.googleapis.com/maps/api/js?key=AIzaSyCMi6gtkWbn6mTQ-i0PMtsjwnG3MxD-mHY&libraries=places&callback=initMap";
// document.body.appendChild(script);

function initMap(){}

$(document).ready(function(){
    webInit();
    webConfig();
});

$(window).resize(function(){
    webConfig();
});

$(document).on('click', function(){
    docClicked();
});

var afterSubmitEditor, failSubmitEditor;
var editor;
var webInit = function(){

    var ping = function(){
        var timeInMs = Date.now();
        $.get(SITE_URL +'user/ping', function(response){
            var responseTime = Date.now() - timeInMs;
            $('#ping-ms').html(responseTime +'ms')
            response = parseInt(response);
            if (response == 200){
                $('.ping-status').removeClass('pending disconected');
                $('.ping-status').addClass('connected');
            } else if (response == 403) {
                $('.ping-status').removeClass('connected disconected');
                $('.ping-status').addClass('pending');
                $('#need-login').fadeIn('fast');
            } else {
                $('.ping-status').removeClass('connected pending');
                $('.ping-status').addClass('disconected');
            }

            window.setTimeout(ping, 2000);
        })
    }

    $('.ping-status').addClass('pending');
    ping();

    function getSelectionCoords() {
        var sel = document.selection, range, rect;
        var x = 0, y = 0;
        if (sel) {
            if (sel.type != "Control") {
                range = sel.createRange();
                range.collapse(true);
                x = range.boundingLeft;
                y = range.boundingTop;
            }
        } else if (window.getSelection) {
            sel = window.getSelection();
            if (sel.rangeCount) {
                range = sel.getRangeAt(0).cloneRange();
                if (range.getClientRects) {
                    range.collapse(true);
                    if (range.getClientRects().length>0){
                        rect = range.getClientRects()[0];
                        x = rect.left;
                        y = rect.top;
                    }
                }
                // Fall back to inserting a temporary element
                if (x == 0 && y == 0) {
                    var span = document.createElement("span");
                    if (span.getClientRects) {
                        // Ensure span has dimensions and position by
                        // adding a zero-width space character
                        span.appendChild( document.createTextNode("\u200b") );
                        range.insertNode(span);
                        rect = span.getClientRects()[0];
                        x = rect.left;
                        y = rect.top;
                        var spanParent = span.parentNode;
                        spanParent.removeChild(span);

                        // Glue any broken text nodes back together
                        spanParent.normalize();
                    }
                }
            }
        }
        return { x: x, y: y };
    }

    function getSelectionContainer() {
        var range, sel, container;
        sel = window.getSelection();
        if ( sel.anchorNode != null ){
            range = sel.getRangeAt(0);
            if (range) {
                container = range.commonAncestorContainer;
                // Check if the container is a text node and return its parent if so
                return container.nodeType === 3 ? container.parentNode : container;
            }
        }
    }

    if ( $('#content-editor').length > 0 ){
        editor = new MediumEditor('#content-editor', {
            buttonLabels: 'fontawesome',
            anchor: {
                linkValidation: true,
            },
            anchorPreview: false,
            placeholder: {
                hideOnClick: false
            }
        });

        $('.am-container').css({
            top: 0,
            left: -50
        });

        $('#content-editor').focus(function(){
            displayAddButton();
        });

        function displayAddButton(){
            if ( $('#content-editor').children().first().attr('contenteditable') != undefined ){
                $('#content-editor').prepend('<p class="space-before"><br></p>');
            }

            var $el = $(getSelectionContainer());
            $('#content-editor p').removeClass('active-node');
            if ( $el && $el.length > 0 && !$el.hasClass('space-before') ){
                if ( !$el.is('p') ) return;
                theHtml = $.trim($el.html());
                if ( theHtml == '<br>' || theHtml == '<br />' || theHtml == '<br/>' || theHtml == '' ){
                    $('.am-container').css({
                        display: 'block',
                        top: $el.offset().top - $('#content-editor').offset().top,
                        left: ($el.offset().left - $('#content-editor').offset().left) -50
                    });

                    $el.addClass('active-node');
                } else {
                    $('.am-container').hide();
                }
            } else if ( $el && $el.length > 0 && $el.hasClass('space-before') ){
                if ( $el.text().length > 0 ){
                    $el.removeClass('space-before');
                }
            } else {
                $('.am-container').hide();
            }
        }

        $('#content-editor').click(function(){
            displayAddButton();
        });

        $('#content-editor').keyup(function(){
            if ( $.trim($(this).html()) == '' ){
                $(this).html('<p><br></p>');
                MediumEditor.selection.moveCursor(document, $('#content-editor p')[0]);
            }
            displayAddButton();
        })
    }

    if ( $('.sparkline_bar').length > 0 ){
        $.get( SITE_URL +'welcome/activity', function(response){
            $('.sparkline_bar').html(response);
        })
    }
    if ( $('.welcome-event-container').length > 0 ){
        $.get( SITE_URL +'welcome/events', function(response){
            $('.welcome-event-container').html(response);
        })
    }

    if ( $('.select2').length > 0 )
        $('.select2').select2();

    PNotify.prototype.options.delay ? (function() {
        PNotify.prototype.options.delay = 1500;
    }()) : (alert('Timer is already at zero.'));

    if ( $('.new-content-container').length > 0 ){
        sortable('.new-content-container', {
            forcePlaceholderSize: true,
            placeholderClass: 'new-content-placeholder',
            handle: '.sortable-handle'
        });
        $('.new-content-container').on('sortupdate', function(e){
            var $item = $(e.detail.item),
            $parent = $(this), itemFound = false;
            var itemContentIdx = $item.attr('content-idx');

            $parent.children('li.new-content-content').each(function( key, val ){
                $(this).find('.x-order-number').html( (key +1) );
            });

            if ( $item.find('.tinymce').length > 0 ){
                $item.find('.mce-tinymce.mce-container').remove();
                $item.find('.tinymce').show();
                initTinyMce();
            }
        });
    }

    var loadingMore = false;
    if ( $('#load-more-container').length > 0 ){
        var $scContainer = $('#load-more-container');
        $(document).scroll(function(){
            if ( $(document).scrollTop() >= ($('#load-more-bottom').offset().top - $(window).height()) -400 ){
                if ( !loadingMore ){
                    loadingMore = true;
                    var load_ur = $scContainer.attr('load-uri');
                    var last_id = $scContainer.find('.load-more-item').last().attr('item-id');
                    load_ur    += (load_ur.indexOf('?') < 0) ? '?' : '&';
                    load_ur    += 'last_id='+ last_id;
                    $.get(load_ur, function(response){
                        $scContainer.append(response);
                        loadingMore = false;
                    })
                }
            }
        })
    }

    if ( $('#device-header').length > 0 ){
        var $deviceHeader = $('#device-header').clone();
        $deviceHeader.css({
            display     : 'none',
            position    : 'fixed',
            top         : 0,
            left        : $('#device-header').offset().left,
            width       : $('#device-header').width() +32
        });
        $('html body').append( $deviceHeader );
        $(document).scroll(function(){
            if ( $(document).scrollTop() >= $('#device-header').offset().top ){
                $deviceHeader.show();
            } else {
                $deviceHeader.hide();
            }
        });
    }

    $('#need-login-form').ajaxForm({
        dataType: 'json',
        clearForm: false,
        resetForm: false,
        beforeSubmit: function(arr, $form, options){
            $('.signin-error').hide();
            $('.btn-signin').html('Signing in...')
        },
        error: function(){
            $('.btn-signin').html('Sign In');
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
            $('.btn-signin').html('Sign In');
            if (response.status == 200){
                $('#need-login').fadeOut('fast');
                $('.ping-status').removeClass('pending disconected');
                $('.ping-status').addClass('connected');
            } else {
                var message = (typeof response.message != 'undefined') ? response.message : 'Internal server error, contact administrator.';
                $('.signin-error').show().html(message);
            }
        }
    });

    if ( $('.ajax-form').length > 0 ){
        $('.ajax-form').ajaxForm({
            dataType: 'json',
            clearForm: false,
            resetForm: false,
            beforeSubmit: function(arr, $form, options){
                scTo(0);
                $('#upload-progress-header').find('.upload-progress-percent').hide();
                $('#upload-progress-header').show();
            },
            uploadProgress: function(event, position, total, percentComplete) {
                $('#upload-progress-2').width(percentComplete +'%');
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
                    if ( typeof $form.attr('success-uri') != 'undefined' ){
                        window.location.href = $form.attr('success-uri');
                    } else{
                        new PNotify({
                            icon: false,
                            title: 'Data Saved',
                            text: 'Data successfully saved.',
                            type: 'success',
                            styling: 'bootstrap3'
                        });
                    }
                }
            }
        });
    }

    if ( $('#form-uploader').length > 0 ){
        var uploading = false;
        var options = { 
            dataType: 'json',
            clearForm: true,
            resetForm: true,
            beforeSubmit: function(){},
            uploadProgress: function(event, position, total, percentComplete) {
                $('.media-uploaded-item.uploading' +' .upload-progress-percent').html( percentComplete +'%' );
                $('.media-uploaded-item.uploading' +' .upload-progress-2').width( percentComplete +'%' );
            },
            error: function(){
                uploading = false;
                $('#media-dropzone').removeClass('disabled');
                $('.media-uploaded-item.uploading').removeClass('uploading').addClass('failed-upload');
                var message = 'Internal server error, contact administrator.';
                new PNotify({
                    icon: false,
                    title: 'Upload Failed',
                    text: message,
                    type: 'error',
                    styling: 'bootstrap3'
                });
            },
            success: function( response, statusText, xhr, $form ){
                $('#media-dropzone').removeClass('disabled');
                if ( response.status == 200 ){
                    $('.media-uploaded-item.uploading').remove();
                    uploading = false;

                    var imagesSelected = [];
                    $.each(response.images, function(key, image){
                        imagesSelected.push(parseInt(image.id));
                        var $imageItem = $('#media-uploaded-item').clone();
                        $imageItem.removeAttr('id').addClass( 'uploaded' ).css('background-image', 'url("'+ image.image_270 +'")');
                        $('#media-upload-progress .media-uploaded').append( $imageItem );
                    });

                    if ( typeof mediaManagerCallback == 'function' ){
                        mediaManager(mediaManagerCallback, mediaManagerSelection, imagesSelected);
                    }

                    new PNotify({
                        title: 'Upload Media Success',
                        text: 'Image added to library.',
                        type: 'success',
                        styling: 'bootstrap3'
                    });

                } else {
                    $('.media-uploaded-item.uploading').removeClass('uploading').addClass('failed-upload');
                    uploading = false;

                    var message = ( typeof response.message != 'undefined' ) ? response.message : 'Internal server error.';
                    new PNotify({
                        icon: false,
                        title: 'Upload Media Failed',
                        text: message,
                        type: 'error',
                        styling: 'bootstrap3'
                    });
                }
            }
        }; 
        $('#form-uploader').ajaxForm(options);
        $('#file-selector').change(function(){
            if ( !uploading ){

                uploading = true;
                $('#media-dropzone').addClass('disabled');
                var $uploadItem = $('#media-uploaded-item').clone();
                $uploadItem.addClass('uploading').removeAttr('id').css('display', 'inline-block');
                $uploadItem.find('.uploading-label span').html( this.files.length );
                $('#media-upload-progress .media-uploaded').append( $uploadItem );

                $('#form-uploader').submit();
                $(this).val('');
            } else {
                new PNotify({
                    icon: false,
                    title: 'Can\'t Upload',
                    text: 'We are still uploading, please wait upload to finish before you upload another file',
                    type: 'warning',
                    styling: 'bootstrap3'
                });
            }
        });
    }

    $('#media-dropzone').on('dragover', function(e){
        e.preventDefault();
        e.stopPropagation();
        $(this).addClass('dragover');
    }).on('dragleave', function(e){
        e.preventDefault();
        e.stopPropagation();
        $(this).removeClass('dragover');
    }).on('drop', function(e){
        e.preventDefault();
        e.stopPropagation();
        $(this).removeClass('dragover');
        if ( !$(this).hasClass('disabled') ){
            var droppedFiles = e.originalEvent.dataTransfer.files;
            $('#file-selector').prop('files', droppedFiles);
        }
    });


    if ( $('.form-modal').length > 0 ){
        $('.form-modal').on('hide.bs.modal', function (e) {
            reloadPanel();
        })
    }
    reloadPanel();
}

var webConfig = function(){
    var $LEFT_COL = $('.left_col'),
        $RIGHT_COL = $('.right_col');
    $RIGHT_COL.css('min-height', $LEFT_COL.height() - 103);
    window.setTimeout(function(){
        $RIGHT_COL.css('min-height', $LEFT_COL.height() - 103);
    }, 700);

    confPostTitle();

    if ( $('.message-input').length ){
        $('.message-input').width($('.message-content').width() +10);
        $('.message-content').height($(document).height() - 150);
    }

    var winH = $(window).height();
    $('.nav-left-container').css( 'height', winH );
    $('.content-body-container').css( 'height', winH );
    $('.img-container.img-fs').css({
        width: $('.right_col').width() +40,
        'margin-left': -(parseInt($('.col-editor').css('margin-left')) +21)
    });
    $('.page').height($('.page').width())
}

var confPostTitle = function(){
    if ( $('.post-title').length > 0 ){
        $('.post-title').each(function(){
            var textarea = $(this)[0];
            textarea.style.height = textarea.scrollHeight + 'px';
            (textarea.oninput = function() {
              textarea.style.height = 0;
              textarea.style.height = textarea.scrollHeight + 'px';
            })();
        })
    }
}

var docClicked = function(){
    $('.img-container').removeClass('ed-active');
}

var autoSaveEditor = function(){
    if ( parseInt($('#add-desa-form #is_publish').val()) < 1 ){
        $('#add-desa-form').submit();
        window.setTimeout(autoSaveEditor, 60000);
    }
}

var scTo = function( pos, speed ){
    if ( typeof speed == 'undefined' ) speed = 'normal';
    $('html, body').stop().animate({
        scrollTop: pos
    }, speed);
}

$(document).on('hide.bs.modal', '#media-manager', function(){
    mediaManagerCallback = null;
})

var mediaManagerSelection = 'multiple', mediaManagerCallback = null;
var mediaManager = function( callback, _mediaManagerSelection, imagesSelected = null ){
    if ( typeof _mediaManagerSelection == 'undefined' )
        _mediaManagerSelection = 'multiple';
    mediaManagerSelection = _mediaManagerSelection;
    mediaManagerCallback = callback;
    $('#media-manager-library').show();
    $('#media-manager-upload').hide();
    $('#media-manager .upload-media-btn').show();
    $('#media-manager').modal('show');
    $.get( SITE_URL +'media/selector', function( response ){
        var $library = $('#media-manager-library');
        $library.html( response );
        var $libraryContent = $library.find('.media-manager-library-content');
        var libraryH = $(window).height() -122;
        if ( $libraryContent.length > 0 ){
            $libraryContent.animate({ height: libraryH });
        }

        if ( imagesSelected != null ){
            $('.media-item-selector').each(function(){
                var imageID = parseInt($(this).attr('media-id'));
                if ( imagesSelected.indexOf(imageID) >= 0 ){
                    $(this).addClass('selected');
                }
            })
        }

        $library.find('.insert-media').unbind('click')
        .bind('click', function(e){
            e.preventDefault();
            mediaManagerCallback = null;
            var $mediaEl = $('.media-item-selector.selected');
            var media = [];
            $('#media-manager').modal( 'hide' );

            $mediaEl.each(function( key, val ){

                var _media = { 
                    id          : $(this).attr('media-id'), 
                    image       : $(this).attr('image-uri'),
                    image_920   : $(this).attr('image-920'),
                    image_hd    : $(this).attr('image-original') };

                if ( _mediaManagerSelection == 'single' ){
                    if ( key == $mediaEl.length -1 ){
                        if ( typeof callback == 'function' )
                            callback(_media);
                    }
                    return;
                } else {
                    media.push(_media);
                    if ( key == $mediaEl.length -1 ){
                        if ( typeof callback == 'function' )
                            callback(media);
                    }
                }
            });
        });

        window.setTimeout(function(){
            if (  $libraryContent.children( '.row' ).height() > ($libraryContent.height() -30) ){
                $libraryContent.css({ 'overflow-y': 'scroll' });
            }
        }, 600);
    });
}

var htmlEncode = function(value){
  return $('<div/>').text(value).html();
}

var htmlDecode = function(value){
  return $('<div/>').html(value).text();
}

var showLoadingFull = function( message ){
    if ( typeof message == 'undefined' ) message = 'Menyimpan...';
    $('.loading-full span').html( message );
    $('.loading-full').stop().fadeIn('fast');
}

var hideLoadingFull = function(){
    $('.loading-full').fadeOut();
}


/**
 * Insert content into editor 
 *
 */
function insertContent(theContent) {
    $('#content-editor p.active-node').replaceWith(theContent);
    if ( $('#content-editor').children().last().attr('contenteditable') != undefined ){
        $('#content-editor').append('<p><br></p>');
    }
    if ( $('#content-editor').children().first().attr('contenteditable') != undefined ){
        $('#content-editor').prepend('<p class="space-before"><br></p>');
    }
}

$(document).on('click', '.media-item-selector', function(e){
    e.preventDefault();
    var $el = $(this);
    if ( $el.hasClass( 'selected' ) ){
        $el.removeClass('selected');
    } else {
        if ( mediaManagerSelection == 'single' )
            $('.media-item-selector').removeClass('selected');
        $el.addClass('selected');
    }
    $('.media-manager-library-footer p').html( '<b>'+ $('.media-item-selector.selected').length +' media selected</b>' );
});
$(document).on('click', '.bgimage-display img', function(e){
    e.preventDefault();
    $(this).parent().parent().parent().find( '.media-manager-input' ).trigger('click');
});

$(document).on('click', '.media-manager-input', function(e){
    e.preventDefault();
    var $el = $(this);
    mediaManager(function( media ){
        $el.parent().find('.bgimage-input').val( media.id );
        $el.parent().parent().find('.bgimage-display img').attr('src', media.image);
    }, 'single');
});
$(document).on('click', '.delete-bgimage', function(e){
    e.preventDefault();
    if ( confirm('Apakah anda yakin ingin mengahpus gambar ini?') ){
        var $el = $(this);
        $el.parent().parent().find('.bgimage-input').val(0);
        $el.parent().parent().find('.bgimage-display img').attr('src', $el.parent().parent().find('.bgimage-display img').attr('img-placeholder'));
    }
});

$(document).on('click', '.publish-button', function(e){
    e.preventDefault();
    var $el = $(this);
    var success_uri = $el.attr('success-uri');
    afterSubmitEditor = function(response){
        if ( response.status == 200 )
            window.location.href = success_uri;
    }
    $('#is_publish').val(1);
    $('#add-desa-form').submit();
});

$(document).on('click', '.new-section-options a', function(e){
    e.preventDefault();
    var $el = $(this); $parent = $el.parents('.new-section-options');
    if ( $el.hasClass('content-back-btn') ){
        $parent.find('li ul').hide();
    } else if ( $el.parent().find('ul').length > 0 ){
        $el.parent().find('ul').show();
    } else {

        var content_type        = $el.attr('content-type'),
            section_idx         = $el.attr('section-idx');
        var $contentContainer   = $('.new-content-container-'+ section_idx);
        var content_idx         = parseInt($contentContainer.attr('content-idx'));
        content_idx++;

        if ( typeof content_type != 'undefined' && content_type != '' ){
            $parent.addClass('loading');
            $.get( SITE_URL +'data/newcontent?content_type='+ content_type +'&section_idx='+ section_idx +'&content_idx='+ content_idx, function(response){

                // Update UI
                $parent.removeClass('loading');
                $parent.find('li ul').hide();
                $contentContainer.attr('content-idx', content_idx).append( response );
                if ( content_type == 'article' )
                    initTinyMce();
                sortable('.new-content-container');
            });
        }
    }
});
$(document).on('click', '.add-section-btn', function(e){
    e.preventDefault();
    var $el = $(this), section_idx = parseInt($('#new-section-container').attr('section-idx'));
    section_idx++;
    $.get( SITE_URL +'data/newsection?section_idx='+ section_idx, function(response){
        var $response = $(response);
        $('#new-section-container').attr('section-idx', section_idx).append($response);
        scTo( $response.offset().top -20 );
    });
});

$(document).on('click', '.visibility-chooser', function(e){
    var $el = $(this);
    var value = $el.attr('value'), label = $el.html();
    $('.visibility-chooser').removeClass('selected');
    $el.addClass('selected')
    $('#visibility').val( value );
    $('#visibility-display .visibility-display').html( label );
});

$(document).on('click', '.gallery-format-item', function(e){
    e.preventDefault();
    var $el = $(this);
    $el.parent().children('.gallery-format-item').removeClass('selected');
    $el.addClass('selected');
    $el.parent().children('.display_format').val( $el.attr('value') );
});

$(document).on('click', '.add-media-btn', function(e){
    e.preventDefault();
    $('#media-manager-upload').show();
    $('#media-manager-library').hide();
    $('#media-manager .upload-media-btn').hide();
    $('#media-manager').modal('show');
});
$(document).on('click', '.upload-media-btn', function(e){
    e.preventDefault();
    $('#media-manager-upload').show();
    $('#media-manager-library').hide();
    $('#media-manager .upload-media-btn').hide();
    $('#media-manager').modal('show');
})

$(document).on('click', '#media-dropzone', function(e){
    e.preventDefault();
    $('#file-selector').trigger('click');
});

$(document).on('click', '.media-uploaded-item .close-btn', function(e){
    e.preventDefault();
    var $parent = $(this).parents('.media-uploaded-item');
    if ( $parent.hasClass('uploaded') ){
        (new PNotify({
            title: 'Confirmation Needed',
            text: 'Are you sure?',
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
            styling: 'bootstrap3'
        })).get().on('pnotify.confirm', function() {
            $parent.fadeOut('normal', function(){
                $(this).remove();
            });
        }).on('pnotify.cancel', function() {
        });
    } else {
        $parent.fadeOut('normal', function(){
            $(this).remove();
        });
    }
});

function formatBytes(bytes,decimals) {
   if(bytes == 0) return '0 Bytes';
   var k = 1024,
       dm = decimals || 2,
       sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'],
       i = Math.floor(Math.log(bytes) / Math.log(k));
   return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
}

$(document).on('click', '.edit-media', function(e){
    e.preventDefault();
    var editorH = $(window).height() -100;
    var edit_id = $(this).attr( 'edit-id' );

    if ( typeof edit_id == 'undefined' ){
        alert('Edit ID tidak ada.');
        return;
    }

    $('#media-editor').modal('show');
    $('#media-editor-container').css({ 'min-height': editorH });
    $('.editor-image-container').css({ 'min-height': editorH });
    $('#media-editor-container').hide();
    $('#media-editor .alert').hide();
    $('#media-editor .media-editor-loading').show();
    $('#media_edit_id').val(edit_id);

    $.getJSON( SITE_URL +'media/get/'+ edit_id, function(response){
        $('#media-editor .media-editor-loading').hide();
        if ( response.status != 200 ){
            var message = ( typeof response.message != 'undefined' ) ? response.message : 'Internal server error.';
            $('#media-editor .alert').show().html('<h3>Open Image Failed</h3><p>'+ message +'</p>');
        } else {
            $('#media-editor-container').show();
            $('.delete-media.delete-from-modal').attr('media-id', edit_id);
            $('#editor-file-file_size').html( formatBytes(response.image.size) );
            $('#editor-file-file_type').html( response.image.mimetype );

            $('<img/>').attr('id', 'editor-image').attr('src', response.image.image_big).load(function(){
                var $bgImg = $('.editor-image-container'), $img = $(this);
                var imgRatio = this.width / this.height;
                var bgRatio = $bgImg.width() / $bgImg.height();
                if ( imgRatio < bgRatio ){
                    $img.css({ 'max-width': '100%' ,'max-height': 'auto' });
                } else {
                    $img.css({ 'max-width': 'auto' ,'max-height': '100%' });
                }
                $('.editor-image-container').html( $img );
                window.setTimeout(function(){
                    $('.editor-image-container').css({ 'height': $('#media-editor-container .editor-info-container').height() +40 });
                    var marginTop = ($('.editor-image-container').height() - $('.editor-image-container img').height()) /2;
                    $img.animate({ 'margin-top': marginTop }, 'fast');
                }, 400);
            })
        }
    });
});

$(document).on('click', '.delete-post', function(e){
    e.preventDefault();
    var $el = $(this);
    var $parent = $el.parents('.post').parent();

    (new PNotify({
        title: 'Confirmation Needed',
        text: 'Are you sure you want to delete this post?<br />All content will be deleted and can\'t be undone.<br />Image attached will not be deleted, you can find them in Media Library.',
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
        });
        $parent.fadeOut();
        var postID = $el.attr('post-id');
        $.get( SITE_URL +'data/confirm_delete/'+ postID, function(){
            $.getJSON( SITE_URL +'data/delete/'+ postID, function(response){
                if ( response.status == 200 ){
                    $parent.remove();
                    if ( $('.post').length < 1 ){
                        window.location.reload();
                    }
                } else {
                    $parent.fadeIn('fast');
                    var _msg = ( typeof response.message != 'undefined' ) ? response.message : 'Internal server error, please try again later.';
                    new PNotify({
                        icon: false,
                        title: 'Delete Failed',
                        text: _msg,
                        type: 'error',
                        styling: 'bootstrap3'
                    });                    
                }
            });
        });
    }).on('pnotify.cancel', function() {
        $('.ui-pnotify-modal-overlay').fadeOut( 'normal', function(){
            $(this).remove();
        });
    });
});

$(document).on('click', '.preview-post', function(e){
    e.preventDefault();
    var $el = $(this);
    if ( parseInt($('#is_publish').val()) > 0 ){
        (new PNotify({
            title: 'Confirmation Needed',
            text: 'If you preview, all changes you have made will be pulished.<br />Continue?',
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
            styling: 'bootstrap3'
        })).get().on('pnotify.confirm', function() {
            afterSubmitEditor = function( response ){
                if ( response.status == 200 )
                    window.location.href = '/content/preview/' + $('#edit_id').val();
            }
            $('#add-desa-form').submit();
        });
    } else {
        afterSubmitEditor = function( response ){
            if ( response.status == 200 )
                window.location.href = '/content/preview/' + $('#edit_id').val();
        }
        $('#add-desa-form').submit();
    }
});
$(document).on('click', '.collapse-new-content', function(e){
    e.preventDefault();
    var $el = $(this);
    var $parent = $el.parents( 'li.new-content-content' );
    if ( $el.hasClass( 'content-collapsed' ) ){
        $parent.find('.new-content-content-inside').stop().slideDown('normal', function(){
            $el.removeClass('content-collapsed');
        });
    } else {
        $parent.find('.new-content-content-inside').stop().slideUp('normal', function(){
            $el.addClass('content-collapsed');
        });
    }
});
$(document).on('click', '.refresh-new-content', function(e){
    e.preventDefault();
    var $el = $(this);
    var $parent = $el.parents( 'li.new-content-content' );
    $el.find('.fa').addClass('fa-spin');
    window.setTimeout( function(){
        $el.find('.fa').removeClass('fa-spin');
    }, 1600);
    if ( $parent.find( '.tinymce' ).length > 0 ){
        $parent.find('.mce-tinymce.mce-container').remove();
        $parent.find('.tinymce').show();
        initTinyMce();
    }
});
$(document).on('click', '.delete-new-content', function(e){
    e.preventDefault();
    var $el = $(this);
    var $parent = $el.parents( 'li.new-content-content' );
    (new PNotify({
        title: 'Confirmation Needed',
        text: 'Are you sure? Content will be deleted and can\'t be undone.',
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
        styling: 'bootstrap3'
    })).get().on('pnotify.confirm', function() {
        $parent.fadeOut( 'normal', function(){
            $(this).remove();
            $('#add-desa-form').submit();
        });
    });
});
$(document).on('click', '.delete-section', function(e){
    e.preventDefault();
    var $el = $(this);
    var $parent = $el.parents( '.new-section-item' );
    (new PNotify({
        title: 'Confirmation Needed',
        text: 'Are you sure? <br />All content inside this section will be deleted and can\'t be undone.',
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
        });
        $parent.fadeOut( 'normal', function(){
            $(this).remove();
            $('#add-desa-form').submit();
        });
    }).on('pnotify.cancel', function() {
        $('.ui-pnotify-modal-overlay').fadeOut( 'normal', function(){
            $(this).remove();
        });
    });
});
$(document).on('click', '.add-image-gallery', function(e){
    e.preventDefault();
    var $el = $(this);
    var $galleryContainer = $el.parent().children('.content-image-item');
    mediaManager(function(media){
        $.each(media, function(key, val){
            var $image = $galleryContainer.find('.content-image-master').clone();
            $image.find('.content-image-input').val( val.id );
            $image.removeClass('content-image-master').css('background-image', 'url('+ val.image +')');
            $galleryContainer.append($image);
        })
    });
});
$(document).on('click', '.add-image-360', function(e){
    e.preventDefault();
    mediaManager(function(media){
        console.log(media);
    }, 'single');
});
$(document).on('click', '.content-image .close-btn', function(e){
    e.preventDefault();
    var $el = $(this);
    var $parent = $el.parent();
    (new PNotify({
        title: 'Confirmation Needed',
        text: 'Are you sure? <br />All content inside this section will be deleted and can\'t be undone.',
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
        styling: 'bootstrap3'
    })).get().on('pnotify.confirm', function() {
        $parent.fadeOut( 'normal', function(){
            $(this).remove();
            $('#add-desa-form').submit();
        });
    });
});

$(document).on('change', '#provinsi-selector', function(e){
    e.preventDefault();
    $.get( SITE_URL +'user/getcity/'+ $(this).val(), function(response){
        $('#city-selector').html( response );
    })
});

$(document).on('click', '.btn-continue, .a-continue', function(e){
    e.preventDefault();
    var $el = $(this);
    var continue_to = $el.attr( 'continue-to' );

    if ( $('#edit_id').val() == '' || $('#edit_id').val() == '0' ){

        showLoadingFull();
        saveCreateDevice( function(response){
            if ( response.status == 200 ){
                $('#edit_id').val( response.device_id );
                window.history.replaceState(null, false, SITE_URL +'device/edit/'+ response.device_id);
                createBookGotoSection( continue_to );
            }
        })

    } else {
        createBookGotoSection( continue_to );
        saveCreateDevice();
    }
});


$(document).on('click', '.device-header .checkbox-container', function(e){
    e.preventDefault();
    var $el = $(this);
    if ( $el.hasClass('checked') ){
        $('.device-selected-label').html('');
        $('.checkbox-container').removeClass('checked');
        $('.action-selected-device').addClass('disabled');
        $('.action-selected-device .dropdown-toggle').addClass('disabled');
    } else {
        $('.checkbox-container').addClass('checked');
        $('.action-selected-device').removeClass('disabled');
        $('.action-selected-device .dropdown-toggle').removeClass('disabled');
        $('.device-selected-label').html($('.checkbox-container.checked').length +' devices selected');
    }
});

$(document).on('click', '.device-item-only .checkbox-container', function(e){
    e.preventDefault();
    var $el = $(this);
    if ( $el.hasClass('checked') ){
        $el.removeClass('checked');
    } else {
        $el.addClass('checked');
    }

    if ( $('.checkbox-container.checked').length > 0 ){
        $('.device-selected-label').html($('.checkbox-container.checked').length +' devices selected');
        $('.action-selected-device').removeClass('disabled');
        $('.action-selected-device .dropdown-toggle').removeClass('disabled');
    } else {
        $('.device-selected-label').html('');
        $('.action-selected-device').addClass('disabled');
        $('.action-selected-device .dropdown-toggle').addClass('disabled');
    }
});

var deleteSelectedDevice = function( callback ){
    var $item = $('.device-item-only .checkbox-container.checked').first();
    $deviceItem = $item.parents('.device-item-only');
    if ( $item.length > 0 ){

        var device_id = $deviceItem.attr('device-id');
        $.get( SITE_URL +'device/confirm_delete/'+ device_id, function(){
            $.getJSON( SITE_URL +'device/delete/'+ device_id, function(response){
                if ( response.status == 200 ){
                    $deviceItem.fadeOut( 'fast', function(){
                        $(this).remove();
                        deleteSelectedDevice( callback );
                    });
                } else {
                    if ( typeof callback == 'function' ) callback('failed');
                }
            });
        });
    } else {
        if ( typeof callback == 'function' ) callback('success');
    }
}

$(document).on('click', '.delete-selected-device', function(e){
    e.preventDefault();
    (new PNotify({
        title: 'Confirmation Needed',
        text: 'Are you sure you want to delete selected devices?<br />All selected devices will be deleted and cant be undone.',
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
        });
        showLoadingFull( 'Deleting devices...' );
        let deviceWillDeletedCount = $('.device-item-only .checkbox-container.checked').length;
        deleteSelectedDevice(function( status ){
            hideLoadingFull();
            if ( status == 'failed' ){
                new PNotify({
                    icon: false,
                    title: 'Delete Failed',
                    text: 'Internal server error, please try again later',
                    type: 'error',
                    styling: 'bootstrap3'
                });
            } else {
                $('.checkbox-container').removeClass('checked');
                new PNotify({
                    icon: false,
                    title: deviceWillDeletedCount + 'Devices Deleted.',
                    text: 'Selected devices successfully deleted.',
                    type: 'success',
                    styling: 'bootstrap3'
                });
            }
        });
    }).on('pnotify.cancel', function() {
        $('.ui-pnotify-modal-overlay').fadeOut( 'normal', function(){
            $(this).remove();
        });
    });
});

$(document).on('click', '.set-featured-selected', function(e){
    e.preventDefault();
});

$(document).on('click', '.with-sort', function(e){
    e.preventDefault();
    window.location.href = $(this).attr('uri');
})

$(document).on('keydown', '#pac-input', function(e){
    if ( e.keyCode == 13 ){
        e.preventDefault();
    }
});

$(document).on('click', '.edit-lat-lng', function(e){
    e.preventDefault();
    var $modalEl = $('#input-latlng-modal');
    $modalEl.find('#lat_input').val($('#lat').val());
    $modalEl.find('#lng_input').val($('#lng').val());
    $modalEl.modal('show');
});

$(document).on('click', '.save-input-latlng', function(e){
    e.preventDefault();
    var _lat = parseFloat($('#lat_input').val()), _lng = parseFloat($('#lng_input').val());
    var _pos = { lat: _lat, lng: _lng };

    $('#lat-label').html(_lat);
    $('#lng-label').html(_lng);
    $('#lat').val(_lat);
    $('#lng').val(_lng);

    map.setCenter(_pos);
    map.setZoom(14);
    marker.setPosition(_pos);

    $('#input-latlng-modal').modal('hide');
});


$(document).on('click', '.add-user-btn', function(e){
    e.preventDefault();
    $('#add-user-modal').modal('show');
});

$(document).on('click', '.delete-media', function(e){
    e.preventDefault();
    var $el = $(this); var media_id = $el.attr('media-id');
    var is_modal = ($el.hasClass('delete-from-modal'));
    if ( is_modal )
        $modal = $('#media-editor');
    else
        $parent = $el.parents('.media-item-col');

    (new PNotify({
        title: 'Confirmation Needed',
        text: 'Are you sure you want to delete this image?<br />Device, notifcation, app content, or page wich this image attached will show image not found.',
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
        styling: 'bootstrap3'
    })).get().on('pnotify.confirm', function() {
        if ( is_modal )
            $modal.modal('hide');
        else
            $parent.stop().fadeOut();
        $.getJSON(SITE_URL +'media/delete/'+ media_id, function(response){
            if ( response.status == 200 ){
                window.setTimeout(function(){
                    if ( !is_modal )
                        $parent.remove();
                    else
                        window.location.reload();
                }, 200);
            } else {
                if ( !is_modal )
                    $parent.stop().fadeIn();
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
});

$(document).on('click', '.delete-user', function(e){
    e.preventDefault();
    var $el = $(this); var user_id = $el.attr('user-id');
    var $parent = $el.parents('tr');
    (new PNotify({
        title: 'Confirmation Needed',
        text: 'Are you sure you want delete this user? this action can\'t be undone.',
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
            $.getJSON(SITE_URL +'user/delete/'+ user_id, function(response){
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

$(document).on('click', '.ban-user', function(e){
    e.preventDefault();
    var $el = $(this); var user_id = $el.attr('user-id');
    var $parent = $el.parents('tr');
    (new PNotify({
        title: 'Confirmation Needed',
        text: 'Are you sure you want ban this user?',
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
        $parent.addClass('banned');
        $('.ui-pnotify-modal-overlay').fadeOut( 'normal', function(){
            $(this).remove();
            $.getJSON(SITE_URL +'user/ban/'+ user_id, function(response){
                if ( response.status == 200 ){
                    $el.addClass('unban-user').removeClass('ban-user')
                    .html('<i class="fa fa-unlock"></i> Unban User');
                } else{
                    $parent.removeClass('banned');
                    new PNotify({
                        icon: false,
                        title: 'Ban User Failed',
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

$(document).on('click', '.unban-user', function(e){
    e.preventDefault();
    var $el = $(this); var user_id = $el.attr('user-id');
    var $parent = $el.parents('tr');
    (new PNotify({
        title: 'Confirmation Needed',
        text: 'Are you sure you want unban this user?',
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
        $parent.removeClass('banned');
        $('.ui-pnotify-modal-overlay').fadeOut( 'normal', function(){
            $(this).remove();
            $.getJSON(SITE_URL +'user/unban/'+ user_id, function(response){
                if ( response.status == 200 ){
                    $el.removeClass('unban-user').addClass('ban-user')
                    .html('<i class="fa fa-ban"></i> Ban User')
                } else{
                    $parent.addClass('banned');
                    new PNotify({
                        icon: false,
                        title: 'Unban User Failed',
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

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#blah').attr('src', e.target.result);
            if ($('.x-open-input.bgimage-display').height() > $('#blah').width())
                $('.x-open-input.bgimage-display').height( $('#blah').width() );
        }
        reader.readAsDataURL(input.files[0]);
    }
}

$(document).on('click', '.x-open-input', function(e){
    e.preventDefault();
    $('.x-bgimage-input').trigger('click');
});
$(document).on('change', '.x-bgimage-input', function(e){
    e.preventDefault();
    readURL(this);
});

$(document).on('click', '.show-change-password', function(e){
    e.preventDefault();
    $(this).hide();
    $('#change-password-container').show();
});

$(document).on('change', '.event-desa-checkbox', function(e){
    if ( $(this)[0].checked ){
        $('.event-desa-container').show();
    } else {
        $('.event-desa-container').hide();
    }
});

$(document).on('click', '.delete-x-bgimage', function(e){
    e.preventDefault();
    if ( confirm('Apakah kamu yakin ingin menghapus foto profil?') ){
        $('.bgimage-display img').attr('src', $('.bgimage-display img').attr('img-placeholder'));
        $('.delete-image').val(1);
        $('.x-bgimage-input').val('');
    }
});

$(document).on('click', '.publish-post', function(e){
    e.preventDefault();
    var post_id = $(this).attr('post-id');
    (new PNotify({
        title: 'Confirmation Needed',
        text: 'Are you sure you want to publish this post?',
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
        styling: 'bootstrap3'
    })).get().on('pnotify.confirm', function() {
        $.getJSON( SITE_URL +'data/publish/'+ post_id, function(response){
            if (response.status != 200){
                new PNotify({
                    icon: false,
                    title: 'Publish Failed',
                    text: 'Internal server error, please try again later.',
                    type: 'error',
                    styling: 'bootstrap3'
                });
            } else {
                refreshPost( post_id );
                new PNotify({
                    icon: false,
                    title: 'Content Published',
                    text: 'Content successfully published.',
                    type: 'success',
                    styling: 'bootstrap3'
                });
            }
        });
    });
});

$(document).on('click', '.set-featured', function(e){
    e.preventDefault();
    var post_id = $(this).attr('post-id');
    $.get( SITE_URL +'data/setfeatured/'+ post_id, function(){
        refreshPost( post_id );
    });
});

$(document).on('click', '.unset-featured', function(e){
    e.preventDefault();
    var post_id = $(this).attr('post-id');
    (new PNotify({
        title: 'Confirmation Needed',
        text: 'Are you sure you want to unset featured label for this post?',
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
        styling: 'bootstrap3'
    })).get().on('pnotify.confirm', function() {
        $.get( SITE_URL +'data/unsetfeatured/'+ post_id, function(){
            refreshPost( post_id );
        });
    });
});

var refreshPost = function(id){
    $.get( SITE_URL +'data/refresh/'+ id, function(response){
        $('#post-item-'+ id).replaceWith(response);
    });
}

$(document).on('click', '.open-am', function(e){
    e.preventDefault();
    if ( $('.am-container').hasClass('open') ){
        $('.am-container').removeClass('open');
        window.setTimeout(function(){
            $('.am-btn-container').fadeOut(100, function(){})
        }, 300);
    } else {
        $('.am-btn-container').fadeIn(100, function(){
            $('.am-container').addClass('open');
        });
    }
});

$(document).on('click', '.am-btn', function(){
    $('.am-container').removeClass('open');
    window.setTimeout(function(){
        $('.am-btn-container').fadeOut(100, function(){})
    }, 300);
})

var reloadEditor = function(){
    editor.destroy();
    $('.content-editor').each(function(){
        if ( $(this).html() == '' || $(this).html() == ' ' ){
            $(this).remove();
        }
    })
    editor.setup();
}

var addAndReloadEditor = function(){
    var editorID = 'editor-'+ $('.content-editor').length;
    editor.destroy();
    $('.content-editor').each(function(){
        if ( $(this).html() == '' || $(this).html() == ' ' ){
            $(this).remove();
        }
    })
    $('<div/>')
        .attr('content-type', 'article')
        .attr('id', editorID)
        .addClass('content-editor ed-section')
        .appendTo('#ce-container');
    editor.setup();
}

var validateYouTubeUrl = function(url){
    if (url != undefined || url != '') {
        var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=|\?v=)([^#\&\?]*).*/;
        var match = url.match(regExp);
        if (match && match[2].length == 11) 
            return match[2];
        else
            return false;
    }
}

$(document).on('keydown', function(e){
    if ( $('.img-container.ed-active').length > 0 ){
        var $el = $('.img-container.ed-active');
        // 8 Backspace, 46 Delete
        if ( e.keyCode == 8 ){
            $el.removeClass('ed-active');
            $('<p><br></p>').insertBefore($el);
            MediumEditor.selection.moveCursor(document, $el.next()[0]);
            $('#content-editor').focus();
        } else if ( e.keyCode == 46 ){
            $el.removeClass('ed-active');
            $('<p><br></p>').insertAfter($el);
            MediumEditor.selection.moveCursor(document, $el.prev()[0], $el.prev()[0].childNodes.length);
            $('#content-editor').focus();
        } else if ( e.keyCode == 13 ){
            e.preventDefault();
            $el.removeClass('ed-active');
            MediumEditor.selection.moveCursor(document, $el.next()[0]);
            $('#content-editor').focus();
        }
    }
})

$(document).on('click', '.am-btn-img', function(e){
    e.preventDefault();
    $('.am-container').hide();
    mediaManager(function(media){
        var _image = (media.width > 920) ? media.image_920 : media.image_hd;

        var $imgCnt = $('<figure/>')
            .attr('content-type', 'image')
            .attr('image-id', media.id)
            .attr('media-mode', 'inside')
            .attr('contenteditable', 'false')
            .addClass('img-container img-inside ed-section');
        $('<img/>')
            .attr('src', _image)
            .attr('data-id', media.id)
            .appendTo($imgCnt);
        $('<input/>')
            .attr('type', 'text')
            .attr('placeholder', 'Caption for this image (optional)')
            .addClass('img-caption')
            .appendTo($imgCnt);
        var $imgConfig = $('<div/>')
            .addClass('img-cnf-cnt')
        $('<li/>')
            .attr('img-mode', 'left')
            .addClass('img-cnf img-cnf-l')
            .appendTo($imgConfig)
        $('<li/>')
            .attr('img-mode', 'right')
            .addClass('img-cnf img-cnf-r')
            .appendTo($imgConfig)
        $('<li/>')
            .attr('img-mode', 'inside')
            .addClass('img-cnf img-cnf-in active')
            .appendTo($imgConfig)
        if ( media.width > 720 ){
            $('<li/>')
                .attr('img-mode', 'wide')
                .addClass('img-cnf img-cnf-wide')
                .appendTo($imgConfig)
            if ((media.width / media.height) > 1.25){
                $('<li/>')
                    .attr('img-mode', 'fs')
                    .addClass('img-cnf img-cnf-fs')
                    .appendTo($imgConfig)
            }
        }
        $imgCnt.append($imgConfig);
        insertContent($imgCnt);

        window.setTimeout(function(){
            $imgCnt.addClass('ed-active');
        }, 300)
    }, 'single');
})

$(document).on('click', '.img-container', function(e){
    e.stopPropagation();
    e.preventDefault();
    $('.img-container').removeClass('ed-active');
    $(this).addClass('ed-active');
    $('#content-editor').blur();
})

$(document).on('click', '.img-cnf', function(e){
    e.preventDefault();
    var imgMode = $(this).attr('img-mode');
    var $parent = $(this).parents('.img-container')
        .removeClass('img-wide img-left img-right img-inside img-fs')
        .attr('media-mode', imgMode)
        .addClass('img-'+ imgMode);
    if ( imgMode == 'fs' ){
        $parent.css({
            width: $('.right_col').width() +40,
            'margin-left': -(parseInt($('.col-editor').css('margin-left')) +21)
        })
    }
    $parent.find('.img-cnf').removeClass('active');
    $(this).addClass('active');
});

$(document).on('blur', '.img-caption', function(){
    if ( $(this).val() != '' ){
        $(this).addClass('with-content');
    } else {
        $(this).removeClass('with-content');
    }
});

$(document).on('keydown', '.img-caption', function(e){
    if (e.keyCode == 13){
        e.preventDefault();
    } else if (e.keyCode == 8 || e.keyCode == 27){
        e.stopPropagation();
    }
});

$(document).on('click', '.am-btn-video', function(e){
    e.preventDefault();
    $('.am-container').hide();
    var $videoInputCnt = $('<figure/>')
        .addClass('input-video  img-container')
        .attr('contenteditable', 'false');
    $videoInput = $('<input/>')
        .attr('type', 'text')
        .attr('placeholder', 'Paste youtube video link here and hit enter')
        .appendTo($videoInputCnt)
    insertContent($videoInputCnt);
    window.setTimeout(function(){
        $videoInput.focus();
    }, 300)
    $videoInput.bind('keydown', function(e){
        if ( e.keyCode == 27 ){
            $videoInputCnt.remove();
            $('#content-editor').focus();
        } else if ( e.keyCode == 8 ){
            if ( $videoInput.val() == '' ){
                $videoInputCnt.remove();
                $('#content-editor').focus();
            }
        } else if ( e.keyCode == 13 ){
            e.preventDefault();
            var videoLink = $(this).val();
            var videoID = validateYouTubeUrl( videoLink );
            if ( videoID ){
                var $videoCnt = $('<figure/>')
                    .attr('content-type', 'youtube')
                    .attr('youtube-id', videoID)
                    .attr('media-mode', 'inside')
                    .attr('contenteditable', 'false')
                    .addClass('img-container img-inside ed-section');
                $('<div/>')
                    .addClass('video-overlay')
                    .appendTo($videoCnt)
                $('<iframe/>')
                    .addClass('video-iframe')
                    .attr('frameborder', 0)
                    .attr('allowfullscreen', true)
                    .attr('src', 'https://www.youtube.com/embed/'+ videoID)
                    .appendTo($videoCnt);
                $('<input/>')
                    .attr('type', 'text')
                    .attr('placeholder', 'Caption for this video (optional)')
                    .addClass('img-caption')
                    .appendTo($videoCnt);

                var $imgConfig = $('<div/>')
                    .addClass('img-cnf-cnt')
                $('<li/>')
                    .attr('img-mode', 'left')
                    .addClass('img-cnf img-cnf-l')
                    .appendTo($imgConfig)
                $('<li/>')
                    .attr('img-mode', 'right')
                    .addClass('img-cnf img-cnf-r')
                    .appendTo($imgConfig)
                $('<li/>')
                    .attr('img-mode', 'inside')
                    .addClass('img-cnf img-cnf-in active')
                    .appendTo($imgConfig)
                $('<li/>')
                    .attr('img-mode', 'wide')
                    .addClass('img-cnf img-cnf-wide')
                    .appendTo($imgConfig)
                $('<li/>')
                    .attr('img-mode', 'fs')
                    .addClass('img-cnf img-cnf-fs')
                    .appendTo($imgConfig)
                $videoCnt.append($imgConfig);
                $videoInputCnt.replaceWith($videoCnt);

                window.setTimeout(function(){
                    $videoCnt.addClass('ed-active');
                }, 300)
            }
            $videoInputCnt.remove();
            $('#content-editor').focus();
        }
    })
});

$(document).on('click', '.am-btn-embed', function(e){
    e.preventDefault();
    $('.am-container').hide();
    var $embedInputCnt = $('<figure/>')
        .addClass('input-embed img-container')
        .attr('contenteditable', 'false')
    var $embedInput = $('<input/>')
        .attr('type', 'text')
        .attr('placeholder', 'Paste embed code (twitter, instagram, google map, etc) here and hit enter')
        .appendTo($embedInputCnt);
    insertContent($embedInputCnt);
    window.setTimeout(function(){
        $embedInput.focus();
    }, 300);
    $embedInput.bind('keydown', function(e){
        if ( e.keyCode == 27 ){
            $embedInputCnt.remove();
            $('#content-editor').focus();
        } else if ( e.keyCode == 8 ){
            if ( $embedInput.val() == '' ){
                $embedInputCnt.remove();
                $('#content-editor').focus();
            }
        } else if ( e.keyCode == 13 ){
            e.preventDefault();
            var embedCode = $(this).val();
            var $embedCnt = $('<figure/>')
                .attr('content-type', 'embed')
                .attr('media-mode', 'inside')
                .attr('contenteditable', 'false')
                .addClass('img-container img-inside ed-section');
            $('<input/>')
                .attr('type', 'text')
                .addClass('hidden hidden-embed-code')
                .val(embedCode)
                .appendTo($embedCnt);
            $('<div/>')
                .addClass('video-overlay')
                .appendTo($embedCnt);
            $('<div/>')
                .addClass('embed-content')
                .html(embedCode)
                .appendTo($embedCnt);
            $('<input/>')
                .attr('type', 'text')
                .attr('placeholder', 'Caption for this embed (optional)')
                .addClass('img-caption')
                .appendTo($embedCnt);

            var $imgConfig = $('<div/>')
                .addClass('img-cnf-cnt')
            $('<li/>')
                .attr('img-mode', 'left')
                .addClass('img-cnf img-cnf-l')
                .appendTo($imgConfig)
            $('<li/>')
                .attr('img-mode', 'right')
                .addClass('img-cnf img-cnf-r')
                .appendTo($imgConfig)
            $('<li/>')
                .attr('img-mode', 'inside')
                .addClass('img-cnf img-cnf-in active')
                .appendTo($imgConfig)
            $('<li/>')
                .attr('img-mode', 'wide')
                .addClass('img-cnf img-cnf-wide')
                .appendTo($imgConfig)
            $('<li/>')
                .attr('img-mode', 'fs')
                .addClass('img-cnf img-cnf-fs')
                .appendTo($imgConfig)
            $embedCnt.append($imgConfig);
            $embedInputCnt.replaceWith($embedCnt);
            $('#content-editor').focus();

            window.setTimeout(function(){
                $embedCnt.addClass('ed-active');
            }, 300)
        }
    })
});

$(document).on('click', '#publish-post', function(e){
    e.preventDefault();
    publishPost(function(response){
        window.location.href = SITE_URL +'articles';
    })
})

var publishPost = function(callback){
    var data = {};
    data.id             = $('#edit_id').val();
    data.lang           = $('#lang').val();
    data.parent         = $('#post_parent').val();
    data.title          = $('#post-title').val();
    data.content        = $('#content-editor').html().trim();
    data.date           = $('#ed-date').html() +' '+ $('#ed-month').html() +' '+ $('#ed-year').html();
    data.time           = $('#ed-hour').html() +':'+ $('#ed-minute').html() +''+ $('#ed-ampm').html();
    data.display_author = ($('.display-author').attr('value') == 'on');
    data.allow_comment  = ($('.allow-comment').attr('value') == 'on');
    data.featured_image = $('#featured_image').val();
    data.is_publish     = 1;
    data.tags           = $('#ed-tags').val();
    data.cat            = [];
    $('#category-wrapper a.selected').each(function(){
        data.cat.push($(this).attr('value'));
    })

    var $images = $('#content-editor').find('img'),
        firstImg = 0, imgFound = false;
    $images.each(function(key, val){
        var imageID = parseInt($(this).parents('.img-container').attr('image-id'));
        if ( key == 0 ) firstImg = imageID;
        if ( imageID == data.featured_image ){
            imgFound = true;
        }
    });
    if ( !imgFound ) data.featured_image = firstImg;

    if ( data.featured_image == 0 && $('#content-editor img').length > 0 ){
        var $theImg = $('#content-editor img').first();
        if ( $theImg.parent().attr('content-type') == 'image' ){
            data.featured_image = $theImg.parent().attr('image-id');
        }
    }

    if ( $('#trip-images').length > 0 ){
        data.images = [];
        $('.trip-image').each(function(){
            var $el = $(this);
            data.images.push({
                id: $el.attr('media-id'),
                active: $el.hasClass('active')
            })
        })

        data.price = $('#trip-price').val();
        data.price_person = $('#trip-price-person').attr('person');
    }

    $.post(SITE_URL +'articles/save', data, function(response){
        if ( response.status == 200 ){
            if ( typeof callback == 'function' ){
                callback(response);
            }
        } else {
            var message = (typeof response.message != 'undefined') ? response.message : 'Internal server error, contact administrator.';
            new PNotify({
                icon: false,
                title: 'Save Failed',
                text: message,
                type: 'error',
                styling: 'bootstrap3'
            });
        }
    }, 'json');
}

$(document).on('click', '#publish-page', function(e){
    e.preventDefault();
    var data = {};
    data.id             = $('#edit_id').val();
    data.title          = $('#page-title').val();
    data.subtitle       = $('#page-subtitle').val();
    data.content        = $('#content-editor').html().trim();
    data.header_image   = $('#header_image').val();
    data.tags           = $('#ed-tags').val();
    data.is_publish     = 1;

    $.post('/admin/page/save', data, function(response){
        if ( response.status == 200 ){
            window.location.href = SITE_URL +'page/view/'+ response.slug;
        } else {
            var message = (typeof response.message != 'undefined') ? response.message : 'Internal server error, contact administrator.';
            new PNotify({
                icon: false,
                title: 'Save Failed',
                text: message,
                type: 'error',
                styling: 'bootstrap3'
            });
        }
    }, 'json');
})

$(document).on('click', '.editor-config-cnt .dropdown-menu', function(e){
    e.preventDefault();
    e.stopPropagation();
})

$(document).on('click', '.editor-config-cnt a', function(){
    var featuredImg = parseInt($('#featured_image').val());
    var $images = $('#content-editor').find('img');
    $('.featured-img-select-img').remove();
    $images.each(function(){
        var imageID = parseInt($(this).parents('.img-container').attr('image-id'));
        var $imgItem = $('<div/>')
            .addClass('featured-img-select-img featured-img-select')
            .attr('src', $(this).attr('src'))
            .attr('image-id', imageID)
            .css('background-image', 'url(\''+ encodeURI($(this).attr('src')) +'\')')
            .html('&nbsp')
        if ( imageID == featuredImg ){
            $imgItem.addClass('active');
        }
        $imgItem.appendTo('#featured-img-cnt');
    })
    if ( $('.featured-img-select-img').length > 0 && featuredImg == 0 ){
        $('.featured-img-select').removeClass('active');
        $('.featured-img-select-img').eq(0).addClass('active');
    }
});

$(document).on('click', '.toggle', function(e){
    e.preventDefault();
    if ( $(this).hasClass('on') ){
        $(this).removeClass('on');
        $(this).attr('value', 'off').trigger('change');
    } else {
        $(this).addClass('on');
        $(this).attr('value', 'on').trigger('change');
    }
});
$(document).on('change', '.display-author', function(){
    if ( $(this).attr('value') == 'on' ){
        $('#article-user').fadeIn('fast');
    } else {
        $('#article-user').fadeOut('fast');
    }
});

$(document).on('click', '.add-new-action', function(){
    window.location.href = $(this).attr('href');
})

$(document).on('click', '.au-date .dropdown-menu li a', function(e){
    e.preventDefault();
    $(this).parents('.dropdown').children('.dropdown-toggle').html($(this).html());
})

$(document).on('click', '.featured-img-select', function(e){
    e.preventDefault();
    var imageID = $(this).attr('image-id');
    $('#featured_image').val(imageID);
    $('.featured-img-select').removeClass('active');
    $(this).addClass('active');
});

$(document).on('click', '.editor-cat-ddm li a', function(e){
    e.preventDefault();
})

$(document).on('click', '.editor-cat-ddm', function(e){
    e.stopPropagation();
})

$(document).on('click', '.add-post-category', function(e){
    e.preventDefault();
    $('#category-wrapper li').each(function(){
        if ( $(this).find('input').length > 0 ){
            $(this).remove();
        }
    })

    var $el = $(this);
    var parentID = $el.attr('post-parent')
    var $newCatCnt = $('<li/>');
    var $newCat = $('<input/>')
        .attr('type', 'text')
        .attr('id', 'new-category')
        .attr('placeholder', 'Category title')
        .appendTo($newCatCnt);
    $('#category-wrapper').append($newCatCnt);

    var doneEditing = function( $parent ){
        var catValue = $newCat.val();
        if ( catValue.trim() != '' && catValue != ' ' ){
            $parent.html('<a href="#" class="cat-name">'+ catValue +'</a>');
            $.post('/admin/data/addcategory/'+ parentID, {cat: catValue}, function(response){
                if ( response.status == 200 ){
                    $parent.find('a').attr('value', response.id);
                    $parent.attr('cat-id', response.id)
                        .append('<span class="edit-cat"><i class="fa fa-pencil"></i></span><span class="delete-cat"></span>');
                } else {
                    $parent.remove();
                    alert('Failed to add category. Please try again later.');
                }
            }, 'json');
        } else {
            $el.parent().remove();
        }
    }

    var cancelEditing = function( $parent ){
        $parent.remove();
    }

    $newCat.focus().bind('keydown', function(e){
        if ( e.keyCode == 13 ){
            e.preventDefault();
            doneEditing( $(this).parent() );
        } else if ( e.keyCode == 27 ){
            e.preventDefault();
            e.stopPropagation();
            cancelEditing( $(this).parent() );
        }
    }).blur(function(){
        doneEditing( $(this).parent() );
    });
})

$(document).on('click', '#category-wrapper a', function(e){
    e.preventDefault();
    if ( $(this).hasClass('selected') )
        $(this).removeClass('selected');
    else
        $(this).addClass('selected');
})


function reloadCategory(){
    var $parent = $('#cat-filter');
    if ( $parent.length > 0 ){
        var parentID = $parent.attr('parent-id');
        $.get(SITE_URL +'data/getcat/'+ parentID, function(response){
            $parent.html(response);
        });
    }
}

$(document).on('click', '.delete-cat', function(e){
    e.preventDefault();
    var $parent = $(this).parent();
    (new PNotify({
        title: 'Confirmation Needed',
        text: 'Are you sure you want to delete '+ $parent.children('.cat-name').html() +' category?',
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
        styling: 'bootstrap3'
    })).get().on('pnotify.confirm', function() {
        $parent.hide();
        var catID = $parent.attr('cat-id');
        $.getJSON( SITE_URL +'data/deletecat/'+ catID, function(response){
            if ( response.status == 200 ){
                $parent.remove();
                reloadCategory();
            } else {
                $parent.fadeIn('fast');
                var _msg = ( typeof response.message != 'undefined' ) ? response.message : 'Internal server error, please try again later.';
                new PNotify({
                    icon: false,
                    title: 'Delete Failed',
                    text: _msg,
                    type: 'error',
                    styling: 'bootstrap3'
                });
            }
        });
    }).on('pnotify.cancel', function() {
    });
})

$(document).on('click', '.edit-cat', function(e){
    e.preventDefault();
    e.stopPropagation();
    var $parent = $(this).parent();
    var catName = $parent.children('.cat-name').html();
    var $input  = $('<input/>')
        .attr('type', 'text')
        .attr('placeholder', 'Category title')
        .addClass('form-control')
        .val(catName);
    var doneEditing = function(){
        $parent.removeClass('editing')
            .children('.cat-name').html($input.val());
        var catID = $parent.attr('cat-id');
        $.post('/admin/data/editcat/'+ catID, {cat: $input.val().trim()}, function(response){
            if ( response.status == 200 ){
                reloadCategory();
            } else {
                cancelEditing();
                alert('Failed to add category. Please try again later.');
            }
        }, 'json');
    }
    var cancelEditing = function(){
        $parent.removeClass('editing')
            .children('.cat-name').html(catName);
    }

    $parent.addClass('editing')
        .children('.cat-name').html($input);
    $input.focus().select();
    $input.bind('keydown', function(e){
        if ( e.keyCode == 13 ){
            e.preventDefault();
            doneEditing();
        } else if ( e.keyCode == 27 ){
            e.preventDefault();
            e.stopPropagation();
            cancelEditing();
        }
    }).blur(function(){
        doneEditing();
    })
});

$(document).on('click', '.cat-filter-add', function(e){
    e.preventDefault();
    if ( $('#cat-filter-new').length > 0 ){
        $('#cat-filter-new').focus();
    } else {
        var $inputCnt = $('<li/>')
        var $inputSpan = $('<a/>')
            .attr('href', '#')
            .addClass('cat-name')
            .appendTo($inputCnt);
        var $input  = $('<input/>')
            .attr('type', 'text')
            .attr('placeholder', 'Category title')
            .attr('id', 'cat-filter-new')
            .addClass('form-control')
            .appendTo($inputSpan);
        var doneEditing = function($parent){
            if ( $input.val().trim() == '' )
                return cancelEditing( $parent );
            $parent.html('<a href="#" class="cat-name">'+ $input.val() +'</a> <span class="edit-cat"><i class="fa fa-pencil"></i></span><span class="delete-cat"></span>');
            var parentID = $('.cat-filter-modal').attr('parent-id');
            $.post('/admin/data/addcategory/'+ parentID, {cat: $input.val().trim()}, function(response){
                if ( response.status == 200 ){
                    $parent.attr('cat-id', response.id);
                    reloadCategory();
                } else {
                    $parent.remove();
                    alert('Failed to add category. Please try again later.');
                }
            }, 'json');
        }
        var cancelEditing = function($parent){
            $parent.remove();
        }

        $('ul.cat-filter-modal').append($inputCnt);
        $input.focus();
        $input.bind('keydown', function(e){
            if ( e.keyCode == 13 ){
                e.preventDefault();
                doneEditing( $(this).parent().parent() );
            } else if ( e.keyCode == 27 ){
                e.preventDefault();
                e.stopPropagation();
                cancelEditing( $(this).parent().parent() );
            }
        }).blur(function(){
            doneEditing( $(this).parent().parent() );
        })
    }
})

$(document).on('click', '#ch-himg', function(e){
    e.preventDefault();
    mediaManager(function( media ){
        $('#header_image').val(media.id);
        $('#header-img-cnt').css('background-image', 'url("'+ media.image_920 +'")');
    }, 'single');
})

$(document).on('click', '.change-lang', function(e){
    e.preventDefault();
    var lang = $(this).attr('lang');
    $('#ed-lang span').html(lang);
    $('#lang').val(lang);
})

$(document).on('click', '.menu-toggle', function(e){
    e.preventDefault();
    $('.main_container').toggleClass('hide-menu');
})

$(document).on('change', '#slide-chooser', function(e){
    var slideType = $(this).val();
    $('.link-to-unknown').removeClass('link-to-article link-to-product link-to-eksternal');
    if ( slideType == 'article' ){
        $('.link-to-unknown').addClass('link-to-article');
    } else if ( slideType == 'product' ){
        $('.link-to-unknown').addClass('link-to-product');
    } else if ( slideType == 'eksternal' ){
        $('.link-to-unknown').addClass('link-to-eksternal');
    }
});

var reloadPanel = function(){
    if ( $('.panel-content').length > 0 ){
        var $panel = $('.panel-content');
        $.get($panel.attr('data-source'), function(response){
            $panel.html(response);

            if ( $('#slide-table').length > 0 ){
                sortable('#slide-table tbody', {
                    forcePlaceholderSize: true,
                    placeholderClass: 'product-sort-ph',
                    items: '#slide-table tbody tr'
                    // handle: '.sortable-handle'
                })[0].addEventListener('sortupdate', function(e) {
                    $.post(SITE_URL +'content/sortslide', {id: $(e.detail.item).attr('data-id'), old_index: e.detail.oldindex, new_index: e.detail.index});
                });
            }

            if ( $('#products-table').length > 0 ){
                sortable('#products-table tbody', {
                    forcePlaceholderSize: true,
                    placeholderClass: 'product-sort-ph',
                    items: '#products-table tbody tr'
                    // handle: '.sortable-handle'
                })[0].addEventListener('sortupdate', function(e) {
                    $.post(SITE_URL +'content/sortproduct', {id: $(e.detail.item).attr('data-id'), old_index: e.detail.oldindex, new_index: e.detail.index});
                });
            }
        })
    }
}

$(document).on('click', '.delete-modal', function(e){
    e.preventDefault();
    var $el = $(this), id = $(this).attr('data-id');
    if (confirm('Are you sure you want to delete this?')){
    	$el.parents('tr').fadeOut();
    	$.getJSON($el.attr('delete-uri'), function(response){
    	    if (response.status != 200){
        		$el.parents('tr').stop().fadeIn('fast');
        		var message = (typeof response.message != 'undefined') ? response.message : 'Internal server error, mohon coba beberapa saat lagi.';
        		alert(message);
    	    } else {
                $el.parents('.modal').modal('hide');
                reloadPanel();
            }
    	});
    }
});

$(document).on('click', '.restore-modal', function(e){
    e.preventDefault();
    var $el = $(this), id = $(this).attr('data-id');
    if (confirm('Are you sure you want to restore this?')){
        $el.parents('tr').fadeOut();
        $.getJSON($el.attr('restore-uri'), function(response){
            if (response.status != 200){
                $el.parents('tr').stop().fadeIn('fast');
                var message = (typeof response.message != 'undefined') ? response.message : 'Internal server error, mohon coba beberapa saat lagi.';
                alert(message);
            } else {
                $el.parents('.modal').modal('hide');
                reloadPanel();
            }
        });
    }
});

$(document).on('click', '.change-pass-btn', function(e){
    e.preventDefault();
    $(this).hide();
    $('.ch-password-cnt').show();
})

$(document).on('click', '.add-modal', function(e){
    e.preventDefault();
    var $modal = $('.form-modal');
    $modal.modal('show');
    $('#modal-form').html('Mohon tunggu...');
    $.get($modal.attr('modal-source'), function(response){
        $('#modal-form').html(response);
        if ( $('.new-datepicker').length > 0 ){
            $('.new-datepicker').datepicker({
                todayBtn: "linked",
                language: "id",
                format: 'yyyy-mm-dd',
                autoclose: true
            });
        }

        if ( $('.the-editable').length > 0 ){
            var autolist = new AutoList();
            var editor = new MediumEditor('.the-editable', {
                anchor: {
                    linkValidation: true,
                },
                anchorPreview: false,
                placeholder: {
                    hideOnClick: false
                },
                extensions: {
                    'autolist': autolist
                }, 
                toolbar: {
                    buttons: ['h1', 'h2', 'bold', 'italic', 'unorderedlist','orderedlist']
                }
            });
        }
    })
});

$(document).on('click', '.edit-modal', function(e){
    e.preventDefault();
    var $modal = $('.form-modal'), $el = $(this);
    $modal.modal('show');
    $('#modal-form').html('Mohon tunggu...');
    $.get($el.attr('data-source'), function(response){
        $('#modal-form').html(response);
        if ( $('.new-datepicker').length > 0 ){
            $('.new-datepicker').datepicker({
                todayBtn: "linked",
                language: "id",
                format: 'yyyy-mm-dd',
                autoclose: true
            });
        }

        if ( $('#info-product-cnt').length > 0 ){
            sortable('#info-product-cnt', {
                forcePlaceholderSize: true,
                placeholderClass: 'sort-ph',
                items: '.info-product-item',
                handle: '.product-info-handle'
            })[0].addEventListener('sortupdate', function(e) {
                $.post(SITE_URL +'content/sortproduct', {id: $(e.detail.item).attr('data-id'), old_index: e.detail.oldindex, new_index: e.detail.index});
            });
        }

        if ( $('.the-editable').length > 0 ){
            var autolist = new AutoList();
            var editor = new MediumEditor('.the-editable', {
                anchor: {
                    linkValidation: true,
                },
                anchorPreview: false,
                placeholder: {
                    hideOnClick: false
                },
                extensions: {
                    'autolist': autolist
                }, 
                toolbar: {
                    buttons: ['h1', 'h2', 'bold', 'italic', 'unorderedlist','orderedlist']
                }
            });
        }
    });
})


$(document).on('submit', '.modal-form', function(e){
    e.preventDefault();
    var $form = $(this);
    $form.ajaxSubmit({
        dataType: 'json',
        clearForm: false,
        resetForm: false,
        beforeSerialize: function($form){
            $('#policy').val($('#policy-input').html());
            $('#ketentuan_umum').val($('#ketentuan-umum').html());
            if ( $('.info-product-item').length > 0 ){
                $('.info-product-info').each(function(){
                    $(this).parent().find('.input-product-info').val($(this).html());
                })
            }
        },
        beforeSubmit: function( formData, $form, options ){
            $form.find('.alert-danger').html('').hide();
        },
        error: function( xhr, textStatus, errorThrown ){
            $('.modal-open .modal').stop().animate({
                scrollTop: 0
            }, 'fast');
            $form.find('.alert-danger').html('Internal server error, mohon coba lagi nanti.').show();
        },
        success: function( response, status, xhr, $form ){
            if ( response.status == 200 ){
                $('.form-modal').modal('hide');
            } else {
                $('.modal-open .modal').stop().animate({
                    scrollTop: 0
                }, 'fast');

                var message = ( typeof response.message != 'undefined' ) ? response.message : 'Internal server error, mohon coba lagi nanti.';
                $form.find('.alert-danger').html( message ).stop().show();
            }
        }
    })
});

$(document).on('click', '.add-info-product', function(e){
    e.preventDefault();
    var $master = $('.info-product-item').first().clone();
    $master.find('.info-product-title').val('');
    $master.find('.info-product-info').html('');
    $master.find('.info_id').val('');
    $master.addClass('info-product-item');
    $master.attr('id', '').appendTo('#info-product-cnt');

    sortableInfo();
});
$(document).on('click', '.product-info-delete', function(e){
    e.preventDefault();
    var $el = $(this);
    if (confirm('Apakah anda yakin ingin menghapus info produk ini?')){
        $el.parents('.info-product-item').fadeOut('normal', function(){
            $(this).remove();
            sortableInfo();
        })
    }
})

$(document).on('click', '.add-package-price', function(e){
    e.preventDefault();
    var $master = $('#package-price-master').clone();
    $master.find('.package-price').val('');
    $master.find('.package-price-period').val('');
    $master.addClass('package-price-item');
    $master.attr('id', '').appendTo('#package-price-cnt');
});

$(document).on('change', '.can_be_bought', function(e){
    if ( $(this).val() == 'Yes' ){
        $('.age-wrapper').show();
        $('.package-price-wrapper').show();
    } else {
        $('.package-price-wrapper').hide();
        $('.age-wrapper').hide();
    }
})

$(document).on('click', '.img-chooser', function(e){
    e.preventDefault();
    $('.img-fake').trigger('click');
})

function readURL(input) {
}

$(document).on('change', '.img-fake', function(e){
    e.preventDefault();
    if (this.files && this.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('.img-chooser').addClass('has-image').css('background-image', 'url('+ e.target.result +')');
        }
        reader.readAsDataURL(this.files[0]);
    }

});

$(document).on('click', '.reload-table', function(e){
    e.preventDefault();
    reloadPanel();
})

$(document).on('click', '.view-product', function(e){
    e.preventDefault();
    var $el = $(this);
    var productID = $el.attr('product-id');
    $('#ViewModal').modal('show');
    $('#view-container').html('');
    $.get(SITE_URL +'content/viewproduct/'+ productID, function(response){
        $('#view-container').html(response);
    })
});

$(document).on('click', '.view-user', function(e){
    e.preventDefault();
    var $el = $(this);
    var userID = $el.attr('user-id');
    $('#ViewModal').modal('show');
    $('#view-container').html('');
    $.get(SITE_URL +'user/viewuser/'+ userID, function(response){
        $('#view-container').html(response);
    })
});

$(document).on('click', '.page-filter', function(e){
    e.preventDefault();
    $('#FilterModal').modal('show');
    $('#filter-form').html('');
    $.get($(this).attr('filter-source'), function(response){
        $('#filter-form').html(response);
        if ( $('.new-datepicker').length > 0 ){
            $('.new-datepicker').datepicker({
                todayBtn: "linked",
                language: "id",
                format: 'yyyy-mm-dd',
                autoclose: true
            });
        }
    })
})

$(document).on('click', '.page-export', function(e){
    e.preventDefault();
    if ( $('.panel-content').length > 0 ){
        var $panel = $('.panel-content');
        window.location.href = $panel.attr('data-source') +'&export=csv';
    }
})

$(document).on('submit', '#filter-form', function(e){
    e.preventDefault();
    var $panel = $('.panel-content');
    var panelUri = $panel.attr('data-source'),
        query = $(this).serialize();

    panelUri += ( panelUri.indexOf('?') > 0 ) ? '&' : '?';
    panelUri += query;

    $('.panel-content').attr('data-source', panelUri);
    $('#FilterModal').modal('hide');
    reloadPanel();
})

$(document).on('click', '.page-pagination', function(e){
    e.preventDefault();
    var nextUri = $(this).attr('page-uri');
    if ( nextUri ){
        $('.panel-content').attr('data-source', nextUri);
        reloadPanel();
    }
});

function deSerialize(queryString) {
    if(queryString.indexOf('?') > -1){
        queryString = queryString.split('?')[1];
    }
    var pairs = queryString.split('&');
    var result = {};
    pairs.forEach(function(pair) {
        pair = pair.split('=');
        result[pair[0]] = decodeURIComponent(pair[1] || '');
    });
    return result;
}

var serialize = function(obj) {
  var str = [];
  for (var p in obj)
    if (obj.hasOwnProperty(p)) {
      str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
    }
  return str.join("&");
}

$(document).on('click', '.page-goto', function(e){
    e.preventDefault();
    var page = prompt('Masukan halaman berapa yang ingin anda tuju.');
    var uri = $('.panel-content').attr('data-source');
    var query = deSerialize(uri);
    query.page = parseInt(page) -1;
    if (uri.indexOf('?') > 0)
        uri = uri.split('?')[0];
    uri = uri +'?'+ serialize(query);
    $('.panel-content').attr('data-source', uri);
    reloadPanel();
})

$(document).on('click', '.approve-claim', function(e){
    e.preventDefault();
    var claimID = $(this).attr('claim-id');
    $('#modal-btn-approve').attr('claim-id', claimID).show();
    $('#modal-btn-decline').hide();
    $('#ModalClaimStatus').modal('show');
})

$(document).on('click', '.reject-claim', function(e){
    e.preventDefault();
    var claimID = $(this).attr('claim-id');
    $('#modal-btn-approve').hide();
    $('#modal-btn-decline').show().attr('claim-id', claimID);
    $('#ModalClaimStatus').modal('show');
})

$(document).on('click', '#modal-btn-approve', function(e){
    var message = $('#claim-status-message').val();
    var claimID = $(this).attr('claim-id');
    if (confirm('Apakah anda yakin ingin menyetujui klaim ini?')){
        $.post(SITE_URL +'content/approveclaim/'+ claimID, {message: message}, function(response){
            if (response.status == 200){
                window.location.reload();
            } else {
                var message = (typeof response.message != 'undefined') ? response.message : 'Internal server error, contact administrator.';
                new PNotify({
                    icon: false,
                    title: 'Save Failed',
                    text: message,
                    type: 'error',
                    styling: 'bootstrap3'
                });
            }
        }, 'json');
    }    
})

$(document).on('click', '#modal-btn-decline', function(e){
    var message = $('#claim-status-message').val();
    var claimID = $(this).attr('claim-id');
    if (confirm('Apakah anda yakin ingin menolak klaim ini?')){
        $.post(SITE_URL +'content/rejectclaim/'+ claimID, {message: message}, function(response){
            if (response.status == 200){
                window.location.reload();
            } else {
                var message = (typeof response.message != 'undefined') ? response.message : 'Internal server error, contact administrator.';
                new PNotify({
                    icon: false,
                    title: 'Save Failed',
                    text: message,
                    type: 'error',
                    styling: 'bootstrap3'
                });
            }
        }, 'json');
    }
})



$(document).on('click', '.open-img-preview', function(e){
    e.preventDefault();
    var imgHD = $(this).attr('img-hd');

    $('#image-preview .img-content').html('Memuat...');
    $('#image-preview .img-content').css('background-image', 'none');
    $('#image-preview').fadeIn('fast', function(){
        $('#image-preview .img-content').html('');
        $('#image-preview .img-content').css('background-image', 'url('+ imgHD +')')
    })
})

$(document).on('click', '#image-preview', function(e){
    $(this).fadeOut('fast');
});

$(document).on('click', '#image-preview .img-content', function(e){
    e.stopPropagation();
})

var $activeRow, followUpID = 0;
$(document).on('click', '.follow-up', function(e){
    e.preventDefault();
    $activeRow = $(this);
    var dataID = $(this).attr('data-id');
    followUpID = parseInt(dataID);
    $('#ModalBerminatNote').modal('show');
})

$(document).on('click', '#modal-btn-follow-up', function(e){
    e.preventDefault();
    var note = $('#follow-up-note').val();

    var folloUpNow = function(_note){
        $('#ModalBerminatNote').modal('hide');
        $.post(SITE_URL +'content/followupberminat/'+ followUpID, {note: _note}, function(response){
            reloadPanel();
            new PNotify({
                icon: false,
                title: 'Follow Up',
                text: 'Update status follow up sukses.',
                type: 'success',
                styling: 'bootstrap3'
            });
        });
    }

    if (note == ''){
        if (confirm('Catatan follow up masih kosong, set status follow up tanpa catatan?')){
            folloUpNow('');
        }
    } else {
        folloUpNow(note);
    }
})

$(document).on('click', '.cancel-follow-up', function(e){
    e.preventDefault();
    var $el = $(this);
    var dataID = $(this).attr('data-id');
    if (confirm('Set status follow up menjadi belum untuk pesan ini?')){
        $el.parents('tr').find('.follow-up-status').removeClass('green-color').addClass('orange-color').html('Belum');
        new PNotify({
            icon: false,
            title: 'Follow Up',
            text: 'Update status follow up sukses.',
            type: 'success',
            styling: 'bootstrap3'
        });
        $.get(SITE_URL +'content/cancelfollowupberminat/'+ dataID, function(){});
    }
})

$(document).on('click', '.check-all-role', function(e){
    e.preventDefault();
    $('.role-allowd-list label input').prop('checked', true);
})
$(document).on('click', '.uncheck-all-role', function(e){
    e.preventDefault();
    $('.role-allowd-list label input').prop('checked', false);
})

$(document).on('click', '.view-role', function(e){
    e.preventDefault();
    var roleID = $(this).attr('role-id');
    $('#ViewModal').modal('show');
    $('#view-container').html('');
    $.get(SITE_URL +'user/viewrole/'+ roleID, function(response){
        $('#view-container').html(response);
    })
})

$(document).on('click', '.temp-change-pass', function(e){
    e.preventDefault();
    var userID = $(this).attr('user-id');
    $('#TempChangePassModal').modal('show');
    $('#TempChangePassModal .loading').show();
    $.getJSON(SITE_URL +'/user/changetemppass/'+ userID, function(response){
        if (response.status == 200){
            $('#TempChangePassModal .loading').hide();
            var tick = 30;
            var changeTick = function(){
                if (tick <= 0){
                    $('#TempChangePassModal').modal('hide');
                } else {
                    $('#temp-pass-tick').html(tick +' detik');
                    tick--;
                    window.setTimeout(changeTick, 1000);
                }
            }

            changeTick();
        } else {
            $('#TempChangePassModal').modal('hide');
            alert('Internal server error, please try again later');
        }
    })
})

$(document).on('change', '.province-selector', function(e){
    var provinceID = $(this).val();
    $.get('user/getcity/'+ provinceID, function(response){
        $('.city-selector').html(response);
    })
})

$(document).on('submit', '#patchpolis-form', function(e){
    e.preventDefault();
    $(this).ajaxSubmit({
        dataType: 'json',
        beforeSubmit: function( formData, $form, options ){
            $('#patchpolis-modal').modal('show');
            $('#patchpolis-modal .loading').show();
        },
        error: function( xhr, textStatus, errorThrown ){
            $('#patchpolis-modal').modal('hide');
            alert('Internal server error')
        },
        success: function( response, status, xhr, $form ){
            $('#patchpolis-modal .loading').hide();
        }
    });
})
