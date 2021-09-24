
var webInit = function(){
	if ( $('.content-wrapper').width() < $(window).width() ){
		$('.content-container').css('overflow-x', 'hidden');
	}

	if ( $('.content-container').length > 0 ){
	   	$('body').mousewheel(function(evt, chg) {
			$('.content-container')[0].scrollLeft -= (chg * .7);
			// evt.preventDefault();
	   	});
   	}

   	$('.quiz-item').each(function(){
   		var $el = $(this);
   		if ( !$(this).hasClass('with-thumb') && $(this).find('.quiz-item-overlay-2').length > 0 ){
   			$('<img/>').attr('src', $(this).find('.quiz-item-overlay-2').attr('hd-img')).load(function(){
   				$el.find('.quiz-item-overlay-2').css({
   					'background-image': 'url("'+ $(this).attr('src') +'")',
   					'-webkit-filter': 'blur(0)',
				    '-moz-filter': 'blur(0)',
				    '-o-filter': 'blur(0)',
				    '-ms-filter': 'blur(0)',
				    filter: 'blur(0)',
   				})
   			})
   		}
   	})

   	contentWidth();
}

var tag = document.createElement('script');
tag.src = "https://www.youtube.com/iframe_api";

var isVideoReady = false;
var isVideoStoped = false;

var firstScriptTag = document.getElementsByTagName('script')[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

var player;
var playVideoID = false;
function onYouTubeIframeAPIReady(){
	isVideoReady = true;
	if ( playVideoID != false ){
		playVideoWithID( playVideoID );
	}
}

function playVideoWithID(vidID){
	isVideoReady = true;
	player = new YT.Player('video-content', {
		height: '100%',
		width: '100%',
		videoId: vidID,
		playerVars: {
			suggestedQuality: 'hd720',
			controls: 1,
			showinfo: 1
		},
		events: {
			'onReady': onPlayerReady,
			'onStateChange': onPlayerStateChange
		}
	});
}

function onPlayerReady(event) {
	$('#video-content-loading').hide();
	$('#video-content').show();
	event.target.playVideo();
}
function onPlayerStateChange(){};

var contentWidth = function(){
	$('.content-container .content-wrapper').width((
		(300 * $('.content-container .content-item-x').length) + 
		($('.content-container .content-item-f').length * 620))
	+ 20);
}

var webConfig = function(){
   	if ( $('#share-container').length > 0 ){
	   	shareOff = $('.section-container').height() +140;
	   	shareOffL = $('.article-content-wrapper').offset().left -90;
   		$('#share-container').css({
   			left: shareOffL,
   			top: shareOff
   		});
   	}
}

$(document).ready(function(){
	webInit();
	webConfig();
})

$(window).resize(function(){
	webConfig();
})

var marginL = 31;
$(document).scroll(function(){
   	if ( $('#share-container').length > 0 ){
		if ( $(document).scrollTop() > ($('.related-article').offset().top -250) ){
			$('#share-container').css({
				position: 'absolute',
				left: shareOffL,
				top: ($('.related-article').offset().top -250) +20
			});
		} else if ( $(document).scrollTop() > (shareOff -20) ){
			marginL = ($(window).width() > 860) ? 31 : 11;
			$('#share-container').css({
				position: 'fixed',
				left: (shareOffL +marginL),
				top: 20
			});
		} else {
			$('#share-container').css({
				position: 'absolute',
				left: shareOffL,
				top: shareOff
			});
		}
	}
})

$(document).on('click', '.btn-share-to', function(e){
	if ( $(window).width() > 560  ){
		e.preventDefault();
		var $el = $(this), w = 400, h = 500;
		var left = (window.screen.width/2)-(w/2);
  		var top = (window.screen.height/2)-(h/2);
  		var title = 'Bagikan ke ';
  		title += ( $el.hasClass('card-share-fb') ) ? 'Facebook' : 'Twitter';
		window.open ($el.attr('href'),title,"menubar=0,resizable=1,width="+w+",height="+h+",top="+top+",left="+left);
	}
});

$(document).on('click', '.open-menu', function(e){
	e.preventDefault();
	$('.menu-full').show().css({
		width: 'auto', height: 'auto',
	}).animate({
		top: 0, right: 0,
		left: 0, bottom: 0
	}, 'normal', function(){
		$('.menu-close').fadeIn('fast').css('transform', 'rotate(90deg)');
	})
});

$(document).on('click', '.menu-close', function(e){
	e.preventDefault();
	$(this).css('transform', 'rotate(0deg)').hide();
	$('.menu-full').animate({
		top: 50, right: 30,
		left: $('.open-menu').offset().left, 
		bottom: $(document).height() -(50+48),
		width: 117, height: 48,
	}, 'normal', function(){
		$(this).hide();
	})
})

$(document).on('click', '.map-embed-iframe .map-overlay', function(){
	$(this).hide();
});

$('.map-embed-iframe iframe').mouseleave(function(){
	$('.map-embed-iframe .map-overlay').show();
});

$(document).on('click', '.image-viewer', function(e){
	e.preventDefault();
	var $el = $(this);
	var $parent = $el.parents('.image-viewer-container');
	var items = [];
	$parent.find('.image-viewer').each(function(){
		var item = {
        	src: $(this).attr('img-uri'),
        	w: $(this).attr('img-w'),
        	h: $(this).attr('img-h')
	    };
	    items.push( item );
	});

	var pswpElement = document.querySelectorAll('.pswp')[0];
	var options = {
	    index: parseInt($el.attr('img-idx'))
	};
	console.log(options);
	console.log(items);
	// Initializes and opens PhotoSwipe
	var gallery = new PhotoSwipe( pswpElement, PhotoSwipeUI_Default, items, options);
	gallery.init();
});

$(document).on('click', '.open-image', function(e){
	e.preventDefault();
	var $el = $(this);
	var items = [];
	$el.find('.photo-item').each(function(){
		var item = {
        	src: $(this).attr('img-uri'),
        	w: $(this).attr('img-w'),
        	h: $(this).attr('img-h')
	    };
	    items.push( item );
	});

	var pswpElement = document.querySelectorAll('.pswp')[0];
	var options = {
	    index: 0
	};

	console.log(items);

	// Initializes and opens PhotoSwipe
	var gallery = new PhotoSwipe( pswpElement, PhotoSwipeUI_Default, items, options);
	gallery.init();
});

$(document).on('click', '.content-container .arrow-right', function(e){
	e.preventDefault();
	$('.content-container').animate({
		scrollLeft: $('.content-container')[0].scrollLeft + ($(window).width() *.7) 
	}, 'slow');
});

$(document).on('click', '.open-video', function(e){
	e.preventDefault();
	$('.video-container').fadeIn();
	if ( isVideoReady ){
		playVideoWithID( $(this).attr('video-id') );
	} else {
		playVideoID = $(this).attr('video-id');
	}
});

$(document).on('click', '.video-container', function(e){
	e.preventDefault();
	$(this).fadeOut('normal', function(){
		$('#video-content').remove();
		$('.video-container .container').append('<div id="video-content"></div>');
	});
});


$(document).on('click', '.open-login', function(e){
	e.preventDefault();

	var _ret = $('#reg-_ret').val();
	if ( _ret == '' )
		_ret = window.location.href;

	$('.tw-signin-xcn').attr('href', '/user/inittwitter?_ret='+ _ret);
	$('#sign-in-1 p').html('Masuk menggunakan akun sosial media anda.');
	$('#login-modal').modal('show');
});


/**
 * Login with FB
 */
// Load the FB SDK asynchronously
(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

// Init FB SDK
window.fbAsyncInit = function() {
    FB.init({
        appId      : FB_APP_ID,
        cookie     : true,
        xfbml      : false,
        version    : FB_APP_VERSION
    });

    // Check User login status
    // 1. Logged into your app ('connected')
    // 2. Logged into Facebook, but not your app ('not_authorized')
    // 3. Not logged into Facebook and can't tell if they are logged into
    //    your app or not.
    //
    // These three cases are handled in the callback function.

    FB.getLoginStatus(function(response) {
        fbSgc(response, true);
    });
};

$(document).on('click', '.fb-signin-xcn', function(e){
    e.preventDefault();

    FB.login(function(response) {
        fbSgc( response );
    }, {
        scope: 'public_profile, email'//, user_likes, user_tagged_places, user_hometown, user_location'
    });
})

var fbSgc = function( response, silent ){
    if ( response.status == 'connected' ){

		FB.api('/me?fields=id,first_name,middle_name,last_name,picture,gender', function(user) {
	        var uri = SITE_URL +'/user/fbsignin';
	        if ( silent ) uri += '?_is_silent=true';

	        if ( $('#sign-up-contact').length > 0 ){
		        $.post( uri, user, function(response){
		        	if ( response.status == 201 ){
		        		$('#login-modal .modal-header h3').html( 'Selamat Datang '+ response.user.first_name );
		        		$('#reg-user_id').val(response.user.id);
		        		$('#reg-email').val(response.user.email);
		        		$('#reg-phone').val(response.user.phone);

		        		if ( typeof response._ret != 'undefined' && response._ret != '' )
			        		$('#reg-_ret').val(response._ret);
			        	else if ( $('#reg-_ret').val() == '' )
			        		$('#reg-_ret').val(window.location.href);

		        		$('#sign-in-1').fadeOut('normal', function(){
		        			$('#sign-up-contact').fadeIn();
		        		})
		        	} else if ( response.status == 200 ){
		        		if ( typeof response._ret != 'undefined' && response._ret != '' ){
		        			window.location.href = response._ret;
		        		} else if ( $('#reg-_ret').val() != '' ){
		        			window.location.href = $('#reg-_ret').val();
		        		} else {
		        			window.location.reload();
		        		}
		            } else {
		                if ( !silent ){
			                var message = ( typeof response.message != 'undefined' ) ? response.message : 'Internal server error, please try again later';
			                alert( message );
		                }
		            }
		        }, 'json');
		    } else {
				var out = [];
				for (var key in user) {
				    out.push(key + '=' + encodeURIComponent(user[key]));
				}
		    	window.location.href = '/user/fbsignin2?'+ out.join('&');
		    }
	    });

    } else {
        console.log('User cancelled login or did not fully authorize.');
    }
}


var quizData = { gender: '', quiz: [] };
$(document).on('click', '.answer-item.enable-js', function(e){
	e.preventDefault();
	var $el = $(this);
	var quizIdx = parseInt($el.attr('quiz-idx')),
		quizType = $el.attr('quiz-type'),
		quizId = $el.attr('quiz-id');

	if ( quizType == 'gender' ){
		quizData.gender = $el.attr('quiz-answer');
		quizData.quiz = [];
		$('.quiz-item').removeClass('enable');
		$('.quiz-for-'+ $el.attr('quiz-answer')).addClass('enable');
		$('.quiz-for-male_and_female').addClass('enable');
		$('.quiz-count-all').html( $('.quiz-item.enable').length );
		$('.quiz-count').fadeIn();
	} else {
		if ( typeof quizId != 'undefined' && parseInt(quizId) > 0 ){
			quizData.quiz[quizIdx] = {
				quiz_id: quizId,
				quiz_answer: $el.attr('quiz-answer')
			};
		}
	}

	$('.quiz-item-gender').addClass('enable');

	var nextQuiz = false, currentIdx = -1;
	$('.quiz-item.enable').each(function(key, val){
		currentIdx++;
		if ( nextQuiz ){
			$(this).stop().animate({
				top: 0,
				height: '100%'
			}, 'slow', function(){
				$(this).addClass('active');
			});
			if ( !$(this).hasClass('quiz-item-end') ){
				$('.quiz-count-current').html(currentIdx);
				nextQuiz = false;
			}
			return false;
		}

		if ( $(this).hasClass('active') ){
			if ( $('.quiz-item.enable').eq((key +1)).hasClass('quiz-item-end') ){
				nextQuiz = true;
				return false;
			}
			$(this).stop().animate({
				top: '-100%',
				height: '120%'
			}, 'slow', function(){
				$(this).removeClass('active');
			});
			nextQuiz = true;
		}
	});
	if ( nextQuiz ){
		// Go to result
		$.post('/quiz/submit', quizData, function(response){
			if ( typeof response.status == 'undefined' ){
				alert('Internal server error, please try again later.');
			} else if ( response.status == 203 ){
        		$('#reg-_ret').val(response._ret);
        		$('#reg-email').val('');
        		$('#sign-in-1').show();
        		$('#sign-in-1 p').html('Masuk untuk melihat hasil test.<br />Masuk menggunakan akun sosial media anda.');
    			$('#sign-up-contact').hide();
    			$('.tw-signin-xcn').attr('href', 'user/inittwitter?_ret='+ response._ret);
				$('#login-modal').modal('show');

			} else if ( response.status == 201 ){
        		$('#login-modal .modal-header h3').html( 'Hai '+ response.user.first_name );
        		$('#reg-user_id').val(response.user.id);
        		$('#reg-email').val(response.user.email);
        		$('#reg-phone').val(response.user.phone);
        		$('#reg-_ret').val(response._ret);
        		$('#sign-in-1').hide();
    			$('#sign-up-contact').show();
				$('#login-modal').modal('show');
			} else if ( response.status == 200 ) {
				window.location.href = '/quiz/result';
			} else {
				alert('Internal server error, please try again later.');
			}
		}, 'json');
	}
});

$(document).on('click', '.quiz-b-btn.enable-js a', function(e){
	e.preventDefault();
	var $el = $(this);

	var nextQuiz = false, currentIdx = -1;
	$('.quiz-item.enable').each(function(key, val){
		if ( $('.quiz-item.enable').eq((key +1)).hasClass('active') ){
			$('.quiz-count-current').html( parseInt($('.quiz-count-current').html()) -1 );
			$('.quiz-item.enable').eq((key +1)).stop().animate({
				top: '100%',
				height: '100%'
			}, 'slow', function(){
				$(this).removeClass('active');
			});
			$(this).stop().animate({
				top: 0,
				height: '100%'
			}, 'slow', function(){
				$(this).addClass('active');
			});

			if ( $(this).hasClass('quiz-item-gender') ){
				$('.quiz-count').hide();
			}
			return false;
		}
	});
})
