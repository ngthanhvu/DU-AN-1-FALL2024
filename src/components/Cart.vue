<script setup>
import { ref, computed, onMounted } from 'vue';
import axios from 'axios';
import Swal from 'sweetalert2';
const API_URL = import.meta.env.VITE_API_URL;

const cartItems = ref([]);
const discountValue = ref(0);
const discountApplied = ref(false);

const isProcessing = ref(false);

const subtotal = computed(() =>
  cartItems.value.reduce((sum, item) => sum + item.price * item.quantity, 0)
);

const totalAfterDiscount = computed(() =>
  subtotal.value - discountValue.value
);

const loadCart = async () => {
  const userId = localStorage.getItem('user_id');
  const guestId = localStorage.getItem('guest_id');

  if (!userId && !guestId) {
    console.error('No user_id or guest_id found in localStorage');
    return;
  }

  try {
    const response = await axios.get(`${API_URL}/api/cart`, {
      params: {
        user_id: userId,
        guest_id: guestId
      }
    });

    const cartItemsWithDetails = await Promise.all(response.data.map(async item => {
      const productResponse = await axios.get(`${API_URL}/api/products/${item.product_id}`);
      const productDetails = productResponse.data;

      const sku = productDetails.skus.find(sku => sku.size === item.size);
      const price = sku ? sku.price : productDetails.price;
      const quantity_detail = productDetails.quantity;

      return {
        ...item,
        name: productDetails.name,
        price: price,
        image: productDetails.images[0]?.image_path || '',
        quantity_detail: quantity_detail
      };
    }));

    cartItems.value = cartItemsWithDetails;
  } catch (error) {
    console.error('Error loading cart:', error);
    alert('Có lỗi xảy ra khi tải giỏ hàng');
  }
};


const updateQuantity = async (cartId, newQuantity) => {
  try {
    const response = await axios.post(`${API_URL}/api/cart/update`, {
      cart_id: cartId,
      quantity: newQuantity
    });

    if (response.data.message === 'Quantity updated successfully') {
      loadCart();
      setTimeout(() => {
        isProcessing.value = false;
      }, 800)
    }
  } catch (error) {
    console.error('Error updating quantity:', error);
    alert('Có lỗi xảy ra khi cập nhật số lượng');
  }
};

const incrementQty = (index) => {
  if (isProcessing.value) return;
  isProcessing.value = true;

  if (cartItems.value[index].quantity >= cartItems.value[index].quantity_detail) {
    Swal.fire({
      icon: 'warning',
      title: 'Số lượng sản phẩm không đủ',
      text: 'Số lượng trong kho hiện tại: ' + cartItems.value[index].quantity_detail,
    })
    isProcessing.value = false;
    return;
  }

  const cartItem = cartItems.value[index];
  cartItem.quantity++;
  updateQuantity(cartItem.id, cartItem.quantity);
};

const decrementQty = (index) => {
  if (isProcessing.value) return;
  isProcessing.value = true;

  const cartItem = cartItems.value[index];
  if (cartItem.quantity > 1) {
    cartItem.quantity--;
    updateQuantity(cartItem.id, cartItem.quantity);
  }
};

const removeItem = async (index) => {
  const userId = localStorage.getItem('user_id');
  const guestId = localStorage.getItem('guest_id');
  const productId = cartItems.value[index].product_id;

  try {
    const result = await Swal.fire({
      title: 'Xác nhận xóa?',
      text: 'Bạn không thể hoàn tác sau khi xóa!',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Xoá',
      cancelButtonText: 'Huỷ'
    });

    if (result.isConfirmed) {
      const response = await axios.post(`${API_URL}/api/cart/remove`, {
        product_id: productId,
        user_id: userId,
        guest_id: guestId
      });

      if (response.data.message === 'Product removed from cart successfully') {
        cartItems.value.splice(index, 1);
        updateCart();
      }
      Swal.fire({
        icon: 'success',
        title: 'Đã xóa!',
        text: 'Sản phẩm đã được xóa khỏi giỏ hàng'
      });
    }

  } catch (error) {
    console.error('Error removing product from cart:', error);
    alert('Có lỗi xảy ra khi xóa sản phẩm khỏi giỏ hàng');
  }
};

const updateCart = () => {
  localStorage.setItem('cart', JSON.stringify(cartItems.value));
};

const formatVND = value => new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(value);

onMounted(() => {
  loadCart();
});
</script>


<template>
  <!-- Breadcrumb Section -->
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
            <li><strong><span class="text-danger"> Giỏ Hàng</span></strong></li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  <div v-if="isProcessing" class="loading-overlay">
    <div class="spinner"></div>
  </div>
  <!-- Shoping Cart Section -->
  <section class="shoping-cart spad">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="shoping__cart__table">
            <table>
              <thead>
                <tr>
                  <th class="shoping__product">Sản Phẩm</th>
                  <th>Tên sản phẩm</th>
                  <th>Giá</th>
                  <th>Số Lượng</th>
                  <th>Size</th>
                  <th>Tổng</th>
                  <th>Hành động</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(item, index) in cartItems" :key="item.productId">
                  <td class="shoping__cart__item">
                    <img :src="`${API_URL}/storage/${item.image}`" :alt="item.image" alt="product-image" />
                  </td>
                  <td class="shoping__cart__text">
                    <h5>{{ item.name }}</h5>
                  </td>
                  <td class="shoping__cart__price">
                    {{ formatVND(item.price) ?? '0' }}
                  </td>
                  <td class="shoping__cart__quantity">
                    <div class="quantity mx-auto">
                      <button class="qty-btn decrement" @click="decrementQty(index)">-</button>
                      <input type="text" v-model.number="item.quantity" class="qty-input" readonly>
                      <button class="qty-btn increment" @click="incrementQty(index)">+</button>

                    </div>
                  </td>
                  <td class="shoping__cart__total">{{ item.size }}</td>
                  <td class="shoping__cart__total">
                    {{ formatVND(item.price * item.quantity) ?? '0' }}
                  </td>
                  <td class="shoping__cart__item__close">
                    <span class="icon_clos" @click="removeItem(index)" style="color: red">X</span>
                  </td>
                </tr>
                <tr v-if="cartItems.length === 0">
                  <td colspan="9">Không có sản phẩm trong giỏ hàng</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-6">
        </div>
        <div class="col-lg-12">
          <div class="shoping__checkout">
            <h5>TỔNG SẢN PHẨM</h5>
            <ul>
              <li>Tạm tính <span>{{ subtotal.toLocaleString('vi-VN') }}đ</span></li>
              <li v-if="discountApplied">Giảm giá <span>{{ discountValue.toLocaleString('vi-VN') }}đ</span></li>
              <li>Tổng thanh toán <span>{{ totalAfterDiscount.toLocaleString('vi-VN') }}đ</span></li>
            </ul>
            <router-link to="/thanh-toan" class="primary-btn">
              TIẾN HÀNH THANH TOÁN
              <font-awesome-icon :icon="['far', 'credit-card']" />
            </router-link>
            <br>
            <router-link to="/san-pham" class="primary-btn cart-btn">
              TIẾP TỤC MUA SẮM
              <font-awesome-icon :icon="['fas', 'bag-shopping']" />
            </router-link>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>




<style scoped>
.quantity {
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
  width: 100px;
  /* Điều chỉnh kích thước */
}

.qty-btn {
  background-color: #f7f7f7;
  border: none;
  width: 30px;
  height: 30px;
  font-size: 18px;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
}

.qty-btn:active {
  background-color: #e0e0e0;
  /* Hiệu ứng khi nhấn */
}

.qty-input {
  text-align: center;
  width: 40px;
  border: none;
  font-size: 16px;
  background-color: #f7f7f7;
}

.loading-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000;
}

.spinner {
  border: 4px solid rgba(255, 255, 255, 0.3);
  border-top: 4px solid white;
  border-radius: 50%;
  width: 40px;
  height: 40px;
  animation: spin 1s linear infinite;
}

@keyframes spin {
  to {
    transform: rotate(360deg);
  }
}
</style>
