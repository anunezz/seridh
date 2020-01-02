import {RouterView} from './RouterView.js';

import EntiIndex from '../components/views/catalogs/entity/index';
import AutoIndex from '../components/views/catalogs/authority/index';
import OrderIndex from '../components/views/catalogs/government order/index';
import PowerIndex from '../components/views/catalogs/government power/index';
import OdsIndex from '../components/views/catalogs/ods/index';
import PopuIndex from '../components/views/catalogs/population/index';
import RepoIndex from '../components/views/catalogs/reported action/index';
import RequesIndex from '../components/views/catalogs/requested action/index';


import store from '../store/index';
import {Message} from 'element-ui'

export default {
    path: '/catalogos',
    component: RouterView,
    children: [
        {
            path: '/entidad',
            component: EntiIndex,
            name: 'EntiIndex',
        },
        {
            path: '/orden',
            component: OrderIndex,
            name: 'OrderIndex',
        },
        {
            path: '/autoridad',
            component: AutoIndex,
            name: 'AutoIndex',
        },
        {
            path: '/poder',
            component: PowerIndex,
            name: 'PowerIndex',
        },
        {
            path: '/ods',
            component: OdsIndex,
            name: 'OdsIndex',
        },
        {
            path: '/poblacion',
            component: PopuIndex,
            name: 'PopuIndex',
        },
        {
            path: '/reportada',
            component: RepoIndex,
            name: 'RepoIndex',
        },
        {
            path: '/solicitada',
            component: RequesIndex,
            name: 'RequesIndex',
        },

    ],
}
