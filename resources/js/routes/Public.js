import {RouterView} from './RouterView.js';
import store from '../store/index';
import {Message} from 'element-ui'

import PublicHome from '../components/views/public/Home';
import PublicFilter from '../components/views/public/Filters';
import PublicDetails from '../components/views/public/Details';
import PublicDocuments from '../components/views/public/Documents';

export default {
    path: '/publico',
    component: RouterView,
    children: [
        {
            path: '',
            component: PublicHome,
            name: 'PublicHome',
        },
        {
            path:'/publico/filtros',
            component: PublicFilter,
            name: 'PublicFilter',

        },
        {
            path:'/publico/filtros/detalle',
            component: PublicDetails,
            name: 'PublicDetails',
        },
        {
            path:'/publico/documentos',
            component: PublicDocuments,
            name: 'PublicDocuments'
        }
    ],
}
