<template>
  <div class="container" >
    <div class="register-form">
      <h2 class="text-center text-bold">ĐĂNG KÝ</h2>
      <form @submit.prevent="handleSubmit">
        <div class="mb-3">
          <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
          <input type="text" class="form-control" id="username" v-model="formData.username"
            :class="{ 'is-invalid': errors.username }" placeholder="Username">
          <div class="invalid-feedback" v-if="errors.username">
            {{ errors.username }}
          </div>
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
          <input type="email" class="form-control" id="email" v-model="formData.email"
            :class="{ 'is-invalid': errors.email }" placeholder="Email">
          <div class="invalid-feedback" v-if="errors.email">
            {{ errors.email }}
          </div>
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Mật khẩu <span class="text-danger">*</span></label>
          <input type="password" class="form-control" id="password" v-model="formData.password"
            :class="{ 'is-invalid': errors.password }" placeholder="Mật khẩu">
          <div class="invalid-feedback" v-if="errors.password">
            {{ errors.password }}
          </div>
        </div>
        <div class="mb-3">
          <label for="confirmPassword" class="form-label">Xác nhận mật khẩu <span class="text-danger">*</span></label>
          <input type="password" class="form-control" id="confirmPassword" v-model="formData.confirmPassword"
            :class="{ 'is-invalid': errors.confirmPassword }" placeholder="Xác nhận mật khẩu">
          <div class="invalid-feedback" v-if="errors.confirmPassword">
            {{ errors.confirmPassword }}
          </div>
        </div>
        <div class="mb-3 form-check">
          <input type="checkbox" class="form-check-input" id="terms" v-model="formData.terms"
            :class="{ 'is-invalid': errors.terms }">
          <label class="form-check-label" for="terms">Đồng ý với điều khoản</label>
          <div class="invalid-feedback" v-if="errors.terms">
            {{ errors.terms }}
          </div>
        </div>
        <button type="submit" class="btn btn-register w-100" :disabled="isLoading">
          {{ isLoading ? 'Đang xử lý...' : 'Đăng ký' }}
        </button>
        <div class="text-center mt-3">
          <router-link to="/login" class="text-decoration-none text-dark">
            Đã có tài khoản? Đăng nhập
          </router-link>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';
import Swal from 'sweetalert2';

const router = useRouter();
const API_URL = import.meta.env.VITE_API_URL;
const isLoading = ref(false);

const formData = reactive({
  username: '',
  email: '',
  password: '',
  confirmPassword: '',
  terms: false
});

const errors = reactive({
  username: '',
  email: '',
  password: '',
  confirmPassword: '',
  terms: ''
});

const validateForm = () => {
  let isValid = true;

  // Reset errors
  Object.keys(errors).forEach(key => errors[key] = '');

  // Username validation
  if (formData.username.length < 3) {
    errors.username = 'Username phải có ít nhất 3 ký tự';
    isValid = false;
  }

  // Email validation
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (!emailRegex.test(formData.email)) {
    errors.email = 'Email không hợp lệ';
    isValid = false;
  }

  // Password validation
  if (formData.password.length < 6) {
    errors.password = 'Mật khẩu phải có ít nhất 6 ký tự';
    isValid = false;
  }

  // Confirm password validation
  if (formData.password !== formData.confirmPassword) {
    errors.confirmPassword = 'Mật khẩu không khớp';
    isValid = false;
  }

  // Terms validation
  if (!formData.terms) {
    errors.terms = 'Bạn phải đồng ý với điều khoản';
    isValid = false;
  }

  return isValid;
};

const handleSubmit = async () => {
  if (!validateForm()) {
    return;
  }

  isLoading.value = true;

  try {
    const response = await axios.post(`${API_URL}/api/register`, {
      username: formData.username,  // Sử dụng username theo yêu cầu API
      email: formData.email,
      password: formData.password,
      password_confirmation: formData.confirmPassword  // Giữ nguyên format password_confirmation
    });

    if (response.data) {
      Swal.fire({
        icon: 'success',
        title: 'Thành công!',
        text: 'Đăng ký thành công!'
      })
      router.push('/login');
    }
  } catch (error) {
    console.log('Error response:', error.response?.data);  // Log để debug

    if (error.response?.data?.errors) {
      // Xử lý lỗi validation từ Laravel
      Object.keys(error.response.data.errors).forEach(key => {
        errors[key === 'password_confirmation' ? 'confirmPassword' : key] =
          error.response.data.errors[key][0];
      });
    } else if (error.response?.data?.message) {
      // Hiển thị message lỗi chung nếu có
      Swal.fire({
        icon: 'error',
        title: 'Lỗi!',
        text: error.response.data.message
      });
    } else {
      Swal.fire({
        icon: 'error',
        title: 'Lỗi!',
        text: 'Có lỗi xảy ra. Vui lòng thử lại sau!'
      });
    }
  } finally {
    isLoading.value = false;
  }
};
</script>

<style scoped>
.register-form {
  max-width: 800px;
  margin: 50px auto;
  padding: 20px;
  background: #fff;
  border-radius: 8px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
  margin-top: 105px;
}

.btn-register {
  background: #FF0000;
  color: #fff;
}

.btn-register:hover {
  background: #f63905;
  color: #fff;
}

.btn-register:disabled {
  background: #ccc;
  cursor: not-allowed;
}

.text-dark:hover {
  color: #FF0000 !important;
}

.invalid-feedback {
  display: block;
}
</style>
