import {EventBus} from "./eventbus";

export default {
    // called by Vue.use(FirstPlugin)
    install(Vue) {
        Vue.prototype.$toast = {
            send(message, type, options) {
                EventBus.$emit("toast-message", {
                    message: message,
                    type: type,
                    options: options
                });
            },
            success(message, options = {}) {
                this.send(message, "success", options);
            },
            error(message, options = {}) {
                this.send(message, "error", options);
            }
        };
    }
}
