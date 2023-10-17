import { createRouter, createWebHistory } from "vue-router";
import {authRequest} from "@/api.js";

const router = createRouter({
    //history: createWebHistory(import.meta.env.BASE_URL),
    history: createWebHistory(),
    routes: [
        {
            path: "/registration",
            name: "Registration",
            component: () => import("@/views/Registration.vue"),
            meta: {
                layout : "mainLayout"
            }
        },
        {
            path: "/",
            name: "Login",
            component: () => import("@/views/Login.vue"),
            meta: {
                layout : "mainLayout"
            }
        },
        {
            path: "/profile",
            name: "Profile",
            component: () => import("@/views/Profile.vue"),
            meta: {
                layout : "mainLayout"
            }
        },


        //page not found
        {
            path: "/404",
            name: "404",
            component: () => import("@/views/Page404.vue"),
            meta: {
                layout : "mainLayout"
            }
        },
        {
            path: '/:pathMatch(.*)*',
            component: () => import("@/views/Page404.vue"),
            meta: {
                layout : "mainLayout"
            }
        },


    ],
});



// protect router
router.beforeEach( async (to, from, next) => {
    if ( to.fullPath.match(/admin/g) ){
        if ( localStorage.getItem("token") !== null ) {

            let response = await authRequest('/api/authorization', 'get');


            if (response.data.permission === 'admin') {
                next()
            } else {
                next({name: 'Login'})
            }


            if (to.name === 'Profile') {
                console.log('123')
                if (response.data.permission === 'user' || response.data.permission === 'admin') {
                    next()
                } else {
                    next({name: 'Login'})
                }
            }
        }
        else {
            next({name: 'Login'})
        }
    }
    else {
        next();
    }
})

export default router;
