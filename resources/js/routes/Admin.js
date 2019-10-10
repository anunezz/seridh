import {RouterView} from './RouterView.js';
import Index from '../components/views/admin/Index';
import UsersIndex from '../components/views/admin/users/Index';
import UsersCreate from '../components/views/admin/users/Create';
import UsersEdit from '../components/views/admin/users/Edit';
import CatalogsIndex from '../components/views/admin/catalogs/Index';
import OdsIndex from '../components/views/admin/recommendation/Index.vue';

import store from '../store/index';
import {Message} from 'element-ui'

export default {
    path: '/administracion',
    component: RouterView,
    beforeEnter: (to, from, next) => {
        if (store.state.user.profile !== 1) {
            next('/');
            Message({
                type: "error",
                message: "No cuenta con los privilegios para acceder a este modulo."
            });
        }
        next();
    },
    children: [
        {
            path: '',
            component: Index,
            name: 'AdminIndex',
        },
        {
            path: 'usuarios',
            component: UsersIndex,
            name: 'UsersIndex',
        },
        {
            path: 'usuarios/nuevo',
            component: UsersCreate,
            name: 'UsersCreate',
        },
        {
            path: 'usuarios/editar/:id',
            component: UsersEdit,
            name: 'UsersEdit',
            props: true
        },
        {
            path: 'catalogos',
            component: CatalogsIndex,
            name: 'CatalogsIndex',
        },
        {
            path:'ods',
            component: OdsIndex,
            name:'OdsIndex',
        }
    ],
}
