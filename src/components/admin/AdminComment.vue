<template>
  <div id="layoutSidenav_content">
    <main>
      <div class="container-fluid px-4" style="margin-top: 80px;">
        <h2 class="mt-4 fw-bold">Quản lý bình luận</h2>
        <select v-model="selectedCategoryId" @change="fetchCommentsByCategory" class="form-select mt-3">
          <option value="">Chọn Danh mục cần xem bình luận</option>
          <option v-for="category in categories" :key="category.id" :value="category.id">
            {{ category.name }}
          </option>
        </select>
        <div style="height: 2vh"></div>
        <select v-model="selectedProductId" @change="fetchComments" class="form-select">
          <option value="">Chọn Sản phẩm cần xem bình luận</option>
          <option v-for="product in products" :key="product.id" :value="product.id">
            {{ product.name }}
          </option>
        </select>

        <table v-if="comments.length > 0" class="table mt-3">
          <thead class="table-dark">
            <tr>
              <th>Tên Người Dùng</th>
              <th>Bình luận</th>
              <th>Sản phẩm</th>
              <th>Ngày Tạo</th>
              <th>Hành Động</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="comment in comments" :key="comment.id">
              <td>{{ comment.user.username }}</td>
              <td>{{ comment.comment }}</td>
              <td>{{ comment.product_id }}</td>
              <td>{{ new Date(comment.created_at).toLocaleString() }}</td>
              <td>
                <button @click="confirmDeleteComment(comment.id)" class="btn btn-danger btn-sm">Xóa</button>
              </td>
            </tr>
          </tbody>
        </table>

        <p v-else class="mt-3">Không có bình luận cho sản phẩm này.</p>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import Swal from 'sweetalert2';

const API_URL = import.meta.env.VITE_API_URL;


const products = ref([]);
const comments = ref([]);
const selectedProductId = ref('');
const categories = ref([]);
const selectedCategoryId = ref('');

const fetchCategories = async () => {
  try {
    const response = await axios.get(`${API_URL}/api/categories`);
    categories.value = response.data;
  } catch (error) {
    console.error('Lỗi khi lấy danh mục:', error);
  }
};

const fetchCommentsByCategory = async () => {
  if (!selectedCategoryId.value) {
    fetchComments();
    return;
  }

  try {
    const response = await axios.get(`${API_URL}/api/comments/category/${selectedCategoryId.value}`);
    comments.value = response.data;
  } catch (error) {
    console.error('Lỗi khi lọc bình luận:', error);
  }
};


const fetchProducts = async () => {
  try {
    const response = await axios.get(`${API_URL}/api/products`);
    products.value = response.data;
  } catch (error) {
    console.error('Lỗi khi lấy sản phẩm:', error);
  }
};

const fetchComments = async () => {
  try {
    const endpoint = selectedProductId.value
      ? `${API_URL}/api/comments/${selectedProductId.value}`
      : `${API_URL}/api/comments`;

    const response = await axios.get(endpoint);
    comments.value = response.data;
  } catch (error) {
    console.error('Lỗi khi lấy bình luận:', error);
  }
};



const deleteComment = async (commentId) => {
  try {
    await axios.delete(`${API_URL}/api/comments/${commentId}`);
    comments.value = comments.value.filter(comment => comment.id !== commentId);
    Swal.fire('Thành công', 'Bình luận đã xóa!', 'success');
  } catch (error) {
    console.error('Lỗi khi xóa bình luận:', error);
    Swal.fire('Loi', 'Không thể xóa bình luận', 'error');
  }
};

const confirmDeleteComment = (commentId) => {
  Swal.fire({
    title: 'Bạn có chắc chắn?',
    text: 'Bạn có chắc chắn muốn xóa bình luận này không?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Có, xóa nó!',
    cancelButtonText: 'Hủy'
  }).then((result) => {
    if (result.isConfirmed) {
      deleteComment(commentId);
    }
  });
};

onMounted(() => {
  fetchProducts();
  fetchCategories();
  fetchComments();
});

</script>
