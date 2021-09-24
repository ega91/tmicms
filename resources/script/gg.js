
var webInit = function(){
	if ( $('#lightSlider').length > 0 ){
		$('#lightSlider').lightSlider({
			item: 1
		}); 
	}

	if ($('#sliderVideo').length > 0){
		$('#sliderVideo').lightSlider({
			item: 4
		})
	}

	$('.menu-toggle').click(function(e){
	    e.preventDefault();
	    e.stopPropagation();
	    if ($(this).hasClass('open')){
			$(this).removeClass('open');
			$('.menu-container').removeClass('open');
	    } else {
			$(this).addClass('open');
			$('.menu-container').addClass('open');
	    }
	});
}
var webConfig = function(){
}

var docClicked = function(){
	$('.menu-container').removeClass('open');
	$('.menu-toggle').removeClass('open');
}

var docScrolled = function(){
}


$(document).ready(function(){
	webInit();
	webConfig();
})

$(window).resize(function(){
	webConfig();
})

$(document).scroll(function(){
	docScrolled();
})

$(document).on('click', function(){
	docClicked();
});


$(document).on('click', '.menu-container', function(e){
	e.stopProgragation();
});

$(document).on('click', '.modal-close', function(e){
	e.preventDefault();
	$('.modal').modal('hide');
});

$(document).on('change', '#province', function(){
	$('#city').html('<option value="0">Pilih kota</option>');
	$.get('/welcome/getcity/'+ $(this).val(), function(response){
		$('#city').html(response);
	});
});

var goTo = function( pos, speed ){
    if ( typeof pos == 'undefined' ) pos = 0;
    if ( typeof speed == 'undefined' ) speed = 'normal';
    $('html, body').stop().animate({
        scrollTop: pos
    }, speed);
}

$(document).on('submit', '#voucher-form', function(e){
	e.preventDefault();
	$('#voucherModal').modal('show');
	$('#voucher-form .alert-danger').hide();
	var data = {
	    'nama': $('#name').val(),
	    'email': $('#email').val(),
	    'phone': $('#phone').val(),
	    'province': $('#province').val(),
	    'city': $('#city').val(),
	    question: []
	}
	$('.question').each(function(){
		if ( $(this).is(':checked') )
			data.question.push($(this).attr('question-id'));
	})
	console.log(data);
	$.post('/welcome/getvoucher', data, function(response){
	    if (response.status == 200){
			$('#voucher-form')[0].reset();
			$('#province').val(31).trigger('change');
			$('#voucherModal').addClass('success');
	    } else {
			window.setTimeout(function(){
				$('#voucherModal').modal('hide');
				goTo( $('#voucher-form').offset().top -20 );
			}, 1000);
			var message = (response.message != undefined) ? response.message : 'Iternal server error, mohon coba lagi nanti.';
			$('#voucher-form .alert-danger').html(message).show();
	    }
	}, 'json');
});

$(document).on('click', '.video-thumb', function(e){
	e.preventDefault();
	$('.video-thumb').removeClass('active');
	$(this).addClass('active');
	$('#video-big').html('<iframe width="100%" height="415" src="https://www.youtube.com/embed/'+ $(this).attr('video-id') +'?autoplay=1" autoplay="1" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>');
})

$(document).on('click', '.go-section', function(e){
	e.preventDefault();
	var href = $(this).attr('href');
	goTo($(href).offset().top);
})


