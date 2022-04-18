import {http} from "./http_service";
import jwt from 'jsonwebtoken'

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
}

export function isLoggedIn() {
    const token = localStorage.getItem('shym-kurs-token');
    return token != null;
}
