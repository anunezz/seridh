import {RouterView} from './RouterView.js';
import AdminIndex from '../components/views/admin/Index';
import PanelIndex from '../components/views/Admin/Panel/index';
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
    ],
}
