import Vue from 'vue';
import Vuex from 'vuex';
import * as courseService from "./services/course_service";
import * as teacherService from "./services/teacher_service";

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        apiURL: window.location.origin+'/api',
        serverPath: 'http://localhost:8000',
        langs: [
            {
                display_name: 'қазақ тілінде',
                name: 'kk'
            },
            {
                display_name: 'орыс тілінде',
                name: 'ru'
            },
            {
                display_name: 'қазақ/орыс тілдерінде',
                name: 'kk_ru'
            },
        ],
        positions: [
            {
                name: 'teacher',
                display_name: 'Мұғалім'
            },
            {
                name: 'head',
                display_name: 'Завуч'
            },
        ],
        activeCourses: [],
        archiveCourses: [],
        teachers: [],
        currentTeacher: {},
        schools: [],
        subjects: [],
    },
    mutations: {
        SET_ACTIVE_COURSES(state, payload) {
            state.activeCourses = payload
        },
        SET_ARCHIVE_COURSES(state, payload) {
            state.archiveCourses = payload
        },
        SET_SCHOOLS(state, payload) {
            state.schools = payload
        },
        SET_SUBJECTS(state, payload) {
            state.subjects = payload
        },
        CREATE_COURSE(state, payload) {
            state.activeCourses.unshift(payload)
        },
        DELETE_ACTIVE_COURSE(state, id) {
            state.activeCourses = state.activeCourses.filter(obj => {
                return obj.id != id;
            });
        },
        DELETE_ARCHIVE_COURSE(state, id) {
            state.archiveCourses = state.archiveCourses.filter(obj => {
                return obj.id != id;
            });
        },
        UPDATE_ACTIVE_COURSE(state, response) {
            state.activeCourses.map(course => {
                if (course.id == response.id) {
                    for (let key in response) {
                        course[key] = response[key]
                    }
                }
            })
        },
        UPDATE_ARCHIVE_COURSE(state, response) {
            state.archiveCourses.map(course => {
                if (course.id == response.id) {
                    for (let key in response) {
                        course[key] = response[key]
                    }
                }
            })
        },
        ARCHIVE_COURSE(state, response) {
            state.archiveCourses.unshift(response)
            state.activeCourses = state.activeCourses.filter(obj => {
                return obj.id != response.id;
            });
        },
        ACTIVATE_COURSE(state, response) {
            state.activeCourses.unshift(response)
            state.archiveCourses = state.archiveCourses.filter(obj => {
                return obj.id != response.id;
            });
        },
        SET_CURRENT_TEACHER(state, payload) {
            state.currentTeacher = payload
        },
        ATTACH_COURSE_TO_CURRENT_TEACHER(state, payload) {
            if (state.currentTeacher.hasOwnProperty('courses')) {
                state.currentTeacher.courses.unshift(payload)
            } else {
                state.currentTeacher.courses = payload
            }
        },
        DETACH_COURSE_FROM_CURRENT_TEACHER(state, id) {
            state.currentTeacher.courses = state.currentTeacher.courses.filter(course => {
                return course.pivot.pivot_id != id;
            });
        },
    },
    actions: {
        async getActiveCourses({commit}) {
            const response = await courseService.loadCourses();
            commit('SET_ACTIVE_COURSES', response.data)
        },
        getArchiveCourses() {
            return courseService.loadCourses({is_active: 0});
        },
        createCourse({}, data) {
            return courseService.createCourse(data);
        },
        deleteCourse({}, id) {
            return courseService.deleteCourse(id);
        },
        updateCourse({}, data) {
            return courseService.updateCourse(data.id, data.options);
        },
        getTeacher({}, id) {
            return teacherService.getTeacher(id)
        },
        async loadAllSchools({commit}) {
            const response = await teacherService.loadSchools();
            commit('SET_SCHOOLS', response.data)
        },
        async loadAllSubjects({commit}) {
            const response = await teacherService.loadSubjects();
            commit('SET_SUBJECTS', response.data)
        },
        deleteTeacher({}, id) {
            return teacherService.deleteTeacher(id);
        },
    }
})
