<template>
    <div>
        <Header/>

        <div id="layoutSidenav">
            <Sidebar/>

            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        Hellou
                    </div>
                </main>
                <Footer/>
            </div>
        </div>
    </div>
</template>

<script>
import Header from "./components/Header";
import Sidebar from "./components/Sidebar";
import Footer from "./components/Footer";

export default {
    components: {
        Header,Sidebar,Footer
    }
}
</script>
