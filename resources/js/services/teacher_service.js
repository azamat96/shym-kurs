import {http, objectToFormData} from './http_service';

export function loadSchools(params = {}) {
    return http().get('/schools',{params})
}

export function loadSubjects(params = {}) {
    return http().get('/subjects',{params})
}

export function createTeacher(data) {
    return http().post('/teachers', objectToFormData(data))
}

export function getTeacher(id) {
    return http().get(`/teachers/${id}`)
}

export function updateTeacher(id, data) {
    return http().post(`/teachers/${id}`, objectToFormData(data))
}
