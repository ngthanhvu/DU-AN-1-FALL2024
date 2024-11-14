<template>
  <div id="layoutSidenav">
    <Sidebar />
    <router-view />
  </div>
</template>

<script setup>
import Sidebar from './AdminSidebar.vue';
import AdminDashboar from './AdminDashboard.vue';
import AdminProduct from './AdminProduct.vue';
</script>
