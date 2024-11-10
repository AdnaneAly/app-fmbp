<script setup>
import Sidebar from "./Partials/Sidebar.vue";
import NavBar from "./Partials/Navbar.vue"
</script>

<template>
    <div class="wrapper">
        <NavBar />
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="index3.html" class="brand-link">
                <img
                    src="~admin-lte/dist/img/AdminLTELogo.png"
                    alt="AdminLTE Logo"
                    class="brand-image img-circle elevation-3"
                    style="opacity: 0.8"
                />
                <span class="brand-text font-weight-light">AdminLTE 3</span>
            </a>

            <Sidebar />
        </aside>

        <div class="content-wrapper">
            <slot />
        </div>

    </div>
</template>
