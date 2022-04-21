<template>
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <router-link to="/home" class="nav-link sidebar-link" exact>
                        <div class="sb-nav-link-icon"><i class="fas fa-home"></i></div>
                        Басты бет
                    </router-link>
                    <div class="sb-sidenav-menu-heading">Мұғалімдер</div>
                    <router-link to="/home/teacher/list" class="nav-link sidebar-link" exact-path>
                        <div class="sb-nav-link-icon">
                            <i class="fas fa-table"></i></div>
                        Мұғалімдер тізімі
                    </router-link>
                    <router-link to="/home/teacher/create" class="nav-link sidebar-link" exact>
                        <div class="sb-nav-link-icon"><i class="fas fa-user-plus"></i></div>
                        Мұғалім қосу/өшіру
                    </router-link>
                    <div class="sb-sidenav-menu-heading">Курстар</div>
                    <router-link to="/home/course/list" class="nav-link sidebar-link" exact-path>
                        <div class="sb-nav-link-icon"><i class="fas fa-list-alt"></i></div>
                        Курстар тізімі
                    </router-link>
                </div>
            </div>
            <div class="sb-sidenav-footer">
                <div class="small">Logged in as:</div>
                {{profile.name}}
            </div>
        </nav>
    </div>
</template>

<script>
import {mapState} from "vuex";

export default {
    name: "Sidebar",
    computed: mapState({
        profile: 'profile'
    })
}
</script>

<style scoped>

</style>
