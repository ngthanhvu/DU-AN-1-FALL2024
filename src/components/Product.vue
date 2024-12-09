<template>
  <section class="shop1 text-center">
    <span class="crumb-border"></span>
    <div class="container">
      <div class="row">
        <div class="col-xs-12">
          <ul class="breadcrumb">
            <li class="home">
              <router-link to="/"><b>Trang chủ </b></router-link>
              <span class="icon-arrow-right text-danger"><font-awesome-icon :icon="['fas', 'arrow-right']" /></span>
            </li>
            <li><strong><span class="text-danger"> Sản phẩm</span></strong></li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  <div class="container">
    <div class="row mt-3">
      <span class="boloc"><font-awesome-icon :icon="['fas', 'sliders']" /> <b>Bộ lọc</b></span>
      <div class="col-md-2 sidebar">
        <h5><b>Danh Mục</b></h5>
        <div v-for="category in categories" :key="category.id" class="mt-2">
          <input class="form-check-input mb-2 text-muted" type="checkbox" :value="category.id"
            v-model="filters.category_ids" /> {{ category.name }}
        </div>
        <hr>
        <h5><b>Khoảng giá</b></h5>
        <div v-for="range in priceRanges" :key="range.label">
          <a @click="filters.min_price = range.min; filters.max_price = range.max"
            class="text-decoration-none text-black text-muted filter-price">
            {{ range.label }}
          </a>
        </div>
        <p class="mt-2">
          Giá: {{ formatVND(filters.min_price) }} - {{ formatVND(filters.max_price) }}
        </p>
        <button @click="resetFilter" class="btn btn-danger"><font-awesome-icon
            :icon="['fas', 'rotate-left']" /></button>
      </div>

      <!-- Mobile Sidebar -->
      <div v-if="isSidebarOpen" class="filter-mobile-sidebar">
        <a href="/" class="logo1">
          <img src="https://bizweb.dktcdn.net/100/483/998/themes/904984/assets/logo.png?1720275862057" alt="Logo">
        </a>

        <button @click="closeSidebar" class="btn-close-sidebar-mb">&times;</button>
        <h5 class="mb-3">Danh Mục</h5>
        <div v-for="category in categories" :key="category.id">
          <input class="form-check-input" type="checkbox" :value="category.id" v-model="filters.category_ids" />
          <label class="form-check-label">{{ category.name }}</label>
        </div>
        <h5><b>Khoảng giá</b></h5>
        <div v-for="range in priceRanges" :key="range.label">
          <a @click="filters.min_price = range.min; filters.max_price = range.max"
            class="text-decoration-none text-black text-muted filter-price">
            {{ range.label }}
          </a>
        </div>
        <p class="mt-2">
          Giá: {{ formatVND(filters.min_price) }} - {{ formatVND(filters.max_price) }}
        </p>
      </div>
      <div v-if="isSidebarOpen" class="opacity_filter-mobile-sidebar" @click="closeSidebar"></div>
      <!-- End Mobile Sidebar -->

      <div class="col-md-10 main-product">
        <div class="d-flex justify-content-between mb-3">
          <button @click="toggleSidebar" class="btn-filter-sidebar">
            <span><font-awesome-icon :icon="['fas', 'sliders']" /></span>
          </button>

          <div class="input-group" style="width: 60%;">
            <span class="input-group-text bg-danger text-white border-danger" id="basic-addon1">
              <font-awesome-icon :icon="['fas', 'magnifying-glass']" />
            </span>
            <input v-model="filters.search" type="text" class="form-control" placeholder="Tìm kiếm sản phẩm">
          </div>
          <select v-model="filters.sort" class="form-select" style="width: 20%;">
            <option value="">Sắp xếp</option>
            <option value="az">A-Z</option>
            <option value="za">Z-A</option>
          </select>
        </div>

        <div class="row">
          <div v-for="product in products" :key="product.id" class="col-md-3 col-sm-6 mb-5 product-col">
            <div class="product-box">
              <div class="product-thumbnail">
                <router-link :to="'/chi-tiet-san-pham/' + product.id" class="image_link">
                  <img :src="`${API_URL}/storage/${product.images.find(img => img.is_primary === 1)?.image_path}`"
                    class="lazyload" :alt="product.name" width="100%">
                </router-link>
                <div v-if="product.isOnSale" class="product-label">
                  <strong class="label">Sale</strong>
                </div>
              </div>
              <div class="product-info a-left">
                <h3 class="product-name">
                  <router-link :to="'/chi-tiet-san-pham/' + product.id">{{ product.name }}</router-link>
                </h3>
                <p class="product-category text-muted"><span class="text-muted">Danh mục:</span> {{
                  product.category.name }}</p>
                <div class="price-box clearfix">
                  <span class="price product-price">{{ formatVND(product.price) }}</span>
                  <span v-if="product.oldPrice" class="price product-price-old">
                    <del>{{ product.oldPrice }}₫</del>
                  </span>
                </div>
              </div>
            </div>
          </div>
          <div v-if="products.length === 0" class="col-md-12 text-center">
            <p>Không tìm thấy sản phẩm nào</p>
          </div>
        </div>

        <!-- Phân trang -->
        <ul class="pagination">
          <li class="page-item">
            <button @click="filters.page > 1 && (filters.page -= 1)"
              class="page-link bg-danger border-danger text-white" :disabled="filters.page === 1">
              <font-awesome-icon :icon="['fas', 'angles-left']" />
            </button>
          </li>
          <li v-for="page in pagination.last_page" :key="page" class="page-item">
            <button @click="filters.page = page" class="page-link bg-danger border-danger text-white">
              {{ page }}
            </button>
          </li>
          <li class="page-item">
            <button @click="filters.page < pagination.last_page && (filters.page += 1)"
              class="page-link bg-danger border-danger text-white" :disabled="filters.page === pagination.last_page">
              <font-awesome-icon :icon="['fas', 'angles-right']" />
            </button>
          </li>
        </ul>


      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue';
import axios from 'axios';

const API_URL = import.meta.env.VITE_API_URL;

const isSidebarOpen = ref(false);
const products = ref([]);
const categories = ref([]);
const pagination = ref({});
const filters = ref({
  search: '',
  category_ids: [],
  min_price: '',
  max_price: '',
  sort: '',
  page: 1
});

const priceRanges = [
  { label: 'Dưới 100k', min: 0, max: 100000 },
  { label: '100k - 200k', min: 100000, max: 200000 },
  { label: '200k - 300k', min: 200000, max: 300000 },
  { label: '300k - 500k', min: 300000, max: 500000 },
  { label: 'Trên 500k', min: 500000, max: 100000000 }
];

const getProducts = async () => {
  try {
    const queryParams = { ...filters.value };

    if (queryParams.category_ids.length === 1) {
      queryParams['category_ids'] = queryParams.category_ids[0];
    } else if (queryParams.category_ids.length > 1) {
      queryParams['category_ids'] = queryParams.category_ids.join(',');
    } else {
      delete queryParams['category_ids'];
    }

    const queryString = new URLSearchParams(queryParams).toString();
    const response = await axios.get(`${API_URL}/api/product/view?${queryString}`);
    products.value = response.data.data;
    pagination.value = response.data;
  } catch (error) {
    console.error('Error fetching products:', error);
  }
  closeSidebar();

};

const resetFilter = () => {
  filters.value.category_ids = [];
  filters.value.min_price = '';
  filters.value.max_price = '';
  filters.value.sort = '';
  filters.value.page = 1;
  getProducts();
};

const getCategories = async () => {
  try {
    const response = await axios.get(`${API_URL}/api/categories`);
    categories.value = response.data;
  } catch (error) {
    console.error('Error fetching categories:', error);
  }
};

watch(filters, () => {
  getProducts();
}, { deep: true });

const setPriceRange = (range) => {
  filters.value.min_price = range.min;
  filters.value.max_price = range.max;
};

const toggleSidebar = () => {
  isSidebarOpen.value = !isSidebarOpen.value;
};

const closeSidebar = () => {
  isSidebarOpen.value = false;

};

const formatVND = value => new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(value);

onMounted(() => {
  getCategories();
  getProducts();
});
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

.filter-price {
  cursor: pointer;
  padding: 5px;
}

.filter-price:hover {
  background: #0000000d;
}
</style>
