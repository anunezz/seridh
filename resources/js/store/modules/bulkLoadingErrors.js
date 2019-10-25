const state = {
    errorsBulk: [],
};

const mutations = {
    addRows(state, data){
        state.errorsBulk = data;
    },
    deleteRow(state,data){
        state.errorsBulk.splice(data, 1);
    }
};

const actions = {
    addRows({commit}, data) {
        commit('addRows', data)
    },
    deleteRow({commit},data){
        commit('deleteRow',data)
    }
};

const getters = {
    errorsBulk: state => state.errorsBulk,
    editRow: (state) => (index) => {
        return state.errorsBulk[index]
    }
};

export default {
    namespaced: true,
    state,
    mutations,
    actions,
    getters
};
