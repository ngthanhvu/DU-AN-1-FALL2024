<template>
    <div class="sidebar bg-dark text-white vh-100">
        <ul class="nav flex-column p-3 mt-5">
            <li class="nav-item" :class="{ active: $route.path === '/admin' }">
                <router-link to="/admin" class="nav-link text-white">
                    <font-awesome-icon :icon="['fas', 'gauge']" /> Dashboard
                </router-link>
            </li>
            <span class="nav-title mt-3">Quản trị</span>
            <li class="nav-item" :class="{ active: $route.path === '/admin/products' }">
                <router-link to="/admin/products" class="nav-link text-white">
                    <font-awesome-icon :icon="['fas', 'folder-open']" /> Products
                </router-link>
            </li>
        </ul>
    </div>
</template>

<style scoped>
.sidebar {
    width: 250px;
    position: fixed;
    top: 0;
    left: 0;
    height: 100%;
    background-color: #1f1f2e;
    /* font-size: 0.9rem; */
}

.nav-title {
    font-size: 0.75rem;
    color: #6c757d;
    text-transform: uppercase;
    padding-left: 10px;
    margin-top: 20px;
}

.nav-item {
    margin-top: 10px;
}

.nav-link {
    display: flex;
    align-items: center;
    padding: 8px 10px;
    color: #adb5bd;
}

.nav-item.active .nav-link {
    background-color: #7fad39;
    color: #fff;
    border-radius: 5px;
}
</style>