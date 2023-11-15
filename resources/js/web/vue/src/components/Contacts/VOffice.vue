<template>
    <div class="location" v-if="office">
        <div v-if="withMap()" class="contacts__map-location">
            <div class="location__content">
                <h2 class="location__title">{{ office.name }}</h2>
                <v-office-item :office="office"></v-office-item>
            </div>
            <div class="location__map-canvas">
                <v-google-map
                    v-if="office.map"
                    :markers="office.map.markers"
                    :infoWindow="office.map.infoWindow"
                ></v-google-map>
            </div>
        </div>
        <div v-else>
            <h2 class="location__title">{{ office.name }}</h2>
            <v-office-item :office="office"></v-office-item>
        </div>
    </div>
</template>

<script>
export default {
    name: "VOffice",
    props: {
        office: {
            default() {
                return null;
            }
        }
    },
    methods: {
        getImage(key) {
            return this.office.image_path + key;
        },
        isPhone(type) {
            return type === "phone";
        },
        withMap() {
            return !!this.office.map;
        }
    }
};
</script>

<style scoped></style>
