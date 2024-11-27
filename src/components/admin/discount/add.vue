<template>
      <div id="layoutSidenav_content">
    <main>
      <div class="container-fluid px-4" style="margin-top: 80px;">
        <h2 class="mt-4">Quản lý mã giảm giá</h2>
      
      <form @submit.prevent="submitForm">
        <div class="form-group">
          <label for="code">Discount Code:</label>
          <input
            type="text"
            id="code"
            v-model="discountForm.code"
            :class="{'is-invalid': errors.code}"/>
          <span v-if="errors.code" class="error-message">{{ errors.code }}</span>
        </div>
  
        <div class="form-group">
          <label for="value">Discount Value:</label>
          <input
            type="number"
            id="value"
            v-model="discountForm.value"
            :class="{'is-invalid': errors.value}"
          />
          <span v-if="errors.value" class="error-message">{{ errors.value }}</span>
        </div>
  
        <div class="form-group">
          <label for="type">Discount Type:</label>
          <select
            id="type"
            v-model="discountForm.type"
            :class="{'is-invalid': errors.type}">
            <option value="percentage">Giảm theo %</option>
            <option value="fixed">Giảm theo số tiền cố định</option>
          </select>
          <span v-if="errors.type" class="error-message">{{ errors.type }}</span>
        </div>
  
        <div class="form-group">
          <label for="expires_at">Expiration Date (Optional):</label>
          <input
            type="date"
            id="expires_at"
            v-model="discountForm.expires_at"
            :class="{'is-invalid': errors.expires_at}"/>
          <span v-if="errors.expires_at" class="error-message">{{ errors.expires_at }}</span>
        </div>
  
        <div class="form-group">
          <label for="usage_limit">Usage Limit (Optional):</label>
          <input
            type="number"
            id="usage_limit"
            v-model="discountForm.usage_limit"
            :class="{'is-invalid': errors.usage_limit}"/>
          <span v-if="errors.usage_limit" class="error-message">{{ errors.usage_limit }}</span>
        </div>
  
        <button type="submit">Create Discount</button>
  
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
  
  const submitForm = async () => {
    errors.value = {};
    message.value = '';
    success.value = false;
  
    try {
      const response = await axios.post('http://localhost:8000/api/discounts', discountForm.value);
      success.value = true;
      message.value = response.data.message;
    } catch (error) {
      if (error.response && error.response.status === 422) {
        errors.value = error.response.data.errors;
        message.value = 'Please fix the errors above.';
      } else {
        // General error handling
        message.value = 'An error occurred while creating the discount.';
      }
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
  