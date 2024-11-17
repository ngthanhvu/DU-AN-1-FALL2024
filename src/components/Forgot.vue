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

    <section class="reset-password-container">
        <div class="reset-password-form">
            <h2>Lấy Lại Mật Khẩu</h2>

            <!-- Form nhập email -->
            <div v-if="step === 1">
                <form @submit.prevent="sendResetLink">
                    <div class="form-group">
                        <label for="email">Email của bạn</label>
                        <input type="email" id="email" v-model="email" placeholder="Nhập email của bạn" required />
                    </div>
                    <button type="submit" class="btn btn-primary">Gửi Ngay</button>
                </form>
            </div>

            <!-- Otp code -->
            <div v-if="step === 2">
                <div class="container">
                    <div id="inputs" class="inputs">
                        <input class="input" type="text" inputmode="numeric" maxlength="1" v-model="otp[0]" />
                        <input class="input" type="text" inputmode="numeric" maxlength="1" v-model="otp[1]" />
                        <input class="input" type="text" inputmode="numeric" maxlength="1" v-model="otp[2]" />
                        <input class="input" type="text" inputmode="numeric" maxlength="1" v-model="otp[3]" />
                    </div>
                </div>
                <button class="btn btn-primary" @click="verifyOTP">Xác nhận OTP</button>
            </div>

            <!-- Form nhập mật khẩu mới -->
            <div v-if="step === 3">
                <form @submit.prevent="resetPassword">
                    <div class="form-group">
                        <label for="password">Mật khẩu mới</label>
                        <input type="password" id="password" v-model="password" placeholder="Nhập mật khẩu mới"
                            required />
                    </div>
                    <div class="form-group">
                        <label for="confirmPassword">Xác nhận mật khẩu mới</label>
                        <input type="password" id="confirmPassword" v-model="confirmPassword"
                            placeholder="Xác nhận mật khẩu mới" required />
                    </div>
                    <button type="submit" class="btn btn-primary">Đặt lại mật khẩu</button>
                </form>
            </div>

            <!-- Thông báo lỗi và thành công -->
            <div v-if="errorMessage" class="error-message">
                <p>{{ errorMessage }}</p>
            </div>
            <div v-if="successMessage" class="success-message">
                <p>{{ successMessage }}</p>
            </div>
        </div>
    </section>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';

const email = ref('');
const password = ref('');
const confirmPassword = ref('');
const otp = ref(['', '', '', '']); // OTP code input
const step = ref(1); // Bước hiện tại, 1: Nhập email, 2: Nhập OTP, 3: Nhập mật khẩu mới
const errorMessage = ref('');
const successMessage = ref('');

// Gửi yêu cầu đặt lại mật khẩu đến API
const sendResetLink = async () => {
    try {
        const response = await axios.post('/api/send-reset-link', { email: email.value });
        if (response.data.success) {
            successMessage.value = 'Đã gửi liên kết đặt lại mật khẩu đến email của bạn.';
            step.value = 2; // Chuyển sang bước 2 (Nhập OTP)
        } else {
            errorMessage.value = 'Không tìm thấy tài khoản với email này.';
        }
    } catch (error) {
        errorMessage.value = 'Có lỗi xảy ra. Vui lòng thử lại sau.';
    }
};

// Xác nhận mã OTP
const verifyOTP = async () => {
    const otpCode = otp.value.join('');
    if (otpCode.length !== 4) {
        errorMessage.value = 'Vui lòng nhập đầy đủ mã OTP.';
        return;
    }

    try {
        const response = await axios.post('/api/verify-otp', { otp: otpCode });
        if (response.data.success) {
            successMessage.value = 'Mã OTP xác thực thành công.';
            step.value = 3; // Chuyển sang bước 3 (Nhập mật khẩu mới)
        } else {
            errorMessage.value = 'Mã OTP không hợp lệ.';
        }
    } catch (error) {
        errorMessage.value = 'Có lỗi xảy ra. Vui lòng thử lại sau.';
    }
};

// Đặt lại mật khẩu mới
const resetPassword = async () => {
    if (password.value !== confirmPassword.value) {
        errorMessage.value = 'Mật khẩu xác nhận không khớp.';
        return;
    }

    try {
        const response = await axios.post('/api/reset-password', { password: password.value });
        if (response.data.success) {
            successMessage.value = 'Mật khẩu đã được đặt lại thành công.';
        } else {
            errorMessage.value = 'Có lỗi xảy ra. Vui lòng thử lại sau.';
        }
    } catch (error) {
        errorMessage.value = 'Có lỗi xảy ra. Vui lòng thử lại sau.';
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
