<script setup>
import AdminSidebar from './AdminSidebar.vue';
</script>

<template>
    <div class="admin-layout">
        <AdminSidebar />
        <div class="content">
            <router-view></router-view>
        </div>
    </div>
</template>

<style scoped>
.admin-layout {
    display: flex;
    height: 100vh;
}

.sidebar {
    width: 250px;
}

.content {
    flex-grow: 1;
    margin-left: 250px;
    padding: 20px;
    background-color: #f8f9fa;
}
</style>