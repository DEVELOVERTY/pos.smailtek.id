$(function () {
    // use below if you want to specify the path for leaflet's images
    //L.Icon.Default.imagePath = '@Url.Content("~/Content/img/leaflet")';

    var curLocation = [0, 0];
    // use below if you have a model
    // var curLocation = [@Model.Location.lang, @Model.Location.long];

    if (curLocation[0] == 0 && curLocation[1] == 0) {
        curLocation = [$("#lang").val(), $("#long").val()];
    }

    var map = L.map('map').setView(curLocation, 10);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© MDHDigital',
    }).addTo(map);
    current_accuracy = L.circle(curLocation, 15000).addTo(map);
    map.attributionControl.setPrefix(false);

    var marker = new L.marker(curLocation, {
        draggable: 'true'
    });



    marker.on('dragend', function (event) {
        var position = marker.getLatLng();
        marker.setLatLng(position, {
            draggable: 'true'
        }).bindPopup(position).update();
        $("#lang").val(position.lat);
        $("#long").val(position.lng).keyup();
        removeCircle();
        current_accuracy = L.circle(position, 15000);
        map.addLayer(current_accuracy);
    });

    $("#lang, #long").change(function () {
        var position = [parseInt($("#lang").val()), parseInt($("#long").val())];
        marker.setLatLng(position, {
            draggable: 'true'
        }).bindPopup(position).update();
        map.panTo(position);
    });

    function removeCircle() {
        map.removeLayer(current_accuracy);
    }

    map.addLayer(marker);
})
