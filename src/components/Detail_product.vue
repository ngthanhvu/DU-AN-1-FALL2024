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
            <li><strong><span class="text-danger"> Áo Khoác Thể Thao</span></strong></li>
          </ul>
        </div>
      </div>
    </div>
  </section>
  <!-- Product Details Section Begin -->
  <section class="product-details ">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 col-md-6">
          <div class="product__details__pic">
            <div class="product__details__pic__item">
              <img :src="largeImage" class="product__details__pic__item--large" alt="">
            </div>
            <div class="product__details__pic__slider">
              <div class="thumbnail" v-for="(image, index) in thumbnails" :key="index"
                :style="{ backgroundImage: `url(${image})` }" @click="changeImage(image)">
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-6 col-md-6">
          <div class="product__details__text">
            <h3>Áo Khoác Thể Thao</h3>
            <div class="swatch clearfix mb-3" data-option-index="0">
              <div class="mb-3"><strong>Hãng: </strong>
                <label for="hang_sp">Đang cập nhập</label>
              </div>
              <div class="header"><strong>Size:</strong></div>

              <div v-for="size in sizes" :key="size" :data-value="size"
                :class="['swatch-element', size, { available: selectedSize !== size }]">
                <input type="radio" :id="'swatch-0-' + size" name="option-0" :value="size" v-model="selectedSize"
                  :disabled="false" />
                <label :for="'swatch-0-' + size">{{ size }}</label>
              </div>
              <div class="mb-3"><strong>Số lượng trong kho: </strong>
                <label for="sl_kho"> <b> <span class="badge text-bg-danger"> 0 </span> </b></label>
              </div>

              <div class="mb-3"><strong>Giá sản phẩm: </strong>
                <label for="sl_kho"> <b> <span class="text-danger text-nowrap fs-5"> 257.000đ
                    </span></b></label>
              </div>
            </div>

            <div class="product__details__quantity mb-3">
              <div><strong>Số Lượng:</strong></div>
              <div class="quantity d-flex align-items-center">
                <button @click="decreaseQuantity" class="qty-btn qty-decrease me-2">-</button>
                <input type="text" :value="quantity" class="qty-input text-center" readonly>
                <button @click="increaseQuantity" class="qty-btn qty-increase ms-2">+</button>
              </div>
            </div>
            <div class="mb-3">
              <router-link to="/cart" class="btn btn-danger mt-3">ADD TO CARD <font-awesome-icon
                  :icon="['fas', 'cart-plus']" /> </router-link>
            </div>

            <ul>
              <li><b>Sẵn có: </b> <span>Còn hàng</span></li>
              <li><b>Thời gian giao hàng:</b> <span> 2 - 3 ngày. <samp>Giao hàng miễn phí</samp></span>
              </li>
              <li><b>Khối Lượng: </b> <span>0.2 kg</span></li>
              <li><b>Share on</b>
                <div class="share">
                  <a href="#"><font-awesome-icon :icon="['fab', 'facebook']" /></a>
                  <a href="#"><font-awesome-icon :icon="['fab', 'twitter']" /></a>
                  <a href="#"><font-awesome-icon :icon="['fab', 'linkedin']" /></a>
                  <a href="#"><font-awesome-icon :icon="['fab', 'pinterest-p']" /></a>
                </div>
              </li>
            </ul>
          </div>
        </div>

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
  <!-- Product Details Section End -->

  <!-- Product Slider Section Begin -->
  <section class="section-3 mt-5">
    <div class="container">
      <div class="heading-container">
        <h2>Cháy cùng Euro/Copa</h2>
        <router-link to="/san-pham" class="text-decoration-none text-black"><b>Xem thêm</b></router-link>
      </div>
      <div class="slider-container">
        <!-- Product Cards -->
        <div class="slider" :style="{ transform: 'translateX(' + (-currentSlide * 20) + '%)' }">
          <div class="slide" v-for="(item, index) in products" :key="index">
            <a href="/chi-tiet-san-pham" class="text-decoration-none text-black">
              <div class="card border-0 py-5">
                <img :src="item.image" class="border" alt="Product Image" />
                <div class="card-body">
                  <div class="rating">
                    <font-awesome-icon :icon="['far', 'star']" class="star-icon" v-for="i in 5" :key="i" />
                  </div>
                  <p class="card-title text-left">
                    <b>{{ item.name }}</b>
                  </p>
                  <p class="card-text text-left">
                    <span class="text-danger me-2"><b>{{ item.price }}</b></span>
                    <span class="text-decoration-line-through">{{ item.oldPrice }}</span>
                  </p>
                </div>
              </div>
            </a>
          </div>
        </div>
        <button @click="prevSlide" class="prev-button"><font-awesome-icon :icon="['fas', 'arrow-left']" /></button>
        <button @click="nextSlide" class="next-button"><font-awesome-icon :icon="['fas', 'arrow-right']" /></button>
      </div>
    </div>
  </section>
  <!-- Product Slider Section End -->
</template>

<script>
export default {
  name: 'DetailProduct',
  data() {
    return {
      largeImage: 'https://bizweb.dktcdn.net/thumb/1024x1024/100/483/998/products/photo-2024-09-11-22-53-27.jpg?v=1726070059660',
      thumbnails: [
        'https://bizweb.dktcdn.net/thumb/1024x1024/100/483/998/products/photo-2024-09-11-22-53-27.jpg?v=1726070059660',
        'https://bizweb.dktcdn.net/thumb/1024x1024/100/483/998/products/photo-2024-09-11-22-53-28.jpg?v=1726070063893',
        'https://bizweb.dktcdn.net/thumb/compact/100/483/998/products/photo-2024-09-11-22-53-29-2.jpg?v=1726070065717',
        'https://bizweb.dktcdn.net/thumb/1024x1024/100/483/998/products/photo-2024-09-11-22-53-31-2.jpg?v=1726070069620'
      ],
      quantity: 1,
      selectedSize: 'S',
      sizes: ['S', 'M', 'L', 'XL', 'XXL'],
      selectedTab: 'tabs-1',
      tabs: [
        { id: 'tabs-1', name: 'MÔ TẢ', content: 'Nội dung mô tả sản phẩm tại đây.' },
        { id: 'tabs-2', name: 'XUẤT XỨ', content: 'Nội dung thông tin sản phẩm tại đây.' },
        { id: 'tabs-3', name: 'BÌNH LUẬN', content: '' },
      ],
      commentData: {
        name: '',
        email: '',
        rating: '5',
        comment: ''
      },
      comments: [],
      currentSlide: 0,
      products: [
        {
          name: 'MU Home (2012/2013) Màu đỏ + Cộc tay | Bản CLASSIC [Không có quần]',
          price: '250.000đ',
          oldPrice: '300.000đ',
          image: 'https://bizweb.dktcdn.net/thumb/1024x1024/100/483/998/products/9b098813-1-1722496273940.jpg'
        },
        {
          name: 'Product 2',
          price: '200.000đ',
          oldPrice: '250.000đ',
          image: 'https://via.placeholder.com/150'
        },
        {
          name: 'Product 3',
          price: '150.000đ',
          oldPrice: '200.000đ',
          image: 'https://via.placeholder.com/150'
        },
        {
          name: 'Product 4',
          price: '300.000đ',
          oldPrice: '350.000đ',
          image: 'https://via.placeholder.com/150'
        },
        {
          name: 'Product 5',
          price: '100.000đ',
          oldPrice: '150.000đ',
          image: 'https://via.placeholder.com/150'
        },
        {
          name: 'Product 5',
          price: '100.000đ',
          oldPrice: '150.000đ',
          image: 'https://via.placeholder.com/150'
        }, {
          name: 'Product 5',
          price: '100.000đ',
          oldPrice: '150.000đ',
          image: 'https://via.placeholder.com/150'
        }, {
          name: 'Product 5',
          price: '100.000đ',
          oldPrice: '150.000đ',
          image: 'https://via.placeholder.com/150'
        },
      ]
    };
  },
  computed: {
    currentSlideProducts() {
      const perPage = 5;
      const start = this.currentIndex * perPage;
      return this.products.slice(start, start + perPage);
    }
  },
  methods: {
    changeImage(image) {
      this.largeImage = image;
    },
    increaseQuantity() {
      this.quantity++;
    },
    nextSlide() {
      if (this.currentSlide < this.products.length - 5) {
        this.currentSlide++;
      } else {
        this.currentSlide = 0;
      }
    },
    prevSlide() {
      if (this.currentSlide > 0) {
        this.currentSlide--;
      }
    },
    submitComment() {
      this.comments.push({ ...this.commentData });
      // Xóa dữ liệu trong form sau khi gửi
      this.commentData = {
        name: '',
        email: '',
        rating: '5',
        comment: ''
      }
    }
  }
};

</script>

<style scoped>
.slider-slide {
  width: 100%;
  /* Mỗi slide chiếm 100% chiều rộng */
}

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

.swatch-element {
  display: inline-block;
  margin: 15px;
}

.swatch-element input[type="radio"] {
  display: none;
}

.swatch-element label {
  cursor: pointer;
  padding: 8px 20px;
  background-color: #ffffff;
  border-radius: 5px;
}

.swatch-element input[type="radio"]:checked+label {
  background-color: #ed1010;
  color: white;
}

.swatch-element.available label {
  background-color: #f0f0f0;
}

.swatch-element input[type="radio"]:disabled+label {
  background-color: #ddd;
  cursor: not-allowed;
}

.prev-button,
.next-button {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  background-color: rgba(0, 0, 0, 0.5);
  color: white;
  padding: 10px 12px;
  cursor: pointer;
  border: none;
  border-radius: 50%;
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
</style>
