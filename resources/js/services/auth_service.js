import {http} from "./http_service";
import jwt from 'jsonwebtoken'
import store from "../store";

export function login(user) {
    return http().post('/auth/login', user)
        .then(response => {
            if (response.status === 200) {
                setToken(response.data)
            }

            return response.data
        });
}

function setToken(user) {
    const token = jwt.sign({user: user}, 'shymkurslaravelspavueapp')
    localStorage.setItem('shym-kurs-token', token)
    store.dispatch('authenticate', user.user)
}

export function isLoggedIn() {
    const token = localStorage.getItem('shym-kurs-token');
    return token != null;
}

export function getAccessToken() {
    const token = localStorage.getItem('shym-kurs-token')
    if (!token) {
        return null;
    }
    const tokenData = jwt.decode(token)
    return tokenData.user.access_token;
}

export function logout() {
    http().get('/auth/logout')
    localStorage.removeItem('shym-kurs-token')
}

export function getProfile() {
    return http().get('/auth/profile');
}
