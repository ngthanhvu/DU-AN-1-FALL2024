<template>
    <section class="shop1 text-center">
        <span class="crumb-border"></span>
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <ul class="breadcrumb">
                        <li class="home">
                            <router-link to="/"><b>Trang chủ </b></router-link>
                            <span class="icon-arrow-right text-danger">
                                <font-awesome-icon :icon="['fas', 'arrow-right']" />
                            </span>
                        </li>
                        <li><strong><span class="text-danger"> Thông Tin Tài Khoản</span></strong></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <div class="container mt-5">
        <div class="row justify-content-center" style="height: 100vh; padding-top: 100px;">
            <div class="col-md-4">
                <h3 class="text-center mb-4">Đặt Lại Mật Khẩu</h3>
                <form @submit.prevent="resetPassword">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" v-model="email" placeholder="Nhập email"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="token" class="form-label">Token</label>
                        <input type="text" class="form-control" id="token" v-model="token" placeholder="Nhập token"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Mật khẩu mới</label>
                        <input type="password" class="form-control" id="password" v-model="password"
                            placeholder="Nhập mật khẩu mới" required>
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Xác nhận mật khẩu mới</label>
                        <input type="password" class="form-control" id="password_confirmation"
                            v-model="password_confirmation" placeholder="Nhập lại mật khẩu mới" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Đặt Lại Mật Khẩu</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useRoute, useRouter } from 'vue-router';
import Swal from 'sweetalert2';

const route = useRoute();
const router = useRouter();

const email = ref('');
const password = ref('');
const password_confirmation = ref('');
const token = route.query.token;
const API_URL = import.meta.env.VITE_API_URL;
onMounted(() => {
    email.value = route.query.email;
});

const resetPassword = async () => {
    try {
        const response = await axios.post(`${API_URL}/api/password/reset`, {
            email: email.value,
            password: password.value,
            password_confirmation: password_confirmation.value,
            token: token,
        });
        if (response.status === 200) {
            Swal.fire('Success', 'Mật khẩu đã được đặt lại thành công!', 'success');
            router.push('/login');
        }
    } catch (error) {
        console.error(error);
        Swal.fire('Error', 'Có lỗi xảy ra. Vui lòng thử lại!', 'error');
    }
};
</script>

<style scoped>
.reset-password-section {
    padding: 20px 0;
    background-color: #f9f9f9;
}

.crumb-border {
    border-top: 1px solid #ddd;
}

.breadcrumb {
    padding: 10px 0;
    background-color: transparent;
    margin-bottom: 0;
}

.breadcrumb .home {
    font-weight: bold;
}

.reset-password-container {
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 30px 0;
}

.reset-password-form {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    max-width: 400px;
    width: 100%;
}

h2 {
    text-align: center;
    margin-bottom: 20px;
}

.form-group {
    margin-bottom: 15px;
}

label {
    display: block;
    font-weight: bold;
}

input {
    width: 100%;
    padding: 10px;
    margin-top: 5px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

button {
    width: 100%;
    padding: 10px;
    background-color: #ff0000;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
}

button:hover {
    background-color: #a04545;
}

.error-message {
    color: red;
    margin-top: 10px;
}

.success-message {
    color: green;
    margin-top: 10px;
}

.inputs {
    display: flex;
    justify-content: space-between;
}

.input {
    width: 50px;
    height: 50px;
    text-align: center;
    font-size: 20px;
    border: 1px solid #ccc;
    border-radius: 4px;
    margin: 0 5px;
}
</style>
