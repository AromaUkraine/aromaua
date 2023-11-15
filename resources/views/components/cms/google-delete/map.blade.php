<div id="map" style="height: {{$height}}px" data-info="{{$info}}" ></div>
<div class="form-group mt-2 pb-1">
    <label>{{__('cms.set_marker_to_map')}} </label>
    <input type="text" class="form-control" id="pac-input" value="{{$value}}"
           placeholder="{{__('cms.Enter_the_address_to_search')}}">
</div>
<div class="form-group pb-1">
    <input type="hidden" name="{{$lat}}" value="{{$setValue($lat)}}" id="lat">
</div>
<div class="form-group pb-1">
    <input type="hidden" name="{{$lng}}" value="{{$setValue($lng)}}" id="lng">
</div>

@push('scripts')
    <script src="{{$src}}"></script>
    <script>

        let markers = [];
        let lat = document.getElementById("lat");
        let lng = document.getElementById("lng");
        const input = document.getElementById("pac-input");
        const mapElement = document.getElementById("map");
        // Create the search box and link it to the UI element.
        const searchBox = new google.maps.places.SearchBox(input);

        $('form input').on('keypress', function(e) {
            return e.which !== 13;
        });

        $(function () {
            initAutocomplete();
        })

        function initAutocomplete() {

            // Initialize map
            const map = new google.maps.Map(mapElement, {
                center: {lat: 50.440800650451344, lng: 30.502144005859382},
                zoom: 8,
                mapTypeId: "roadmap",
            });

            // Установка карты по геопозиции
            navigator.geolocation.getCurrentPosition(function (position) {
                // Center on user's current location if geolocation prompt allowed
                var initialLocation = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
                map.setCenter(initialLocation);
                map.setZoom(13);
            }, function (positionError) {
                // User denied geolocation prompt - default to Kiev
                map.setCenter(new google.maps.LatLng(50.440800650451344, 30.502144005859382));
                map.setZoom(8);
            });

            if (typeof map === 'object') {
                let latLng = new google.maps.LatLng(lat.value, lng.value);
                getPlace(latLng, function (res) {
                    let place = res;
                    if (!place.geometry) {
                        console.log("Returned place contains no geometry");
                        return;
                    }
                    deleteMarkers(map);
                    setMarker(map, latLng, place);
                })
            }

            // map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
            // Bias the SearchBox results towards current map's viewport.
            // map.addListener("bounds_changed", () => {
            //     searchBox.setBounds(map.getBounds());
            // });


            // Listen for the event fired when the user selects a prediction and retrieve
            // more details for that place.
            searchBox.addListener("places_changed", () => {
                const places = searchBox.getPlaces();

                if (places.length == 0) {
                    return;
                }

                deleteMarkers(map);

                places.forEach((place) => {
                    if (!place.geometry) {
                        console.log("Returned place contains no geometry");
                        return;
                    }
                    setMarker(map, place.geometry.location, place);
                });
            });
        }

        let getPlace = async function (latLng, callback) {
            let geocoder = new google.maps.Geocoder();

            geocoder.geocode({
                'latLng': latLng
            }, function (results, status) {

                if (status === google.maps.GeocoderStatus.OK) {
                    if (results[1]) {
                        callback(results[1]);
                    } else {
                        console.log('No results found');
                    }
                } else {
                    console.log('Geocoder failed due to: ' + status);
                }
            });
        }

        let setMarker = function (map, position, place) {

            let marker = new google.maps.Marker({
                map,
                draggable: true,
                position: position,
            });

            markers.push(marker);
            setBounds(map, marker, place);
            showInfo(map, marker);
        }


        let setBounds = function (map, marker, place) {
            // For each place, get the icon, name and location.
            const bounds = new google.maps.LatLngBounds();

            if (place.geometry.viewport) {
                // Only geocodes have viewport.
                bounds.union(place.geometry.viewport);
            } else {
                bounds.extend(place.geometry.location);
            }

            map.fitBounds(bounds);

            google.maps.event.addListener(marker, 'dragend', function (event) {
                setCoordinate(marker);
            });
        }


        let showInfo = function (map, marker){

            console.log();
            let info = $(mapElement).data('info');
            if(!info)
                return;

            const infowindow = new google.maps.InfoWindow({
                content: info,
            });

            infowindow.open(map, marker);
        }


        let clearMarkers = function () {
            for (let i = 0; i < markers.length; i++) {
                markers[i].setMap(null);
            }
        }

        let deleteMarkers = function () {
            clearMarkers();
            markers = [];
        }

        let setCoordinate = function (marker) {
            lat.value = marker.getPosition().lat();
            lng.value = marker.getPosition().lng();
        }


    </script>
@endpush
