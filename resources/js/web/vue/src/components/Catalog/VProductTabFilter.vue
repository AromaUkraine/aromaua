<template>
    <section class="search">
<!--        Поиск по продукции-->
        <h1 class="search__title">{{ category.name }}</h1>

        <div class="tabs">
            <ul class="tabs__nav"></ul>
            <div class="search__container">
                <v-product-feature-filter
                    :category="category"
                />
                <v-form-product-search
                    :category="category"
                />
            </div>
        </div>
        <!-- END: catalog-tabs-->
    </section>
</template>

<script>
import { createNamespacedHelpers } from "vuex";
const { mapGetters, mapActions, mapMutations } = createNamespacedHelpers("catalog");

export default {
    name: "VProductFilter",
    props: {
        path: { default() { return null }},
        products: {
            default() {
                return null;
            }
        },
        category: {
            default() {
                return null;
            }
        }
    },
    data:()=>({
        tabs: [
            { 'name': 'Perfume','flavoring': 0 },
            { 'name': 'Food_flavors', 'flavoring': 1 }
        ],
        active: null,
    }),
    computed:{
        ...mapGetters(["flavoring"]),
    },
    methods: {
        ...mapMutations(['set_flavoring']),
        getActive(tab) {
            return tab.flavoring === this.flavoring
        },
        getImage(key) {
            return this.path + key;
        },
        tabClicked(selectedTab) {
            this.set_flavoring( selectedTab.flavoring );
        },
        counter(key){
            let qty = 0;
            for(var k = 0; k <= this.products.length; k++){

                if(typeof this.products[k] !== typeof undefined){
                    if(this.products[k].is_flavoring == key){
                        ++qty
                    }
                }
            }
            return qty;
        }
    }
}
</script>

<style scoped>

</style>
