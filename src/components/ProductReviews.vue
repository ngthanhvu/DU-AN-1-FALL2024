<template>
    <section class="product-reviews-section">
        <!-- Breadcrumb Section -->
        <section class="breadcrumb-section shop1 text-center mb-4">
            <span class="crumb-border"></span>
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <ul class="breadcrumb">
                            <li class="home">
                                <router-link to="/"><b>Trang chủ </b></router-link>
                                <span class="icon-arrow-right text-danger">
                                    <font-awesome-icon :icon="['fas', 'arrow-right']" />
                                </span>
                            </li>
                            <li class="home">
                                <router-link to="/san-pham"><b>Sản Phẩm </b></router-link>
                                <span class="icon-arrow-right text-danger">
                                    <font-awesome-icon :icon="['fas', 'arrow-right']" />
                                </span>
                            </li>
                            <li>
                                <strong><span class="text-danger">Đánh giá</span></strong>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <div class="container" style="margin-top: 50px">
            <h3 class="heading" v-if="product">Đánh giá {{ product.name }}</h3>

            <!-- Đánh giá trung bình và số lượng -->
            <div class="point" v-if="product">
                <div class="point-average">
                    <i class="iconcmt-allstar"></i>
                    <div class="point-average-container">
                        <text class="point-average-score">★ {{ averageRating.toFixed(1) }}</text>
                        <text class="point-average-total">/5</text>
                    </div>
                </div>

                <div class="point-satisfied-container">
                    <p class="point-satisfied"><strong>{{ fiveStarPercentage }}% </strong> tổng số khách đánh giá 5 ★
                    </p>
                </div>
                <span class="point-alltimerate">{{ totalReviews }} đánh giá cho {{ product.name }}</span>
            </div>

            <!-- Lọc và phân loại đánh giá -->
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

            <div class="product-reviews">
                <h1 v-if="product">Đánh giá cho {{ product.name }}</h1>
                <div class="container" style="margin-top: 20px">
                    <div class="filter-sort-container">
                        <span class="tie"><strong>Sắp Xếp: </strong></span>
                        <select v-model="sortOrder" class="form-control">
                            <option value="desc">Mới nhất</option>
                            <option value="asc">Cũ nhất</option>
                            <option value="rating-desc">Sao cao nhất</option>
                            <option value="rating-asc">Sao thấp nhất</option>
                            <option value="likes-desc">Hữu ích nhất</option>
                        </select>
                    </div>
                </div>

                <div v-if="filteredReviews.length > 0">
                    <div v-for="review in currentPageReviews" :key="review.id" class="review-card">
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

                        <!-- Hiển thị các phản hồi -->
                        <div v-if="review.replies && review.replies.length > 0" class="review-replies">
                            <div v-for="reply in review.replies" :key="reply.id" class="review-reply">
                                <p class="replies-heading">
                                    <img src="https://bizweb.dktcdn.net/100/483/998/themes/904984/assets/logo.png?1722078914172"
                                        alt="HangSport Avatar" class="reply-avatar" />
                                    Phản hồi từ HangSport
                                    <span class="reply-date">{{ formatDate(reply.created_at) }}</span>
                                </p>
                                <div class="reply-header">
                                    <span class="reply-text">{{ reply.reply }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="review-divider">
                            <button @click="likeReview(review.id)" class="btn-like">
                                ❤️ Hữu ích ({{ review.likes }})
                            </button>
                            <span class="review-date">{{ formatDate(review.created_at) }}</span>
                        </div>
                    </div>
                </div>

                <div v-if="filteredReviews.length === 0">
                    <p>Không có đánh giá với số sao này.</p>
                </div>


                <!-- Phân trang -->
                <div class="pagination-container">
                    <button @click="goToPage(currentPage - 1)" :disabled="currentPage === 1">Trang trước</button>
                    <span>{{ currentPage }} / {{ totalPages }}</span>
                    <button @click="goToPage(currentPage + 1)" :disabled="currentPage === totalPages">Trang sau</button>
                </div>
            </div>
        </div>
    </section>
</template>


<script setup>
import { ref, onMounted, computed, watch } from 'vue';
import { useRoute } from 'vue-router';
import axios from 'axios';
import { format } from 'date-fns';
import Swal from 'sweetalert2';

const reviews = ref([]);
const route = useRoute();
const likedReviews = ref([]);
const averageRating = ref(0);
const fiveStarPercentage = ref(0);
const ratingDistribution = ref([0, 0, 0, 0, 0]);
const selectedRating = ref(0);
const sortOrder = ref('desc');
const product = ref(null);

const currentPage = ref(1);
const itemsPerPage = 5;

const API_URL = import.meta.env.VITE_API_URL;

const filteredReviews = computed(() => {
    let reviewsFiltered = reviews.value;

    if (selectedRating.value > 0) {
        reviewsFiltered = reviewsFiltered.filter(review => review.rating === selectedRating.value);
    }

    reviewsFiltered = reviewsFiltered.sort((a, b) => {
        switch (sortOrder.value) {
            case 'desc':
                return new Date(b.created_at) - new Date(a.created_at);
            case 'asc':
                return new Date(a.created_at) - new Date(b.created_at);
            case 'rating-desc':
                return b.rating - a.rating;
            case 'rating-asc':
                return a.rating - b.rating;
            case 'likes-desc':
                return b.likes - a.likes;
            default:
                return 0;
        }
    });

    return reviewsFiltered;
});

const totalReviews = computed(() => reviews.value.length);

const totalPages = computed(() => Math.ceil(filteredReviews.value.length / itemsPerPage));

const currentPageReviews = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage;
    const end = currentPage.value * itemsPerPage;
    return filteredReviews.value.slice(start, end);
});

const loadAllReviews = async () => {
    try {
        const params = selectedRating.value > 0 ? { rating: selectedRating.value } : {};
        const response = await axios.get(`${API_URL}/api/reviews/product/${route.params.id}`, { params });
        reviews.value = response.data;
        calculateRatingStats();
    } catch (error) {
        console.error('Error loading reviews:', error);
    }
};


const likeReview = async (reviewId) => {
    if (likedReviews.value.includes(reviewId)) {
        // alert('Bạn đã thích đánh giá này rồi!');
        Swal.fire('Lỗi', 'Bản đánh giá này rồi!', 'error');
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

const calculateRatingStats = () => {
    if (reviews.value.length === 0) return;

    let totalRating = 0;
    let fiveStarCount = 0;
    const distribution = [0, 0, 0, 0, 0]; // Index 0: 5 sao, Index 4: 1 sao

    reviews.value.forEach((review) => {
        totalRating += review.rating;
        if (review.rating === 5) fiveStarCount++;
        distribution[5 - review.rating]++; // Đếm ngược từ 5 sao đến 1 sao
    });

    averageRating.value = totalRating / reviews.value.length;
    fiveStarPercentage.value = (fiveStarCount / reviews.value.length) * 100;

    ratingDistribution.value = distribution; // Đã sẵn thứ tự từ 5 sao đến 1 sao
};



// Format date
const formatDate = (date) => {
    return format(new Date(date), 'dd/MM/yyyy');
};

// Load product details
const loadProduct = async () => {
    try {
        const response = await axios.get(`${API_URL}/api/products/${route.params.id}`);
        product.value = response.data;
    } catch (error) {
        console.error('Error loading product:', error);
    }
};

// Watch for changes in rating filter
watch(selectedRating, () => {
    loadAllReviews();
});

// Load data when component is mounted
onMounted(() => {
    loadAllReviews();
    loadProduct();
});

// Handle page change
const goToPage = (page) => {
    if (page < 1 || page > totalPages.value) return;
    currentPage.value = page;
};
</script>



<style scoped>
.review-divider {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
    flex-wrap: wrap;
}

.filter-sort-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 15px;
    margin-top: 20px;
}

.form-control {
    width: 200px;
    padding: 8px 12px;
    font-size: 14px;
    border-radius: 5px;
    border: 1px solid #ccc;
    background-color: #f9f9f9;
    transition: border-color 0.3s ease, background-color 0.3s ease;
}

.form-control:focus {
    border-color: #ff5733;
    background-color: #fff;
}

.form-control option {
    font-size: 14px;
}

.product-reviews {
    display: flex;
    flex-direction: column;
    gap: 20px;
    /* Khoảng cách giữa các phần tử */
}

.filter-sort-container {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    gap: 10px;
}

.filter-sort-container select {
    padding: 8px 12px;
    font-size: 14px;
    border-radius: 5px;
    border: 1px solid #ccc;
    background-color: #f9f9f9;
    transition: border-color 0.3s ease, background-color 0.3s ease;
}

.filter-sort-container select:focus {
    border-color: #ff5733;
    background-color: #fff;
}

.heading {
    flex: 1;
    margin-bottom: 0;
}

.review-card {
    margin-bottom: 20px;
}

.review-divider {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
    flex-wrap: wrap;
}

.review-date {
    font-size: 12px;
    color: #888;
}

.pagination-container {
    display: flex;
    justify-content: center;
    margin-top: 20px;
}

.pagination-container button {
    padding: 8px 16px;
    margin: 0 10px;
    border: 1px solid #ccc;
    background-color: #f9f9f9;
    cursor: pointer;
}

.pagination-container button:disabled {
    background-color: #e0e0e0;
    cursor: not-allowed;
}

.pagination-container span {
    margin: 0 10px;
    align-self: center;
}

.review-replies {
    margin-top: 20px;
    padding: 10px 20px;
    background-color: rgba(0, 0, 0, 0.05);
    /* Màu xám mờ */
    border-left: 2px solid #f1f1f1;
    border-radius: 8px;
    background-size: cover;
    /* Lấp đầy toàn bộ khu vực */
    background-position: center;
}

.replies-heading {
    font-weight: bold;
    margin-bottom: 10px;
    color: #333;
}

.review-reply {
    margin-bottom: 15px;
    padding: 10px;
    background-color: rgba(255, 255, 255, 0.8);
    border-radius: 5px;
}

.reply-header {
    font-size: 0.9rem;
    font-weight: bold;
    color: #333;
    display: flex;
    align-items: center;
}

.reply-text {
    font-size: 1rem;
    color: #555;
    margin-top: 5px;
}

.reply-date {
    font-size: 0.8rem;
    color: #999;
    margin-top: 5px;
}
</style>