<template>

  <section class="shop1 text-center">
    <span class="crumb-border"></span>
    <div class="container">
      <div class="row">
        <div class="col-xs-12">
          <ul class="breadcrumb">
            <li class="home">
              <router-link to="/"><b>Trang chủ </b></router-link>
              <span class="icon-arrow-right text-danger"><font-awesome-icon :icon="['fas', 'arrow-right']" />  </span>
            </li>
            <li><strong><span class="text-danger">  Áo Tuyển Quốc Gia</span></strong></li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  <section class="shop2 text-left">
    <div class="container">
      <div class="row">
        <div class="col-xs-12">
          <ul class="breadcrumb">
            <li class="home">
              <router-link href="/" class="text-decoration-none" style="color: #dc3545;">
                <span>Trang Chủ</span>
              </router-link>
              <span class="icon-arrow-right text-danger"> -> </span>
            </li>
            <li>
              <strong>
                <span> Sản phẩm </span>
              </strong>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  <button @click="toggleSidebar" class="btn-filter-sidebar">
    <i class="fa-solid fa-sliders"></i>
  </button>

  <div v-if="isSidebarOpen" class="filter-mobile-sidebar">
    <button @click="closeSidebar" class="btn-close-sidebar-mb">&times;</button>
    <h5>Danh Mục</h5>
    <a href="/product?id=1" class="text-decoration-none text-black text-muted">Danh mục 1</a>
    <a href="/product?id=2" class="text-decoration-none text-black text-muted">Danh mục 2</a>
    <a href="/product?id=3" class="text-decoration-none text-black text-muted">Danh mục 3</a>
  </div>

  <div class="container">
    <div class="row">
      <div class="col-md-3 sidebar">
        <h5>Danh Mục</h5>
        <a href="/product?id=1" class="text-decoration-none text-black text-muted">Danh mục 1</a>
        <a href="/product?id=2" class="text-decoration-none text-black text-muted">Danh mục 2</a>
        <a href="/product?id=3" class="text-decoration-none text-black text-muted">Danh mục 3</a>
      </div>

      <div class="col-md-9 main-product">
        <div class="d-flex justify-content-between mb-3">
          <div class="input-group" style="width: 60%;">
            <span class="input-group-text bg-danger text-white border-danger" id="basic-addon1"><i
                class="bi bi-search"></i></span>
            <input v-model="searchQuery" type="text" class="form-control" placeholder="Tìm kiếm sản phẩm">
          </div>
          <select v-model="sortOption" class="form-select" style="width: 20%;">
            <option value="">Sắp xếp</option>
            <option value="az">A-Z</option>
            <option value="za">Z-A</option>
          </select>
        </div>

        <div class="row">
          <div v-for="product in filteredProducts" :key="product.id" class="col-md-3 col-sm-6 mb-4 product-item"
            :data-name="product.name">
            <router-link :to="'/detail_product'" class="text-decoration-none text-black">
              <div class="card product-card1">
                <div class="card-img-wrapper">
                  <img :src="product.image" class="card-img-top" :alt="product.name" width="100%">
                </div>
                <div class="card-body">
                  <div class="d-flex justify-content-left small text-warning mb-2">
                    <div v-for="n in 5" :key="n" class="bi-star-fill"></div>
                  </div>
                  <h5 class="card-title">{{ product.name }}</h5>
                  <p class="card-text">{{ product.price }} <del class="text-decoration-line-through text-danger">{{
                      product.oldPrice }}</del></p>
                </div>
              </div>
            </router-link>
          </div>
        </div>

        <!-- Phân trang -->
        <ul class="pagination">
          <li v-for="page in pages" :key="page" class="page-item">
            <a class="page-link bg-danger border-danger text-white" :href="'?page=' + page">{{ page }}</a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      searchQuery: '',
      sortOption: '',
      isSidebarOpen: false,
      products: [
        { id: 1, name: 'Sản phẩm 1', price: '100.000đ', oldPrice: '150.000đ', image: 'https://bizweb.dktcdn.net/thumb/large/100/483/998/products/photo-2024-06-26-13-23-57-2.jpg?v=1719386766340' },
        { id: 2, name: 'Sản phẩm 2', price: '120.000đ', oldPrice: '180.000đ', image: 'https://bizweb.dktcdn.net/thumb/large/100/483/998/products/photo-2024-06-26-13-23-57-2.jpg?v=1719386766340' },
        { id: 3, name: 'Sản phẩm 3', price: '110.000đ', oldPrice: '160.000đ', image: 'https://bizweb.dktcdn.net/thumb/large/100/483/998/products/photo-2024-06-26-13-23-57-2.jpg?v=1719386766340' },
        // Thêm sản phẩm khác ở đây
      ]
    };
  },
  computed: {
    filteredProducts() {
      let filtered = this.products.filter(product =>
        product.name.toLowerCase().includes(this.searchQuery.toLowerCase())
      );

      if (this.sortOption === 'az') {
        filtered = filtered.sort((a, b) => a.name.localeCompare(b.name));
      } else if (this.sortOption === 'za') {
        filtered = filtered.sort((a, b) => b.name.localeCompare(a.name));
      }

      return filtered;
    },
    pages() {
      const totalPages = Math.ceil(this.products.length / 4); // Assuming 4 products per page
      return Array.from({ length: totalPages }, (_, i) => i + 1);
    }
  },
  methods: {
    toggleSidebar() {
      this.isSidebarOpen = !this.isSidebarOpen;
    },
    closeSidebar() {
      this.isSidebarOpen = false;
    }
  }
};
</script>

<style scoped>
.product-card1 {
  overflow: hidden;
  position: relative;
}

.product-card1 img {
  transition: transform 0.3s ease;
}

.product-card1:hover img {
  transform: scale(1.1);
}



.sidebar h5 {
  margin-top: 20px;
}

.sidebar a {
  text-decoration: none;
  color: #000;
  display: block;
  margin-bottom: 10px;
}

.sidebar a:hover {
  color: #007bff;
}

.card-img-wrapper {
  overflow: hidden;
  height: 200px;
}

.card {
  height: 300px;
}
</style>
