<template>
  <div id="layoutSidenav_content">
    <main>
      <div class="container-fluid px-4" style="margin-top: 80px;">
        <h2 class="mt-4 fw-bold">Quản lý bình luận</h2>
        <select v-model="selectedProductId" @change="fetchComments" class="form-select">
          <option value="">Chọn Sản phẩm để xem bình luận</option>
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
                <button @click="deleteComment(comment.id)" class="btn btn-danger btn-sm">Xóa</button> <!-- Nút xóa -->
              </td>
            </tr>
          </tbody>
        </table>

        <p v-else class="mt-3">Không có bình luận cho sản phẩm này.</p>
        <div style="height: 100vh"></div>

      </div>
    </main>
  </div>
</template>
<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const API_URL = 'http://127.0.0.1:8000';

const products = ref([]); 
const comments = ref([]); 
const selectedProductId = ref(''); 

const fetchProducts = async () => {
  try {
    const response = await axios.get(`${API_URL}/api/products`);
    products.value = response.data;
  } catch (error) {
    console.error('Lỗi khi lấy sản phẩm:', error);
  }
};

const fetchComments = async () => {
  if (!selectedProductId.value) {
    comments.value = []; 
    return;
  }

  try {
    const response = await axios.get(`${API_URL}/api/comments/${selectedProductId.value}`);
    comments.value = response.data;
  } catch (error) {
    console.error('Lỗi khi lấy bình luận:', error);
  }
};

const deleteComment = async (commentId) => {
  try {
    await axios.delete(`${API_URL}/api/comments/${commentId}`);
    comments.value = comments.value.filter(comment => comment.id !== commentId);
  } catch (error) {
    console.error('Lỗi khi xóa bình luận:', error);
  }
};

onMounted(fetchProducts);
</script>
