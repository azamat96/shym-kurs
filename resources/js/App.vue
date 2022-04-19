<template>
    <div>
        <router-view></router-view>
        <ToastMessage/>
    </div>
</template>

<script>
import ToastMessage from "./components/ToastMessage";
import * as auth from "./services/auth_service"

export default {
    components: {
        ToastMessage
    },
    beforeCreate: async function() {
        try {
            if (auth.isLoggedIn()) {
                const response = await auth.getProfile()
                console.log(response)
                this.$store.dispatch('authenticate', response.data)
            }
        } catch (e) {
            auth.logout()
        }
    }
}
</script>
