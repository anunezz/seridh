import {RouterView} from './RouterView.js';
import store from '../store/index';
import {Message} from 'element-ui'

import PublicHome from '../components/views/public/Home';
import PublicFilter from '../components/views/public/Filters';
import PublicDetails from '../components/views/public/Details';

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
            path:'/publico/filtros/:json',
            component: PublicFilter,
            name: 'PublicFilter',

        },
        {
            path:'/publico/filtros/detalle/:json',
            component: PublicDetails,
            name: 'PublicDetails',
        }
    ],
}
