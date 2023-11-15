export default {
    getProducts({ commit, dispatch, getters }, data) {
        $('.loader').show();
        $('.search__submit').attr('disabled', 'disabled');
        return new Promise((resolve, reject) => {
            axios
                .post(route("products"), data)
                .then(({ data: { data } }) => {

                    data = Array.isArray(data)
                    ? data
                    : Object.keys(data).map(key => data[key]);

                    commit("set_total_pages", data[1]);

                    let page = data[2];
                    commit("set_page", page);
                    if (page == 1) {
                        commit("set_products", data[0]);
                    } else {
                        let list = getters.products;
                        list = list.concat(data[0]);
                        commit("set_products", list);
                    }

                    resolve(data);
                    $('.loader').hide();
                    $('.search__submit').attr('disabled', false);

                })
                .catch(error => reject(error));
        });
    },
    getFeatures({ commit, dispatch }, data) {
        return new Promise((resolve, reject) => {
            axios
                .post(route("features"), data)
                .then(({ data: { data } }) => {

                    data = Array.isArray(data)
                    ? data
                    : Object.keys(data).map(key => data[key]);

                    commit("set_features", data);

                    resolve(data);
                })
                .catch(error => reject(error));
        });
    }
};
