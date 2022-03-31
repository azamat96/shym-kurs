<template>
    <div class="position-fixed top-0 end-0 p-3 toast-container" style="z-index: 1060" ref="toastMsg">
        <div ref="toastOk" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="fas fa-check-circle"></i> {{success.message}}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
        <div ref="toastErr" class="toast align-items-center text-white bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="fas fa-exclamation-triangle"></i> {{error.message}}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
</template>

<script>
import { Toast } from 'bootstrap'
import {EventBus} from "../plugins/eventbus";

export default {
    name: "ToastMessage",
    data() {
        return {
            // TODO сделать массивом уведомлении, а то просто show/hide
            success: {
                toast: null,
                message: ''
            },
            error: {
                toast: null,
                message: 'Ощибка с сервером'
            },
        }
    },
    created() {
        // start listening for "toast-message" channel's events
        EventBus.$on("toast-message", this.handleMessageEvent);
    },
    mounted() {
        this.success.toast = new Toast(this.$refs.toastOk)
        this.error.toast = new Toast(this.$refs.toastErr)
    },
    methods: {
        handleMessageEvent(payload) {
            if (payload.message) {
                this.showMessage(payload.message, payload.type, payload.options);
            }
        },
        showMessage(message, type, options = {}) {
            if (type === "success") {
                this.success.toast.show()
                this.success.message = message
            }
            if (type === "error") {
                this.error.toast.show()
                this.error.message = message
            }
        }
    }
}
</script>

<style scoped>

</style>
