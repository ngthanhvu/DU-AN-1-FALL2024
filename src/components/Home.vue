<template>
  <div>
    <section class="section-1">
       <!-- Modal -->
       <div v-if="showModal" class="modal-overlay">
            <div class="modal-content">
                <button class="close-btn" @click="closeModal">×</button>
                <img :src="quangCao" alt="Quang Cao" :data="quangCao">               
            </div>
        </div>

      <div class="container">
        <div id="carouselExampleIndicators" class="carousel slide carousel-fade" data-bs-ride="carousel">
          <!-- Indicators -->
          <div class="carousel-indicators">
            <button v-for="(slide, index) in carouselImages" :key="index" type="button"
              data-bs-target="#carouselExampleIndicators" :data-bs-slide-to="index" :class="{ active: index === 0 }"
              :aria-current="index === 0" :aria-label="'Slide ' + (index + 1)">
            </button>
          </div>

          <!-- Slides -->
          <div class="carousel-inner">
            <div v-for="(slide, index) in carouselImages" :key="index"
              :class="['carousel-item', { active: index === 0 }]">
              <img v-if="isDesktop" :src="slide.desktop" class="d-block w-100" alt="Desktop Slide">
              <img v-else :src="slide.mobile" class="d-block w-100" alt="Mobile Slide">
            </div>
          </div>
          
          <!-- Controls -->
          <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
          </button>
        </div>
      </div>
    </section>

    <!-- Section 2: Product Categories -->
    <section class="section-2 mt-5">
      <div class="container">
        <div class="row">
          <!-- Category Card 1 -->
          <div class="col-md-4">
            <div class="product-card">
              <div class="product-info">
                <h3>ĐỒ BÓNG ĐÁ</h3>
                <p>Áo bóng đá, giày bóng đá, tất bóng đá,...</p>
                <router-link to="/san-pham" class="btn btn-custom">Mua Ngay</router-link>
              </div>
              <div class="product-image">
                <img
                :src="danhMuc1" :data="danhMuc1"
                alt="Đồ bóng đá">
              </div>
            </div>
          </div>

          <!-- Category Card 2 -->
          <div class="col-md-4">
            <div class="product-card">
              <div class="product-info">
                <h3>CỐC GIỮ NHIỆT</h3>
                <p>Áo thể thao, giày thể thao, tất thể thao,...</p>
                <router-link to="/san-pham" class="btn btn-custom">Mua Ngay</router-link>
              </div>
              <div class="product-image">
                <img
                :src="danhMuc2" :data="danhMuc2"
                alt="Đồ thể thao">
              </div>
            </div>
          </div>

          <!-- Category Card 3 -->
          <div class="col-md-4">
            <div class="product-card">
              <div class="product-info">
                <h3>PHỤ KIỆN THỂ THAO</h3>
                <p>Giày thể thao, băng cổ chân, tất,...</p>
                <router-link to="/san-pham" class="btn btn-custom">Mua Ngay</router-link>
              </div>
              <div class="product-image">
                <img
                :src="danhMuc3" :data="danhMuc3"
                alt="Phụ kiện thể thao">
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- product1 -->
    <section class="section-3 mt-5">
      <div class="container">
        <h2 class="text-left fw-bold">Sản phẩm mới nhất <span><img
              src="https://theadvocatesleague.in/assets/images/new.gif"
              style="width: 100px; height: 30px; object-fit: cover;" alt=""></span> </h2>
        <div class="row justify-content">
          <!-- Sản phẩm 1 -->
          <div class="col-lg-2 col-md-3 col-sm-4 col-6 mt-3" v-for="product in sortedProducts.slice(0, 6)"
            :key="product.id">
            <router-link :to="`/chi-tiet-san-pham/${product.id}`" class="text-decoration-none text-black">
              <div class="card border-0">
                <img :src="`${API_URL}/storage/${product.images.find(img => img.is_primary === 1)?.image_path}`"
                  class="border" alt="MU Home" style="width: 200px" />
                <div class="card-body">
                  <h5 class="card-title text-left">
                    <b style="font-size: 14px">{{ product.name }}</b>
                  </h5>
                  <p class="card-text text-left">
                    <span class="text-danger me-2"><b>{{ formatVND(product.price) }}</b></span>
                    <span v-if="product.sale_price" class="text-decoration-line-through">
                      {{ formatVND(product.sale_price) }}
                    </span>

                  </p>
                </div>
              </div>
            </router-link>
          </div>
          <!-- Thêm sản phẩm khác tương tự -->
        </div>
      </div>
    </section>
    <!-- end -->

    <section class="section awe-section-4 mt-5">
      <div class="section_banner_adv">
        <div class="container">
          <div class="text-center row mb-3">
            <a class="col-12 px-md-0" href="/san-pham" title="Giảm giá cực sốc!">
              <img class="img-fluid lazyload" :src="bannerImage" :data-src="bannerImage" alt="Giảm giá cực sốc" />
            </a>
          </div>
        </div>
      </div>
    </section>

    <!-- product2 -->
    <section class="section-3 mt-5" v-for="category in categories" :key="category.id">
      <div class="container">
        <!-- Hiển thị tên Category -->
        <h2 class="text-left fw-bold">{{ category.name }}</h2>
        <div class="row justify-content">
          <!-- Hiển thị sản phẩm của category -->
          <div class="col-lg-2 col-md-3 col-sm-4 col-6 mt-3" v-for="product in productByCategory[category.id]"
            :key="product.id">
            <a :href="`/chi-tiet-san-pham/${product.id}`" class="text-decoration-none text-black">
              <div class="card border-0">
                <img :src="`${API_URL}/storage/${product.images.find(img => img.is_primary === 1)?.image_path}`"
                  class="border" alt="MU Home" style="width: 200px" />
                <div class="card-body">
                  <div class="rating" style="color: #ffcc00">
                    <i class="far fa-star"></i>
                    <i class="far fa-star"></i>
                    <i class="far fa-star"></i>
                    <i class="far fa-star"></i>
                    <i class="far fa-star"></i>
                  </div>
                  <h5 class="card-title text-left">
                    <b style="font-size: 14px">{{ product.name }}</b>
                  </h5>
                  <p class="card-text text-left">
                    <span class="text-danger me-2"><b>{{ formatVND(product.price) }}</b></span>
                    <span class="text-decoration-line-through">{{ formatVND(product.sale_price) }}</span>
                  </p>
                </div>
              </div>
            </a>
          </div>
        </div>
      </div>
    </section>

    <!-- Section: Tin Tức -->
    <section class="section-news mt-5">
      <div class="container">
        <h2 class="section-title mb-4">Tin Tức Mới Nhất</h2>
        <div class="row">
          <!-- Tin Tức 1 -->
          <div class="col-md-4 mb-4" v-for="post in posts" :key="post.id">
            <div class="news-item">
              <router-link :to="`/chi-tiet-tin-tuc/${post.id}`" class="text-decoration-none">
                <img v-if="post.image" :src="`${API_URL}/storage/${post.image}`" alt="Hình ảnh bài viết"
                  class="img-thumbnail" style="width: 450px; height: 300px " />

                <h4 class="mt-3" style="font-weight: bold; color: black">{{ post.title }}</h4>
                <p class="text-muted " v-html="truncateContent(post.content, 100)"></p>
              </router-link>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Section 6: Banner -->
    <section class="section-6 mt-5">
      <div class="home-two-banner">
        <div class="container">
          <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 content_banner">
              <div class="title_banner">
                <h3>ĐẶT IN ÁO LIÊN HỆ NGAY</h3>
                <span>Khách hàng có nhu cầu IN TÊN SỐ, đặt đội hoặc mua số lượng lớn từ 7 bộ vui lòng
                  inbox để SHOP hỗ trợ với giá tốt nhất cùng nhiều ưu đãi quà tặng đặc biệt</span>
              </div>
              <div class="group-banner">
                <a class="banner-1" href="#" title="ĐẶT IN ÁO LIÊN HỆ NGAY">
                  <img class="img-responsive"
                    src="https://bizweb.dktcdn.net/100/483/998/themes/904984/assets/twobanner_1.png?1722078914172"
                    alt="Hang Thể Thao" style="width: 100%;">
                </a>
                <div class="des">
                  <a href="#" class="lien-he btn btn-danger mb-4 btn-lg" title="Xem thêm">Liên hệ
                    ngay</a>
                  <p>Hỗ trợ, tư vấn ngay qua messenger FB hoặc qua SĐT: 0987654321</p>
                </div>
              </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 content_banner_2">
              <a href="#" title="">
                <img class="img-responsive"
                  src="https://bizweb.dktcdn.net/100/483/998/themes/904984/assets/twobanner_2.png?1722078914172"
                  alt="Hang Thể Thao" style="width: 100%;">
              </a>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>
<script setup>
import { ref, onMounted, computed } from 'vue';
import axios from 'axios';
import bannerImage from '@/components/icons/bannerxx.png';
import slider1Desktop from '@/components/icons/slide_1.png';
import slider2Desktop from '@/components/icons/slide_2.png';
import slider3Desktop from '@/components/icons/slide_3.png';
import slider4Desktop from '@/components/icons/slide_4.png';
import danhMuc1 from '@/components/icons/danhmuc1.png';
import danhMuc2 from '@/components/icons/danhmuc2.png';
import danhMuc3 from '@/components/icons/danhmuc3.png';
import quangCao from '@/components/icons/quangcao.png';
const API_URL = import.meta.env.VITE_API_URL;
const products = ref([]);
const categories = ref([]);
const posts = ref([]);
const productByCategory = ref({});
const showModal = ref(true);


const checkModalStatus = () => {
  const lastCloseTime = localStorage.getItem('modalCloseTime');
  if (lastCloseTime) {
    const currentTime = new Date().getTime();
    const oneHour = 60 * 60 * 1000; 
    if (currentTime - lastCloseTime < oneHour) {
      showModal.value = false; 
    }
  }
};

const closeModal = () => {
  showModal.value = false; 
};
const fetchProducts = async () => {
  try {
    const response = await axios.get(`${API_URL}/api/products`);
    products.value = response.data.map(product => ({
      ...product,
      image: `http://127.0.0.1:8000/${product.images[0]?.image_path}`
    }));
  } catch (error) {
    console.error('Error fetching products:', error);
  }
};

const getProductByCategory = async (categoryId) => {
  try {
    const response = await axios.get(`${API_URL}/api/products/category/${categoryId}`);
    productByCategory.value[categoryId] = response.data.map(product => ({
      ...product,
      image: `http://127.0.0.1:8000/${product.images[0]?.image_path}`
    }));
    console.log(productByCategory.value);
  } catch (error) {
    console.error('Error fetching products by category:', error);
  }
};


const fetchCategories = async () => {
  try {
    const response = await axios.get(`${API_URL}/api/categories`);
    categories.value = response.data;
    categories.value.forEach(category => {
      getProductByCategory(category.id);
    })
  } catch (error) {
    console.error(error);
  }
};

onMounted(() => {
  fetchCategories();
});

onMounted(async () => {
  try {
    const response = await axios.get(`${API_URL}/api/posts`);
    posts.value = response.data.posts;
  } catch (error) {
    console.error('Failed to fetch posts:', error);
  }
});
const cleanContent = (content) => {
  const cleanedContent = content.replace(/<\/?[^>]+(>|$)/g, "");
  return cleanedContent.length > 100 ? cleanedContent.slice(0, 100) + '...' : cleanedContent;
};

const truncateContent = (content) => {
  return cleanContent(content);
};
// Hàm định dạng giá tiền
const formatVND = value => new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(value);


const carouselImages = ref([
  {
    desktop: slider1Desktop,
    mobile: 'https://bizweb.dktcdn.net/100/483/998/themes/904984/assets/silde_m_1.png?1717181462123',
  },
  {
    desktop: slider2Desktop,
    mobile: 'https://bizweb.dktcdn.net/100/483/998/themes/904984/assets/silde_m_2.png?1717181462123',
  },
  {
    desktop: slider3Desktop,
    mobile: 'https://bizweb.dktcdn.net/100/483/998/themes/904984/assets/silde_m_3.png?1717181462123',
  },
  {
    desktop: slider4Desktop,
    mobile: 'https://bizweb.dktcdn.net/100/483/998/themes/904984/assets/silde_m_4.png?1717181462123',
  },
]);

// Kiểm tra kích thước màn hình
const isDesktop = ref(window.innerWidth > 768);

// Cập nhật trạng thái khi thay đổi kích thước màn hình
function updateIsDesktop() {
  isDesktop.value = window.innerWidth > 768;
}

const sortedProducts = computed(() => {
  return products.value.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
});
const closeModalForOneHour = () => {
  const currentTime = new Date().getTime();
  localStorage.setItem('modalCloseTime', currentTime); 
  showModal.value = false; 
  Swal.fire({
    icon: 'info',
    title: 'Thông Báo',
    text: 'Thông báo sẽ không hiển thị lại trong 1 giờ.',
  });
};
onMounted(() => {
  window.addEventListener('resize', updateIsDesktop);
  fetchProducts();
  checkModalStatus();
});


</script>


<style scoped>
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.7);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
}

.modal-content {
    padding: 20px;
    border-radius: 8px;
    text-align: center;
    width: 90%;
    max-width: 500px;
}


.close-btn {
    position: absolute;
    top: 10px;
    right: 10px;
    background: transparent;
    border: none;
    font-size: 24px;
    cursor: pointer;
    width: 35px;
    text-align: center;
    background-color: #fff;
    border-radius: 50%;
}

.close-btn:hover {
    color: #ff0000;
    background-color: #9c9696;
    border-radius: 50%;
    transform: scale(1.1);
}

.star-icon {
  color: gold;
  font-size: 15px;
}

.slider-slide img {
  transition: transform 0.3s ease;
}

.slider-slide:hover img {
  transform: scale(1.1);
}

.card-title {
  transition: color 0.3s ease, transform 0.3s ease;
}

.card-title:hover {
  color: #ff0000;
}

.card img {
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card img:hover {
  transform: scale(1.1);
  box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
}

.card-body h5:hover {
  color: rgb(253, 0, 0);
}

.card-body h5 {
  font-size: 14px;
}

.rating {
  color: gold;
  /* Star color */
}

.news-item h4 {
  color: #000000;
}

.news-item h4 :hover {
  color: #ff0000;
}
</style>
