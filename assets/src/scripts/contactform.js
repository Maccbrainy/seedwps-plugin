document.addEventListener('DOMContentLoaded', function(e) {
	console.log('Contact form is ready!');
});

jQuery(document).ready(function($){


	$('#paragonContactForm').on('submit',function(e){

			e.preventDefault();
			
		$('.has-error').removeClass('has-error');
		$('.js-show-feedback').removeClass('js-show-feedback');

		var form = $(this),
			name =form.find('#name').val(),
			email=form.find('#email').val(),
			message=form.find('#message').val(),
			ajaxurl = form.data('url');

			if (name === '' ) {
				$('#name').parent('.form-group').addClass('has-error');
				return;
			}
			if (email === '' ) {
				$('#email').parent('.form-group').addClass('has-error');
				return;
			}
			if (message === '' ) {
				$('#message').parent('.form-group').addClass('has-error');
				return;
			}

			form.find('input, button, textarea').attr('disabled','disabled');
			$('.js-form-submission').addClass('js-show-feedback');


			$.ajax({
			
			url : ajaxurl,
			type : 'post',
			data : {
				
				name : name,
				email : email,
				message : message,
				action: 'paragon_save_user_contact_form'
				
			},
			error : function( response ){
				$('.js-form-submission').removeClass('js-show-feedback');
				$('.js-form-error').addClass('js-show-feedback');
				form.find('input, button, textarea').removeAttr('disabled');
			},
			success : function( response ){
				if( response == 0 ){
					
					setTimeout(function(){
						$('.js-form-submission').removeClass('js-show-feedback');
						$('.js-form-error').addClass('js-show-feedback');
						form.find('input, button, textarea').removeAttr('disabled');
					},1500);				

				} else {
					
					setTimeout(function(){
						$('.js-form-submission').removeClass('js-show-feedback');
						$('.js-form-success').addClass('js-show-feedback');
						form.find('input, button, textarea').removeAttr('disabled').val('');
					},1500);

				}
			}
			
		});
	});
});