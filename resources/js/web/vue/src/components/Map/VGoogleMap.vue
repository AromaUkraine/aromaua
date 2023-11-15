<template>
    <div :apiKey="apiKey" id="initMap">
        <gmap-map
            ref="googleMap"
            :center="center"
            :zoom="zoom"
            style="width: 100%; height: 300px"
        >
            <gmap-marker
                v-for="(item, key) in coordinates"
                :key="key"
                :position="getPosition(item)"
                :clickable="true"
                @click="toggleInfo(item, key)"
            />
        </gmap-map>
    </div>
</template>

<script>
import Vue from "vue";
import * as VueGoogleMaps from "vue2-google-maps";

Vue.use(VueGoogleMaps,{
    load: {
        key: document.head.querySelector('meta[name="google-map-api-key"]').content,
        libraries: "places"
    },
    installComponents: true
});
export default {
    name: "google-map",
    props: {
        markers: {
            default() {
                return [];
            }
        },
        apiKey: {
            default() {
                return '';
            }
        }
    },
    data: () => ({
        zoom: 18,
        dataMarkers: [],
        loadMap : false
    }),
    computed: {
        center() {
            let { lat, lng } = this.markers[0];
            return { lat: parseFloat(lat), lng: parseFloat(lng) };
        },
        coordinates() {
            let arr = [];
            let { lat, lng } = this.markers[0];
            let t = { lat: parseFloat(lat), lng: parseFloat(lng) };
            arr.push(t);
            return arr;
        }
    },
    methods: {
        getPosition: function(marker) {
            return {
                lat: parseFloat(marker.lat),
                lng: parseFloat(marker.lng)
            };
        }
    },
    mounted() {
        console.log('map')
    }
};
</script>

<style scoped></style>
