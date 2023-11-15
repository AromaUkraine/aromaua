export default {
    getCountries({commit, dispatch}) {
        let url = route('get_countries');
        console.log(url);
        return new Promise((resolve, reject) => {
            axios
                .get(url)
                .then(response => {
                     let data  = response.data.data;
                     commit("set_countries", data)
                     resolve(response);
                })
                .catch(error => reject(error));
        });
    },
};
