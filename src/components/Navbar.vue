<template>
  <header class="home-page" style="z-index: 100;">
    <div class="container head-container">
      <!-- Mobile Nav Button -->
      <div class="nav-mobile-button hidden-md hidden-lg" @click="openNav">
        <span class="icon-search-normal-5"><i class="fas fa-bars"></i></span>
      </div>

      <!-- Logo -->
      <a href="/" class="logo">
        <img src="https://bizweb.dktcdn.net/100/483/998/themes/904984/assets/logo.png?1720275862057" alt="Logo">
      </a>

      <!-- Main Navigation Links -->
      <ul class="navmenu">
        <li><router-link to="/">Trang Chủ</router-link></li>
        <li><router-link to="/san-pham">Sản Phẩm</router-link></li>
        <li><router-link to="/gioi-thieu">Giới Thiệu</router-link></li>
        <li><router-link to="/tin-tuc">Tin Tức</router-link></li>
        <li><router-link to="/lien-he">Liên Hệ</router-link></li>

        <li v-if="isAdmin" class="admin-link"><a href="/admin">Admin</a></li>
      </ul>

      <!-- Cart and Login Icons -->
      <ul class="navicon">
        <li><a style="color: #333;" href="/gio-hang"><font-awesome-icon :icon="['fas', 'bag-shopping']" /> <span>{{
          cartCount }}</span></a></li>

        <!-- Kiểm tra trạng thái đăng nhập -->
        <li v-if="isLogin" class="dropdown">
          <a href="#" class="dropdown-toggle" style="color: #333;" data-bs-toggle="dropdown" aria-expanded="false">
            <font-awesome-icon :icon="['fas', 'circle-user']" /> {{ username }}
          </a>
          <ul class="dropdown-menu">
            <li><router-link to="/trang-ca-nhan" class="dropdown-item text-black  mx-auto" >Thông tin cá nhân</router-link></li>
            <li><button class="dropdown-item" style="font-weight: 500;" @click="logout">Đăng xuất</button></li>
          </ul>
        </li>

        <!-- Nếu chưa đăng nhập, hiển thị nút đăng nhập -->
        <li v-else><router-link to="/login" class="login-button">Đăng nhập</router-link></li>
      </ul>
    </div>

    <!-- Mobile Sidenav -->
    <div v-if="isSidenavOpen" id="mySidenav" class="sidenav menu_mobile hidden-md hidden-lg">
      <a href="javascript:void(0)" class="closebtn" @click="closeNav">&times;</a>
      <div class="logo-mb">
        <a href="/" class="logo-wrapper">
          <img src="//bizweb.dktcdn.net/100/483/998/themes/904984/assets/logo.png?1722078914172" width="88" height="37"
            alt="logo">
        </a>
      </div>
      <div class="content_menu_mb">
        <div class="link_list_mobile">
          <ul class="ct-mobile">
            <li><a href="/">Trang Chủ</a></li>
            <li><a href="/san-pham">Sản Phẩm</a></li>
            <li><a href="/blog">Tin tức</a></li>
            <li><a href="/contact">Liên Hệ</a></li>
            <li v-if="isAdmin" class="admin-link"><a href="/admin">Admin</a></li>
          </ul>
        </div>
      </div>
    </div>
  </header>
</template>

<script setup>
import { ref, watch } from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter();
const isLogin = ref(localStorage.getItem('isLogin') === 'true');
const isSidenavOpen = ref(false);
const cartCount = ref(localStorage.getItem('cartCount') || '0');
const isAdmin = ref(localStorage.getItem('role') === 'admin');
// const role = ref(localStorage.getItem('role') || '');

const openNav = () => {
  isSidenavOpen.value = true;
};

const closeNav = () => {
  isSidenavOpen.value = false;
};

const logout = () => {
  localStorage.removeItem('isLogin');
  localStorage.removeItem('token');
  localStorage.removeItem('role');
  localStorage.removeItem('user_id');
  isLogin.value = false;
  router.push('/');
};

watch(() => localStorage.getItem('isLogin'), (newVal) => {
  isLogin.value = newVal === 'true';
});

// watch(() => localStorage.getItem('role'), (newVal) => {
//   role.value = newVal || '';
// });

</script>



<style scoped>
/* Style for navbar */
.navmenu a {
  color: #000;
}

.home-page .navmenu a {
  color: #000;
}

.home-page .navicon i,
.home-page .login-button {
  color: #000;
}

/* Sidenav style */
.sidenav {
  height: 100%;
  width: 0;
  position: fixed;
  z-index: 1;
  top: 0;
  left: 0;
  background-color: #111;
  overflow-x: hidden;
  transition: 0.5s;
  padding-top: 60px;
}

.sidenav .closebtn {
  position: absolute;
  top: 0;
  right: 25px;
  font-size: 36px;
  margin-left: 50px;
}

.logo-mb {
  text-align: center;
  margin-bottom: 20px;
}

.content_menu_mb .ct-mobile {
  list-style-type: none;
  padding: 0;
}

.content_menu_mb .ct-mobile li {
  padding: 8px 0;
}

.content_menu_mb .ct-mobile li a {
  color: #818181;
  text-decoration: none;
  font-size: 25px;
  display: block;
  transition: 0.3s;
}

.content_menu_mb .ct-mobile li a:hover {
  color: #f1f1f1;
}

.navicon .dropdown-menu {
  right: 0;
  left: auto;
}
</style>
