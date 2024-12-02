<template>
  <div id="layoutSidenav_content">
    <main>
      <div class="container-fluid px-4" style="margin-top: 80px;">
        <h2 class="mt-4">Thêm mã giảm giá</h2>
        
        <form @submit.prevent="submitForm">
          <div class="form-group">
            <label for="code">Nhập mã (code):</label>
            <input
              type="text"
              id="code"
              v-model="discountForm.code"
              :class="{'is-invalid': errors.code}"
            />
            <span v-if="errors.code" class="error-message">{{ errors.code }}</span>
          </div>
  
          <div class="form-group">
            <label for="value">Phần trăm / Số tiền muốn giảm:</label>
            <input
              type="number"
              id="value"
              v-model="discountForm.value"
              :class="{'is-invalid': errors.value}"
            />
            <span v-if="errors.value" class="error-message">{{ errors.value }}</span>
          </div>
  
          <div class="form-group">
            <label for="type">Hình thức giảm giá:</label>
            <select
              id="type"
              v-model="discountForm.type"
              :class="{'is-invalid': errors.type}"
            >
              <option value="percentage">Giảm theo %</option>
              <option value="fixed">Giảm theo số tiền cố định</option>
            </select>
            <span v-if="errors.type" class="error-message">{{ errors.type }}</span>
          </div>
  
          <div class="form-group">
            <label for="expires_at">Ngày hết hạn:</label>
            <input
              type="date"
              id="expires_at"
              v-model="discountForm.expires_at"
              :class="{'is-invalid': errors.expires_at}"
            />
            <span v-if="errors.expires_at" class="error-message">{{ errors.expires_at }}</span>
          </div>
  
          <div class="form-group">
            <label for="usage_limit">Giới hạn sử dụng:</label>
            <input
              type="number"
              id="usage_limit"
              v-model="discountForm.usage_limit"
              :class="{'is-invalid': errors.usage_limit}"
            />
            <span v-if="errors.usage_limit" class="error-message">{{ errors.usage_limit }}</span>
          </div>
  
          <button type="submit">Thêm mã giảm giá</button>
  
          <div v-if="message" :class="{'success': success, 'error': !success}">
            {{ message }}
          </div>
        </form>
      </div>
    </main>
    <div style="height: 30vh"></div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';
import Swal from 'sweetalert2'; // Import SweetAlert2

const discountForm = ref({
  code: '',
  value: '',
  type: 'percentage',
  expires_at: '',
  usage_limit: null,
});

const errors = ref({
  code: '',
  value: '',
  type: '',
  expires_at: '',
  usage_limit: '',
});

const message = ref('');
const success = ref(false);

// Validate the form before submission
const validateForm = () => {
  let isValid = true;
  errors.value = {};

  // Validate code
  if (!discountForm.value.code) {
    errors.value.code = 'Mã giảm giá không được để trống';
    isValid = false;
  }
  const specialCharacterRegex = /[^a-zA-Z0-9]/; 
  if (specialCharacterRegex.test(discountForm.value.code)) {
    errors.value.code = 'Mã giảm giá không được chứa kí tự đặc biệt';
    isValid = false;
  }
  // Validate value
  if (!discountForm.value.value || discountForm.value.value <= 0) {
    errors.value.value = 'Giá trị giảm giá phải lớn hơn 0';
    isValid = false;
  }

  // Validate type
  if (!discountForm.value.type) {
    errors.value.type = 'Vui lòng chọn hình thức giảm giá';
    isValid = false;
  }

  // Validate expiration date
  if (!discountForm.value.expires_at) {
    errors.value.expires_at = 'Vui lòng chọn ngày hết hạn';
    isValid = false;
  }

  // Validate usage limit
  if (discountForm.value.usage_limit && discountForm.value.usage_limit <= 0) {
    errors.value.usage_limit = 'Giới hạn sử dụng phải lớn hơn 0';
    isValid = false;
  }

  return isValid;
};

const submitForm = async () => {
  // Validate the form before submission
  if (!validateForm()) {
    Swal.fire({
      icon: 'error',
      title: 'Lỗi',
      text: 'Vui lòng nhập đầy đủ thông tin hợp lệ.',
    });
    return;
  }

  errors.value = {};
  message.value = '';
  success.value = false;

  try {
    const response = await axios.post('http://localhost:8000/api/discounts', discountForm.value);
    success.value = true;
    message.value = response.data.message;
    
    // Show success message with SweetAlert2
    Swal.fire({
      icon: 'success',
      title: 'Thành công',
      text: response.data.message,
    });
  } catch (error) {
    if (error.response && error.response.status === 422) {
      errors.value = error.response.data.errors;
      message.value = 'Vui lòng nhập đầy đủ thông tin';
    } else {
      message.value = 'Không thể thêm mã giảm giá';
    }

    // Show error message with SweetAlert2
    Swal.fire({
      icon: 'error',
      title: 'Lỗi',
      text: message.value,
    });
  }
};
</script>


<style scoped>
.add-discount {
  max-width: 400px;
  margin: 0 auto;
  padding: 20px;
  border: 1px solid #ddd;
  border-radius: 8px;
  background-color: #f9f9f9;
}

.form-group {
  margin-bottom: 15px;
}

input,
select {
  width: 100%;
  padding: 8px;
  margin-top: 5px;
  border: 1px solid #ccc;
  border-radius: 4px;
}

input.is-invalid,
select.is-invalid {
  border-color: red;
}

.error-message {
  color: red;
  font-size: 12px;
}

button {
  padding: 10px 15px;
  background-color: #4c93af;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

button:hover {
  background-color: #33abcd;
}

.success {
  color: green;
}

.error {
  color: red;
}
</style>
