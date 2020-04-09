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

//Variáveis para atribuir no input
var partida = document.getElementById("origin");
var destino = document.getElementById("destiny");
var descricao = document.getElementById("description");

var origin = {
    lat: null,
    lng: null,
    street: null
};

var destination = {
    lat: null,
    lng: null,
    street: null
};

const sendToDatabase = {
    beginDate: null,
    description: null,
    destination: destination,
    endDate: null,
    organization: null,
    origin: origin,
    status: null
};

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

    //Variables
    var contClicks = 0;

    var markerOrigin = {
        lat: null,
        lng: null
    };

    var markerDestination = {
        lat: null,
        lng: null
    };

    //New map
    map = new google.maps.Map(document.getElementById("map"), options);
    intervention();

    //Map Listener Click Event //verificar se esta selecionado o inicio e o destino no form e mandar um request na função handleClick aqui no arquivo js
    map.addListener("click", function(e) {
        if (contClicks == 0) {
            markerOrigin.lat = e.latLng.lat();
            markerOrigin.lng = e.latLng.lng();
            // markerOrigin.lat = e.Za.y;
            // markerOrigin.lng = e.Za.x;
            // console.log(origem);
            addMarker(markerOrigin);
            contClicks++;
            cleanCount++;
            // console.log(cleanCount);
            requestGeocodeAPI(markerOrigin);
        } else if (contClicks == 1) {
            markerDestination.lat = e.latLng.lat();
            markerDestination.lng = e.latLng.lng();
            // markerDestination.lat = e.Za.y;
            // markerDestination.lng = e.Za.x;

            addMarker(markerDestination);
            contClicks++;
            cleanCount++;
            // console.log(cleanCount);
            requestGeocodeAPI(markerDestination);
        } else if (contClicks >= 2) {
            contClicks = 0;
            cleanCount = 0;
            //Limpa os inputs
            partida.value = "";
            destino.value = "";

            setMapTemp(null);
            deleteTempMarkers();

            // clearMarkers();
            // setMapOnAll(null);
            // deleteMarkers();
        }
    });
}

//Cadastra a intervenção no banco
function addIntervention(
    origin_street,
    destiny_street,
    description,
    date,
    permission,
    user
) {
    if (
        origin_street == origin.street &&
        destiny_street == destination.street
    ) {
        //Divide a data em begin e end date
        var data = date.toString();
        var array = data.split("~");
        var beginDate = array[0];
        var endDate = array[1];
        //---------------------------------

        var user = user;

        //Verifica se o usuário é administrador, se for a interdição já vai como true
        if (permission == "Administrador") {
            var status = true;
        } else {
            var status = false;
        }

        sendToDatabase.beginDate = beginDate;
        sendToDatabase.description = description;
        sendToDatabase.destination = destination;
        sendToDatabase.endDate = endDate;
        sendToDatabase.organization = user;
        sendToDatabase.origin = origin;
        sendToDatabase.status = status;

        interventionRef.push(sendToDatabase); //Cria a intervenção no banco

        //Limpa os campos do form
        partida.value = "";
        destino.value = "";
        descricao.value = "";
        //-----------------------
    }
}

//Traz a localização - Reverse GeoCode (informa a lat lng e traz o Endereço)
async function requestGeocodeAPI(location) {
    var latLng = new google.maps.LatLng({
        lat: location.lat,
        lng: location.lng
    });

    var latLngOrigin;
    var latLngDestiny;

    const formatedLagLng = `${latLng.toJSON().lat}, ${latLng.toJSON().lng}`;
    const url = `https://maps.googleapis.com/maps/api/geocode/json?latlng=${formatedLagLng}&key=AIzaSyAiQpZjuO1K2Y9PfZLAsYqqDVIhVhxtU7s`;

    const { data } = await axios.get(url);
    // console.log(data);
    const expectedResult = data.results[0].formatted_address;

    if (contStreet % 2 == 0) {
        //Cria o objeto de origin para o firebase
        partida.value = expectedResult;
        origin.lat = location.lat;
        origin.lng = location.lng;
        origin.street = expectedResult;
    } else {
        //Cria o objeto de destination para o firebase
        destino.value = expectedResult;
        destination.lat = location.lat;
        destination.lng = location.lng;
        destination.street = expectedResult;

        latLngOrigin = new google.maps.LatLng({
            lat: origin.lat,
            lng: origin.lng
        });
        latLngDestiny = new google.maps.LatLng({
            lat: destination.lat,
            lng: destination.lng
        });
    }
    //Contador para saber qual rua é: partida ou destino
    contStreet++;
}

//Adiciona os markers no mapa
function addMarker(location) {
    var marker = new google.maps.Marker({
        position: location,
        map: map
        // title: 'Hello World!'
    });

    markerTemp.push(marker);
    markers.push(marker);
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
                    moment(dateNow).isAfter(begin) &&
                    moment(dateNow).isBefore(end)
                ) {
                    //Entre intervalo
                    isInInterval = true;
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
