<template>

    <div class="js-tabs__content-item js-tabs__content-item--active">
        <v-office
            v-for="office in officesMain"
            :key="office.id"
            :office="office"
        ></v-office>
        <div class="contacts__group-locations">
            <v-office
                v-for="office in officeAdditional"
                :key="office.id"
                :office="office"
            ></v-office>
        </div>
    </div>
</template>

<script>
import { createNamespacedHelpers } from "vuex";
const { mapGetters, mapActions } = createNamespacedHelpers("contacts");
export default {
    name: "VBranchesCountry",
    props: {
        selected: {
            default() {
                return null;
            }
        }
    },
    computed: {
        ...mapGetters(["officeWithMapByCountry", "officeWithoutMapByCountry"]),
        officesMain() {
            return this.officeWithMapByCountry(this.selected);
        },
        officeAdditional() {
            return this.officeWithoutMapByCountry(this.selected);
        }
    },
    methods: {
        ...mapActions(["getOffices"])
    },
    mounted() {
        this.getOffices();
    }
};
</script>
