import {RouterView} from './RouterView.js';
import store from '../store/index';
import {Message} from 'element-ui'

import CatalogsIndex from '../components/views/catalogs/Index';



export default {
    path: '/catalogs',
    component: RouterView,
    children: [
        {
            path: '',
            component: CatalogsIndex,
            name: 'CatalogsIndex',
        }
    ],
}
