var mapCanvas;
var _categories = [];
var _layers = [];
var _layerDummy;
var _turkeyIcon;
var _queryMarker;

$(document).ready(function() {	
	//search events setupMarker
	$(document).on('keypress','#txtSearch',function(e){
		if (e.which == 13) {
			search();
			return false;
		}
	});

	$(document).on('click','#btnSearch',function(){
		search();
		return false;
	});	
	
	$(document).on('click','.form__close',function(){	
		$(".form__list").hide();
		$(".leaflet-control-zoom").css("visibility", "visible");
		//loadMarkers();
		return false;
	});
	
	//Share pop up initialization
	$('#popup-share').popup({
		background:false
	});
		
	//share plug in init
	$("#popup-share-div").jsSocials({
			showLabel: false,
    		showCount: false,
            shares: ["email", "twitter", "facebook", "googleplus", "pinterest", "whatsapp"]
        });

	//map initialization
	initMap();		
});

/**
 * Ajax Call Function
 */
function getAjaxPromise(ajaxUrl, async){
	return $.ajax({
		url: $('body').data('site-url') + ajaxUrl,
		dataType: 'json',
		async: async,
		method: 'get'
	})
	.fail(function() {
		//location.reload();
	});
}

function getFreeGeoIpData(){
	$.ajax({
		url: 'http://freegeoip.net/json',
		dataType: 'jsonp',
		async: true,
		method: 'get'
	})
	.fail(function() {
		//location.reload();
	})
	.done(function(data) {
		console.log(data);
	});
}

/**
 * Map initialization
 */
function initMap() {
	//map pointint to Lomas de Zamora, Buenos Aires, Argentina
	var initLat = -34.766667;
	var initLng = -58.4;
	var initZoom = 14;
	
	//if showll has value, use lat and log as setView
	var position = $("#showll").val().split(',');
	if(position.length==2){
		initLat = parseFloat(position[0]);
		initLng = parseFloat(position[1]);
		initZoom = 18;
	}
	
	//init
	mapCanvas = L.map('map-canvas',{
		visualClickEvents: 'dblclick',
		contextmenu: true,
		contextmenuWidth: 140,
		contextmenuItems: [{
			text: '<i class="fa fa-share-alt" aria-hidden="true"></i> Compartir',
			callback: shareCoordinates
		}, {
			text: '<i class="fa fa-crosshairs" aria-hidden="true"></i> Centrar aquí',
			callback: centerMap
		}]
	}).setView([initLat, initLng], initZoom);
	
	mapCanvas.on('popupopen', function(e) {
		$("#maker-share").jsSocials({
			showLabel: false,
    		showCount: false,
            shares: ["email", "twitter", "facebook", "googleplus", "pinterest", "whatsapp"]
        });
		$("#maker-share").jsSocials("option", "url", 'http://mapasolidario.org.ar/?@=' + $("#maker-alias").val());
	});
	
	mapCanvas.on('popupclose', function(e) {
		$("#maker-share").jsSocials("destroy");
	});
	
	//if ll isset, point to
	if(position.length==2){
		positionMarker([initLat, initLng]);
	}
	
	//adding png tile
	L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
		transparent: true,
		tiled: true,
		attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://www.noseaspavote.org.ar">NoSeasPavote</a>'
	}).addTo(mapCanvas);
	
	
	_turkeyIcon = new L.icon({
			iconUrl: $('body').data('site-url') + 'assets/media/img/marker-turkey.png',
			iconSize:     [34, 35],
    		popupAnchor:  [12, -20]
		});
		
	//loading categories
	var ajaxPromise = getAjaxPromise('api/categories', false);	
	ajaxPromise.done(function(data) {
		loadCategories(data);
		
		//open annuncement pop up
		if($("#link-announcement").data('show-on-load')==true){
			$("#link-announcement").trigger( "click" );
		}
		
		//loading the markers when I have the categories	
		loadMarkers();
	})
}

/**
 * Context menu functions
 */
function shareCoordinates (e) {
	var lat = e.latlng['lat'];
	var lng = e.latlng['lng'];
	var url = 'http://mapasolidario.org.ar/?ll=' + encodeURI(lat) + ','+ encodeURI(lng);
	
	var clipboard = new Clipboard('#popup-share-copy-link');
	console.log(clipboard);
	$("#popup-share-div").jsSocials("option", "url", url);
	$('#popup-share-input').val(url);
	$('#popup-share').popup('show');
}

function centerMap (e) {
    mapCanvas.panTo(e.latlng);
}


/**
 * Function to load the categories in the sidebar.
 */
function loadCategories(data){
	_categories = data;
	$(".category-template-container").loadTemplate("#category-template", _categories);
}

//hides markers in map
function getLayerByCategory(id) {
	var layer = null;
	$.each(_layers, function(i, e) {
		if(e.category_id == id){	
			layer = e.layer;
		}
	});
	return layer;
}

/**
 * ---
 */
function setupMarker(feature, layer){
	var icon = new L.icon({
			iconUrl: $('body').data('site-url') + 'assets/media/img/' + feature.properties.icon,
			iconSize:     [34, 46],
    		popupAnchor:  [12, -20]
		});
	layer.setIcon(icon);
	
	var moreLink;
	if(feature.properties.alias!=''){
		moreLink = $('body').data('site-url') + 'institucion/alias/' + feature.properties.alias;
	}else if(feature.properties.code!=''){
		moreLink = $('body').data('site-url') + 'institucion/code/' + feature.properties.code;
	}
	
	var content = '<div>';
		content = content + '<b>' + feature.properties.name + '</b><br />';
		content = content + 'Dirección: ' + feature.properties.street_name + ' ' + feature.properties.street_number + '<br />';
		content = content + '<br />';
		content = content + ((feature.properties.description === '' || feature.properties.description == null) ? '': '<span>' + feature.properties.description + '</span><br />' ) ;
		content = content + '<br />';
		content = content + '<span style="float:left;">';
		content = content + 'Fuente: <a href="' + feature.properties.source_site_url + '" target="_blank" title="' + feature.properties.source_description + '">' + feature.properties.source_name + '</a>';
		content = content + '</span>';
		content = content + '<br />';
		content = content + '<span style="float:right;">';
		content = content + '<a href="' + moreLink + '" title="Conocer más">[conocer más]</a>';
		content = content + '</span>';
		content = content + '<br />';
		content = content + '<div id="maker-share"></div>';
		content = content + '<input type="hidden" id="maker-alias" value="' + feature.properties.alias + '"/>';
		content = content + '</div>';
	layer.bindPopup(content);
	
	//open popup info by default
	var showInstitutionVal = $('#showInstitution').val().toUpperCase();
	if(showInstitutionVal!=''){
		if(feature.properties.alias == showInstitutionVal){
			_queryMarker = layer;
		}else if (feature.properties.id == showInstitutionVal) {
			_queryMarker = layer;
		}
	}
}

/**
 * Function to load markers for each category
 */
function loadMarkers(){
	$(_categories).each(function(key,data) {
		var ajaxPromise = getAjaxPromise('api/markers.geojson/category/' + data.id, false);		
		
		var categoryObj = {category_id: data.id, layer: []};
		ajaxPromise.done(function(data) {
			var layer = L.geoJson(data,{
				onEachFeature: setupMarker
				}).addTo(mapCanvas);
			categoryObj.layer = layer;
			_layers.push(categoryObj);
			
			//open marker query by url
			if(_queryMarker){
				_queryMarker.openPopup();
				mapCanvas.setView(_queryMarker.getLatLng(), 18);
			}
		})
	});	
	
}

/**
 * Function to get current position of the user
 */
function useCurrentLocation(){
	mapCanvas.on('locationfound', onLocationFound);
	mapCanvas.on('locationerror', onLocationError);
	mapCanvas.locate({setView: true, maxZoom: 16});
}

function onLocationFound(e) {
    L.marker(e.latlng, {icon: _turkeyIcon}).addTo(mapCanvas)
        .bindPopup("<b>Estás aquí!</b>").openPopup();
}

function onLocationError(e) {
    console.log(e.message);
	alert("Ocurrió un error, estamos trabajando para solucionarlo.");
}

/**
 * Show and hide markers in the map
 */
function setCategoryMarkers(link) {
		
	var id = $(link).prev().val();
	
	$(link).find("i").toggleClass('fa-check-square');
	$(link).find("i").toggleClass('fa-square'); 

	if($(link).data('selected')==true){
		mapCanvas.removeLayer(getLayerByCategory(id));
		$(link).data('selected', false);
	}else{
		mapCanvas.addLayer(getLayerByCategory(id));
		$(link).data('selected', true);
	}
}

/**
 * Show ALL Category Markers
 */
function setAllCategories() {
	$(".category-template-container").find("a").each(function() {
		if($( this ).data('selected')==false){
			$( this ).trigger( "click" );
		}	
	});
}

function showInfo(link){
	var id = $(link).prev().val();
	
	mapCanvas.eachLayer(function (layer) {	
		if(layer.hasOwnProperty("feature")){
			if(layer.feature.hasOwnProperty("properties")){
				if (layer.feature.properties.id == id) {
					layer.openPopup();
				}
			};
		};
	});
}

function search() {
		
	var searchText = $("#txtSearch").val();
	
	if (searchText != "") {
		$(".leaflet-control-zoom").css("visibility", "hidden");
		
		var ajaxPromise = getAjaxPromise('api/markers/q/' + encodeURIComponent(searchText), true);
			
		ajaxPromise.done(function(data) {
			_markers = data;
			if (_markers.length > 0) {
				$(".form__list").show();
				$(".form--search__result").loadTemplate("#result-template", _markers);
			}else{
				$(".form__list").hide();
			}
		})
	}
}

function positionMarker(latlng){
	L.marker(latlng).addTo(mapCanvas);
}