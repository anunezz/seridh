import {RouterView} from './RouterView.js';
import filesIndex from '../components/views/files/Index';

import imagesIndex from '../components/views/files/publicdoc/index';
import imagesEdit from '../components/views/files/publicdoc/Edit';
import filesDoc from '../components/views/files/doc';
import filesRecommendation from '../components/views/files/recommendationdoc';
import documentFiles from '../components/views/files/Indexdoc';


import store from '../store/index';
import {Message} from 'element-ui'

export default {
    path: '/archivos',
    component: RouterView,
    children: [
        {
            path: '',
            component: filesIndex,
            name: 'filesIndex',
        },

        {
            path: 'imagenes',
            component: imagesIndex,
            name: 'imagesIndex',
        },
        {
            path: 'edit/:id',
            component: imagesEdit,
            name: 'imagesEdit',
            props: true
        },
        {
            path: 'doc',
            component: filesDoc,
            name: 'filesDoc',
        },
        {
            path: 'asociados',
            component: filesRecommendation,
            name: 'filesRecommendation',
        },
        {
            path: 'seleccionar',
            component: documentFiles,
            name: 'documentFiles',
        },

    ],
}
