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
	let chmpAdresseDepart = document.getElementById('ChmpAdresseDepart')
	
	// On récupère les champs de la page
	let chmpAdresseArrivee = document.getElementById('ChmpAdresseArrivee')


		
	// On écoute l'évènement "change" sur le champ ville

	chmpAdresseDepart.addEventListener("change", function(){
    		// On envoie la requête ajax vers nominatim et on traite la réponse
	   		ajaxGet(`https://nominatim.openstreetmap.org/search?q=${this.value}&format=json&addressdetails=1&limit=1&polygon_svg=1`).then(reponse => {
	   		 	
	        // On convertit la réponse en objet Javascript
	        let data = JSON.parse(reponse)


	        // On stocke la latitude et la longitude dans la variable ville
	        ville1 = [data[0].lat, data[0].lon];
	        console.log(ville1);

			  if (marker1 == null) {
			  		   marker1 = L.marker(ville1, {icon: greenIcon}).addTo(mymap);
			  		   mymap.panTo(ville1);
			  		   mymap.setView(ville1, 11);
					   }
			  else {
					   mymap.removeLayer(marker1);
					   marker1 = L.marker(ville1, {icon: greenIcon}).addTo(mymap);
					   mymap.panTo(ville1);
					  
					   }
					  

			  document.getElementById("v1lat").value =ville1[0];
			  document.getElementById("v1lng").value =ville1[1];
			  
			  refreshRouteAndDistance();
			

    })
	})


	// On écoute l'évènement "change" sur le champ ville arrivé

	chmpAdresseArrivee.addEventListener("change", function(){

    		// On envoie la requête ajax vers nominatim et on traite la réponse
	   		ajaxGet(`https://nominatim.openstreetmap.org/search?q=${this.value}&format=json&addressdetails=1&limit=1&polygon_svg=1`).then(reponse => {
	  	       
	        // On convertit la réponse en objet Javascript
	        let data = JSON.parse(reponse)

	        // On stocke la latitude et la longitude dans la variable ville
	        ville2 = [data[0].lat, data[0].lon]
	
			if (marker2 == null) {
				mymap.panTo(ville2);
				mymap.setView(ville2, 11);
			    marker2 = L.marker(ville2,{icon:redIcon}).addTo(mymap);
			    }
			  else {
			   mymap.removeLayer(marker2);
			   marker2 = L.marker(ville2,{icon:redIcon}).addTo(mymap);
			   mymap.panTo(ville2);
			  }	

			document.getElementById("v2lat").value =ville2[0];
			document.getElementById("v2lng").value =ville2[1];  			 
			  
            refreshRouteAndDistance();
			
    })
	})		
			
 				
 			function refreshRouteAndDistance() {

				if(ville1 != "" && ville2 !="")
		            {	
			           // dir = MQ.routing.directions();
			            dir.optimizedRoute({
			                    locations: [
			                        { latLng: { lat: ville1[0], lng: ville1[1]} },         
			           			    { latLng: { lat: ville2[0], lng: ville2[1]} }
			                    ]

			                });
			               /*console.log('id',MQ.routing.routeLayer({
			                    directions: dir,
			                    fitBounds: true,
			                    ribbonOptions: {
							        draggable: false,
							        ribbonDisplay: { color: '#0000FF', opacity: 0.3 }
							       }})) ;*/
						  //mymap.removeLayers(MQ.mapLayer());				     
			              mymap.addLayer(MQ.routing.routeLayer({
			                    directions: dir,
			                    fitBounds: true,
			                    ribbonOptions: {
							        draggable: false,
							        ribbonDisplay: { color: '#0000FF', opacity: 0.3 }
							       }}));

			            //Distance par km
			             distance = getDistance(ville1,ville2)/1000;
						 document.getElementById('distance').innerHTML =((distance.toFixed())+' km') ;
						 document.getElementById("distances").value =((distance.toFixed())+' km');

						 //Durée estimée
						 duration=getduration(distance);
						 if(duration<59){
						 	document.getElementById('Durée').innerHTML =(Math.round(duration)+'minutes') ;
						 	document.getElementById("duree").value =(Math.round(duration)+'minutes');
						 } else{	
						 	var heure=duration/60;
						 	var minute=duration%60;
						 	document.getElementById('Durée').innerHTML =(Math.round(heure)+' h '+Math.round(minute)+' min') ;
						 	document.getElementById("duree").value =(Math.round(heure)+' h '+Math.round(minute)+' min');
						 }

						 //consomation carburant
						 document.getElementById('carburant').innerHTML =(Math.round((distance.toFixed())*7.18/100)*2+' L (Aller/Retour)') ;

						 //lat lon ville depart et ville d'arrivée
						  //ville2 = [data[0].lat, data[0].lon]
						   //document.getElementById("v1lat").value =ville1.data[0].lat;
						 //document.getElementById("v1lng").value =(Math.round(duration)+'minutes');
						 //document.getElementById("v2lat").value =(Math.round(duration)+'minutes');
						 //document.getElementById("v2lng").value =(Math.round(duration)+'minutes');

		            }	
			
					
			 }

				/* Function Calcul Distance */
				function getDistance(origin, destination) {
					    // return distance in meters
					    var lon1 = toRadian(origin[1]),
					        lat1 = toRadian(origin[0]),
					        lon2 = toRadian(destination[1]),
					        lat2 = toRadian(destination[0]);

					    var deltaLat = lat2 - lat1;
					    var deltaLon = lon2 - lon1;

					    var a = Math.pow(Math.sin(deltaLat/2), 2) + Math.cos(lat1) * Math.cos(lat2) * Math.pow(Math.sin(deltaLon/2), 2);
					    var c = 2 * Math.asin(Math.sqrt(a));
					    var EARTH_RADIUS = 6371;
					    return c * EARTH_RADIUS * 1000;
					}
					function toRadian(degree) {
					    return degree*Math.PI/180;
					}

					/* Function Calcul Durée Estimée */
				function getduration(distance) {

					    if (distance <40) 
					    {
					    	return Math.round(distance* 1.37);
					    }
					    else if (40<distance && distance<70) 
					    {
					    	console.log(distance);
					    	return Math.round(distance*1.1);

					    }
						else
						{
							return Math.round(distance/1.37);
						} 
					}
					
			
				function DeleteRoute()
				{
						mymap.removeLayer(dir.route({
			                    locations: [
			                        { latLng: { lat: ville1[0], lng: ville1[1]} },         
			           			    { latLng: { lat: ville2[0], lng: ville2[1]} }
			                    ]

			                }));
					
					
				}					
				
} 

		

		/* /Auto Complete MapBox*/


/**
 * Cette fonction effectue un appel Ajax vers une url et retourne une promesse
 * @param {string} url 
 */
function ajaxGet(url){
    return new Promise(function(resolve, reject){
        // Nous allons gérer la promesse
        let xmlhttp = new XMLHttpRequest();

        xmlhttp.onreadystatechange = function(){
            // Si le traitement est terminé
            if(xmlhttp.readyState == 4){
                // Si le traitement est un succès
                if(xmlhttp.status == 200){
                    // On résoud la promesse et on renvoie la réponse
                    resolve(xmlhttp.responseText);
                }else{
                    // On résoud la promesse et on envoie l'erreur
                    reject(xmlhttp);
                }
            }
        }

        // Si une erreur est survenue
        xmlhttp.onerror = function(error){
            // On résoud la promesse et on envoie l'erreur
            reject(error);
        }

        // On ouvre la requête
        xmlhttp.open('GET', url, true);

        // On envoie la requête
        xmlhttp.send(null);
    })
}   



//scroll

$(document).ready(function(){

	//Stickey NavBar
	$(window).scroll(function(){

		var sc=$(this).scrollTop();
		if (sc<342){
			$('.leaflet-control-zoom').show();
			
		}else
		{
			$('.leaflet-control-zoom').hide();
		}

		//Footer logo Map
		if (sc>740){
			$('.leaflet-control').hide();
		}else
		{
			$('.leaflet-control-attribution').show();
			$('.mq-logo-control').show();
			$('.mq-attribution-control').show();
		}
	});
});

