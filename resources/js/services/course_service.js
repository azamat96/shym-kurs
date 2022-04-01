import {http} from './http_service';

function objectToFormData(data) {
    const formData = new FormData();
    Object.getOwnPropertyNames(data).forEach((key) => {
        formData.append(key, data[key])
    })
    return formData
}
export function createCourse(data) {
    return http().post('/course', objectToFormData(data))
}

export function loadCourses(params = {}) {
    return http().get('/course',{params})
}

export function deleteCourse(id) {
    return http().delete(`/course/${id}`);
}

export function updateCourse(id, data) {
    return http().post(`/course/${id}`, objectToFormData(data));
}
