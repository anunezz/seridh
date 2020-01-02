import {RouterView} from './RouterView.js';
import store from '../store/index';
import {Message} from 'element-ui'

import DocumentIndex from '../components/views/files/index';


export default {
    path: '/archivos',
    component: RouterView,
    children: [
        {
            path: '',
            component: DocumentIndex,
            name: 'DocumentIndex',
        },
    ],
}
