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
              <router-link to="/san-pham"><b>Sản Phẩm </b></router-link>
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
                  <input type="radio" name="size" :value="sku.size" v-model="selectedSize">
                  <span>{{ sku.size }}</span>
                </label>
              </div>

              <div class="mb-3"><strong>Số lượng trong kho: </strong><b><span class="badge text-bg-danger">{{
                product.quantity }}</span></b>
              </div>
              <div class="mb-3"><strong>Giá sản phẩm: </strong><b><span class="text-danger text-nowrap fs-5">{{
                formatVND(product.price) }}</span></b></div>
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
              <button type="button" @click="addToCart" class="btn btn-danger mt-3">Thêm vào giỏ hàng<font-awesome-icon
                  :icon="['fas', 'cart-plus']" /></button>
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
              <li class="nav-item" style="cursor: pointer;">
                <a class="nav-link" :class="{ active: selectedTab === 'tabs-1' }" @click="preiew('tabs-1')" role="tab">
                  MÔ TẢ
                </a>
              </li>
              <li class="nav-item" style="cursor: pointer;">
                <a class="nav-link" :class="{ active: selectedTab === 'tabs-3' }" @click="preiew('tabs-3')" role="tab">
                  BÌNH LUẬN
                </a>
              </li>
              <li class="nav-item" style="cursor: pointer;">
                <a class="nav-link" :class="{ active: selectedTab === 'tabs-2' }" @click="preiew('tabs-2')" role="tab">
                  ĐÁNH GIÁ
                </a>
              </li>
            </ul>

            <!-- Tab Content -->
            <div class="tab-content">
              <!-- Tab 1: MÔ TẢ -->
              <div v-if="selectedTab === 'tabs-1'" id="tabs-1" class="tab-pane" role="tabpanel">
                <div class="product__details__tab__desc">
                  <h6>MÔ TẢ</h6>
                  <div v-html="product.description"></div>
                </div>
              </div>

              <div v-if="selectedTab === 'tabs-2'" class="tab-content">
                <h3 class="heading">Đánh Giá {{ product.name }}</h3>
                <div class="point">
                  <div class="point-average">
                    <i class="iconcmt-allstar"></i>
                    <div class="point-average-container">
                      <text class="point-average-score">{{ averageRating.toFixed(1) }}</text>
                      <text class="point-average-total">/5</text>
                    </div>
                  </div>

                  <div class="point-satisfied-container">
                    <p class="point-satisfied"><strong>{{ fiveStarPercentage }}% </strong> tổng số khách đánh giá 5 sao
                    </p>
                  </div>
                  <span class="point-alltimerate">{{ totalReviews }} đánh giá cho {{ product.name }}</span>
                </div>

                <ul class="rate-list">
                  <li v-for="(count, index) in ratingDistribution" :key="index">
                    <div class="number-star">
                      {{ 5 - index }}<i class="iconcmt-starfilter-og"></i>
                    </div>
                    <div class="timeline-star">
                      <p class="timing" :style="{ width: `${(count / totalReviews * 100).toFixed()}%` }"></p>
                    </div>
                    ★
                    <span class="number-percent">{{ ((count / totalReviews) * 100).toFixed() }}%</span>
                  </li>
                </ul>

                <!-- Form đánh giá -->
                <div class="review-form-title">

                  <form @submit.prevent="submitReview" class="review-form-container">
                    <div class="review-form">
                      <textarea v-model="reviewText" class="review-textarea"
                        placeholder="Hãy viết đánh giá của bạn..."></textarea>
                      <div v-if="errors.review" class="error-message text-danger">{{ errors.review }}</div>

                      <!-- Chọn sao -->
                      <div class="rating-stars">
                        <label for="rating" class="rating-label">Đánh giá: </label>
                        <div class="stars">
                          <span v-for="star in 5" :key="star" @click="rating = star"
                            :class="{ 'star-filled': star <= rating }" class="star">
                            ★
                          </span>
                        </div>
                      </div>

                      <div v-if="errors.rating" class="error-message text-danger">{{ errors.rating }}</div>

                      <!-- Upload ảnh -->
                      <div class="file-upload">
                        <input type="file" id="review-image" @change="onFileChange" />
                      </div>

                      <!-- Nút gửi đánh giá -->
                      <button class="btn-submit" :disabled="submittingReview">Gửi Đánh Giá</button>
                    </div>
                  </form>
                </div>

                <!-- Danh sách đánh giá -->
                <div class="review-list" id="review-listing">
                  <!-- Nếu có đánh giá -->
                  <div v-if="reviews.length > 0">
                    <!-- Hiển thị 2 đánh giá hữu ích nhất -->
                    <div v-for="review in topHelpfulReviews" :key="review.id" class="review-card">
                      <div class="review-header">
                        <span class="review-username">{{ review.user.username }}</span>
                        <span class="review-rating">
                          <span v-for="star in 5" :key="star"
                            :class="{ 'star-filled': star <= review.rating, 'star-empty': star > review.rating }">
                            ★
                          </span>
                        </span>
                      </div>

                      <p class="review-text">{{ review.review }}</p>
                      <img v-if="review.image_path" :src="`${API_URL}/storage/${review.image_path}`"
                        alt="Hình ảnh đánh giá" class="review-image" />
                      <div class="tiei">
                        <button @click="likeReview(review.id)" class="btn-like">
                          ❤️ Hữu ích ({{ review.likes }})
                        </button>
                        <span class="review-date">{{ formatDate(review.created_at) }}</span>
                      </div>

                      <!-- Hiển thị các phản hồi -->
                      <div v-if="review.replies && review.replies.length > 0" class="review-replies">
                        <div v-for="reply in review.replies" :key="reply.id" class="review-reply">
                          <div class="reply-header">
                            <img src="https://bizweb.dktcdn.net/100/483/998/themes/904984/assets/logo.png?1722078914172"
                              alt="HangSport Avatar" class="reply-avatar" style="width: 20px; height: 20px; border-radius: 50%;" />
                            <span class="reply-username">Phản hồi từ HangSport</span>
                            <span class="reply-date">{{ formatDate(reply.created_at) }}</span>
                          </div>
                          <p class="reply-text">{{ reply.reply }}</p>
                        </div>
                      </div>
                    </div>

                    <button @click="navigateToAllReviews" class="btn-view-all">
                      Xem tất cả đánh giá
                    </button>
                  </div>

                  <!-- Nếu không có đánh giá -->
                  <div v-else class="no-reviews">
                    <p>Chưa có đánh giá cho sản phẩm này.</p>
                  </div>
                </div>
              </div>



                <!-- Tab 3: Bình Luận -->
                <div v-if="selectedTab === 'tabs-3'" id="tabs-3" class="tab-pane" role="tabpanel">
                  <div class="product__details__tab__desc">
                    <h6>BÌNH LUẬN</h6>
                    <h6>Viết bình luận của bạn</h6>

                    <!-- Comment Form -->
                    <form @submit.prevent="submitComment">
                      <div class="form-group">
                        <label for="name">Tên của bạn:</label>
                        <input type="text" id="name" v-model="commentData.name" />
                        <p v-if="errors.name" class="error-message text-danger">{{ errors.name }}</p>
                      </div>

                      <div class="form-group">
                        <label for="comment">Bình luận:</label>
                        <textarea id="comment" v-model="commentData.comment"></textarea>
                        <p v-if="errors.comment" class="error-message text-danger">{{ errors.comment }}</p>
                      </div>

                      <button type="submit" class="btn-comment">Gửi bình luận</button>
                    </form>


                    <!-- Comments List -->
                    <div v-if="comments.length" class="comments-list">
                      <h6>Các bình luận</h6>
                      <div v-for="(comment, idx) in comments" :key="idx" class="comment-item">
                        <p><strong>{{ comment.name }}</strong> <i class="bi bi-check-circle-fill"
                            style="color: blue;"></i></p>
                        <p>{{ comment.comment }}</p>
                      </div>
                    </div>
                    <div v-else>
                      <p>Chưa có bình luận nào.</p>
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
      </div>
    </div>
  </section>

  <!-- end -->
</template>


<script setup>
import { ref, onMounted, computed } from 'vue';
import axios from 'axios';
import swal from 'sweetalert2';
import { format } from 'date-fns';
import { useRoute, useRouter } from 'vue-router';
const selectedTab = ref('tabs-1');
const commentData = ref({
  name: '',
  comment: ''
});
const errors = ref({
  name: '',
  comment: '',
})
const comments = ref([]);
const selectedSize = ref(null);

const reviewText = ref('');
const rating = ref(0);
const imageFile = ref(null);
const reviews = ref({});
const averageRating = ref(0);
const fiveStarPercentage = ref(0);
const ratingDistribution = ref([0, 0, 0, 0, 0]);
const submittingReview = ref(false);
const likedReviews = ref([]);
const formatDate = (date) => {
  return format(new Date(date), 'dd/MM/yyyy');
};
const route = useRoute();
const router = useRouter();
const API_URL = import.meta.env.VITE_API_URL;


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

const fetchProduct = async () => {
  try {
    const response = await axios.get(`${API_URL}/api/products/${route.params.id}`);
    product.value = response.data;
    const primaryImage = product.value.images.find(image => image.is_primary) || product.value.images[0];
    largeImage.value = primaryImage ? primaryImage.image_path : '';
  } catch (error) {
    console.error('Error fetching product:', error);
  }
};

const fetchComments = async () => {
  try {
    const response = await axios.get(`${API_URL}/api/comments/${route.params.id}`);
    comments.value = response.data;
  } catch (error) {
    console.error('Error fetching comments:', error);
  }
};

const validateInput = () => {
  errors.value.name = '';
  errors.value.comment = '';

  const namePattern = /^[\p{L}0-9\s]+$/u;

  if (!commentData.value.name) {
    errors.value.name = 'Tên không được để trống.';
  } else if (!namePattern.test(commentData.value.name)) {
    errors.value.name = 'Tên chỉ được chứa chữ cái, số và khoảng trắng, không có ký tự đặc biệt.';
  }


  if (!commentData.value.comment) {
    errors.value.comment = 'Bình luận không được để trống.';
  }

  return !errors.value.name && !errors.value.comment;
};

const submitComment = async () => {
  if (!validateInput()) {
    return;
  }

  try {
    const userId = localStorage.getItem('user_id');

    if (!userId) {
      swal.fire('Vui lòng đăng nhập để bình luận!', '', 'warning');
      return;
    }

    const payload = {
      name: commentData.value.name,
      comment: commentData.value.comment,
      product_id: route.params.id,
      user_id: userId,
    };

    const response = await axios.post(`${API_URL}/api/comments`, payload);

    if (response.data.success) {
      comments.value.unshift(response.data.comment);
      commentData.value.name = '';
      commentData.value.comment = '';
      swal.fire('Bình luận đã được thêm thành công!', '', 'success');
    }
  } catch (error) {
    console.error('Lỗi khi gửi bình luận:', error);
    swal.fire('Đã xảy ra lỗi khi gửi bình luận!', '', 'error');
  }
};

// Chuyển đổi giá thành VND
const formatVND = (price) => {
  return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(price);
};

const changeImage = (imagePath) => {
  largeImage.value = imagePath;
};

const increaseQuantity = () => {
  quantity.value++;
};

const decreaseQuantity = () => {
  if (quantity.value > 1) {
    quantity.value--;
  }
};

const addToCart = async () => {
  let userId = localStorage.getItem('user_id');
  let guestId = localStorage.getItem('guest_id');

  if (!userId && !guestId) {
    guestId = 'guest_' + Math.random().toString(36).substring(2, 9);
    localStorage.setItem('guest_id', guestId);
  }

  const payload = {
    product_id: route.params.id,
    quantity: quantity.value,
    size: selectedSize.value
  };

  if (userId) {
    payload.user_id = userId;
  } else {
    payload.guest_id = guestId;
  }

  try {
    const response = await axios.post(`${API_URL}/api/cart/add`, payload);

    if (response.data.message === 'Product added to cart successfully') {
      alert('Sản phẩm đã được thêm vào giỏ hàng');
    }
  } catch (error) {
    console.error('Error adding product to cart:', error);
    alert('Có lỗi xảy ra khi thêm sản phẩm vào giỏ hàng');
  }
};

// Khi chọn tab đánh giá
const preiew = (tab) => {
  selectedTab.value = tab;
  loadReviews();
};

// Load product, reviews, and other necessary data
const loadReviews = async () => {
  try {
    const response = await axios.get(`${API_URL}/api/reviews/product/${route.params.id}`);
    reviews.value = response.data;
    calculateRatingStats();
  } catch (error) {
    console.error('Error loading reviews:', error);
  }
};


// Calculate the average rating and five-star percentage
const totalReviews = computed(() => reviews.value.length);

const calculateRatingStats = () => {
  if (reviews.value.length === 0) return;

  let totalRating = 0;
  let fiveStarCount = 0;
  const distribution = [0, 0, 0, 0, 0];

  reviews.value.forEach((review) => {
    totalRating += review.rating;
    if (review.rating === 5) fiveStarCount++;
    distribution[5 - review.rating]++;
  });
  averageRating.value = totalRating / reviews.value.length;
  fiveStarPercentage.value = (fiveStarCount / reviews.value.length) * 100;

  ratingDistribution.value = distribution;
};



const onFileChange = (event) => {
  imageFile.value = event.target.files[0];
};

const submitReview = async () => {
  if (submittingReview.value) return;
  submittingReview.value = true;

  // Validation
  if (!rating.value) {
    errors.value.rating = 'Bạn chưa chọn mức đánh giá.';
    submittingReview.value = false;
    return;
  }
  if (!reviewText.value.trim()) {
    errors.value.review = 'Đánh giá không được để trống.';
    submittingReview.value = false;
    return;
  }

  const formData = new FormData();
  const userId = localStorage.getItem('user_id');
  if (!userId) {
    submittingReview.value = false;
    swal.fire({
      title: 'Lỗi',
      text: 'Vui lòng đăng nhập để gửi đánh giá.',
      icon: 'error',
      confirmButtonText: 'OK',
      timer: 3000

    });
    return;
  }

  formData.append('user_id', userId);
  formData.append('review', reviewText.value);
  formData.append('rating', rating.value);
  if (imageFile.value) formData.append('image_path', imageFile.value);
  formData.append('product_id', route.params.id);

  swal.fire({
    title: 'Đang gửi đánh giá...',
    text: 'Vui lòng đợi...',
    icon: 'info',
    showConfirmButton: false,
    allowOutsideClick: false,
    timer: 3000
  });


  try {
    const response = await axios.post(`${API_URL}/api/reviews`, formData);
    const newReview = response.data.review;

    reviews.value.push(newReview);
    reviews.value = [...reviews.value];

    calculateRatingStats();

    reviewText.value = '';
    rating.value = 0;
    imageFile.value = null;
    submittingReview.value = false;

    swal.fire({
      title: 'Thành công!',
      text: 'Đánh giá của bạn đã được gửi thành công.',
      icon: 'success',
      confirmButtonText: 'OK',
      timer: 3000
    });

    const reviewSection = document.getElementById('review-listing');
    if (reviewSection) {
      reviewSection.scrollIntoView({ behavior: 'smooth' });
    }
  } catch (error) {
    submittingReview.value = false;
    swal.fire({
      title: 'Lỗi',
      text: 'Đã xảy ra lỗi, vui lòng thử lại!',
      icon: 'error',
      confirmButtonText: 'OK'
    });
  }
};

// Xử lý nút thích đánh giá
const likeReview = async (reviewId) => {
  if (likedReviews.value.includes(reviewId)) {
    alert('Bạn đã thích đánh giá này rồi!');
    return;
  }

  try {
    const response = await axios.post(`${API_URL}/api/reviews/${reviewId}/like`);
    const review = reviews.value.find((r) => r.id === reviewId);
    if (review) review.likes = response.data.likes;
    likedReviews.value.push(reviewId);
  } catch (error) {
    console.error('Error liking review:', error);
  }
};

const topHelpfulReviews = computed(() => {
  return reviews.value
    .slice()
    .sort((a, b) => b.likes - a.likes)
    .slice(0, 2);
});

const navigateToAllReviews = () => {
  router.push(`/danh-gia-san-pham/${route.params.id}`);
};

onMounted(() => {
  fetchProduct();
  fetchComments();
  loadReviews();
});

</script>


<style scoped>
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

.card img {
  width: 100%;
  height: auto;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card img:hover {
  transform: scale(1.1);
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
}

.size-options {
  display: flex;
  gap: 10px;
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
  background-color: #ff0000;
  color: #fff;
}

.size-options span:hover {
  border-color: #ff0000;
  background-color: #e6f0ff;
}

.tab-content>.tab-pane {
  display: block;
}

.tab-content>.active {
  display: block;
}


.tab-content {
  padding: 20px;
  background: #f9f9f9;
  border-radius: 10px;
}

.heading {
  font-size: 1.8rem;
  margin-bottom: 20px;
  color: #333;
}

.review-form {
  margin-bottom: 30px;
}

.review-textarea {
  width: 100%;
  padding: 10px;
  border: 1px solid #ddd;
  border-radius: 5px;
  font-size: 1rem;
  margin-bottom: 15px;
}

.rating-stars {
  display: flex;
  align-items: center;
  margin-bottom: 15px;
}

.rating-label {
  margin-right: 10px;
  font-size: 1rem;
}

.stars {
  display: flex;
}

.star {
  font-size: 1.5rem;
  color: #ddd;
  cursor: pointer;
  transition: color 0.3s;
}


.file-upload {
  margin-bottom: 15px;
}

.file-label {
  font-size: 1rem;
  margin-right: 10px;
}

.btn-submit {
  background: #ff0000;
  color: white;
  padding: 10px 20px;
  border: none;
  border-radius: 5px;
  font-size: 1rem;
  cursor: pointer;
  transition: background 0.3s;
}

.btn-submit:disabled {
  background: #f70000;
  cursor: not-allowed;
}

.review-list {
  margin-top: 20px;
}

.review-card {
  background: white;
  padding: 15px;
  border: 1px solid #ddd;
  border-radius: 10px;
  margin-bottom: 15px;
}

.review-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 10px;
}

.review-username {
  font-weight: bold;
}


.review-text {
  font-size: 1rem;
  color: #555;
  margin-bottom: 10px;
}

.review-image {
  max-width: 100px;
  border-radius: 5px;
  object-fit: cover;
  margin-bottom: 10px;
}

.btn-like {
  background: none;
  border: none;
  color: #e74c3c;
  cursor: pointer;
  font-size: 1rem;
  transition: color 0.3s;
}

.btn-like:hover {
  color: #c0392b;
}

.no-reviews {
  text-align: center;
  font-size: 1rem;
  color: #888;
}



.number-star {
  font-weight: bold;
}

.timeline-star {
  flex: 1;
  background-color: #e0e0e0;
  height: 8px;
  border-radius: 4px;
  overflow: hidden;
  position: relative;
}

.timeline-star .timing {
  height: 100%;
  background-color: #ff0000;
}


.tab-content .heading {
  font-size: 1.5rem;
  font-weight: bold;
  margin-bottom: 1rem;
}

.point {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}

.point-average {
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.point-average-score {
  font-size: 2rem;
  font-weight: bold;
  color: #ff0000;
}

.point-average-total {
  font-size: 1.2rem;
  color: #666;
}

.point-satisfied-container {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  font-size: 0.9rem;
}

.point-explain {
  font-size: 0.8rem;
  color: #555;
}

.star-filled {
  color: #ff0000;
  /* Màu vàng cho sao đã đánh */
}

.star-empty {
  color: #ccc;
  /* Màu xám cho sao chưa đánh */
}

.tiei {
  display: flex;
  justify-content: space-between;
  align-items: center;
  width: 100%;
  flex-wrap: wrap;
}

.btn-view-all {
  padding: 10px 20px;
  font-size: 16px;
  font-weight: bold;
  background-color: #ff0000;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s ease, transform 0.2s ease;
}

.btn-view-all:hover {
  background-color: #ff0000;
  transform: translateY(-2px);
}
</style>
