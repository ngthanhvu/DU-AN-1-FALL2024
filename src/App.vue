<script>
import Navbar from './components/Navbar.vue'
import Footer from './components/Footer.vue'
import AdminHeader from './components/admin/AdminHeader.vue';
import AdminFooter from './components/admin/AdminFooter.vue';
import AdminSidebar from './components/admin/AdminSidebar.vue';
import "quill/dist/quill.snow.css"; // Import Quill's Snow theme CSS


export default {
  name: 'App',
  computed: {
    headerComponent() {
      return this.$route.path.includes('/admin') ? AdminHeader : Navbar
    },
    footerComponent() {
      return this.$route.path.includes('/admin') ? AdminFooter : Footer

    },
    sidebarComponent() {
      return this.$route.path.includes('/admin') ? AdminSidebar : Sidebar
    }
  }
}
</script>

<template>
  <header>
    <div class="wrapper">
      <!-- <Navbar/> -->
      <component :is="headerComponent" />
    </div>
  </header>

  <main class="main">
    <RouterView />
  </main>
  <!-- <Footer /> -->
  <component :is="footerComponent" />
</template>

<style scoped>
</style>
