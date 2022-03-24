<template>
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <router-link to="/" class="nav-link" exact>
                        <div class="sb-nav-link-icon"><i class="fas fa-home"></i></div>
                        Басты бет
                    </router-link>
                    <div class="sb-sidenav-menu-heading">Мұғалім</div>
                    <router-link to="/teacher/list" class="nav-link" exact-path>
                        <div class="sb-nav-link-icon">
                            <i class="fas fa-table"></i></div>
                        Мұғалімдер тізімі
                    </router-link>
                    <router-link to="/teacher/add-remove" class="nav-link" exact>
                        <div class="sb-nav-link-icon"><i class="fas fa-user-circle"></i></div>
                        Мұғалім қосу/өшіру
                    </router-link>
                </div>
            </div>
            <div class="sb-sidenav-footer">
                <div class="small">Logged in as:</div>
                Алмас
            </div>
        </nav>
    </div>
</template>

<script>
export default {
    name: "Sidebar"
}
</script>

<style scoped>

</style>
