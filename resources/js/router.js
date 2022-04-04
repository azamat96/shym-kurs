import Vue from "vue";
import Router from 'vue-router';
import Welcome from "./views/Welcome";
import TeachersList from "./views/TeachersList";
import AddTeacher from "./views/AddTeacher";
import CoursesList from "./views/CoursesList";

Vue.use(Router);

const routes = [
    {
        path: '/',
        name: 'welcome',
        component: Welcome
    },
    {
        path: '/teacher/list',
        name: 'teachers_list',
        component: TeachersList
    },
    {
        path: '/teacher/create',
        name: 'create_teacher',
        component: AddTeacher,
        props: {mode: 'create'}
    },
    {
        path: '/teacher/show/:id',
        name: 'show_teacher',
        component: AddTeacher,
        props: {mode: 'show'}
    },
    {
        path: '/teacher/update/:id',
        name: 'update_teacher',
        component: AddTeacher,
        props: {mode: 'update'}
    },
    {
        path: '/course/list',
        name: 'courses_list',
        component: CoursesList
    },
]

const router = new Router({
    routes: routes,
    linkActiveClass: 'active'
});

export default router;
