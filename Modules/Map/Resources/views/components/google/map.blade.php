<div id="map" style="height: {{$height}}px" data-set-marker="{{$setMarker}}" data-info="{{$info}}" ></div>
<div class="form-group mt-2 pb-1">
    <label for="pac-input">{{__('cms.set_marker_to_map')}}</label>
    <input
        type="text"
        class="form-control"
        id="pac-input"
        value="{{$address}}"
        placeholder="{{__('cms.Enter_the_address_to_search')}}"
    />
    <div
        class="col-10 float-left pl-0"
        style="display: none;"
        id="error"
    >
        <span class="invalid-feedback d-block" role="alert">
            <strong>{{__('cms.The specified address was not found, please try to refine your search')}}</strong>
        </span>
    </div>
    <input type="hidden" name="lat" value="{{$lat}}" id="lat">
    <input type="hidden" name="lng" value="{{$lng}}" id="lng">
</div>

@push('scripts')
    <script src="{{$src}}"></script>
    <script>
       let map = null;
       let markers = [];
       let lat = document.getElementById("lat");
       let lng = document.getElementById("lng");
       const mapElement = document.getElementById("map");
       const input = document.getElementById("pac-input");
       let error = document.getElementById("error");

      // Create the search box and link it to the UI element.
       const searchBox = new google.maps.places.SearchBox(input);

       $('form input').on('keypress', function(e) {
           return e.which !== 15;
       });

        $(function () {
            initAutocomplete();
        })

        function initAutocomplete() {

            // Initialize map
            map = new google.maps.Map(mapElement, {
                center: {lat: 50.440800650451344, lng: 30.502144005859382},
                zoom: 8,
                mapTypeId: "roadmap",
            });

            if($(mapElement).data('set-marker')) {
                    // если есть координаты
                console.log($(lat).val())
                console.log($(input).val())
                if( $(lat).val() !== '' && $(lng).val() !== '' )
                    setMarkerByLatLng(lat.value, lng.value);
                // если нет координат, но есть адрес
                else if($(input).val() !== '' ){
                    console.log('asdasda');
                    setMarkerByAddress($(input).val());
                }

            }

        }


        // Установка маркера по адресу при загрузке страницы
        let setMarkerByAddress = function(address)
        {
            let geocoder = new google.maps.Geocoder();
            geocoder.geocode({'address': address },
                function (results, status) {
                    if (status == google.maps.GeocoderStatus.OK && results.length > 0) {
                        makeMarker(results);
                    }
                });
        }

        // Установка маркера по координатам при загрузке страницы
        let setMarkerByLatLng = function(lat, lng)
        {
            let latLng = new google.maps.LatLng(lat, lng);
            getPlace(latLng, function (res) {
                let place = res;

                if (!place.geometry) {
                    console.log("Returned place contains no geometry");
                    return;
                }
                // установка маркера makeMarker([place]) - ведет к неточности координат
                // посему просто удаляем маркеры и ставим по координатам
                deleteMarkers(map);
                setMarker(map, latLng, place);
            })

        }

        // Слушатель ввода адреса
        searchBox.addListener("places_changed", () => {
            const places = searchBox.getPlaces();
            setError(false);
            if (places.length == 0) {
                setError(true);
                return;
            }
            makeMarker(places);
        });


        // очищает маркеры и создает новые
        let makeMarker = function(places)
        {
            deleteMarkers(map);
            places.forEach((place) => {
                if (!place.geometry) {
                    console.log("Returned place contains no geometry");
                    return;
                }
                setMarker(map, place.geometry.location, place);
            });
        }

        // получение мета по координатам
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

        // устанавливает маркеры
        let setMarker = function (map, position, place)
        {

            let marker = new google.maps.Marker({
                map,
                draggable: true,
                position: position,
            });

            markers.push(marker);
            setBounds(map, marker, place);
            showInfo(map, marker);
            map.setZoom(18);
            setCoordinate(marker);
        }

        // центрирует карту относительно маркеров
        let setBounds = function (map, marker, place)
        {
            // For each place, get the icon, name and location.
            const bounds = new google.maps.LatLngBounds();

            if (place.geometry.viewport) {
                // Only geocodes have viewport.
                bounds.union(place.geometry.viewport);
            } else {
                bounds.extend(place.geometry.location);
            }

            center = bounds.getCenter();
            map.fitBounds(bounds);

            google.maps.event.addListener(marker, 'dragend', function (event) {
                setCoordinate(marker);
            });
        }

        // создает инфо маркера
        let showInfo = function (map, marker)
        {

            let info = $(mapElement).data('info');
            if(!info)
                return;

            const infowindow = new google.maps.InfoWindow({
                content: info,
            });

            infowindow.open(map, marker);
        }

        // очищает массив маркеров
        let deleteMarkers = function ()
        {
            clearMarkers();
            markers = [];
        }

        // удаляет все маркеры с карты
        let clearMarkers = function ()
        {
            for (let i = 0; i < markers.length; i++) {
                markers[i].setMap(null);
            }
        }

        // записывает координаты маркера в input-поля lat,lng
        let setCoordinate = function (marker)
        {
            lat.value = marker.getPosition().lat();
            lng.value = marker.getPosition().lng();
        }

        // показывает, прячет ошибки
        let setError = function(status)
        {
            (status) ? $(error).show() : $(error).hide();
        }



        //удаление маркера
        $('a#delete').click(function(e){
            e.preventDefault();
            console.log($(this).attr('href'));
            window.location.replace($(this).attr('href'))
            var data = {
                    title: "{{__('datatable.delete.title')}}",
                    message: "{{__('cms.delete_marker')}}",
                    confirmButtonText: "{{ __('datatable.delete.confirmButtonText') }}",
                    cancelButtonText: "{{ __('datatable.delete.cancelButtonText') }}",
                }

            // $.confirm(data, function (result) {
            //     if (result) {

            //        // window.location.href = $(this).attr('href');
            //         // console.log($(this).attr('href'));
            //         // $.sendAjax({url: $(this).attr('href'), type: "post"}, function (res) {
            //         //     console.log(res);
            //         //     // row.remove();
            //         //     // window.location.reload();
            //         // });
            //     }
            // })
        })
    </script>
@endpush
<?php
