
//var socket = io('https://api.tmlife.co.id'), mcKey, mcTo,
 var socket = io('http://localhost:3000'), mcKey, mcTo,
	appName = 'TOSS', playSound = true, inboxID,
	sound = new Howl({ src: ['/admin/resources/sounds/definite.mp3'] });

var unread = 0, newReq = true;

socket.on('connect', function(){
    console.log('connected to server');
	$.getJSON(SITE_URL +'messages/secret', function(response){
		if ( response.status == 200 ){
			mcKey = response.secret;
			mcUuid = response.uuid;
			socket.emit('count unread', {secret: mcKey, uuid: mcUuid});
		} else {
			alert('Session kadaluarsa, silahkan refresh halaman ini untuk login.');
		}
	});
});

socket.on('new message', function(){
	console.log('new message');
	socket.emit('count unread', {secret: mcKey, uuid: mcUuid});
});

var countUnread = function(){
	socket.emit('count unread', {secret: mcKey, uuid: mcUuid});
	window.setTimeout(countUnread, 2000);
}

window.setTimeout(countUnread, 3000);

socket.on('unread counted', function(data){
	if ( data.count > 0 ){

		if (data.count == unread || newReq){
			playSound = false;
		} else {
			playSound = true;
		}

		unread = data.count;
		newReq = false;

		var docTitle = document.title.split(')');
		docTitle = (docTitle.length > 1) ? docTitle[1] : docTitle[0];
		document.title = '('+ data.count +') '+ docTitle;
		$('#badge-message').html(data.count).show();

		if ($('.message-content').is(':visible')){
			$.get(SITE_URL +'messages/conv/'+ inboxID +'?_to='+ mcTo, function(response){
				$('.message-content').html(response);
			    $('.message-content').stop().animate({
			        scrollTop: $('.message-content')[0].scrollHeight
			    }, 0);
			})
		}

		$.get(SITE_URL +'messages/inbox', function(response){
			if ( playSound ) sound.play();
			$('#inbox-cnt').html(response);
			$('#inbox-cnt .mu-inbox').each(function(key, val){
				var _inboxID = parseInt($(this).attr('data-id'));
				if (inboxID == _inboxID)
					$(this).addClass('active')
			})
		})

	} else {
		playSound = true;
		var docTitle = document.title.split(')');
		docTitle = (docTitle.length > 1) ? docTitle[1] : docTitle[0];
		document.title = docTitle;
		$('#badge-message').html(data.count).hide();
	}
})

$('.message-user').height($(window).height() - 75);

var openConv = function(){
	$('.message-content').html('').show();
	$('.message-content').removeClass('typing');
	$('.message-content').height($(window).height() - 113);
	window.setTimeout(function(){
	    $('.message-content').stop().animate({
	        scrollTop: $('.message-content')[0].scrollHeight
	    }, 'fast');
	}, 100);

	$('.message-input').css('top', $(window).height() - 100).show();
    $('.message-input').width($('.message-content').width() +10);
    $('#message-input').focus();
}

var genConv = function(data){
	if ( data.length > 0 ){
		data.forEach(function(val, key){
			var $item = $('<div/>');
			$item.addClass('message');
			if ( val.position == 'right' ) $item.addClass('message-r');
			else $item.addClass('message-l');
			$item.html('<div class="user-img"></div>');

			var $theMessage = $('<div/>');
			$theMessage.addClass('the-message');

			var $buble = $('<div/>');
			$buble.addClass('the-buble');
			$buble.html('<h3>'+ val.from +'</h3>');
			$buble.append('<p class="the-p">'+ val.message.replace(/\n/g, '<br>') +'</p>');
			$buble.appendTo($theMessage);

			$theMessage.append('<p class="message-date">'+ val.date +'</p>');
			$theMessage.appendTo($item);

			$('.message-content').append($item);

			if ( data.length == (key +1) ){
			    $('.message-content').stop().animate({
			        scrollTop: $('.message-content')[0].scrollHeight
			    }, 'fast');
			}
		})
	}
}

if ( $('#inbox-cnt').length > 0 ){
	$('#inbox-cnt').html('Memuat data...');
	$.get(SITE_URL +'messages/inbox', function(response){
		$('#inbox-cnt').html(response);
	})
}

$(document).on('click', '.mu-inbox', function(e){
	e.preventDefault();
	$('.mu-inbox').removeClass('active');
	$(this).addClass('active');
	$(this).find('.inbox-unread').hide();
	mcTo = $(this).attr('data-to');
	inboxID = $(this).attr('data-id');
	openConv();

    $('html, body').stop().animate({
        scrollTop: 0
    }, 'normal');

	$('.message-content').html('...');
	$.get(SITE_URL +'messages/conv/'+ inboxID +'?_to='+ mcTo, function(response){
		$('.message-content').html(response);
	    $('.message-content').stop().animate({
	        scrollTop: $('.message-content')[0].scrollHeight
	    }, 0);
	})
});

$(document).on('submit', '#message-form', function(e){
	e.preventDefault(); 
});

$(document).on('keydown', '#message-input', function(e){
	if (e.keyCode == 13 && !e.shiftKey){
		e.preventDefault();
		var message = $('<div>'+ $(this).html().replace(/<br>|<br\/>/g,'\n') +'</div>').text();
		$(this).html('');
		var d = new Date(),
			h = d.getHours(),
			m = d.getMinutes();
		if (h<10) h = '0'+ h;
		if (m<10) m = '0'+ m;
		genConv([{
			from 		: 'Layanan Pelanggan',
			position 	: 'right',
			message 	: message,
			date 		: h +':'+ m
		}])

		socket.emit('send message', {
			secret 	 : mcKey,
			_to 	 : mcTo,
			inbox_id : inboxID,
			message  : message
		});
	}
});
