<template>

  <section class="shop1 text-center">
    <span class="crumb-border"></span>
    <div class="container">
      <div class="row">
        <div class="col-xs-12">
          <ul class="breadcrumb">
            <li class="home">
              <router-link to="/"><b>Trang chủ </b></router-link>
              <span class="icon-arrow-right text-danger"><font-awesome-icon :icon="['fas', 'arrow-right']" /> </span>
            </li>
            <li><strong><span class="text-danger"> Áo Tuyển Quốc Gia</span></strong></li>
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
      <h3><b>Áo Bóng Đá</b></h3>
      <span><font-awesome-icon :icon="['fas', 'sliders']" /> <b>Bộ lọc</b></span>
      <div class="col-md-2 sidebar">
        <h5><b>Danh Mục</b></h5>
        <router-link to="/san-pham" class="text-decoration-none text-black text-muted">Danh mục 1</router-link>
        <router-link to="/san-pham" class="text-decoration-none text-black text-muted">Danh mục 2</router-link>
        <router-link to="/san-pham" class="text-decoration-none text-black text-muted">Danh mục 3</router-link>
        <hr>
        <h5><b>Loại sản phẩm</b></h5>
        <router-link to="/san-pham" class="text-decoration-none text-black text-muted">Danh mục 1</router-link>
        <router-link to="/san-pham" class="text-decoration-none text-black text-muted">Danh mục 2</router-link>
      </div>
      <div class="col-md-10 main-product">
        <div class="d-flex justify-content-between mb-3">
          <div class="input-group" style="width: 60%;">
            <span class="input-group-text bg-danger text-white border-danger" id="basic-addon1"><font-awesome-icon
                :icon="['fas', 'magnifying-glass']" /></span>
            <input v-model="searchQuery" type="text" class="form-control" placeholder="Tìm kiếm sản phẩm">
          </div>
          <select v-model="sortOption" class="form-select" style="width: 20%;">
            <option value="">Sắp xếp</option>
            <option value="az">A-Z</option>
            <option value="za">Z-A</option>
          </select>
        </div>


        <div class="row">
          <div v-for="product in filteredProducts" :key="product.id" class="col-md-3 col-sm-6 mb-5 product-col">
            <div class="product-box">
              <div class="product-thumbnail">
                <router-link :to="'/chi-tiet-san-pham/' + product.id" class="image_link">
                  <img :src="product.image" class="lazyload" :alt="product.name" width="100%">
                </router-link>
                <div v-if="product.isOnSale" class="product-label">
                  <strong class="label">Sale</strong>
                </div>
              </div>
              <div class="product-info a-left">
                <div class="sapo-product-reviews-badge">
                  <div class="sapo-product-reviews-star" style="color: #ffbe00; font-size: 24px;">
                    <span v-for="n in 5" :key="n" class="bi-star"
                      :class="{ 'text-warning': n <= product.rating }"></span>
                  </div>
                </div>
                <h3 class="product-name">
                  <router-link :to="'/chi-tiet-san-pham/' + product.id">{{ product.name }}</router-link>
                </h3>
                <div class="price-box clearfix">
                  <span class="price product-price">{{ product.price }}₫</span>
                  <span v-if="product.oldPrice" class="price product-price-old">
                    <del>{{ product.oldPrice }}₫</del>
                  </span>
                </div>
              </div>
            </div>
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
        { id: 1, name: 'BĐN Home (2024 - 2025) Màu đỏ + Cộc tay | Bản PLAYER [Có quần]', price: '100.000đ', oldPrice: '150.000đ', image: 'https://bizweb.dktcdn.net/thumb/large/100/483/998/products/photo-2024-06-26-13-23-57-2.jpg?v=1719386766340' },
        { id: 2, name: 'BĐN Home (2024 - 2025) Màu đỏ + Cộc tay | Bản PLAYER [Có quần]', price: '120.000đ', oldPrice: '180.000đ', image: 'https://bizweb.dktcdn.net/thumb/large/100/483/998/products/photo-2024-06-26-13-23-57-2.jpg?v=1719386766340' },
        { id: 3, name: 'BĐN Home (2024 - 2025) Màu đỏ + Cộc tay | Bản PLAYER [Có quần]', price: '110.000đ', oldPrice: '160.000đ', image: 'https://bizweb.dktcdn.net/thumb/large/100/483/998/products/photo-2024-06-26-13-23-57-2.jpg?v=1719386766340' },
        { id: 4, name: 'BĐN Home (2024 - 2025) Màu đỏ + Cộc tay | Bản PLAYER [Có quần]', price: '110.000đ', oldPrice: '160.000đ', image: 'https://bizweb.dktcdn.net/thumb/large/100/483/998/products/photo-2024-06-26-13-23-57-2.jpg?v=1719386766340' },
        // Thêm sản phẩm khác ở đây
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
      const totalPages = Math.ceil(this.products.length / 4); 
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
.product-name {
  font-size: 17px;
  font-weight: bold;
  color: #333;
  margin: 12px 0 8px;
  transition: color 0.3s ease;
}

.product-name a {
  text-decoration: none;
  color: inherit;
}

.product-name a:hover {
  color: #ff0000; 
}

.price-box {
  display: flex;

  gap: 10px;
  margin-top: 5px;
}

.price.product-price {
  font-size: 17px;
  font-weight: bold;
  color: #e53935; 
}

.price.product-price-old {
  font-size: 16px;
  color: #999;
  text-decoration: line-through;
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


</style>
