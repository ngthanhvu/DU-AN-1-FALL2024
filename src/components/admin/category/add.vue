<template>
  <div id="layoutSidenav_content">
    <main>
      <div class="container-fluid px-4" style="margin-top: 80px;">
        <h2>Thêm danh mục</h2>
        <form @submit.prevent="handleSubmit">
          <div class="mb-3">
            <label class="form-label">Tên danh mục:</label>
            <input v-model="formData.name" type="text" class="form-control" required placeholder="Nhập tên danh mục" />
            <small v-if="errorMessages.name" class="text-danger">{{ errorMessages.name }}</small>
          </div>

          <div class="mb-3">
            <label class="form-label">Mô tả danh mục:</label>
            <textarea v-model="formData.description" class="form-control" placeholder="Nhập mô tả danh mục"></textarea>
          </div>

          <button type="submit" class="btn btn-primary">Thêm</button>
        </form>
      </div>
    </main>
  </div>
</template>

<script setup>
import { reactive, ref } from 'vue';
import axios from 'axios';
import Swal from 'sweetalert2';

const API_URL = import.meta.env.VITE_API_URL;

const formData = reactive({
  name: '',
  description: ''
});

const errorMessages = reactive({
  name: ''
});

const validateCategoryName = () => {
  const name = formData.name.trim();

  const regex = /[!@#$%^&*(),.?":{}|<>]/;
  if (regex.test(name)) {
    errorMessages.name = 'Tên danh mục không được chứa ký tự đặc biệt.';
    return false;
  }

  errorMessages.name = '';
  return true;
};

const checkCategoryExists = async () => {
  try {
    const response = await axios.get(`${API_URL}/api/categories/check-exists`, {
      params: { name: formData.name }
    });

    if (response.data.exists) {
      Swal.fire({
        icon: 'error',
        title: 'Danh mục đã tồn tại',
        text: 'Tên danh mục này đã được sử dụng.'
      });
      return true;
    }
    return false;
  } catch (error) {
    console.error(error);
    Swal.fire({
      icon: 'error',
      title: 'Lỗi hệ thống',
      text: 'Không thể kiểm tra tính hợp lệ của tên danh mục.'
    });
    return true;
  }
};

const handleSubmit = async () => {
  if (!validateCategoryName()) return;

  const isExists = await checkCategoryExists();
  if (isExists) return;

  // Step 3: Proceed with form submission
  try {
    const response = await axios.post(`${API_URL}/api/categories`, formData);
    console.log(response.data);
    Swal.fire({
      icon: 'success',
      title: 'Thêm danh mục thành công',
      text: 'Danh mục đã được thêm vào'
    });
    formData.name = '';
    formData.description = '';
  } catch (error) {
    console.error(error);
    Swal.fire({
      icon: 'error',
      title: 'Thêm danh mục thất bại',
      text: 'Có lỗi xảy ra khi thêm danh mục.'
    });
  }
};
</script>
