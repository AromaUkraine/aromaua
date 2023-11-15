<template>
    <div class="search__filter" >
        <div class="filter">
            <div
                v-for="item in features"
                class="filter__col js-filter-item-parent"
                :key="item.id"
                :data-index="item.id"
            >
                <div class="filter__select filter-select">
                    <button
                        class="filter-select__btn-toggle js-filter-btn-toggle"
                        @click="setActiveFeatureGroup(item)"
                        type="button"
                        :class="{'open' : active_feature === item.id}"
                    >
                        <span></span> {{ item.name }}
                    </button>

                    <div class="filter-select__dropdown " :class="{'show-feature-list' : active_feature === item.id}">
                        <div class="filter-select__wrap">
                            <ul class="filter-select__list">

                                <li class="filter-select__item" v-for="value in item.values">
                                    <div class="checkbox">
                                        <label class="checkbox__label">
                                            <input class="checkbox__input" type="checkbox" :data-index="value.id" :name="'feature_'+item.id+'[]'" :value="value.id">
                                            <svg class="checkbox__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="12">
                                                <path stroke-linecap="round" stroke-miterlimit="10" fill="none" d="M22.9 3.7l-15.2 16.6-6.6-7.1"></path>
                                            </svg>
                                            <span class="checkbox__text">{{ value.name }}</span>
                                        </label>
                                    </div>
                                </li>

                            </ul>
                            <div class="filter-select__footer">
                                <button
                                    class="filter-select__btn btn"
                                    type="button"
                                    @click="applyFilterFeature(item.id)"
                                >{{__t('web.apply')}}</button>
                            </div>
                        </div>
                    </div>
                </div>
                <ul class="filter__tags tags">
                    <li class="tag show" v-for="selected_value in feature_values[item.id]">
                        <span class="tag__text">{{ selected_value.text }}</span>
                        <button class="tag__close" type="button"
                                :data-feature_id="item.id"
                                :data-index="selected_value.id"
                                @click="removeFilterValue(item.id, selected_value.id)"
                        >×</button>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
    import { createNamespacedHelpers } from "vuex";
    const { mapGetters, mapActions, mapMutations } = createNamespacedHelpers("catalog");

export default {
    name: "VProductFeatureFilter",
    props: {
        category: {
            default() {
                return null;
            }
        }
    },
    data:()=>({
        active_feature: null
    }),
    methods: {
        ...mapMutations(["set_feature_values"]),
        ...mapActions(["getProducts"]),
        setActiveFeatureGroup(item) {
            if(this.active_feature === item.id){
                this.active_feature = null
            }else{
                this.active_feature = item.id
            }
        },
        resetData(){
            this.active_feature = null
        },
        applyFilterFeature(featureId) {

            this.active_feature = null;
            let current_values = this.feature_values;

            let that = $(".js-filter-item-parent[data-index='"+featureId+"']");
            let checkboxes = that.find('input.checkbox__input');
            let values = [];
            checkboxes.each(function () {
                if ($(this).is(':checked')) {
                    values.push({
                        'id': $(this).data('index'),
                        'text': $(this).parent().find('.checkbox__text').html()
                    });
                }
            });

            current_values[featureId] = values;

            this.set_feature_values(current_values);

            this.getProducts({ category_id: this.category.id, feature_values: this.feature_values, search: this.get_search_product });

            $('html, body').animate({
                scrollTop: $(".tabs").offset().top - 30
            }, 1000);
            
            return true;
        },
        removeFilterValue(featureId, valueId) {

            let checkbox = $('.checkbox__input[data-index="'+valueId+'"]');
            checkbox.prop('checked', false);
            this.applyFilterFeature(featureId);
            this.active_feature = 0;
            return true;
        }
    },
    computed:{
        ...mapGetters(["features", "feature_values", "get_search_product"]),
    },
    mounted(){
        let self = this;
        eventBus.$on('changeTabProductFilter', function (){
            self.resetData();
        });
        this.set_feature_values([]);
    }
}
</script>

<style scoped>
    .show-feature-list{
        display: block !important;
    }
</style>
