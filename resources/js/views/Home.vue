<template>
    <div>
        <Header/>

        <div id="layoutSidenav">
            <Sidebar/>

            <div id="layoutSidenav_content">
                <main>
                    <router-view></router-view>
                </main>

                <Footer/>
            </div>
        </div>
    </div>
</template>

<script>
import Header from "../components/Header";
import Sidebar from "../components/Sidebar";
import Footer from "../components/Footer";

export default {
    name: "Home",
    components: {
        Header,Sidebar,Footer
    },
    created() {
        document.querySelector('body').style.backgroundColor = '#fff'
    },
}
</script>

<style scoped>

</style>
