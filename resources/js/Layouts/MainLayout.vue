<script setup>
import Sidebar from "./Partials/Sidebar.vue";
import NavBar from "./Partials/Navbar.vue";
import { computed } from "vue";
import { usePage } from "@inertiajs/vue3";

const user = computed(() => {
  return usePage().props.auth.user;
});
</script>

<template>
  <div class="wrapper">
    <NavBar />
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <Link :href="route('home')" class="brand-link">
        <img
          src="~admin-lte/dist/img/AdminLTELogo.png"
          alt="AdminLTE Logo"
          class="brand-image img-circle elevation-3"
          style="opacity: 0.8"
        />
        <span class="brand-text font-weight-light">FMBP-APP-{{ user.annee }}</span>
      </Link>

      <Sidebar />
    </aside>

    <div class="content-wrapper">
      <slot />
    </div>
  </div>
</template>
