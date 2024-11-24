<template>
  <div id="layoutSidenav">
    <Sidebar />
    <router-view />
  </div>
</template>

<script setup>
import Sidebar from './AdminSidebar.vue';
import { useRouter } from 'vue-router';
const router = useRouter();
const checkRole = () => {
  const role = localStorage.getItem('role');
  if (role !== 'admin') {
    alert('Bạn không có quyền truy cập trang này');
    router.push('/');
  }
};
checkRole();
</script>
