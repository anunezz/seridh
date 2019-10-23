import Vue from 'vue'
import Vuex from 'vuex'
import loading from './modules/loading'
import user from './modules/user'
import bulkLoading from './modules/bulkLoadingErrors'

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        loading,
        user,
        bulkLoading,
    }
});
