<template>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4" style="margin-top: 80px">
                <h2 class="mt-4 fw-bold">Quản lý Đánh giá</h2>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <select v-model="selectedCategory" class="form-select" @change="filterReviews">
                            <option value="">Tất cả danh mục</option>
                            <option v-for="category in categories" :key="category.id" :value="category.id">
                                {{ category.name }}
                            </option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <select v-model="selectedProduct" class="form-select" @change="filterReviews">
                            <option value="">Tất cả sản phẩm</option>
                            <option v-for="product in products" :key="product.id" :value="product.id">
                                {{ product.name }}
                            </option>
                        </select>
                    </div>
                </div>

                <!-- Bảng đánh giá -->
                <table>
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Người dùng</th>
                            <th>Sản phẩm</th>
                            <th>Đánh giá</th>
                            <th>Bình luận</th>
                            <th>Hình ảnh</th>
                            <th>Phản hồi</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="review in reviews" :key="review.id">
                            <td>{{ review.id }}</td>
                            <td>{{ review.user.username }}</td>
                            <td>{{ review.product.name }}</td>
                            <td>{{ review.rating }} sao</td>
                            <td>{{ review.review }}</td>
                            <td>
                                <template v-if="review.image_path">
                                    <img :src="`${API_URL}/storage/${review.image_path}`" alt="Hình ảnh đánh giá"
                                        class="review-image" />
                                </template>
                                <template v-else>
                                    Không có hình ảnh cho đánh giá này
                                </template>
                            </td>
                            <td>
                                <div v-if="activeReviewId === review.id" class="reply-form">
                                    <textarea v-model="replyText" rows="3" placeholder="Nhập phản hồi..."
                                        class="form-control"></textarea>
                                    <button class="btn btn-success mt-2" @click="submitReply(review.id)">Gửi</button>
                                    <button class="btn btn-secondary mt-2" @click="cancelReply">Hủy</button>
                                </div>
                                <div v-if="review.replies.length > 0" class="replies-section">
                                    <div v-for="reply in review.replies" :key="reply.id" class="reply-item">
                                        <strong>{{ reply.user.username }}:</strong>
                                        <span v-if="editingReplyId !== reply.id">{{ reply.reply }}</span>
                                        <textarea v-else v-model="replyText" rows="3"
                                            class="form-control">{{ reply.reply }}</textarea>
                                        <button v-if="editingReplyId !== reply.id" @click="editReply(reply.id)"
                                            class="btn btn-success">
                                            <font-awesome-icon :icon="['far', 'pen-to-square']" />
                                        </button>
                                        <button v-if="editingReplyId === reply.id" @click="submitEditedReply(reply.id)"
                                            class="btn btn-success">Cập
                                            nhật</button>
                                        <button v-if="editingReplyId === reply.id" @click="cancelEdit"
                                            class="btn btn-danger">Hủy</button>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                <button class="btn btn-danger me-2" @click="deleteReview(review.id)">
                                    <font-awesome-icon :icon="['fas', 'trash']" />
                                </button>
                                <button class="btn btn-primary me-2" @click="replyToReview(review.id)">
                                    <font-awesome-icon :icon="['fas', 'pen']" />
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <!-- Phân trang -->
                <div class="pagination">
                    <button @click="goToPage(currentPage - 1)" :disabled="currentPage === 1">Trang trước</button>
                    <button v-for="page in totalPages" :key="page" @click="goToPage(page)"
                        :class="{ active: page === currentPage }">
                        {{ page }}
                    </button>
                    <button @click="goToPage(currentPage + 1)" :disabled="currentPage === totalPages">Trang sau</button>
                </div>
            </div>
        </main>
        <div style="height: 50vh"></div>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import Swal from "sweetalert2";

const API_URL = import.meta.env.VITE_API_URL;

const reviews = ref([]);
const categories = ref([]);
const products = ref([]);
const selectedCategory = ref("");
const selectedProduct = ref("");
const activeReviewId = ref(null);
const editingReplyId = ref(null);
const replyText = ref("");

const currentPage = ref(1);
const totalPages = ref(1);
const totalItems = ref(0);

const fetchReviews = async () => {
    try {
        const response = await axios.get(`${API_URL}/api/reviews/filter`, {
            params: {
                category_id: selectedCategory.value || null,
                product_id: selectedProduct.value || null,
                page: currentPage.value,
            }
        });

        reviews.value = response.data.data;
        totalItems.value = response.data.total;
        totalPages.value = response.data.last_page;
    } catch (error) {
        console.error("Error fetching reviews:", error);
    }
};

const fetchCategories = async () => {
    try {
        const response = await axios.get(`${API_URL}/api/categories`);
        categories.value = response.data;
    } catch (error) {
        console.error("Error fetching categories:", error);
    }
};

const fetchProducts = async () => {
    try {
        const response = await axios.get(`${API_URL}/api/products`);
        products.value = response.data;
    } catch (error) {
        console.error("Error fetching products:", error);
    }
};

const filterReviews = () => {
    currentPage.value = 1;
    fetchReviews();
};

const goToPage = (page) => {
    if (page >= 1 && page <= totalPages.value) {
        currentPage.value = page;
        fetchReviews();
    }
};

const deleteReview = async (reviewId) => {
    const result = await Swal.fire({
        title: 'Bạn có chắc muốn xóa đánh giá này không?',
        text: "Việc này sẽ không thể khôi phục lại.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Xóa',
        cancelButtonText: 'Hủy',
        reverseButtons: true
    });

    if (result.isConfirmed) {
        try {
            const response = await axios.delete(`${API_URL}/api/reviews/${reviewId}`);
            Swal.fire('Đã xóa!', 'Đánh giá đã được xóa thành công.', 'success');
            fetchReviews();
        } catch (error) {
            Swal.fire('Có lỗi xảy ra!', 'Không thể xóa đánh giá này.', 'error');
            console.error("Error deleting review:", error);
        }
    }
};


const submitEditedReply = async (replyId) => {
    if (!replyText.value.trim()) {
        Swal.fire("Vui lọc nhập nội dung phản hồi!", "", "warning");
        return;
    }

    const userId = localStorage.getItem("user_id");
    const userRole = localStorage.getItem("role");

    if (!userId) {
        Swal.fire("Vui lòng đăng nhập!", "", "warning");
        return;
    }

    if (userRole !== 'admin') {
        Swal.fire("Bạn không có quyền cập nhật phản hồi!", "", "warning");
        return;
    }

    try {
        await axios.put(`${API_URL}/api/reviews/replies/${replyId}`, {
            reply: replyText.value,
            user_id: userId,
        });
        Swal.fire("Phản hồi đã được cập nhật!", "", "success");
        editingReplyId.value = null;
        fetchReviews();
    } catch (error) {
        console.error("Error updating reply:", error);
        alert("Có lỗi xảy ra, vui lòng thử lại.");
    }
};
const cancelEdit = () => {
    editingReplyId.value = null;
    replyText.value = "";
};
const editReply = (replyId) => {
    editingReplyId.value = replyId;
    const reply = reviews.value
        .flatMap(review => review.replies)
        .find(reply => reply.id === replyId);
    replyText.value = reply.reply;
};

const replyToReview = (id) => {
    activeReviewId.value = id;
    replyText.value = "";
};

const cancelReply = () => {
    activeReviewId.value = null;
    replyText.value = "";
};

const submitReply = async (reviewId) => {
    if (!replyText.value.trim()) {
        Swal.fire("Vui lòng nhập nội dung phản hồi!", "", "warning");
        return;
    }

    const userId = localStorage.getItem("user_id");

    if (!userId) {
        Swal.fire("Vui lòng đăng nhập đăng nhập!", "", "warning");
        return;
    }

    const review = reviews.value.find(r => r.id === reviewId);
    if (review && review.replies.length > 0) {
        Swal.fire("Mỗi đánh giá chỉ có một phản hồi!", "", "warning");
        return;
    }

    try {
        await axios.post(`${API_URL}/api/reviews/${reviewId}/reply`, {
            reply: replyText.value,
            user_id: userId,
        });
        Swal.fire("Phản hồi được thêm!", "", "success");
        cancelReply();
        fetchReviews();
    } catch (error) {
        console.error("Error submitting reply:", error);
        alert("Có lỗi xảy ra, vui lòng thử lại.");
    }
};

onMounted(() => {
    fetchCategories();
    fetchProducts();
    fetchReviews();
});
</script>

<style scoped>
.reviews {
    padding: 20px;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

thead {
    background-color: #f4f4f4;
}

th,
td {
    border: 1px solid #ddd;
    padding: 10px;
    text-align: left;
}

th {
    font-weight: bold;
}

img {
    max-width: 100px;
    height: auto;
    display: block;
}

ul {
    list-style: none;
    padding: 0;
}

li {
    margin-bottom: 5px;
}

.reply-item {
    display: flex;
    justify-content: space-between;
    border: 1px solid #ddd;
    padding: 10px;
    margin-bottom: 10px;
    background-color: #f9f9f9;
}

.pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 20px;
}

.pagination button {
    padding: 8px 15px;
    margin: 0 5px;
    border: 1px solid #007bff;
    background-color: #ffffff;
    color: #007bff;
    cursor: pointer;
    font-size: 16px;
    border-radius: 5px;
    transition: background-color 0.3s ease, color 0.3s ease;
}

.pagination button:hover {
    background-color: #007bff;
    color: white;
}

.pagination button.active {
    background-color: #007bff;
    color: white;
    font-weight: bold;
}

.pagination button:disabled {
    background-color: #e0e0e0;
    color: #b0b0b0;
    cursor: not-allowed;
}

.pagination button:focus {
    outline: none;
}

.pagination button:first-child,
.pagination button:last-child {
    font-weight: bold;
}
</style>