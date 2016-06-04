/* LO QUE VIENE ACÁ ES PORQUE LA ANCHURA ES MENOR A 600 PX*/
console.log("es mobile");

/*funciones de css
jQuery('.form--search').css("background-color","#8260C8");
jQuery('#posicion a').css("color","white");
jQuery('.header__brand').css("background-color","#d2d6de");
jQuery('.header__brand').css("height","50px");
jQuery('.clear').css("background-color","#d2d6de");
*/

/*agregar loader con el logo de no seas pavote*/


function onReady(callback) {
    var intervalID = window.setInterval(checkReady, 1000);

    function checkReady() {
        if (document.getElementsByTagName('body')[0] !== undefined) {
            window.clearInterval(intervalID);
            callback.call(this);

        }
    }
}

function show(id, value) {
    if (value==true){
        $(id).show();
    }else{
      $(id).hide();
    }


}

onReady(function () {
    show('.body', true);
    show('.loader', false);
});


//saco la imagen de las manos
sacarManitos();
sacarFooter();

//al mapa siempre lo pongo en left 0px,
//para que no tenga que llamar funciones de jquery cada vez que hagan click
$("#map-canvas").css("left","0px");

//función de la solapa Menú
var click_menu=$(".header__menu" ).click();
var click_mapa=$("#map-canvas").click();
var menu_visible=$(".sidebar").is(":visible")


$( ".header__menu" ).click(function() {
  	//si esta visible y hacen click, escondo el menú y pongo el mapa
		$(".sidebar").slideToggle('slow');
		if(!jQuery(".sidebar").is(":visible")){

		}else{

	}
});

//si clickean al mapa y el menu es visible, saco el menú.
$('#map-canvas').bind('click', function() {
		if($(".sidebar").is(":visible")==true){
      console.log("es visible, ameo")
			$(".sidebar").hide("slow");
		}
});


$("#map-canvas").click(function(){
	if(menu_visible==true){
		//console.log("es visible, ameo")
	}
});

$(".redes").css("position","absolute");
$(".redes").css("left","32%");
$(".redes").css("right","0p	x");
$(".redes").css("bottom","0px");
$(".redes").css("height","9%");
$(".redes").css("z-index","0");
$(".redes a").css("border-radius","20px");




function sacarManitos(){
	jQuery(".sidebar").css("background","white");
}
function sacarFooter(){
	jQuery("footer").hide();
}
