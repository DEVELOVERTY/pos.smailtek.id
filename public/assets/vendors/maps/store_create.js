var map = L.map('map', {
    minZoom: 10,
    maxZoom: 18
});

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© MDHDigital',
    }).addTo(map);

    map.attributionControl.setPrefix(false);

    
    // placeholders for the L.marker and L.circle representing user's current position and accuracy    
    var current_position, current_accuracy;

    function onLocationFound(e) {
      // if position defined, then remove the existing position marker and accuracy circle from the map
      if (current_position) {
          map.removeLayer(current_position);
          map.removeLayer(current_accuracy);
      }

      function removeCircle()
      {
        map.removeLayer(current_accuracy);
      }

      var radius = e.accuracy / 4;

      current_position = new L.marker(e.latlng, {
        draggable: 'true'
      }).addTo(map);

        current_position.on('dragend', function(event) {
            var position = current_position.getLatLng();
            current_position.setLatLng(position, {
            draggable: 'true'
            }).bindPopup(position).update();
            $("#long").val(position.lng);
            $("#lang").val(position.lat);
            removeCircle();
            current_accuracy =  L.circle(position, radius);
            map.addLayer(current_accuracy);
        });
            current_accuracy = L.circle(e.latlng, radius).addTo(map);  
            $("#long").val(e.longitude);
            $("#lang").val(e.latitude);     
    }

    
    function onLocationError(e) {
      alert(e.message);
    }

    map.on('locationfound', onLocationFound);
    map.on('locationerror', onLocationError);


    // wrap map.locate in a function    
    function locate() {
      map.locate({setView: true, maxZoom: 16});
    }

    // call locate every 3 seconds... forever
    setTimeout(locate, 1000);
