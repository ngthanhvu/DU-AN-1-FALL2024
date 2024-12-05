<template>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4" style="margin-top: 80px">
                <h2 class="mt-4 fw-bold">Quản lý Đánh giá</h2>
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
                                <img v-if="review.image_path" :src="`${API_URL}/storage/${review.image_path}`"
                                    alt="Hình ảnh đánh giá" class="review-image" />
                            </td>
                            <td>

                                <!-- Form nhập phản hồi -->
                                <div v-if="activeReviewId === review.id" class="reply-form">
                                    <textarea v-model="replyText" rows="3" placeholder="Nhập phản hồi..."
                                        class="form-control"></textarea>
                                    <button class="btn btn-success mt-2" @click="submitReply(review.id)">Gửi</button>
                                    <button class="btn btn-secondary mt-2" @click="cancelReply">Hủy</button>
                                </div>
                                <!-- Hiển thị các phản hồi -->
                                <div v-if="review.replies.length > 0" class="replies-section">
                                    <div v-for="reply in review.replies" :key="reply.id" class="reply-item">
                                        <strong>{{ reply.user.username }}:</strong>
                                        <span v-if="editingReplyId !== reply.id">{{ reply.reply }}</span>
                                        <textarea v-else v-model="replyText" rows="3"
                                            class="form-control">{{ reply.reply }}</textarea>
                                        <button v-if="editingReplyId !== reply.id" @click="editReply(reply.id)"
                                            class="btn btn-success"><font-awesome-icon
                                                :icon="['far', 'pen-to-square']" /></button>
                                        <button v-if="editingReplyId === reply.id"
                                            @click="submitEditedReply(reply.id)" class="btn btn-success">Cập nhật</button>
                                        <button v-if="editingReplyId === reply.id" @click="cancelEdit"
                                            class="btn btn-danger">Hủy</button>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <button class="btn btn-danger me-2" @click="deleteReply(review.id)">
                                    <font-awesome-icon :icon="['fas', 'trash']" />
                                </button>
                                <button class="btn btn-primary me-2" @click="replyToReview(review.id)">
                                    <font-awesome-icon :icon="['fas', 'circle-info']" />
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";

const API_URL = import.meta.env.VITE_API_URL;

const reviews = ref([]);
const activeReviewId = ref(null);
const editingReplyId = ref(null);
const replyText = ref("");

const fetchReviews = async () => {
    try {
        const response = await axios.get(`${API_URL}/api/reviews`);
        reviews.value = response.data;
    } catch (error) {
        console.error("Error fetching reviews:", error);
    }
};

const replyToReview = (id) => {
    activeReviewId.value = id;
    replyText.value = "";
};

const cancelReply = () => {
    activeReviewId.value = null;
    replyText.value = ""; // Clear text
};

const submitReply = async (reviewId) => {
    if (!replyText.value.trim()) {
        alert("Vui lòng nhập nội dung phản hồi!");
        return;
    }

    const userId = localStorage.getItem("user_id");

    if (!userId) {
        alert("Bạn cần đăng nhập để gửi phản hồi.");
        return;
    }

    // Check if the review already has a reply
    const review = reviews.value.find(r => r.id === reviewId);
    if (review && review.replies.length > 0) {
        alert("Mỗi đánh giá chỉ được phép có một phản hồi.");
        return;
    }

    try {
        await axios.post(`${API_URL}/api/reviews/${reviewId}/reply`, {
            reply: replyText.value,
            user_id: userId,
        });
        alert("Phản hồi đã được gửi!");
        cancelReply();
        fetchReviews();
    } catch (error) {
        console.error("Error submitting reply:", error);
        alert("Có lỗi xảy ra, vui lòng thử lại.");
    }
};


const editReply = (replyId) => {
    editingReplyId.value = replyId;
    const reply = reviews.value
        .flatMap(review => review.replies)
        .find(reply => reply.id === replyId);
    replyText.value = reply.reply;
};

const submitEditedReply = async (replyId) => {
    if (!replyText.value.trim()) {
        alert("Vui lòng nhập nội dung phản hồi!");
        return;
    }

    const userId = localStorage.getItem("user_id");
    const userRole = localStorage.getItem("role"); // Get the user role from localStorage

    if (!userId) {
        alert("Bạn cần đăng nhập để sửa phản hồi.");
        return;
    }

    if (userRole !== 'admin') {
        alert("Bạn không có quyền sửa phản hồi này.");
        return;
    }

    try {
        await axios.put(`${API_URL}/api/reviews/replies/${replyId}`, {
            reply: replyText.value,
            user_id: userId,
        });
        alert("Phản hồi đã được cập nhật!");
        editingReplyId.value = null;
        fetchReviews();
    } catch (error) {
        console.error("Error updating reply:", error);
        alert("Có lỗi xảy ra, vui lòng thử lại.");
    }
};
const deleteReply = async (replyId) => {
    const userId = localStorage.getItem("user_id");

    if (!userId) {
        alert("Bạn cần đăng nhập để xóa phản hồi.");
        return;
    }

    try {
        await axios.delete(`${API_URL}/api/reviews/replies/${replyId}`, {
            data: { user_id: userId }, // Send the user_id in the request body
        });
        alert("Phản hồi đã được xóa!");
        fetchReviews(); // Reload the reviews to reflect the changes
    } catch (error) {
        console.error("Error deleting reply:", error);
        alert("Có lỗi xảy ra, vui lòng thử lại.");
    }
};

const cancelEdit = () => {
    editingReplyId.value = null;
    replyText.value = ""; 
};

onMounted(() => {
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
.reply-item{
    display: flex;
    justify-content: space-between;
    border: 1px solid #ddd;
    padding: 10px;
    margin-bottom: 10px;
    background-color: #f9f9f9;
}
</style>