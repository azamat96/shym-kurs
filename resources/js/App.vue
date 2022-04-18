<template>
    <div>
        <router-view></router-view>
        <ToastMessage/>
    </div>
</template>

<script>
import ToastMessage from "./components/ToastMessage";

export default {
    components: {
        ToastMessage
    }
}
</script>
