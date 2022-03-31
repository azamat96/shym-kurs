import Vue from 'vue';
import Vuex from 'vuex';
import * as courseService from "./services/course_service";

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        apiURL: 'http://127.0.0.1:8000/api',
        serverPath: 'http://localhost:8000',
        activeCourses: [],
        archiveCourses: [],
        teachers: []
    },
    mutations: {
        SET_ACTIVE_COURSES(state, payload) {
            state.activeCourses = payload
        },
        SET_ARCHIVE_COURSES(state, payload) {
            state.archiveCourses = payload
        },
        CREATE_COURSE(state, payload) {
            state.activeCourses.unshift(payload)
        },
        DELETE_COURSE(state, id) {
            state.activeCourses = state.activeCourses.filter(obj => {
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
        ARCHIVE_COURSE(state, response) {
            console.log(response, 'mutations')
            state.archiveCourses.unshift(response)
            state.activeCourses = state.activeCourses.filter(obj => {
                return obj.id != response.id;
            });
        }
    },
    actions: {
        getActiveCourses() {
            return courseService.loadCourses();
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
            return courseService.updateCourse(data.id, data.formData);
        },
    }
})
