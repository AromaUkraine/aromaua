export default {
    subscribe({ commit, dispatch }, data) {
        return new Promise((resolve, reject) => {
            axios
                .post(route("subscribe"), data)
                .then(response => {
                    resolve(response.data);
                })
                .catch(error => {
                    this.dispatch('setError', error);
                    reject(error);
                });
        });
    },
    setError({ commit, dispatch }, error) {
        const { data, status, statusText } = error.response;

        switch (status) {
            case 422:
                //error form validation
                commit("FORM_ERRORS", data.errors);
                break;
            case 401:
                // Unauthorized
                // dispatch("setLoading", false);
                // dispatch("clearData");
                 //dispatch("setMessage", { type: "error", code: status, timeOut: 10000 });
                break;
            default:
                 dispatch("setMessage", { type: "error", code: status, timeOut: 10000 });
        }
    },
    showError({ commit }, message){
        commit("FORM_ERRORS", message);
    },
    clearError({ commit }) {
         commit("FORM_ERRORS", []);
    },
    clearData(context) {
        // очищение всех данных после выхода из системы
        // context.commit("auth/REMOVE_SECURITY_DATA");
        // context.commit("user/CLEAR_PROFILE");
    }
};
