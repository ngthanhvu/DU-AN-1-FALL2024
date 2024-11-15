<template>
  <div id="layoutSidenav_content">
    <main>
      <div class="container-fluid px-4" style="margin-top: 80px;">
        <h1 class="mt-4">Quản lý sản phẩm</h1>

        <!-- Nút Thêm sản phẩm -->
        <div class="d-flex justify-content-end mb-3">
          <button class="btn btn-primary" @click="openModal">Thêm sản phẩm <font-awesome-icon :icon="['fas', 'plus']" /></button>
        </div>

        <!-- Danh sách sản phẩm -->
        <div class="card mb-3">
          <div class="card-header">Danh sách sản phẩm</div>
          <div class="card-body">
            <table class="table table-bordered" id="productTable">
              <thead>
                <tr>
                  <th>Product Name</th>
                  <th>Category</th>
                  <th>Price</th>
                  <th>Stock</th>
                  <th>Images</th>
                  <th>Sku Code</th>
                </tr>
              </thead>
              <tbody>
                <!-- Data sẽ được load ở đây -->
              </tbody>
            </table>
          </div>
        </div>

        <!-- Lớp phủ nền mờ khi modal hiển thị -->
        <div v-if="isModalVisible" class="modal-overlay" @click="closeModal"></div>

        <!-- ModalForm: Form thêm sản phẩm -->
        <div v-if="isModalVisible" class="modal fade show" style="display: block;" tabindex="-1"
          aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Thêm Sản Phẩm</h5>
                <button type="button" class="btn-close" @click="closeModal" aria-label="Close"></button>
              </div>
              <form @submit.prevent="handleSubmit">
                <div class="modal-body">
                  <div class="mb-3">
                    <label for="name" class="form-label">Tên sản phẩm:</label>
                    <input type="text" class="form-control" id="name" v-model="product.name" required />
                  </div>
                  <div class="mb-3">
                    <label for="price" class="form-label">Giá sản phẩm:</label>
                    <input type="number" class="form-control" id="price" v-model="product.price" required />
                  </div>
                  <div class="mb-3">
                    <label for="description" class="form-label">Mô tả sản phẩm:</label>
                    <textarea class="form-control" id="description" v-model="product.description" required></textarea>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" @click="closeModal">Đóng</button>
                  <button type="submit" class="btn btn-primary">Thêm sản phẩm</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div style="height: 100vh"></div>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';

const API_URL = 'http://localhost:3000/products';
const isModalVisible = ref(false);

const product = ref({
  name: '',
  price: '',
  description: ''
});

// thêm sản phẩm









const openModal = () => {
  isModalVisible.value = true;
};

const closeModal = () => {
  isModalVisible.value = false;
};
</script>

<style scoped>
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  z-index: 1040;
}

.modal.fade.show {
  display: block;
}
</style>
