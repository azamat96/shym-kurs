import {http} from './http_service';

export function createCourse(data) {
    return http().post('/course', data)
}

export function loadCourses(params = {}) {
    return http().get('/course',{params})
}

export function deleteCourse(id) {
    return http().delete(`/course/${id}`);
}

export function updateCourse(id, data) {
    return http().post(`/course/${id}`, data)
}
