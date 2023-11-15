<template>
    <form >
        <div class="search__form">
            <v-input
                type="text"
                name="search_product"
                :inputClass="(isEmpty) ? 'has-content' : ''"
                :label="__t('web.search','...')"
                @keyup="typeSearch()"
            ></v-input>

            <div class="search__group">
<!--                <div class="search__checkbox checkbox">
                    <label class="checkbox__label">
                        <input class="checkbox__input" type="checkbox" @click="toggleChecked" :checked="checked">
                        <svg class="checkbox__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="12">
                            <path stroke-linecap="round" stroke-miterlimit="10" fill="none" d="M22.9 3.7l-15.2 16.6-6.6-7.1"></path>
                        </svg>
                        <span class="checkbox__text">{{__t('web.Search in all prices')}}</span>
                    </label>
                </div>-->
                <button class="search__submit btn" type="button"
                    @click="applySearch()"
                >{{ __t('web.to_find')}}</button>
            </div>
        </div>
    </form>
</template>

<script>
import {required} from "vuelidate/lib/validators";
import { createNamespacedHelpers } from "vuex";
const { mapMutations, mapGetters, mapActions } = createNamespacedHelpers("catalog");

export default {
    name: "VFormProductSearch",
    props: {
        category: {
            default() {
                return null;
            }
        }
    },
    data:()=>({
        checked:false,
        search_product: ''
    }),
    validations: {
        search_product: {},
    },
    computed: {
        ...mapGetters(["feature_values", "get_search_product"]),
        isEmpty(){

            let searchInput = $('input[name="search_product"]');
            return true;

        }
    },
    methods: {
        ...mapMutations(['set_search_product']),
        ...mapActions(["getProducts"]),
        typeSearch() {
            let searchInput = $('input[name="search_product"]');
            console.log(searchInput.val());
            return true;
        },
        applySearch() {
            let searchInput = $('input[name="search_product"]');
            this.set_search_product(searchInput.val());

            this.getProducts({ category_id: this.category.id, feature_values: this.feature_values, search: this.get_search_product });
            $('html, body').animate({
                scrollTop: $(".tabs").offset().top - 30
            }, 1000);
        },
        toggleChecked(){
            this.checked = !this.checked
        }
    }
}
</script>

<style scoped>

</style>
