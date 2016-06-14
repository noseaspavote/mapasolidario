		//si es pagina web común saco los botones de redes
console.log("no es mobile");
		//jQuery(".redes").hide();
		//$( ".header__menu" ).hide();


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
		    console.log(id);
		    console.log(value);
		    if (value==true){
		        $(id).show();
		    }else{
		      $(id).hide();
		    }
		}

		onReady(function () {
		  console.log("eam");

		    show('.body', true);
		    show('.loader', false);
		});
