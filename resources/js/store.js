import Vue from 'vue';
import Vuex from 'vuex';
import * as courseService from "./services/course_service";
import * as teacherService from "./services/teacher_service";

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        apiURL: 'http://127.0.0.1:8000/api',
        serverPath: 'http://localhost:8000',
        activeCourses: [],
        archiveCourses: [],
        teachers: [],
        currentTeacher: {}
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
            return courseService.updateCourse(data.id, data.options);
        },
        getTeacher({}, id) {
            return teacherService.getTeacher(id)
        },
    }
})
