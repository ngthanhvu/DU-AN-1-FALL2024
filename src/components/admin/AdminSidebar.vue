<template>
  <div id="layoutSidenav_nav" style="min-height: 100vh;">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
      <div class="sb-sidenav-menu">
        <div class="nav">
          <div class="sb-sidenav-menu-heading">Chính</div>
          <router-link class="nav-link" to="/admin">
            <div class="sb-nav-link-icon"><font-awesome-icon :icon="['fas', 'gauge-high']" /></div>
            Bảng Điều Khiển
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
              <router-link class="nav-link" to="/admin/products">Danh sách sản phẩm</router-link>
            </nav>
            <nav class="sb-sidenav-menu-nested nav">
              <router-link class="nav-link" to="/admin/products/add">Thêm sản phẩm</router-link>
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

          <!-- Manage user  -->
          <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseUser"
            aria-expanded="false" aria-controls="collapseUser">
            <div class="sb-nav-link-icon"><font-awesome-icon :icon="['fas', 'circle-user']" /></div>
            Quản Lý Người Dùng
            <div class="sb-sidenav-collapse-arrow"><font-awesome-icon :icon="['fas', 'angle-down']" /></div>
          </a>
          <div class="collapse" id="collapseUser" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
            <nav class="sb-sidenav-menu-nested nav">
              <router-link class="nav-link" to="/admin/user">Danh sách người dùng</router-link>
            </nav>
          </div>

          <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseBlog"
            aria-expanded="false" aria-controls="collapseBlog">
            <div class="sb-nav-link-icon"><font-awesome-icon :icon="['fas', 'newspaper']" /></div>
            Quản Lý Bài Viết
            <div class="sb-sidenav-collapse-arrow"><font-awesome-icon :icon="['fas', 'angle-down']" /></div>
          </a>
          <div class="collapse" id="collapseBlog" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
            <nav class="sb-sidenav-menu-nested nav">
              <router-link class="nav-link" to="/admin/blog">Danh sách bài viết</router-link>
              <router-link class="nav-link" to="/admin/blog/add">Thêm bài viết</router-link>
            </nav>
          </div>

          <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseCoupon"
            aria-expanded="false" aria-controls="collapseCoupon">
            <div class="sb-nav-link-icon"><font-awesome-icon :icon="['fas', 'ticket']" /></div>
            Quản Lý Mã Giảm Giá
            <div class="sb-sidenav-collapse-arrow"><font-awesome-icon :icon="['fas', 'angle-down']" /></div>
          </a>
          <div class="collapse" id="collapseCoupon" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
            <nav class="sb-sidenav-menu-nested nav">
              <router-link class="nav-link" to="/admin/discount">Danh sách mã</router-link>
              <router-link class="nav-link" to="/admin/discount/add">Thêm mã</router-link>
            </nav>
          </div>

          <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseOrder"
            aria-expanded="false" aria-controls="collapseOrder">
            <div class="sb-nav-link-icon"><font-awesome-icon :icon="['fas', 'bag-shopping']" /></div>
            Quản Lý Đơn Hàng
            <div class="sb-sidenav-collapse-arrow"><font-awesome-icon :icon="['fas', 'angle-down']" /></div>
          </a>
          <div class="collapse" id="collapseOrder" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
            <nav class="sb-sidenav-menu-nested nav">
              <router-link class="nav-link" to="/admin/order">Danh sách đơn hàng</router-link>
            </nav>
          </div>

          <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseComment"
            aria-expanded="false" aria-controls="collapseComment">
            <div class="sb-nav-link-icon"><font-awesome-icon :icon="['fas', 'comment']" /></div>
            Bình Luận & Đánh Giá
            <div class="sb-sidenav-collapse-arrow"><font-awesome-icon :icon="['fas', 'angle-down']" /></div>
          </a>
          <div class="collapse" id="collapseComment" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
            <nav class="sb-sidenav-menu-nested nav">
              <router-link class="nav-link" to="/admin/comment">Danh sách Bình Luận</router-link>
            </nav>
            <nav class="sb-sidenav-menu-nested nav">
              <router-link class="nav-link" to="/admin/review">Danh sách đánh giá</router-link>
            </nav>
          </div>

          <div class="sb-sidenav-menu-heading">debug / log</div>
          <router-link class="nav-link" to="/admin/log">
            <div class="sb-nav-link-icon"><font-awesome-icon :icon="['fas', 'bug']" /></div>
            Log
          </router-link>

        </div>
      </div>
    </nav>
  </div>
</template>
