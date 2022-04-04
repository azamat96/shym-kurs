import store from "../store";
import axios from 'axios';

export function http() {
    return axios.create({
        baseURL: store.state.apiURL,
    });
}

export function objectToFormData(data) {
    const formData = new FormData();
    Object.getOwnPropertyNames(data).forEach((key) => {
        formData.append(key, data[key])
    })
    return formData
}
