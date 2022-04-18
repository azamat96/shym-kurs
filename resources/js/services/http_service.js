import store from "../store";
import axios from 'axios';
import * as auth from './auth_service'

export function http() {
    return axios.create({
        baseURL: store.state.apiURL,
        headers: {
            Authorization: "Bearer "+auth.getAccessToken()
        }
    });
}

export function objectToFormData(data) {
    const formData = new FormData();
    Object.getOwnPropertyNames(data).forEach((key) => {
        formData.append(key, data[key])
    })
    return formData
}
