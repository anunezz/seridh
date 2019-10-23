const state = {
    errorsBulk: [],
};

const mutations = {
    increment:(state, data)=>{
        state.errorsBulk = data;
    },
    decrement(state){
        state.errorsBulk--
    }
};

const actions = {
    increment({commit}, data) {
        commit('increment', data)
    }
};

const getters = {
    errorsBulk: state => state.errorsBulk
};

export default {
    namespaced: true,
    state,
    mutations,
    actions,
    getters
};
