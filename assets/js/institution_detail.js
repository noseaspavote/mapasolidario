var mapCanvas;
var _categories = [];
var _mapObj;

$(document).ready(function() {
	
	//share plug in init
	$("#share-div").jsSocials({
			showLabel: false,
    		showCount: false,
            shares: ["email", "twitter", "facebook", "googleplus", "linkedin", "pinterest", "stumbleupon", "whatsapp"]
        });
	
	$.formUtils.addValidator({
		  name : 'check_mail',
		  validatorFunction : function(value, $el, config, language, $form) {
			return $('#email').val()===value;
		  },
		  errorMessage : 'El mail no coincide con el ingresado. Por favor, vuelva a ingresarlo.',
		  errorMessageKey: 'badMailCheck'
		});
  
		$.validate({
			 onSuccess : function() {
				 validateAndSend()
				 return false; // Will stop the submission of the form
			},
		});	
		
		 $('#message').restrictLength($('#maxlength'));
});
 
 
function showFormError(){
	$('#form-contact').css('display','none');	
	$('#form-message').html('Se produjo un error al enviar el formulario. Por favor, volvé a intentarlo más tarde.');
	$('#form-message').removeClass('flash--warning');
	$('#form-message').addClass('flash--error');		
	$('#form-message').css('display','');	
	$("html, body").animate({ scrollTop: 0 }, "slow");
}

function showFormSuccess(){
	$('#form-contact').css('display','none');	
	$('#form-message').html('Gracias por contactarnos!<br> Nuestro equipo se pondrá en contacto con vos a la brevedad. Muchas gracias.');
	$('#form-message').removeClass('flash--warning');
	$('#form-message').addClass('flash--success');		
	$('#form-message').css('display','');	
	$("html, body").animate({ scrollTop: 0 }, "slow");
}

function validateAndSend(){
	$('#btnSubmit').prop('disabled', true);
	$('#btnSubmit').append(' <i class="fa fa-spinner fa-spin"></i>');
	
	var ajaxPutPromise = $.ajax({
		url: $('body').data('base-url') + 'enviar-formulario',
		dataType: 'JSON',
		method: 'POST',
		data: $('#form-contact').serialize()
	})
	.fail(function(data) {
		showFormError();
	})
	.success(function(data) {
		 showFormSuccess();
	})
	.complete(function(data){
		console.log(data);
	});
}


