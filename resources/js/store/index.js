import Vue from 'vue'
import Vuex from 'vuex'
import loading from './modules/loading'
import user from './modules/user'
import bulkLoading from './modules/bulkLoadingErrors'
import publico from './modules/publico'
import createPersistedState from "vuex-persistedstate";
import Carousel3d from 'vue-carousel-3d';


Vue.use(Vuex);

export default new Vuex.Store({
    plugins:[
        createPersistedState({
            key: 'publico',
            paths:['publico']
        }),
        createPersistedState({
            key: 'bulkLoading',
            paths:['bulkLoading']
        }),

    ],
    modules: {
        loading,
        user,
        bulkLoading,
        publico,
        Carousel3d
    }
});
