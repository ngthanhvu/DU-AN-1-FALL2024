<template>
  <div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
      <div class="sb-sidenav-menu">
        <div class="nav">
          <div class="sb-sidenav-menu-heading">Core</div>
          <router-link class="nav-link" to="/admin">
            <div class="sb-nav-link-icon"><font-awesome-icon :icon="['fas', 'gauge-high']" /></div>
            Dashboard
          </router-link>
          <div class="sb-sidenav-menu-heading">Quản lý</div>
          <!-- Manage Products -->
          <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseProducts"
            aria-expanded="false" aria-controls="collapseProducts">
            <div class="sb-nav-link-icon"><font-awesome-icon :icon="['fas', 'cart-shopping']" /></div>
            Quản Lý Sản Phẩm
            <div class="sb-sidenav-collapse-arrow"><font-awesome-icon :icon="['fas', 'angle-down']" /></div>
          </a>
          <div class="collapse" id="collapseProducts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
            <nav class="sb-sidenav-menu-nested nav">
              <router-link class="nav-link" to="/admin/products" >Danh sách sản phẩm</router-link>
            </nav>
            <nav class="sb-sidenav-menu-nested nav">
              <router-link class="nav-link" to="/admin/products/add" >Thêm sản phẩm</router-link>
            </nav>
          </div>

          <!-- Manage Category -->
          <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseCategory"
            aria-expanded="false" aria-controls="collapseCategory">
            <div class="sb-nav-link-icon"><font-awesome-icon :icon="['fas', 'layer-group']" /></div>
            Quản Lý Danh Mục
            <div class="sb-sidenav-collapse-arrow"><font-awesome-icon :icon="['fas', 'angle-down']" /></div>
          </a>
          <div class="collapse" id="collapseCategory" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
            <nav class="sb-sidenav-menu-nested nav">
              <router-link class="nav-link" to="/admin/category">Danh sách danh mục</router-link>
              <router-link class="nav-link" to="/admin/category/add">Thêm danh mục</router-link>
            </nav>
          </div>


        </div>
      </div>
    </nav>
  </div>
</template>
