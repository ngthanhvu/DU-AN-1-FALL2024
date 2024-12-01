<template>
  <div id="layoutSidenav_content">
    <main>
      <div class="container-fluid px-4" style="margin-top: 80px;">
        <h2 class="mt-4 fw-bold">Quản lý sản phẩm</h2>

        <!-- Danh sách sản phẩm -->
        <table class="table table-bordered" id="productTable">
          <thead class="table-dark text-center">
            <tr>
              <th>#</th>
              <th>Tên sản phẩm</th>
              <th>Danh mục</th>
              <th>Giá</th>
              <th>Số Lượng</th>
              <th>Ảnh chính</th>
              <th>Ảnh phụ</th>
              <th>Sku Size</th>
              <th>Hành động</th>
            </tr>
          </thead>
          <tbody class="text-center">
            <tr v-for="(product, index) in products" :key="index">
              <td>{{ index + 1 }}</td>
              <td>{{ product.name }}</td>
              <td>{{ categories.find(category => category.id === product.category_id)?.name }}</td>
              <td>{{ formatPrice(product.price) }}</td>
              <td>{{ product.quantity }}</td>

              <td>
                <img v-if="product.images && product.images.length"
                  :src="`${API_URL}/storage/${getPrimaryImage(product.images)}`" alt="Primary Image"
                  class="product-image mx-auto" style="width: 200px; height: 200px; object-fit: cover;" />
              </td>
              <td>
                <div class="d-flex flex-wrap gap-2 justify-content-center">
                  <img v-for="image in product.images" :key="image.id" :src="`${API_URL}/storage/${image.image_path}`"
                    alt="Product Image" class="product-image" style="width: 50px; height: 50px; object-fit: cover;" />
                </div>
              </td>
              <td>
                <div v-for="sku in product.skus" :key="sku.id" class="mb-1">
                  {{ sku.size }}
                </div>
              </td>
              <td>
                <button class="btn btn-primary" @click="editProduct(product)"><font-awesome-icon
                    :icon="['fas', 'pen-to-square']" /></button> |
                <button class="btn btn-danger" @click="deleteProduct(product.id)"><font-awesome-icon
                    :icon="['far', 'trash-can']" /></button>
              </td>
            </tr>
            <tr v-if="products.length === 0">
              <td colspan="9">Không có sản phẩm</td>
            </tr>
          </tbody>
        </table>

        <!-- Modal Edit Form -->
        <div v-if="isModalVisible" class="modal-overlay" @click="closeModal"></div>
        <div v-if="isModalVisible" class="modal fade show" style="display: block;" tabindex="-1">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Chỉnh sửa sản phẩm</h5>
                <button type="button" class="btn-close" @click="closeModal"></button>
              </div>
              <form @submit.prevent="handleSubmit">
                <div class="modal-body">
                  <!-- Tên sản phẩm -->
                  <div class="mb-3">
                    <label class="form-label">Tên sản phẩm:</label>
                    <input v-model="formData.name" type="text" class="form-control" required />
                  </div>

                  <!-- Giá sản phẩm -->
                  <div class="mb-3">
                    <label class="form-label">Giá sản phẩm:</label>
                    <input v-model="formData.price" type="number" class="form-control" required />
                  </div>

                  <!-- Mô tả -->
                  <div class="mb-3">
                    <label class="form-label">Mô tả sản phẩm:</label>
                    <textarea v-model="formData.description" class="form-control" rows="3"></textarea>
                  </div>

                  <!-- Số lượng -->
                  <div class="mb-3">
                    <label class="form-label">Số lượng:</label>
                    <input v-model="formData.quantity" type="number" class="form-control" required />
                  </div>

                  <!-- Category -->
                  <div class="mb-3">
                    <label class="form-label">Danh mục:</label>
                    <select v-model="formData.category_id" class="form-select" required>
                      <option v-for="category in categories" :key="category.id" :value="category.id">
                        {{ category.name }}
                      </option>
                    </select>
                  </div>

                  <!-- SKUs -->
                  <div class="mb-3">
                    <label class="form-label">SKUs:</label>
                    <div v-for="(sku, index) in formData.skus" :key="index" class="card mb-3 p-3">
                      <div class="row g-3">
                        <div class="col-md-6">
                          <label class="form-label">Mã SKU:</label>
                          <input v-model="sku.sku_code" type="text" class="form-control" required />
                        </div>
                        <div class="col-md-6">
                          <label class="form-label">Size:</label>
                          <input v-model="sku.size" type="text" class="form-control" />
                        </div>
                        <!-- <div class="col-md-6">
                          <label class="form-label">Màu sắc:</label>
                          <input v-model="sku.color" type="text" class="form-control" />
                        </div> -->
                        <div class="col-md-6">
                          <label class="form-label">Số lượng tồn:</label>
                          <input v-model="sku.stock" type="number" class="form-control" required />
                        </div>
                      </div>
                      <button type="button" class="btn btn-danger mt-2" @click="removeSku(index)">
                        Xóa SKU
                      </button>
                    </div>
                    <button type="button" class="btn btn-secondary" @click="addSku">
                      Thêm SKU
                    </button>
                  </div>

                  <!-- Hình ảnh hiện tại -->
                  <div v-if="formData.images.length" class="mb-3">
                    <label class="form-label">Hình ảnh hiện tại:</label>
                    <div class="d-flex flex-wrap gap-2">
                      <div v-for="image in formData.images" :key="image.id" class="position-relative">
                        <img :src="`${API_URL}/storage/${image.image_path}`" class="product-image"
                          style="width: 100px; height: 100px; object-fit: cover;" />
                        <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0"
                          @click="removeImage(image.id)">
                          X
                        </button>
                      </div>
                    </div>
                  </div>

                  <!-- Upload hình ảnh mới -->
                  <div class="mb-3">
                    <label class="form-label">Thêm hình ảnh mới:</label>
                    <input type="file" class="form-control" @change="handleFileChange" multiple accept="image/*" />
                  </div>

                  <!-- Chọn ảnh chính -->
                  <div class="mb-3">
                    <label class="form-label">Ảnh chính:</label>
                    <select v-model="formData.primary_image" class="form-select">
                      <option value="">Chọn ảnh chính</option>
                      <option v-for="image in formData.images" :key="image.id" :value="image.image_path">
                        {{ image.image_path }}
                      </option>
                      <option v-for="(file, index) in imageFiles" :key="'new-' + index" :value="file.name">
                        {{ file.name }} (Ảnh mới)
                      </option>
                    </select>
                  </div>
                </div>

                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" @click="closeModal">
                    Đóng
                  </button>
                  <button type="submit" class="btn btn-primary">
                    Lưu thay đổi
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div style="height: 100vh"></div>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, reactive, onMounted } from 'vue';
import axios from 'axios';
import Swal from 'sweetalert2';

const API_URL = 'http://127.0.0.1:8000';
const isModalVisible = ref(false);
const products = ref([]);
const categories = ref([]);
const currentProductId = ref(null);
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

const formatPrice = (price) => {
  return new Intl.NumberFormat('vi-VN', {
    style: 'currency',
    currency: 'VND'
  }).format(price);
};

const getPrimaryImage = (images) => {
  const primaryImage = images.find(image => image.is_primary === 1);
  return primaryImage ? primaryImage.image_path : '';
};

const openModal = () => isModalVisible.value = true;
const closeModal = () => {
  isModalVisible.value = false;
  currentProductId.value = null;
  imageFiles.value = [];
  Object.keys(formData).forEach(key => {
    formData[key] = Array.isArray(formData[key]) ? [] : '';
  });
};

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

const loadProducts = async () => {
  try {
    const response = await axios.get(`${API_URL}/api/products`);
    products.value = response.data;
  } catch (error) {
    console.error('Error loading products:', error);
    Swal.fire({
      icon: 'error',
      title: 'Lỗi!',
      text: 'Không thể tải danh sách sản phẩm'
    });
  }
};

const addSku = () => {
  formData.skus.push({
    sku_code: '',
    size: '',
    stock: 0
  });
};

const removeSku = (index) => {
  formData.skus.splice(index, 1);
};

const handleFileChange = (event) => {
  imageFiles.value = Array.from(event.target.files);
};

const removeImage = async (imageId) => {
  try {
    await axios.delete(`${API_URL}/api/images/${imageId}`);
    formData.images = formData.images.filter(img => img.id !== imageId);
    if (formData.primary_image === imageId) {
      formData.primary_image = '';
    }
  } catch (error) {
    console.error('Error removing image:', error);
    Swal.fire({
      icon: 'error',
      title: 'Lỗi!',
      text: 'Không thể xóa hình ảnh'
    });
  }
};

const editProduct = (product) => {
  currentProductId.value = product.id;

  formData.name = product.name;
  formData.price = product.price;
  formData.description = product.description;
  formData.quantity = product.quantity;
  formData.category_id = product.category_id;
  formData.skus = JSON.parse(JSON.stringify(product.skus));
  formData.images = [...product.images];

  const primaryImage = product.images.find(img => img.is_primary === 1);
  formData.primary_image = primaryImage ? primaryImage.image_path : '';

  openModal();
};

const handleSubmit = async () => {
  try {
    const requestData = new FormData();

    requestData.append('name', formData.name);
    requestData.append('price', formData.price);
    requestData.append('description', formData.description);
    requestData.append('quantity', formData.quantity);
    requestData.append('category_id', formData.category_id);

    formData.skus.forEach((sku, index) => {
      Object.entries(sku).forEach(([key, value]) => {
        requestData.append(`skus[${index}][${key}]`, value);
      });
    });

    imageFiles.value.forEach(file => {
      requestData.append('images[]', file);
    });

    if (formData.primary_image) {
      requestData.append('primary_image', formData.primary_image);
    }

    requestData.append('_method', 'PUT');

    const response = await axios.post(
      `${API_URL}/api/products/${currentProductId.value}`,
      requestData,
      {
        headers: {
          'Content-Type': 'multipart/form-data'
        }
      }
    );

    Swal.fire({
      icon: 'success',
      title: 'Thành công!',
      text: 'Cập nhật sản phẩm thành công'
    });
    await loadProducts();
    closeModal();
  } catch (error) {
    console.error('Error updating product:', error.response?.data || error);

    Swal.fire({
      icon: 'error',
      title: 'Lỗi!',
      text: error.response?.data?.message || 'Có lỗi xảy ra khi cập nhật sản phẩm'
    });
  }
};

const deleteProduct = async (productId) => {
  try {
    const result = await Swal.fire({
      title: 'Xác nhận xóa?',
      text: "Bạn không thể hoàn tác sau khi xóa!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Xóa',
      cancelButtonText: 'Hủy'
    });

    if (result.isConfirmed) {
      await axios.delete(`${API_URL}/api/products/${productId}`);

      await loadProducts();

      Swal.fire({
        icon: 'success',
        title: 'Đã xóa!',
        text: 'Sản phẩm đã được xóa thành công'
      });
    }
  } catch (error) {
    console.error('Error deleting product:', error);
    Swal.fire({
      icon: 'error',
      title: 'Lỗi!',
      text: 'Không thể xóa sản phẩm'
    });
  }
};

onMounted(async () => {
  await Promise.all([
    loadCategories(),
    loadProducts()
  ]);
});
</script>

<style scoped>
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.5);
  z-index: 1050;
}

.product-image {
  object-fit: cover;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.modal-dialog {
  max-width: 800px;
}

.card {
  border: 1px solid #dee2e6;
  border-radius: 0.5rem;
}

/* Responsive styling */
@media (max-width: 768px) {
  .modal-dialog {
    margin: 0.5rem;
  }

  .table {
    display: block;
    overflow-x: auto;
  }

  .product-image {
    max-width: 100%;
    height: auto;
  }
}

/* Animation */
.modal.show {
  animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
  from {
    opacity: 0;
  }

  to {
    opacity: 1;
  }
}
</style>
