import Vue from "vue";
import Router from 'vue-router';
import Welcome from "./views/Welcome";
import Home from "./views/Home";
import TeachersList from "./views/TeachersList";
import AddTeacher from "./views/AddTeacher";
import CoursesList from "./views/CoursesList";
import * as auth from "./services/auth_service";

Vue.use(Router);

const routes = [
    {
        path: '/home',
        name: 'home',
        component: Home,
        children: [
            {
                path: '',
                name: 'welcome',
                component: () => import('./views/Welcome')
            },
            {
                path: 'teacher/list',
                name: 'teachers_list',
                component: TeachersList
            },
            {
                path: 'teacher/create',
                name: 'create_teacher',
                component: AddTeacher,
                props: {mode: 'create'}
            },
            {
                path: 'teacher/show/:id',
                name: 'show_teacher',
                component: AddTeacher,
                props: {mode: 'show'}
            },
            {
                path: 'teacher/update/:id',
                name: 'update_teacher',
                component: AddTeacher,
                props: {mode: 'update'}
            },
            {
                path: 'course/list',
                name: 'courses_list',
                component: CoursesList
            },
        ],
        beforeEnter(to, from, next) {
            if (!auth.isLoggedIn()) {
                next('/login')
            } else {
                next()
            }
        }
    },
    {
        path: '/login',
        name: 'login',
        component: () => import('./views/Login')
    }
]

const router = new Router({
    mode: 'history',
    routes: routes,
    linkActiveClass: 'active'
});

export default router;
