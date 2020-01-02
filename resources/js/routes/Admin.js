import {RouterView} from './RouterView.js';
import AdminIndex from '../components/views/admin/Index';
import PanelIndex from '../components/views/Admin/Panel/index';
import CatalogsIndex from '../components/views/catalogs/Index';
import PublicIndex from '../components/views/public/admin/Public';
import UsersIndex from '../components/views/Admin/users/Index';
import UsersEdit from '../components/views/Admin/users/Edit';
//import UsersIndex from '../components/views/admin/users/Index';
//import UsersCreate from '../components/views/admin/users/Create';
//import UsersEdit from '../components/views/admin/users/Edit';
//import CatalogsIndex from '../components/views/admin/catalogs/Index';
//import OdsIndex from '../components/views/admin/recommendation/Index.vue';

import store from '../store/index';
import {Message} from 'element-ui'

export default {
    path: '/administracion',
    component: RouterView,
    children: [
        {
            path: '',
            component: AdminIndex,
            name: 'AdminIndex',
        },
        {
            path: 'panel',
            component: PanelIndex,
            name: 'PanelIndex',
        },
        {
            path: 'catalogos',
            component: CatalogsIndex,
            name: 'CatalogsIndex',
        },
        {
            path: 'adminPublico',
            component: PublicIndex,
            name: 'PublicIndex',
        },
        {
            path: 'usuarios',
            component: UsersIndex,
            name: 'UsersIndex',
        },
        {
            path: 'usuarios/editar/:id',
            component: UsersEdit,
            name: 'UsersEdit',
            props: true
        },

    ],
}
