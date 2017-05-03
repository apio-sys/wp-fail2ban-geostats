var IPMapper = {
    map: null,
    mapTypeId: google.maps.MapTypeId.ROADMAP,
    latlngbound: null,
    infowindow: null,
    baseUrl: "https://freegeoip.io/json/",
    initializeMap: function(mapId) {
        IPMapper.latlngbound = new google.maps.LatLngBounds();
        var latlng = new google.maps.LatLng(0, 0);

        // Set map options
        var mapOptions = {
            zoom: 1,
            center: latlng,
            mapTypeId: IPMapper.mapTypeId
        }

        // Initialize map
        IPMapper.map = new google.maps.Map(document.getElementById(mapId), mapOptions);

        // Initialize info window
        IPMapper.infowindow = new google.maps.InfoWindow();

        // Info window close event
        google.maps.event.addListener(IPMapper.infowindow, 'closeclick', function() {
            IPMapper.map.fitBounds(IPMapper.latlngbound);
            IPMapper.map.panToBounds(IPMapper.latlngbound);
        });
    },
    addIPArray: function(ipArray) {
        // Get unique array elements
        ipArray = IPMapper.uniqueArray(ipArray);

        // Add a map marker for each IP address
        for (var i = 0; i < ipArray.length; i++) {
            IPMapper.addIPMarker(ipArray[i]);
        }
    },
    addIPMarker: function(ip) {
        // Validate IP address format
        // Note: You don't need this if you validate IP addresses server-side
        ipRegex = /^(([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])$/;
        if($.trim(ip) != '' && ipRegex.test(ip)) {
            var url = encodeURI(IPMapper.baseUrl + ip + "?callback=?"); // Geocoding URL
            $.getJSON(url, function(data) { // Get geocoded JSONP data
                if($.trim(data.latitude) != '' && data.latitude != '0' && !isNaN(data.latitude)) {
                    // Geocoding successful
                    var latitude = data.latitude;
                    var longitude = data.longitude;
                    var contentString = "";
                    $.each(data, function(key, val) {
                        contentString += '<b>' + key.toUpperCase().replace("_", " ") + ':</b> ' + val + '<br />';
                    });
                    var latlng = new google.maps.LatLng(latitude, longitude);
                    var marker = new google.maps.Marker({ // Create map marker
                        map: IPMapper.map,
                        draggable: false,
                        position: latlng
                    });
                    IPMapper.placeIPMarker(marker, latlng, contentString); // Place marker on map
                } else {
                    IPMapper.logError('IP Address geocoding failed!');
                    $.error('IP Address geocoding failed!');
                }
            });
        } else {
            IPMapper.logError('Invalid IP Address!');
            $.error('Invalid IP Address!');
        }
    },
    placeIPMarker: function(marker, latlng, contentString) { // Place marker on map
        marker.setPosition(latlng);
        google.maps.event.addListener(marker, 'click', function() {
            IPMapper.getIPInfoWindowEvent(marker, contentString);
        });
        IPMapper.latlngbound.extend(latlng);
        IPMapper.map.setCenter(IPMapper.latlngbound.getCenter());
        IPMapper.map.fitBounds(IPMapper.latlngbound);
    },
    getIPInfoWindowEvent: function(marker, contentString) { // Open marker info window
        IPMapper.infowindow.close();
        IPMapper.infowindow.setContent(contentString);
        IPMapper.infowindow.open(IPMapper.map, marker);
    },
    uniqueArray: function(inputArray) { // Return unique elements from array
        var a = [];
        for (var i=0; i<inputArray.length; i++) {
            for (var j=i+1; j<inputArray.length; j++) {
                if (inputArray[i] === inputArray[j]) {
                    j = ++i;
                }
            }
            a.push(inputArray[i]);
        }

        return a;
    },
    logError: function(error) {
        if (typeof console == 'object') {
            console.error(error);
        }
    }
}
