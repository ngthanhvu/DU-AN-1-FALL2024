<!-- src/App.vue -->
<script setup>
import Navbar from '@/components/Navbar.vue';
import Home from '@/components/Home.vue';
import Footer from '@/components/Footer.vue';
</script>

<template>
  <div id="app">
    <Navbar />
    <router-view />
    <Footer />
  </div>
</template>

<style scoped>
/* Thêm style cho App nếu cần */
</style>
