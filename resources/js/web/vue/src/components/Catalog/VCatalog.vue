<template>
    <div>

        <div class="loader"></div>

        <div v-if="loader"></div>
        <div v-else>

            <v-product-tab-filter
                :path="icon_path"
                :products="products"
                :category="category"
            />

            <section class="catalog-price" id="print">
                <v-product-table
                    :category="category"
                    :products="products"
                    :path="icon_path"
                />
            </section>
        </div>
    </div>
</template>

<script>
import { createNamespacedHelpers } from "vuex";
const { mapGetters, mapActions, mapMutations} = createNamespacedHelpers("catalog");

export default {
    name: "VCatalog",
    props: {
        category: {
            default() {
                return null;
            }
        },
        icon_path: {
            default() {
                return null;
            }
        },
    },
    data: () => ({
        loader: true
    }),
    computed: {
        ...mapGetters(["products", "features", "flavoring", "get_search_product", "feature_values"])
    },
    methods: {
        ...mapMutations(["set_flavoring"]),
        ...mapActions(["getProducts", "getFeatures"]),

    },
    async mounted() {

        let loader = $('.loader');
        loader.show();

        await this.getFeatures({ category_id: this.category.id });
        await this.getProducts({ category_id: this.category.id });

        this.loader = false;
        loader.hide();
    }
};
</script>
