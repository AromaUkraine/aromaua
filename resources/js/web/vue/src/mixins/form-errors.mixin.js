export default {
    computed: {
        errors() {
            return this.$store.getters["formErrors"];
        }
    },
    methods: {
        formError(field) {
            return this.errors.hasOwnProperty(field) ? this.errors[field][0] : null;
        },
        validationError($v, field) {
            return $v[field].$invalid && $v[field].$dirty;
        },
        submitError($v) {
            console.log($v);
        }
    },
    mounted() {
        this.$store.dispatch("clearError");
    }
};
