<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-header"><h3 class="text-center font-weight-light my-3">Жүйеге кіру</h3></div>
                    <form v-on:submit.prevent="login">
                    <div class="card-body">
                        <div class="form-floating mb-3">
                            <input v-model="user.email" class="form-control" id="inputEmail" type="email" placeholder="name@example.com" />
                            <label for="inputEmail">Email</label>
                            <div class="invalid-feedback d-block" v-if="errors.email">{{errors.email[0]}}</div>
                        </div>
                        <div class="form-floating mb-3">
                            <input v-model="user.password" class="form-control" id="inputPassword" type="password" placeholder="Password" />
                            <label for="inputPassword">Құпия сөз</label>
                            <div class="invalid-feedback d-block" v-if="errors.password">{{errors.password[0]}}</div>
                        </div>
                        <div class="form-check mb-3">
                            <input v-model="user.remember_me" class="form-check-input" id="inputRememberPassword" type="checkbox" value="" />
                            <label class="form-check-label" for="inputRememberPassword">Құпия сөзді есте сақта</label>
                        </div>
                    </div>
                    <div class="card-footer text-center py-3">
                        <button type="submit" class="btn btn-primary">
                            <span v-if="loading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            <span v-else><i class="fas fa-user-circle"></i></span> Жүйеге кіру</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import * as auth from '../services/auth_service';

export default {
    name: "Login",
    created() {
        document.querySelector('body').style.backgroundColor = '#343a40'
    },
    data() {
        return {
            user: {
                email: '',
                password: '',
                remember_me: false
            },
            errors: {},
            loading: false,
        }
    },
    methods: {
        login: async function() {
            this.loading = true
            try {
                this.errors = {}
                const response = await auth.login(this.user);
                this.$router.push('/home')
                console.log(response)
            } catch (error) {
                console.log(error.response)
                switch (error.response.status) {
                    case 422:
                        this.errors = error.response.data.errors
                        break;
                    case 401:
                        this.$toast.error(error.response.data.message);
                        break;
                    case 500:
                        this.$toast.error(error.response.data.message);
                        break;
                    default:
                        this.$toast.error('Серверде белгілі бір қателіктер пайда болды, кейінірек қайталап көріңіз');
                        break;
                }
            }
            this.loading = false
        }
    }
}
</script>

<style scoped>

</style>
