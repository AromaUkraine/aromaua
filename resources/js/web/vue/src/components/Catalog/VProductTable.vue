<template>
    <div>
        <table class="price-table" id="printMe">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>{{ __t("web.product_name") }}</th>
                    <th>{{ __t("web.product_code") }}</th>
                    <th v-for="(item, index) in category.data.columns" :key="index" >
                        {{ item.name }}
                    </th>
                    <th v-if="getTypeAroma(category)">
                        {{ __t("web.product_flavor_type") }}
                    </th>
                    <th>
                        <a href="#" :title="__t('web.download')" @click="print">
                            <svg
                                class="svg-sprite price-table__icon"
                                width="20px"
                                height="16px"
                            >
                                <use :xlink:href="getImage('#print')"></use>
                            </svg>
                        </a>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="(product, key) in products"
                    :key="key"
                    @click.prevent="redirectHandler(product, category)"
                >
                    <td data-th="No.">{{ ++key }}</td>
                    <td :data-th="__t('web.product_name')">{{ product.name }}</td>
                    <td :data-th="__t('web.product_code')" v-html="product.product_code"></td>
                    <td v-for="(item, index) in category.data.columns" :key="index" :data-th="item.name">
                        <dl
                            v-for="(data, index) in setData(item, product)"
                            :key="index"
                        >
                            <span v-if="data">
                                <dt v-if="data.price">
                                    {{ data.price }} {{ data.currency }}
                                </dt>
                                <dt v-if="data.text">
                                    {{ data.text }}
                                </dt>
                                <dt v-if="data.series">
                                    {{ data.series }}
                                </dt>
                                <dd v-if="data.documents" class="text-capitalize">
                                    {{ data.documents }}
                                </dd>
                            </span>
                        </dl>
                    </td>

                    <td v-if="getTypeAroma(category)" :data-th="__t('web.product_flavor_type')">{{ product.type_aroma }}</td>
                    <td>&nbsp; </td>
                </tr>
            </tbody>
        </table>
        <div class="footer_show_more">
            <button type="submit" class="btn"
                    v-if="page < total_pages"
                    @click="showMore()"
            >{{ __t('web.show_more') }}</button>
        </div>
    </div>
</template>
<script>
import { createNamespacedHelpers } from "vuex";
const { mapGetters, mapActions, mapMutations } = createNamespacedHelpers("catalog");
import { htmlToPaper } from 'vue-html-to-paper'
export default {
    name: "ProductTable",
    props: {
        path: {
            default() {
                return null;
            }
        },
        category: {
            default() {
                return null;
            }
        },
        products: {
            default() {
                return null;
            }
        }
    },
    computed: {
        ...mapGetters(["page", "total_pages", "feature_values", "get_search_product"])
    },
    methods: {
        ...mapActions(["getProducts", "getFeatures"]),
        getTypeAroma(category){
            return category.data.type_aroma != 0;
        },
        getImage(key) {
            return this.path + key;
        },
        redirectHandler(product, category) {
            location.href = category.slug + '/' + product.slug;
        },
        setData(item, product) {
            return product.columns.map(column => {
                if (item.serial_number === column.column_number) {
                    return {
                        price: column.price,
                        text: column.text,
                        currency: column.currency,
                        series: column.series,
                        documents: column.documents,
                    };
                }
            });
        },
        async print () {
            await this.$htmlToPaper('print');
        },
        showMore() {
            let page = this.page + 1;
            this.getProducts({ category_id: this.category.id, feature_values: this.feature_values, search: this.get_search_product, page: page });
        }
    },
    mounted(){

    }
};
</script>

<style scoped>
    .footer_show_more{
        text-align: center;
        padding: 25px;
    }
</style>
