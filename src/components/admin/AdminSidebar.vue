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
          <div class="sb-sidenav-menu-heading">Manager</div>
          <!-- Manage Products -->
          <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseProducts"
            aria-expanded="false" aria-controls="collapseProducts">
            <div class="sb-nav-link-icon"><font-awesome-icon :icon="['fas', 'cart-shopping']" /></div>
            Manage Products
            <div class="sb-sidenav-collapse-arrow"><font-awesome-icon :icon="['fas', 'angle-down']" /></div>
          </a>
          <div class="collapse" id="collapseProducts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
            <nav class="sb-sidenav-menu-nested nav">
              <router-link class="nav-link" to="/admin/products" >Product List</router-link>
            </nav>
          </div>

          <!-- Manage Category -->
          <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseCategory"
            aria-expanded="false" aria-controls="collapseCategory">
            <div class="sb-nav-link-icon"><font-awesome-icon :icon="['fas', 'cart-shopping']" /></div>
            Manage Category
            <div class="sb-sidenav-collapse-arrow"><font-awesome-icon :icon="['fas', 'angle-down']" /></div>
          </a>
          <div class="collapse" id="collapseCategory" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
            <nav class="sb-sidenav-menu-nested nav">
              <a class="nav-link" href="layout-static.html">Static Navigation</a>
              <a class="nav-link" href="layout-sidenav-light.html">Light Sidenav</a>
            </nav>
          </div>


        </div>
      </div>
    </nav>
  </div>
</template>

<style scoped></style>
