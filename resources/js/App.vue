<template>
    <div>
        <Header/>

        <div id="layoutSidenav">
            <Sidebar/>

            <div id="layoutSidenav_content">
                <main>
                    <router-view></router-view>
                </main>
                <ToastMessage/>
                <Footer/>
            </div>
        </div>
    </div>
</template>

<script>
import Header from "./components/Header";
import Sidebar from "./components/Sidebar";
import Footer from "./components/Footer";
import ToastMessage from "./components/ToastMessage";

export default {
    components: {
        Header,Sidebar,Footer, ToastMessage
    }
}
</script>
