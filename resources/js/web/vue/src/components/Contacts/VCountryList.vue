<template>
    <ul class="js-tabs__nav contacts__countries">
        <li
            class="js-tabs__nav-item contacts__country"
            v-for="country in countries"
            :key="country.id"
            @click="clickHandler(country.id)"
            :class="selected === country.id ? 'js-tabs__nav-item--active' : ''"
        >
            {{ country.name }}
        </li>
    </ul>
</template>

<script>
import { createNamespacedHelpers } from "vuex";
const { mapGetters, mapActions } = createNamespacedHelpers("countries");

export default {
    name: "VCountryList",
    data: () => ({
        selected: null
    }),
    computed: {
        ...mapGetters(["countries"])
    },
    methods: {
        ...mapActions(["getCountries"]),
        clickHandler(id) {
            this.selected = id;
            this.$emit("selected", id);
        }
    },
    async created() {
        await this.getCountries();
    }
};
</script>

<style scoped></style>
