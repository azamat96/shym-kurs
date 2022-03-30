import {http} from './http_service';

export function createCourse(data) {
    return http().post('/course', data)
}

export function loadCourses() {
    return http().get('/course')
}

export function deleteCourse(id) {
    return http().delete(`/course/${id}`);
}

export function updateCourse(id, data) {
    return http().post(`/course/${id}`, data)
}
