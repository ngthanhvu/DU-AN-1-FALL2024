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
            <li class="home">
              <router-link to="/product"><b>Sản Phẩm </b></router-link>
              <span class="icon-arrow-right text-danger"><font-awesome-icon :icon="['fas', 'arrow-right']" /> </span>
            </li>
            <li><strong><span class="text-danger"> {{ product.name }}</span></strong></li>
          </ul>
        </div>
      </div>
    </div>
  </section>


  <!-- Product Details Section Begin -->
  <section class="product-details">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 col-md-6">
          <div class="product__details__pic">
            <div class="product__details__pic__item">
              <img :src="`${API_URL}/storage/${largeImage}`" class="product__details__pic__item--large"
                :alt="product.name">
            </div>
            <div class="product__details__pic__slider">
              <div v-for="image in product.images" :key="image.id" class="thumbnail"
                :style="{ backgroundImage: `url(${API_URL}/storage/${image.image_path})` }"
                @click="changeImage(image.image_path)"></div>
            </div>
          </div>
        </div>

        <div class="col-lg-6 col-md-6">
          <div class="product__details__text">
            <h3>{{ product.name }}</h3>
            <div class="swatch clearfix mb-3">
              <div class="mb-3"><strong>Hãng: </strong><label for="hang_sp">Đang cập nhật</label></div>
              <div class="header"><strong>Size:</strong></div>
              <div class="size-options">
                <label v-for="sku in product.skus" :key="sku.id">
                  <input type="radio" name="size" :value="sku.size">
                  <span>{{ sku.size }}</span>
                </label>
              </div>

              <div class="mb-3"><strong>Số lượng trong kho: </strong><b><span class="badge text-bg-danger">{{
                    product.quantity }}</span></b>
              </div>
              <div class="mb-3"><strong>Giá sản phẩm: </strong><b><span class="text-danger text-nowrap fs-5">{{
                product.price }}</span></b></div>
            </div>

            <div class="product__details__quantity mb-3">
              <div><strong>Số Lượng:</strong></div>
              <div class="quantity d-flex align-items-center">
                <button class="qty-btn qty-decrease me-2" @click="decreaseQuantity">-</button>
                <input type="text" :value="quantity" class="qty-input text-center" readonly>
                <button class="qty-btn qty-increase ms-2" @click="increaseQuantity">+</button>
              </div>
            </div>

            <div class="mb-3">
              <a href="/cart" class="btn btn-danger mt-3">ADD TO CART</a>
            </div>

            <ul>
              <li><b>Sẵn có:</b> <span>Còn hàng</span></li>
              <li><b>Thời gian giao hàng:</b> <span>2 - 3 ngày. <samp>Giao hàng miễn phí</samp></span></li>
              <li><b>Khối lượng:</b> <span>0.2 kg</span></li>
              <li><b>Share on</b>
                <div class="share">
                  <a href="#"><i class="fab fa-facebook"></i></a>
                  <a href="#"><i class="fab fa-twitter"></i></a>
                  <a href="#"><i class="fab fa-linkedin"></i></a>
                  <a href="#"><i class="fab fa-pinterest-p"></i></a>
                </div>
              </li>
            </ul>
          </div>
        </div>

        <!-- Product Details Section End -->

        <div class="col-lg-12">
          <div class="product__details__tab">
            <!-- Tab Navigation -->
            <ul class="nav nav-tabs" role="tablist">
              <li class="nav-item" v-for="(tab, index) in tabs" :key="index">
                <a :class="['nav-link', { active: selectedTab === tab.id }]" @click="selectedTab = tab.id"
                  href="javascript:void(0)" role="tab" :aria-selected="selectedTab === tab.id ? 'true' : 'false'">
                  {{ tab.name }}
                  <span v-if="tab.count">({{ tab.count }})</span>
                </a>
              </li>
            </ul>

            <!-- Tab Content -->
            <div class="tab-content">
              <div v-for="(tab, index) in tabs" :key="index" :id="tab.id" class="tab-pane" role="tabpanel"
                :class="{ active: selectedTab === tab.id }">
                <div class="product__details__tab__desc">
                  <h6>{{ tab.name }}</h6>
                  <p>{{ tab.content }}</p>

                  <!-- Hiển thị form bình luận khi chọn tab ĐÁNH GIÁ -->
                  <div v-if="tab.id === 'tabs-3'">
                    <h6>Viết bình luận của bạn</h6>
                    <form @submit.prevent="submitComment">
                      <div class="form-group">
                        <label for="name">Tên của bạn:</label>
                        <input type="text" id="name" v-model="commentData.name" required />
                      </div>

                      <div class="form-group">
                        <label for="comment">Bình luận:</label>
                        <textarea id="comment" v-model="commentData.comment" required></textarea>
                      </div>
                      <button type="submit" class="btn-comment">Gửi bình luận</button>
                    </form>

                    <!-- Hiển thị danh sách bình luận -->
                    <div class="comments-list" v-if="comments.length">
                      <h6>Các bình luận</h6>
                      <div v-for="(comment, idx) in comments" :key="idx" class="comment-item">
                        <p><strong>{{ comment.name }}</strong> 🥰 </p>
                        <p>{{ comment.comment }}</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Product new section -->
  <section class="section-3 mt-5">
    <div class="container">
      <h2 class="text-left">Sản phẩm mới nhất</h2>
      <div class="row justify-content">
        <!-- Sản phẩm 1 -->
        <div class="col-lg-2 col-md-3 col-sm-4 col-6 mt-3">
          <a href="/chi-tiet-san-pham" class="text-decoration-none text-black">
            <div class="card border-0">
              <img src="https://bizweb.dktcdn.net/thumb/1024x1024/100/483/998/products/9b098813-1-1722496273940.jpg"
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
                  <b style="font-size: 14px">MU Home (2012/2013) Màu đỏ + Cộc tay | Bản CLASSIC [Không có quần]</b>
                </h5>
                <p class="card-text text-left">
                  <span class="text-danger me-2"><b>250.000đ</b></span>
                  <span class="text-decoration-line-through">300.000đ</span>
                </p>
              </div>
            </div>
          </a>
        </div>

        <!-- Sản phẩm 2 -->


        <!-- Thêm sản phẩm khác tương tự -->
      </div>
    </div>
  </section>

  <!-- end -->
</template>


<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useRoute } from 'vue-router';

const route = useRoute();
const API_URL = 'http://127.0.0.1:8000';

const product = ref({
  name: '',
  description: '',
  price: '',
  quantity: 0,
  category: null,
  skus: [],
  images: []
});

const largeImage = ref('');
const quantity = ref(1);

// Lấy sản phẩm theo ID
const fetchProduct = async () => {
  try {
    const response = await axios.get(`${API_URL}/api/products/${route.params.id}`);
    product.value = response.data;

    // Tìm ảnh chính hoặc ảnh đầu tiên
    const primaryImage = product.value.images.find(image => image.is_primary) || product.value.images[0];
    largeImage.value = primaryImage ? primaryImage.image_path : '';
  } catch (error) {
    console.error('Error fetching product:', error);
  }
};

// Chuyển đổi giá thành VND
const formatVND = (price) => {
  return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(price);
};

// Thay đổi ảnh lớn
const changeImage = (imagePath) => {
  largeImage.value = imagePath;
};

// Quản lý số lượng sản phẩm
const increaseQuantity = () => {
  quantity.value++;
};

const decreaseQuantity = () => {
  if (quantity.value > 1) {
    quantity.value--;
  }
};
onMounted(() => {
  fetchProduct();
});
</script>


<style scoped>
.product__details__pic__item--large {
  width: 100%;
  height: 600px;
  object-fit: cover;
}

.product__details__pic__slider .thumbnail {
  width: 60px;
  height: 60px;
  background-size: cover;
  background-position: center;
  cursor: pointer;
}

.product__details__pic__slider .thumbnail:hover {
  border: 2px solid #c8f3a2;
}

.product__details__pic__slider {
  display: flex;
  justify-content: space-between;
  overflow-x: auto;
  gap: 10px;
}

.product__details__pic__slider .thumbnail {
  width: 150px;
  height: 130px;
  background-size: cover;
  background-position: center;
  object-fit: cover;
  border: 1px solid #ddd;
  cursor: pointer;
}

.product__details__pic__slider .thumbnail:hover {
  border-color: #f56363;
}

.product__details__quantity {
  display: flex;
  align-items: center;
  gap: 10px;
}

.quantity {
  display: flex;
  align-items: center;
}

.qty-btn {
  width: 30px;
  height: 39zpx;
  font-size: 18px;
  background-color: #f5f5f5;
  border: 1px solid #ccc;
  text-align: center;
  cursor: pointer;
}

.qty-input {
  width: 50px;
  text-align: center;
  margin: 0 5px;
  border: 1px solid #ccc;
  padding: 5px;
  font-size: 16px;
  background-color: #fff;
}

.qty-btn:hover {
  background-color: #e0e0e0;
}

.product-details {
  margin: -65px 0 auto;
}

.btn-comment {
  background-color: #ff0000;
  color: #fff;
  padding: 10px 15px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

.btn-comment:hover {
  background-color: #e60000;
}

/* Hiệu ứng hover cho ảnh sản phẩm */
.card img {
  width: 100%;
  height: auto;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

/* Khi hover, ảnh sẽ phóng to */
.card img:hover {
  transform: scale(1.1);
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
}

.size-options {
  display: flex;
  gap: 10px;
  /* Khoảng cách giữa các nút */
}

.size-options label {
  position: relative;
  display: inline-flex;
  align-items: center;
  cursor: pointer;
}

.size-options input[type="radio"] {
  display: none;
}

.size-options span {
  display: inline-block;
  padding: 8px 16px;
  border: 2px solid #ccc;
  border-radius: 5px;
  background-color: #f9f9f9;
  font-size: 14px;
  font-weight: bold;
  color: #333;
  transition: all 0.3s ease;
}

.size-options input[type="radio"]:checked+span {
  border-color: #ff0000;
  /* Màu viền khi được chọn */
  background-color: #ff0000;
  /* Màu nền khi được chọn */
  color: #fff;
  /* Màu chữ khi được chọn */
}

.size-options span:hover {
  border-color: #ff0000;
  background-color: #e6f0ff;
}
</style>
