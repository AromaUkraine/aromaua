export default {
    computed: {
        loading() {
            return 0//this.$store.getters["loading"];
        },
        disabled() {
            return this.loading;
        }
    }
};
