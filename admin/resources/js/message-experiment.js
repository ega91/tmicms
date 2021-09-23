
var inboxID 	= 0, 
	messageTo 	= 0, 
	userID 		= 0, 
	broadcast 	= 0, 
	userSecret 	= '',
	inboxs		= [];
var socket 		= io('http://localhost:3000');

var genInbox = function(data){
	inboxs = data;
	if ( data.length > 0 ){
		data.forEach(function(val, key){
			if ( val.target ){
				var $item = $('<div/>');
				$item.addClass('mu mu-inbox inbox-'+ val.id);

				if ( val.unread == 1 )
					$item.addClass('unread');

				$item.attr('data-id', val.id);

				if ( val.broadcast == 1 )
					$item.html('<div class="user-img broadcast-icon"></div>');
				else
					$item.html('<div class="user-img"></div>');

				var $content = $('<div/>');
				$content.addClass('mu-content');
				$content.html('<div class="pull-right mu-date" style="display: none;">12:12am</div>');

				if ( val.broadcast == 1 ){
					$content.append('<h3>Broadcast Message</h3>');
				} else {
					$content.append('<h3>'+ val.target.first_name +' '+ val.target.last_name +'</h3>');
				}

				if ( val.last_message )
					$content.append('<p>'+ val.last_message +'</p>');
				else
					$content.append('<p>-</p>');

				$item.append($content);
				$item.appendTo('.conv-cnt');
			}
		})
	}
}

var genConv = function(data){
	if ( data.length > 0 ){
		data.forEach(function(val, key){
			var $item = $('<div/>');
			$item.addClass('message');
			if ( val.from.id == userID ) $item.addClass('message-r');
			else $item.addClass('message-l');
			$item.html('<div class="user-img"></div>');

			var $theMessage = $('<div/>');
			$theMessage.addClass('the-message');

			var $buble = $('<div/>');
			$buble.addClass('the-buble');
			$buble.html('<h3>'+ val.from.first_name +' '+ val.from.last_name +'</h3>');
			$buble.append('<p class="the-p">'+ val.message +'</p>');
			$buble.appendTo($theMessage);

			$theMessage.append('<p class="message-date">12:53am</p>');
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

socket.on('connect', function(){
	$.getJSON(SITE_URL +'messages/secret', function(response){
		if ( response.status == 200 ){
			userID = response.id;
			userSecret = response.secret;
			socket.emit('signin', { secret: response.secret });

			socket.on('msg-'+ userID, (data) => {
				console.log('new message...');
				console.log(data);
				genConv([data]);

				console.log('gen inbox...');
				console.log(inboxs);
				if ( !inboxs || inboxs.length == 0 ){
					$('.conv-cnt').html('');
					genInbox([data.inbox]);
				} else {
					var hasInbox = false;
					inboxs.forEach(function(val, key){
						if ( val.id == data.inbox.id ){
							$('.inbox-'+ val.id).find('p').html(data.message);
							if ( val.unread )
								$('.inbox-'+ val.id).addClass('unread');
							hasInbox = true;
						}

						if ( inboxs.length == (key +1) && !hasInbox ){
							inboxs.unshift(data.inbox);
							$('.conv-cnt').html('');
							genInbox(inboxs);
						}
					})
				}
			});

			socket.on('typing-'+ userID, (data) => {
				console.log(data.target.first_name +' is typing...');
				console.log(data);
				if ( data.id == inboxID ){
					$('.message-content').addClass('typing');
				}
			})

			socket.on('stoptyping-'+ userID, (data) => {
				console.log(data.target.first_name +' stop typing...');
				console.log(data);
				if ( data.id == inboxID ){
					$('.message-content').removeClass('typing');
				}
			})
		}
	});
});

socket.on('inbox', (data) => {
	console.log('inbox...');
	console.log(data);
	$('.conv-cnt').html('');
	genInbox(data);
});

socket.on('conv', (data) => {
	console.log('conversation...');
	console.log(data);
	$('.message-content').html('');
	$('.message-content').removeClass('typing');
	genConv(data);
});

socket.on('allusers', (data) => {
	console.log('all users...');
	console.log(data);
	$('.msg-contacts').html('');
	if ( data && data.length > 0 ){
		data.forEach(function(val){
			if ( userID != val.id ){
				var $item = $('<div/>');
				$item.attr('user-id', val.id);
				$item.addClass('mu mu-contact');
				$item.html('<div class="user-img"></div>');

				var $content = $('<div/>');
				$content.addClass('mu-content');
				$content.html('<h3>'+ val.first_name +' '+ val.last_name +'</h3>');
				$content.appendTo($item);

				$item.appendTo('.msg-contacts');
			}
		});
	}
});

var clearInbox = function(){
	$('.mu-inbox').each(function(){
		if ( $(this).attr('data-id') == undefined || $(this).attr('data-id') == '' ){
			$(this).remove();
		}
	})
}

$(document).on('click', '.new-msg', function(e){
	e.preventDefault();
	clearInbox();

	$('.new-msg-cnt').hide();
	$('.conv-cnt').hide();
	$('.new-msg-contacts').stop().fadeIn('fast');
	socket.emit('users', {secret: userSecret});
});

$(document).on('click', '.cancel-new-msg', function(e){
	e.preventDefault();
	$('.new-msg-contacts').hide();
	$('.new-msg-cnt').stop().fadeIn('fast');
	$('.conv-cnt').stop().fadeIn('fast');
});

$(document).on('click', '.new-broadcast-msg', function(e){
	e.preventDefault();
	$('.cancel-new-msg').trigger('click');
	$.getJSON(SITE_URL +'messages/secret', function(response){
		if ( response.status == 200 ){
			socket.emit('newmsg', { secret: response.secret, broadcast: 1 });
		}
	});
});

$(document).on('click', '.mu-inbox', function(e){
	e.preventDefault();
	clearInbox();

	var $el = $(this);
	inboxID = $el.attr('data-id');
	socket.emit('openconv', { id: inboxID, secret: userSecret });

	inboxs.forEach(function(val){
		if ( val.id == inboxID ){
			if ( val.to == userID )
				messageTo = val.from;
			else
				messageTo = val.to;
		}
	})

	$('.mu-inbox').removeClass('active');
	$el.addClass('active');
	$el.removeClass('unread');

	$('.message-content').html('').show();
	$('.message-content').removeClass('typing');
	$('.message-content').height($(document).height() - 150);
	window.setTimeout(function(){
	    $('.message-content').stop().animate({
	        scrollTop: $('.message-content')[0].scrollHeight
	    }, 'fast');
	}, 100);

	$('.message-input').show();
    $('.message-input').width($('.message-content').width() +10);
    $('#message-input').focus();
});

$(document).on('submit', '#message-form', function(e){
	e.preventDefault();
	var message = $('#message-input').val();
	socket.emit('message', { id: inboxID, to: messageTo, broadcast: broadcast, message: message, secret: userSecret });
	socket.emit('stoptyping', {id: inboxID, secret: userSecret});

	$('#message-input').val('');
});

var newInbox = function($el, to){
	inboxID = 0; broadcast = 0; messageTo = to;
	$('.message-content').html('').show();
	$('.message-content').removeClass('typing');
	$('.message-content').height($(document).height() - 150);
	window.setTimeout(function(){
	    $('.message-content').stop().animate({
	        scrollTop: $('.message-content')[0].scrollHeight
	    }, 'fast');
	}, 100);

	$('.message-input').show();
    $('.message-input').width($('.message-content').width() +10);
    $('#message-input').focus();

    $('.mu-inbox').removeClass('active');
	var $item = $('<div/>');
	$item.addClass('mu mu-inbox active');
	$item.html('<div class="user-img"></div>');

	var $content = $('<div/>');
	$content.addClass('mu-content');
	$content.html('<div class="pull-right mu-date" style="display: none;">12:12am</div>');
	$content.append('<h3>'+ $el.find('h3').html() +'</h3>');
	$content.append('<p>-</p>');

	$item.append($content);
	$item.appendTo('.conv-cnt');
	$('.conv-cnt').show();
}

$(document).on('click', '.mu-contact', function(e){
	e.preventDefault();
	var $el = $(this);
	$('.cancel-new-msg').trigger('click');

	messageTo = $el.attr('user-id');
	if ( inboxs.length > 0 ){
		var hasInbox = false;
		inboxs.forEach(function(val, key){
			if ( val.from == messageTo || val.to == messageTo ){
				$('.inbox-'+ val.id).trigger('click');
				hasInbox = true;
			}

			if ( inboxs.length == (key +1) && !hasInbox ){
				newInbox($el, messageTo);
			}
		})
	} else {
		newInbox($el, messageTo);
	}
});

$(document).on('keyup', '#message-input', function(){
	if ( $(this).val().length > 0 ){
		socket.emit('starttyping', {id: inboxID, secret: userSecret});
	} else {
		socket.emit('stoptyping', {id: inboxID, secret: userSecret});
	}
})
