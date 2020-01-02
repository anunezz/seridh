

const state = {
    loading:false,
    visits: {},
    advancedsearch:[],
    cats:[],
    colorsOds:[{ id:1,  color: '#e02b40'},
               { id:2,  color: '#d19f2a'},
               { id:3,  color: '#4c9f38'},
               { id:4,  color: '#c5192d'},
               { id:5,  color: '#ff3a21'},
               { id:6,  color: '#27bde2'},
               { id:7,  color: '#fcc312'},
               { id:8,  color: '#a21942'},
               { id:9,  color: '#fd6925'},
               { id:10, color: '#dd1367'},
               { id:11, color: '#fd9d24'},
               { id:12, color: '#bf8b2e'},
               { id:13, color: '#48773c'},
               { id:14, color: '#007dbb'},
               { id:15, color: '#40ae49'},
               { id:16, color: '#00558a'},
               { id:17, color: '#1a3668'}
                ],
    detail:[],
    colors: ["#FF5353","#DD597D","#CA00CA","#A41CC6","#7373FF","#29AFD6","#74BAAC","#E1E1A8","#DAAF85","#CF8D72","#F7DE00","#93BF96","#63E9FC","#AE70ED","#FF97CB","#5EAE9E","#25A0C5","#5B5BFF","#8D18AB","#B300B3","#D73E68","#FF2626","#99E0FF","#CEFFFD","#FF86C2"]
};


const mutations = {
    addVisits(state, data){
        state.visits = data;
    },
    addPrueba(state, data){
        state.prueba = data;
    },
    addCats(state, data){
        state.cats = data;
    },
    addAdvancedSearch(state, data){
        state.advancedsearch = data;
    },
    activeLoaing(state, data){
        state.loading = data;
    },
    addDetails(state, data){
        state.detail = data;
    },
    addColors(state, data){
        state.colors = data;
    },
    addcolorsOds(state, data){
        state.colorsOds = data;
    },

};

const actions = {
    addVisits({commit}, data) {
        commit('addVisits', data)
    },
    addCats({commit}, data) {
        commit('addCats', data)
    },
    addAdvancedSearch({commit}, data) {
        commit('addAdvancedSearch', data)
    },
    addPrueba({commit}, data) {
        commit('addPrueba', data)
    },
    activeLoaing({commit}, data) {
        commit('activeLoaing', data)
    },
    addDetails({commit}, data) {
        commit('addDetails', data)
    },
    addcolorsOds({commit}, data) {
        commit('addcolorsOds', data)
    },
    addColors({commit}, data) {
        commit('addColors', data)
    }

};

const getters = {
    errorsBulk: state => state.errorsBulk,
};

export default {
    namespaced: true,
    state,
    mutations,
    actions,
    getters
};
