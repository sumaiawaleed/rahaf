<script>
    function initMap() {
        var myLatlng = {lat: {{  env('PLAT') }}, lng: {{ env('PLNG') }}};

        var map = new google.maps.Map(
            document.getElementById('map'), {zoom: 4, center: myLatlng});

        // Create the initial InfoWindow.
        var infoWindow = new google.maps.InfoWindow(
            {content: 'Click the map to get Lat/Lng!', position: myLatlng});
        infoWindow.open(map);

        // Configure the click listener.
        map.addListener('click', function(mapsMouseEvent) {
            // Close the current InfoWindow.
            infoWindow.close();

            // Create a new InfoWindow.
            infoWindow = new google.maps.InfoWindow({position: mapsMouseEvent.latLng});
            infoWindow.setContent(mapsMouseEvent.latLng.toString());

            $('#lat').val(mapsMouseEvent.latLng.lat().toString());
            $('#log').val(mapsMouseEvent.latLng.lng().toString());


            infoWindow.open(map);
        });
    }
</script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key={{ env('MAP_API') }}&callback=initMap">
</script>
