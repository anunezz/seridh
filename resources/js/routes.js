import Home from "./components/views/layouts/Home";

import PublicMenu from "./components/views/layouts/Public";
import PublicHome from "./components/views/public/Home";
import AccessDenied from "./components/views/layouts/AccessDenied";
import Menu from "./components/views/layouts/Menu";
import Admin from "./routes/Admin";
import Recommendations from "./routes/Recommendations";
import Public from "./routes/Public";

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
    // {
    //     path: '/publico',
    //     component: Public,
    //     children: [
    //         { path: '', component: PublicHome }
    //     ],
    //     beforeEnter: (to, from, next) => {
    //         next();
    //     }
    // },

    {
        path: '/publico',
        component: PublicMenu,
        children: [
            //  {path: '', component: PublicHome},
             { ...Public}
        ],
        beforeEnter: (to, from, next) => {
            next();
        }
    },


    {
        path: '/',
        component: Home,
        children: [
            { path: '', component: Menu },

            { ...Admin },
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
