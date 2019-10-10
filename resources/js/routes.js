import Home from "./components/views/layouts/Home";
import AccessDenied from "./components/views/layouts/AccessDenied";
import Menu from "./components/views/layouts/Menu";
//import Admin from "./routes/Admin";
import Recommendations from "./routes/Recommendations";
//import Reports from "./routes/Reports";

export const routes = [
    {
        path: '/ingresar',
        component: AccessDenied,
        beforeEnter: (to, from, next) => {

            if (sessionStorage.getItem('SERIDH_token')) {
                next('/');
            } else {
                next();
            }
        }
    },
    {
        path: '/',
        component: Home,
        children: [
            { path: '', component: Menu },
            //{ ...Admin },
            { ...Recommendations },
            //{ ...Reports },
            // { ...Minister },
            // { ...Organism },
        ],
        beforeEnter: (to, from, next) => {
            if (sessionStorage.getItem("SERIDH_token")) {
                next();
            } else {
                next("/ingresar");
            }
        }
    },
    { path: '*', redirect: '/' }
];
