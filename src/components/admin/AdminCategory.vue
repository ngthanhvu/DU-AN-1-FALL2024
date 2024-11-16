<template>
  <div id="layoutSidenav_content">
    <main>
      <div class="container-fluid px-4" style="margin-top: 80px;">
        <h2 class="mt-4 fw-bold">Quản lý danh mục</h2>
        <table class="table table-bordered">
          <thead class="table-dark text-center">
            <tr>
              <th>#</th>
              <th>Tên danh mục</th>
              <th>Hành động</th>
            </tr>
          </thead>
          <tbody class="text-center">
            <tr v-for="(category, index) in categories" :key="index">
              <td>{{ index + 1 }}</td>
              <td>{{ category.name }}</td>
              <td>
                <button class="btn btn-danger" @click="deleteCategory(category.id)">
                  <font-awesome-icon :icon="['far', 'trash-can']" />
                </button> |
                <button class="btn btn-primary" @click="editCategory(category)">
                  <font-awesome-icon :icon="['fas', 'pen-to-square']" />
                </button>
              </td>
            </tr>
          </tbody>
        </table>
        <div style="height: 100vh"></div>
      </div>
    </main>

    <!-- Modal chỉnh sửa -->
    <div v-if="showModal" class="modal fade show" style="display: block;" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Chỉnh sửa danh mục</h5>
            <button type="button" class="btn-close" @click="closeModal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="updateCategory">
              <div class="mb-3">
                <label for="categoryName" class="form-label">Tên danh mục</label>
                <input type="text" class="form-control" id="categoryName" v-model="editedCategory.name" required>
              </div>
              <button type="submit" class="btn btn-primary">Cập nhật</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import Swal from 'sweetalert2';

const API_URL = 'http://127.0.0.1:8000';
const categories = ref([]);
const showModal = ref(false);
const editedCategory = ref({ id: null, name: '' });

const loadCategories = async () => {
  try {
    const response = await axios.get(`${API_URL}/api/categories`);
    categories.value = response.data;
  } catch (error) {
    console.error('Error loading categories:', error);
    Swal.fire({
      icon: 'error',
      title: 'Lỗi!',
      text: 'Không thể tải danh mục sản phẩm'
    });
  }
};

const deleteCategory = async (id) => {
  try {
    const result = await Swal.fire({
      title: 'Xác nhận xoá?',
      text: "Bạn không thể hoàn tác sau khi xoá!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Xoá',
      cancelButtonText: 'Hủy'
    });

    if (result.isConfirmed) {
      const response = await axios.delete(`${API_URL}/api/categories/${id}`);
      if (response.status === 200 || response.status === 204) {
        categories.value = categories.value.filter(category => category.id !== id);

        Swal.fire({
          icon: 'success',
          title: 'Đã xoá!',
          text: 'Danh mục đã được xoá'
        });
      } else {
        throw new Error('Không thể xoá danh mục');
      }
    }
  } catch (error) {
    console.error('Error deleting category:', error);
    Swal.fire({
      icon: 'error',
      title: 'Lỗi!',
      text: 'Không thể xoá danh mục sản phẩm'
    });
  }
};

const editCategory = (category) => {
  editedCategory.value = { ...category }; // Copy category data to editedCategory
  showModal.value = true;
};

const closeModal = () => {
  showModal.value = false;
};

const updateCategory = async () => {
  try {
    const response = await axios.put(`${API_URL}/api/categories/${editedCategory.value.id}`, editedCategory.value);
    if (response.status === 200) {
      const index = categories.value.findIndex(cat => cat.id === editedCategory.value.id);
      if (index !== -1) {
        categories.value[index] = { ...editedCategory.value }; // Update category in the list
      }

      Swal.fire({
        icon: 'success',
        title: 'Thành công!',
        text: 'Danh mục đã được cập nhật'
      });
      closeModal();
    } else {
      throw new Error('Không thể cập nhật danh mục');
    }
  } catch (error) {
    console.error('Error updating category:', error);
    Swal.fire({
      icon: 'error',
      title: 'Lỗi!',
      text: 'Không thể cập nhật danh mục'
    });
  }
};

onMounted(() => {
  loadCategories();
});
</script>
