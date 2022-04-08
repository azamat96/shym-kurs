import Vue from "vue";
import App from './App.vue';
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap';
import router from './router'
import store from "./store";
import ToastMessagePlugin from "./plugins/toast";

Vue.use(ToastMessagePlugin)

Vue.filter('getYear', function(value) {
    if (value) {
        let date = new Date(value);
        return date.getFullYear();
    }
})

new Vue({
    el: '#app',
    router,
    store,
    render: h => h(App)
});
