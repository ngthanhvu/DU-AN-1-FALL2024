<template>
  <div class="container" style="height: 55vh;">
      <div class="login-form">
          <h2 class="text-center text-bold">ĐĂNG NHẬP</h2>
          <form @submit.prevent="handleSubmit">
              <div class="mb-3">
                  <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                  <input
                      type="email"
                      class="form-control"
                      id="email"
                      v-model="formData.email"
                      :class="{ 'is-invalid': errors.email }"
                      placeholder="Email"
                      required
                  >
                  <div class="invalid-feedback" v-if="errors.email">
                      {{ errors.email }}
                  </div>
              </div>
              <div class="mb-3">
                  <label for="password" class="form-label">Mật khẩu <span class="text-danger">*</span></label>
                  <input
                      type="password"
                      class="form-control"
                      id="password"
                      v-model="formData.password"
                      :class="{ 'is-invalid': errors.password }"
                      placeholder="Mật khẩu"
                      required
                  >
                  <div class="invalid-feedback" v-if="errors.password">
                      {{ errors.password }}
                  </div>
              </div>
              <div class="mb-3 text-center">
                  <a href="#" class="text-decoration-none text-dark">Quên mật khẩu? Nhấn vào đây</a>
              </div>
              <button
                  type="submit"
                  class="btn btn-login w-100"
                  :disabled="isLoading"
              >
                  {{ isLoading ? 'Đang xử lý...' : 'Đăng nhập' }}
              </button>
              <div class="text-center mt-3">
                  <router-link to="/register" class="text-decoration-none text-dark">
                      Chưa có tài khoản? Đăng ký
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

const router = useRouter();
const API_URL = 'http://127.0.0.1:8000';
const isLoading = ref(false);

const formData = reactive({
  email: '',
  password: ''
});

const errors = reactive({
  email: '',
  password: ''
});

const validateForm = () => {
  let isValid = true;

  // Reset errors
  Object.keys(errors).forEach(key => errors[key] = '');

  // Email validation
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (!emailRegex.test(formData.email)) {
      errors.email = 'Email không hợp lệ';
      isValid = false;
  }

  // Password validation
  if (!formData.password) {
      errors.password = 'Vui lòng nhập mật khẩu';
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
      const response = await axios.post(`${API_URL}/api/login`, {
          email: formData.email,
          password: formData.password
      });

      if (response.data.token) {
          // Lưu token vào localStorage
          localStorage.setItem('token', response.data.token);

          // Thêm token vào header mặc định của axios
          axios.defaults.headers.common['Authorization'] = `Bearer ${response.data.token}`;

          alert('Đăng nhập thành công!');
          router.push('/'); // hoặc trang bạn muốn chuyển đến sau khi đăng nhập
      }
  } catch (error) {
      console.log('Error response:', error.response?.data);

      if (error.response?.data?.errors) {
          Object.keys(error.response.data.errors).forEach(key => {
              errors[key] = error.response.data.errors[key][0];
          });
      } else if (error.response?.data?.message) {
          alert(error.response.data.message);
      } else {
          alert('Đăng nhập thất bại. Vui lòng kiểm tra lại thông tin!');
      }
  } finally {
      isLoading.value = false;
  }
};
</script>

<style scoped>
.login-form {
  max-width: 800px;
  margin: 50px auto;
  padding: 20px;
  background: #fff;
  border-radius: 8px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
  margin-top: 175px;
}

.btn-login {
  background: #FF0000;
  color: #fff;
}

.btn-login:hover {
  background: #f63905;
  color: #fff;
}

.btn-login:disabled {
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
