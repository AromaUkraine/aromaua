export default {
    getCentralOffice({commit, dispatch}) {
        let url = route('get_central_office');

        return new Promise((resolve, reject) => {
            axios
                .get(url)
                .then(response => {
                    let contact  = response.data.data;
                    commit("set_central_office",contact)
                    resolve(response);
                })
                .catch(error => reject(error));
        });
    },
    getOffices({commit, dispatch}, data) {
        let url = route('get_offices_with_country');
        return new Promise((resolve, reject) => {
            axios
                .get(url)
                .then(response => {
                     let offices  = response.data.data;
                     commit("set_offices", offices)
                     resolve(response);
                })
                .catch(error => reject(error));
        });
    }
};
