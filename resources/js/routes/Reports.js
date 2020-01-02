import {RouterView} from './RouterView.js';
import Index from '../components/views/reports/Index';
import publicIndex from '../components/views/reports/public/index';
import recommendationIndex from '../components/views/reports/recommendation/index'
//import DaysReport from '../components/views/reports/DaysReport';
//import AverageReport from '../components/views/reports/AverageReport';
//import SendReport from '../components/views/reports/SendReport';
import store from "../store";
import {Message} from "element-ui";

export default {
    path: '/reportes',
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
            name: 'ReportsIndex',
        },
        {
            path: 'reportes',
            component: publicIndex,
            name: 'publicIndex',
        },
        {
            path: 'recomendaciones',
            component: recommendationIndex,
            name: 'recommendationIndex',
        },
 //       {
 //           path: 'dias',
 //           component: DaysReport,
 //           name: 'DaysReport',
 //       },
 //       {
 //           path: 'promedio',
 //           component: AverageReport,
 //           name: 'AverageReport',
 //       },
 //       {
 //           path: 'enviados',
 //           component: SendReport,
 //           name: 'SendReport',
 //       }
    ],
}
