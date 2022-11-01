// Variables globales
let ville1 = ville2 = distance = ""
var marker1 = null;
var marker2 = null;


var distance;

var dir = MQ.routing.directions();
window.onload = () => 
{
    // On initialise la carte et on la centre sur Tunisie
     let mymap = L.map('map', {
                  layers:MQ.mapLayer(),
                  center: [ 34.01, 9.56 ],
                  zoom: 6
                });

    
	L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
	    attribution: '&copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
	    maxZoom: 18,
	    id: 'mapbox/streets-v11',
	    tileSize: 512,
	    zoomOffset: -1,
	    accessToken: 'pk.eyJ1Ijoic2FpZm1zayIsImEiOiJjazh5cWR0b2UwZDZhM2RvZ3V0d2xwMXRkIn0.a3rJzudk7Rd0o8PuvgZ0kQ'
	}).addTo(mymap);

	//change icon
	var greenIcon = L.icon({
	    iconUrl: '/images/maps/point_vert.png',
	    iconSize:     [23, 23], // size of the icon
	    iconAnchor:   [11, 23], // point of the icon which will correspond to marker's location
	    //popupAnchor:  [0, 22] // point from which the popup should open relative to the iconAnchor
	});

	var redIcon = L.icon({
	    iconUrl: '/images/maps/point_rouge.png',
	    iconSize:     [23, 23], // size of the icon
	    iconAnchor:   [11, 23], // point of the icon which will correspond to marker's location
	    //popupAnchor:  [0, 22] // point from which the popup should open relative to the iconAnchor
	});


	// On récupère les champs de la page

	let ville1_lat = document.getElementById("myVar1").value;
	let ville1_lng = document.getElementById("myVar2").value;

	let ville2_lat = document.getElementById("myVar3").value;
	let ville2_lng = document.getElementById("myVar4").value;

	   		 	
	        // On stocke la latitude et la longitude dans la variable ville
	        ville1 = [ville1_lat, ville1_lng];
	        //console.log(ville1);

			  		   marker1 = L.marker(ville1, {icon: greenIcon}).addTo(mymap);
			  		   mymap.panTo(ville1);
			  		   mymap.setView(ville1, 11);
					   
			 	
	        // On stocke la latitude et la longitude dans la variable ville
	        ville2 = [ville2_lat, ville2_lng];
	
				mymap.panTo(ville2);
				mymap.setView(ville2, 11);
			    marker2 = L.marker(ville2,{icon:redIcon}).addTo(mymap);
			    
			  			 
			  
            refreshRouteAndDistance();
			
			
 				
 			function refreshRouteAndDistance() {

				if(ville1 != "" && ville2 !="")
		            {	
			            dir.optimizedRoute({
			                    locations: [
			                        { latLng: { lat: ville1[0], lng: ville1[1]} },         
			           			    { latLng: { lat: ville2[0], lng: ville2[1]} }
			                    ]

			                });
			               			     
			              mymap.addLayer(MQ.routing.routeLayer({
			                    directions: dir,
			                    fitBounds: true,
			                    ribbonOptions: {
							        draggable: false,
							        ribbonDisplay: { color: '#0000FF', opacity: 0.3 }
							       }}));

		            }				
					
			 }
										
				
}


//scroll

$(document).ready(function(){

	//Stickey NavBar
	$(window).scroll(function(){

		var sc=$(this).scrollTop();
		//console.log(sc);
		if (sc>980){
			
			$('.leaflet-control-zoom').hide();
			
		}else
		{
			$('.leaflet-control-zoom').show();	
		}

		//Footer logo Map
		if (sc>1380){
			$('.leaflet-control').hide();
		}else
		{
			$('.leaflet-control-attribution').show();
			$('.mq-logo-control').show();
			$('.mq-attribution-control').show();
		}
	});
}); 

		



