var mapCanvas;
var marker;
var _geocoder;
var _provinceCombo = $("#province_id");
var _districtCombo = $("#district_id");
var _cityCombo = $("#city_id");
var _institutionTypeCombo = $('#institution_type_id');

$(document).ready(function() {	
	initMap();
		
	_provinceCombo.change(function() {
		if(_provinceCombo.val()==''){
			_districtCombo.empty();
			_districtCombo.append('<option value="">---- Seleccione un partido ----</option>');
			_districtCombo.attr('disabled','disabled');
			
			_cityCombo.empty();
			_cityCombo.append('<option value="">---- Seleccione una ciudad ----</option>');
			_cityCombo.attr('disabled','disabled');
		}else{	
			_districtCombo.empty();
			_districtCombo.append('<option value="">---- Seleccione un partido ----</option>');
			loadDistricts(_provinceCombo.val());
			
			_cityCombo.empty();
			_cityCombo.append('<option value="">---- Seleccione una ciudad ----</option>');
			_cityCombo.attr('disabled','disabled');		
		}
	});
	
	$('.geocode-params').on('change', function() {
		searchGeocode($('#street_name').val() + ' ' + $('#street_number').val()  + ', ' + $("#city_id option:selected").text()+ ', ' + $("#district_id option:selected").text()+ ', ' + $("#province_id option:selected").text());
	});
	
	_districtCombo.change(function() {
		if(_districtCombo.val()==''){			

			_cityCombo.empty();
			_cityCombo.append('<option value="">---- Seleccione una ciudad ----</option>');
			_cityCombo.attr('disabled','disabled');
		}else{	
			_cityCombo.empty();
			_cityCombo.append('<option value="">---- Seleccione un ciudad ----</option>');
			loadCities(_districtCombo.val());	
		}
	});
	
	$('#alias').keyup(function(){
		if($('#alias').val().length>=4){
			var ajaxPromise = getAjaxPromise('api/markers.geojson/alias/' + $('#alias').val());		
			ajaxPromise.done(function(data) {
				$('#alias_check').val(data.features.length===0);
			})
		}
    });
	
	$('.uppercase').change(function(){
		$(this).val($(this).val().toUpperCase());
    });
	
	$.formUtils.addValidator({
		  name : 'check_email',
		  validatorFunction : function(value, $el, config, language, $form) {
			return $('#email').val()===value;
		  },
		  errorMessage : 'El mail no coincide con el ingresado. Por favor, vuelva a ingresarlo.',
		  errorMessageKey: 'badMailCheck'
		});
		
	$.formUtils.addValidator({
		  name : 'unique_alias',
		  validatorFunction : function(value, $el, config, language, $form) {
			if($('#alias').val().length<4) return false;
			if($('#alias_check').val()=='false') return false;
			return true
		  },
		  errorMessage : 'El alias debe tener más de 3 caracteres y ser único. Intenta nuevamente.'
		});	
		
	$.formUtils.addValidator({
		  name : 'check_suscriptor_email',
		  validatorFunction : function(value, $el, config, language, $form) {
			return $('#suscriptor_email').val()===value;
		  },
		  errorMessage : 'El mail no coincide con el ingresado. Por favor, vuelva a ingresarlo.',
		  errorMessageKey: 'badMailCheck'
		});
  
		$.validate({
    		 modules : 'html5',
			 onSuccess : function() {
				 $('#btnSubmit').attr('disabled','disabled');
				 return true;
			},
		});	
});

/**
 * Ajax Call Function
 */
function getAjaxPromise(ajaxUrl){
	return $.ajax({
		url: $('body').data('site-url') + ajaxUrl,
		dataType: 'json',
		method: 'get'
	})
	.fail(function() {
		//location.reload();
	});
}

/**
 * Map initialization
 */
function initMap() {
	
	//init map pointint to Lomas de Zamora, Buenos Aires, Argentina
	mapCanvas = L.map('map-institution').setView([-34.766667, -58.4], 16),
					_geocoder = L.Control.Geocoder.nominatim(),
					control = L.Control.geocoder({
						geocoder: _geocoder
					}).addTo(mapCanvas);
}

function searchGeocode(adress){
	_geocoder.geocode(adress, function(results) {
		var r = results[0];
		if (r) {
			$("#latitude").val(r.center.lat);
			$("#longitude").val(r.center.lng);
		}
	})
}

function loadDistricts(id){
	var ajaxPromise = getAjaxPromise('api/districts/id_province/' + id, 'get', 'json');
	
	_districtCombo.attr('disabled','disabled');
	
	ajaxPromise.done(function(data) {
		$.each(data, function(index,item) {
			 _districtCombo.append("<option value=" + item.id + ">" + item.name + "</option>"); 
		});
		_districtCombo.removeAttr("disabled");
	})
}

function loadCities(id){
	var ajaxPromise = getAjaxPromise('api/cities/district_id/' + id, 'get', 'json');
	
	_cityCombo.attr('disabled','disabled');
	
	ajaxPromise.done(function(data) {
		$.each(data, function(index,item) {
			 _cityCombo.append("<option value=" + item.id + ">" + item.name + "</option>"); 
		});
		_cityCombo.removeAttr("disabled");
	})
}
