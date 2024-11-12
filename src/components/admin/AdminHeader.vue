<template>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">Admin Dashboard</span>
            <router-link to="/" class="btn btn-outline-light">
                <font-awesome-icon :icon="['fas', 'arrow-right-from-bracket']" />
            </router-link>
        </div>
    </nav>
</template>

<script setup>
</script>

<style scoped>
.navbar {
    position: fixed;
    width: 100%;
    z-index: 1000;
}
</style>