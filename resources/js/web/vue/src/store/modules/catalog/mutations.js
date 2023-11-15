export default {
    set_products: (state, data) =>{
        state.products = data;
    },
    set_features: (state, data) =>{
        state.features = data;
    },
    set_feature_values: (state, data) =>{
        state.feature_values = data;
    },
    set_flavoring: (state, status) => {
        state.flavoring = status;
    },
    set_search_product: (state, search) => {
        state.search_product = search;
    },
    set_page: (state, page) => {
        state.page = page;
    },
    set_total_pages: (state, total_pages) => {
        state.total_pages = total_pages;
    },
    transaction: (data) => {
        return Array.isArray(data)
            ? data
            : Object.keys(data).map(key => data[key]);
    }
};
