<template>
    <div>
        <v-skeleton-office-with-map
            :loading="!centralOffice"
        ></v-skeleton-office-with-map>
        <v-office v-if="centralOffice" :office="centralOffice"></v-office>
        <div class="js-tabs contact__branches">
            <v-country-list @selected="setSelected"></v-country-list>
            <div class="js-tabs__content">
                <!-- BEGIN: tabs-item-->
                <v-branches-country
                    :selected="getSelected"
                ></v-branches-country>
            </div>
        </div>
    </div>
</template>

<script>
import { createNamespacedHelpers } from "vuex";
const { mapGetters, mapActions } = createNamespacedHelpers("contacts");

export default {
    name: "VContacts",
    data: () => ({
        selected: null
    }),
    computed: {
        ...mapGetters(["centralOffice"]),
        getSelected() {
            return this.selected;
        }
    },
    methods: {
        ...mapActions(["getCentralOffice"]),
        setSelected(id) {
            this.selected = id;
        }
    },
    async created() {

        await this.getCentralOffice();
    }
};
</script>

<style scoped></style>
