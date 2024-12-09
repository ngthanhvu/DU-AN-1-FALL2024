<template>
  <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <!-- Navbar Brand-->
    <a class="navbar-brand ps-3" href="/"><font-awesome-icon :icon="['fas', 'user-tie']" /> Trang Quản Trị</a>
    <!-- Sidebar Toggle-->
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><font-awesome-icon
        :icon="['fas', 'bars']" /></button>
    <!-- Navbar Search-->
    <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
      <div class="input-group">
      </div>
    </form>
    <!-- Navbar-->
    <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
      <li class="nav-item dropdown">
        <a class="nav-link" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown"
          aria-expanded="false"><font-awesome-icon :icon="['fas', 'user']" /> Wellcome back <b>Admin</b>!</a>
      </li>
    </ul>
  </nav>
</template>

<script setup>

</script>

<style scoped>
.navbar {
  position: fixed;
  width: 100%;
  /* z-index: 1000; */
}
</style>
