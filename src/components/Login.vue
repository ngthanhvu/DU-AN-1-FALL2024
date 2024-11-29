<template>
    <div class="container" style="height: 55vh;">
        <div class="login-form">
            <h2 class="text-center text-bold">ĐĂNG NHẬP</h2>
            <form @submit.prevent="handleSubmit">
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
                <div class="mb-3 text-center">
                    <router-link to="/quen-mat-khau" class="text-decoration-none text-dark">Quên mật khẩu? Nhấn vào đây</router-link>
                </div>
                <button type="submit" class="btn btn-login w-100" :disabled="isLoading">
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
import Swal from 'sweetalert2';

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

    Object.keys(errors).forEach(key => errors[key] = '');

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(formData.email)) {
        errors.email = 'Email không hợp lệ';
        isValid = false;
    }

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
            localStorage.setItem('token', response.data.token);
            axios.defaults.headers.common['Authorization'] = `Bearer ${response.data.token}`;

            const userResponse = await axios.get(`${API_URL}/api/user`);
            const userId = userResponse.data.id;
            localStorage.setItem('user_id', userId);

            localStorage.setItem('role', userResponse.data.role);
            localStorage.setItem('isLogin', 'true');
            localStorage.setItem('username', userResponse.data.username);

            Swal.fire({
                icon: 'success',
                title: 'Thành công!',
                text: 'Đăng nhập thành công!'
            }).then(() => {
              window.location.href = '/';
            })
        }
    } catch (error) {
        console.log('Error response:', error.response?.data);

        if (error.response?.data?.errors) {
            Object.keys(error.response.data.errors).forEach(key => {
                errors[key] = error.response.data.errors[key][0];
            });
        } else if (error.response?.data?.message) {
            Swal.fire({
                icon: 'error',
                title: 'Đăng nhập thất bại!',
                text: error.response.data.message
            })
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Đăng nhập thất bại!',
                text: 'Vui lòng kiểm tra lại thông tin!'
            })
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
