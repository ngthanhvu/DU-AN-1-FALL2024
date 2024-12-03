<template>
  <header class="home-page" style="z-index: 100;">
    <div class="container head-container">
      <!-- Mobile Nav Button -->
      <div class="nav-mobile-button hidden-md hidden-lg" @click="openNav">
        <span class="icon-search-normal-5"><font-awesome-icon :icon="['fas', 'bars']" /></span>
        <router-link to="/" class="logo1">
          <img src="https://bizweb.dktcdn.net/100/483/998/themes/904984/assets/logo.png?1720275862057" alt="Logo">
        </router-link>
      </div>

      <router-link to="/" class="logo">
        <img src="https://bizweb.dktcdn.net/100/483/998/themes/904984/assets/logo.png?1720275862057" alt="Logo">
      </router-link>

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
          cartCount.length > 0 ? cartCount.length : 0 }}</span></a></li>

        <li v-if="isLogin" class="dropdown desktop-only">
          <a href="#" class="dropdown-toggle" style="color: #333;" data-bs-toggle="dropdown" aria-expanded="false">
            <font-awesome-icon :icon="['fas', 'circle-user']" />
          </a>
          <span style="padding-left: 10px;">Xin chào, <b>{{ username }}</b>!</span>
          <ul class="dropdown-menu">
            <li><router-link to="/trang-ca-nhan" class="dropdown-item text-black mx-auto">Thông tin cá
                nhân</router-link></li>
            <li><router-link to="/lich-su-mua-hang" class="dropdown-item text-black mx-auto">Lịch sử mua hàng</router-link></li>

            <li><button class="dropdown-item" style="font-weight: 500;" @click="logout">Đăng xuất</button></li>
          </ul>
        </li>

        <!-- If not logged in, show login button -->
        <li v-else><router-link to="/login" class="login-button">Đăng nhập</router-link></li>
      </ul>
    </div>

    <!-- mobile -->
    <div v-show="isSidenavOpen" id="mySidenav" class="sidenav menu_mobile">
      <a href="javascript:void(0)" class="closebtn" @click="closeNav">&times;</a>
      <div class="logo-mb">
        <a href="/" class="logo-wrapper">
          <img src="//bizweb.dktcdn.net/100/483/998/themes/904984/assets/logo.png?1722078914172" width="88" height="37"
            alt="logo">
        </a>
      </div>
      <ul class="navicons">
        <li v-if="isLogin" class="dropdown mobile-only">
          <a href="#" class="drop-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            <font-awesome-icon :icon="['fas', 'circle-user']" />
            <span>Xin chào, <b>{{ username }}</b></span>
          </a>
        </li>
        <li v-else><router-link to="/login" class="login-button">Đăng nhập</router-link></li>
      </ul>

      <div class="content_menu_mb">
        <ul class="ct-mobile">
          <li><router-link to="/">Trang Chủ</router-link></li>
          <li><router-link to="/san-pham">Sản Phẩm</router-link></li>
          <li><router-link to="/tin-tuc">Tin Tức</router-link></li>
          <li><router-link to="/lien-he">Liên Hệ</router-link></li>
          <li v-if="isAdmin" class="admin-link"><a href="/admin">Admin</a></li>
        </ul>
      </div>

      <li v-if="isLogin"><router-link to="/trang-ca-nhan" class="drop-profile">Thông tin cá nhân</router-link></li>
      <li v-if="isLogin"><router-link to="/lich-su-mua-hang" class="drop-profile">Lịch sử mua hàng</router-link></li>
      <li v-if="isLogin"><button class="drop-logout" @click="logout">Đăng xuất</button></li>

    </div>


    <div v-show="isSidenavOpen" class="hidden-md hidden-lg opacity_menu" @click="closeNav"></div>
  </header>
</template>



<script setup>
import { ref, watch, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';

const API_URL = 'http://127.0.0.1:8000';

const router = useRouter();
const isLogin = ref(localStorage.getItem('isLogin') === 'true');
const isSidenavOpen = ref(false);
const cartCount = ref(0);
const isAdmin = ref(localStorage.getItem('role') === 'admin');
const username = ref(localStorage.getItem('username'));

const openNav = () => {
  isSidenavOpen.value = true;
};

const closeNav = () => {
  isSidenavOpen.value = false;
};

const getCountCart = async () => {
  try {
    const response = await axios.get(`${API_URL}/api/cart`, {
      params: {
        guest_id: localStorage.getItem('guest_id'),
        user_id: localStorage.getItem('user_id'),
      }
    });
    cartCount.value = response.data;
  } catch (error) {
    console.error('Error fetching cart count:', error);
  }
};

const logout = () => {
  localStorage.removeItem('isLogin');
  localStorage.removeItem('token');
  localStorage.removeItem('role');
  localStorage.removeItem('user_id');
  localStorage.removeItem('username');
  isLogin.value = false;
  router.push('/');
};

watch(() => localStorage.getItem('isLogin'), (newVal) => {
  isLogin.value = newVal === 'true';
});

onMounted(() => {
  if (!localStorage.getItem('guest_id')) {
    localStorage.setItem('guest_id', `guest_${Date.now()}`);
  };
  getCountCart();
});
router.afterEach(() => {
  closeNav();
});
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

Sidenav style .sidenav {
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
  margin: 0 -30px auto;
  transition: color 0.3s ease;

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
  padding: 2px 0;
}

.content_menu_mb .ct-mobile li a {
  color: #3e3e3e;
  text-decoration: none;
  margin: 0 0 auto;
  font-size: 18px;
  display: block;
  transition: 0.5s;
  border-bottom: 1px solid #cdcdcd;
}

.content_menu_mb .ct-mobile li a:hover {
  color: #8e8e8e;
}

.navicon .dropdown-menu {
  right: 0;
  left: auto;
}
</style>
