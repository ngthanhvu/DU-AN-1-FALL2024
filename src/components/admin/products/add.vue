<template>
  <div id="layoutSidenav_content">
    <main>
      <div class="container-fluid px-4" style="margin-top: 80px;">
        <!-- Form thêm sản phẩm -->
        <h2>Thêm sản phẩm</h2>
        <form @submit.prevent="handleSubmit">
          <div class="mb-3">
            <label class="form-label">Tên sản phẩm:</label>
            <input v-model="formData.name" type="text" class="form-control" placeholder="Nhập tên sản phẩm" />
          </div>

          <div class="mb-3">
            <label class="form-label">Giá sản phẩm:</label>
            <input v-model="formData.price" type="number" class="form-control" placeholder="Nhập giá sản phẩm" />
          </div>

          <div class="mb-3">
            <label class="form-label">Mô tả sản phẩm:</label>
            <!-- <textarea v-model="formData.description" class="form-control" placeholder="Nhập mô tả sản phẩm"></textarea> -->
            <div id="editor"></div>
          </div>

          <div class="mb-3">
            <label class="form-label">Số lượng:</label>
            <input v-model="formData.quantity" type="number" class="form-control" placeholder="Nhập số lượng"
              value="1" />
          </div>

          <div class="mb-3">
            <label class="form-label">Chọn Category:</label>
            <select v-model="formData.category_id" class="form-select">
              <option value="" disabled>Chọn Category</option>
              <option v-for="category in categories" :value="category.id">{{ category.name }}</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">SKUs:</label>
            <div v-for="(sku, index) in formData.skus" :key="index" class="card mb-3 p-3">
              <div class="row g-3">
                <div class="col-md-6">
                  <label class="form-label">Mã SKU:</label>
                  <input v-model="sku.sku_code" type="text" class="form-control" />
                </div>
                <div class="col-md-6">
                  <label class="form-label">Size:</label>
                  <input v-model="sku.size" type="text" class="form-control" />
                </div>
                <div class="col-md-6">
                  <label class="form-label">Số lượng tồn:</label>
                  <input v-model="sku.stock" type="number" class="form-control" />
                </div>
              </div>
            </div>
            <button type="button" class="btn btn-secondary" @click="addSku" style="margin-left: 10px;">
              Thêm SKU
            </button>
          </div>

          <div class="mb-3">
            <label class="form-label">Tải lên hình ảnh:</label>
            <input type="file" class="form-control" @change="handleFileChange" multiple />
          </div>

          <div class="mb-3">
            <label class="form-label">Chọn ảnh chính:</label>
            <select v-model="formData.primary_image" class="form-select">
              <option value="" disabled>Chọn ảnh chính</option>
              <option v-for="image in imageFiles" :key="image.name" :value="image.name">{{ image.name }}</option>
            </select>
          </div>

          <button type="submit" class="btn btn-primary">Thêm sản phẩm</button>
        </form>

        <div style="height: 100vh"></div>
      </div>
    </main>
  </div>
</template>


<script setup>
import { ref, reactive, onMounted } from 'vue';
import axios from 'axios';
import Swal from 'sweetalert2';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

const editor = ref(null);

const API_URL = 'http://127.0.0.1:8000';
const products = ref([]);
const categories = ref([]);
const imageFiles = ref([]);
const formData = reactive({
  name: '',
  price: '',
  description: '',
  quantity: '',
  category_id: '',
  skus: [],
  images: [],
  primary_image: ''
});

const errors = reactive({
  name: '',
  price: '',
  description: '',
  quantity: '',
  category_id: '',
  images: '',
  primary_image: ''
});

const loadCategories = async () => {
  try {
    const response = await axios.get(`${API_URL}/api/categories`);
    categories.value = response.data;
  } catch (error) {
    console.error('Error loading categories:', error.response.data);
  }
};

const addSku = () => {
  formData.skus.push({ sku_code: '', size: '', stock: 0 });
};

const handleFileChange = (event) => {
  imageFiles.value = Array.from(event.target.files);
  formData.images = imageFiles.value.map((file) => ({
    file,
    name: file.name
  }));
};

const handleSubmit = async () => {
  const requestData = new FormData();
  Object.keys(formData).forEach((key) => {
    if (key === 'skus') {
      formData.skus.forEach((sku, index) => {
        Object.entries(sku).forEach(([skuKey, value]) => {
          requestData.append(`skus[${index}][${skuKey}]`, value);
        });
      });
    } else if (key === 'images') {
      formData.images.forEach((image) => {
        requestData.append('images[]', image.file);
      });
    } else {
      requestData.append(key, formData[key]);
    }
  });

  requestData.set('primary_image', formData.primary_image);

  try {
    await axios.post(`${API_URL}/api/products`, requestData, {
      headers: { 'Content-Type': 'multipart/form-data' }
    });
    Swal.fire({
      icon: 'success',
      title: 'Thêm sản phẩm thành công!',
    });
    formData.name = '';
    formData.price = '';
    formData.description = '';
    formData.quantity = '';
    formData.category_id = '';
    formData.skus = [];
    formData.images = [];
    formData.primary_image = '';
    imageFiles.value = [];
  } catch (error) {
    console.error('Error creating product:', error.response.data);
    Swal.fire({
      icon: 'error',
      title: 'Đã xảy ra lỗi!',
      text: error.response.data.message || 'Vui lòng kiểm tra lại thông tin!'
    });
  }
};

const loadProducts = async () => {
  try {
    const response = await axios.get(`${API_URL}/api/products`);
    products.value = response.data;
  } catch (error) {
    console.error('Error loading products:', error.response.data);
  }
};

onMounted(async () => {
  await loadCategories();
  await loadProducts();

  ClassicEditor
    .create(document.querySelector('#editor'), {
    })
    .then(editorInstance => {
      editor.value = editorInstance;
      editorInstance.model.document.on('change:data', () => {
        formData.description = editorInstance.getData(); // Lấy dữ liệu từ CKEditor và lưu vào formData
      });
    })
    .catch(error => {
      console.error("CKEditor initialization error: ", error);
    });
});
</script>
