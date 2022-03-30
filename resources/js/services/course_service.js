import {http} from './http_service';

export function createCourse(data) {
    return http().post('/course', data)
}
