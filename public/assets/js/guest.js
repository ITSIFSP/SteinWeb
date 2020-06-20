//Definindo a ref do banco para interdictions
var interventionRef = firebase.database().ref("interdictions");
// var interventionTeste = firebase.database().ref("interdictionsTeste");

var map;
var markers = [];
var markerTemp = [];
var directions = [];
var results = [];
var teste;
var objectLenght = 0;

var contStreet = 0;
var contDirections = 0;

var cleanCount = null;

//Map options
var options = {
    zoom: 14,
    center: { lat: -21.135008, lng: -48.980169 } //Catanduva - IFSP
};

//Directions API

//Gera o Maps
function initMap() {
    setMapTemp(null);
    deleteTempMarkers();

    //New map
    map = new google.maps.Map(document.getElementById("map"), options);
    intervention();
}

// Sets the map on all markers in the array.
function setMapOnAll(map) {
    for (var i = 0; i < markers.length; i++) {
        markers[i].setMap(map);
    }
}

// Removes the markers from the map, but keeps them in the array.
function clearMarkers() {
    setMapOnAll(null);
}

// Deletes all markers in the array by removing references to them.
function deleteMarkers() {
    clearMarkers();
    markers = [];
}

//Parte das locations temporárias
function deleteTempMarkers() {
    markerTemp = [];
}

function setMapTemp(map) {
    for (var i = 0; i < markerTemp.length; i++) {
        markerTemp[i].setMap(map);
    }
}

//Plota a rota no mapa
function calculateRoute(origin, destination) {
    var directionsService = new google.maps.DirectionsService();

    var directionsRequest = {
        origin: origin,
        destination: destination,
        travelMode: "DRIVING"
    };
    directionsService.route(directionsRequest, function(response, status) {
        if (status == google.maps.DirectionsStatus.OK) {
            render = new google.maps.DirectionsRenderer({
                map: map,
                directions: response,
                preserveViewport: true
            });
        } else {
            window.location.reload();
        }
    });
}

function intervention() {
    //Método listener do banco para trazer as interdições
    interventionRef.on("value", function(snapshot) {
        //Se tiver mudança nas rotas depois de plotar a primeira vez atualiza a página
        if (contDirections > 0) {
            window.location.reload();
        }

        let local1;
        let local2;
        var lenghtAux = 0;
        // lenghtAux = objectLenght; //0
        const interventions = [];

        var data = [];
        var data = snapshot.val();
        var dateNow = moment().format("DD/MM/YYYY hh:mm A");

        for (let index in data) {
            var isInInterval = false;

            //Verifica se o status da interdição é verdadeiro
            if (data[index].status == true || data[index].status == "true") {
                const intervention = {
                    origin: origin,
                    destination: destination
                };

                //Pega as datas do Banco
                var begin = data[index].beginDate;
                var end = data[index].endDate;

                // console.log(
                //     "Date Begin: " +
                //         begin +
                //         " \nDate Now: " +
                //         dateNow +
                //         " \nDate End: " +
                //         end
                // );
                if (
                    // moment(dateNow).isAfter(begin) &&
                    // moment(dateNow).isBefore(end)
                    dateNow >= begin &&
                    dateNow <= end
                ) {
                    //Entre intervalo
                    isInInterval = true;
                    // console.log("aaaaaaaaaa");
                    // console.log(begin = data[index].beginDate);
                    // console.log(end = data[index].endDate);
                }
                if (isInInterval) {
                    //Aqui vai o código de plotar a intervenção
                    intervention.origin = data[index].origin;
                    intervention.destination = data[index].destination;
                    interventions.push(intervention);
                }
            } else {
                // console.log("status falso");
            }
        }

        // //Plota as directions no mapa
        for (let index in interventions) {
            local1 = new google.maps.LatLng({
                lat: interventions[index].origin.lat,
                lng: interventions[index].origin.lng
            });

            local2 = new google.maps.LatLng({
                lat: interventions[index].destination.lat,
                lng: interventions[index].destination.lng
            });

            calculateRoute(local1, local2);            
        }
        contDirections++;
    });
}
