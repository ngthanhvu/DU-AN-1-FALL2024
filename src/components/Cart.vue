<script setup>
import { ref, computed, onMounted } from 'vue';
import axios from 'axios';

const API_URL = 'http://127.0.0.1:8000';

const cartItems = ref([]); // Giỏ hàng hiện tại

console.log("Cart:", cartItems);

// Tính tổng tạm tính và tổng thanh toán
const subtotal = computed(() =>
    cartItems.value.reduce((sum, item) => sum + item.price * item.quantity, 0)
);

// Lấy dữ liệu giỏ hàng từ API
const loadCart = async () => {
    const userId = localStorage.getItem('user_id');
    const guestId = localStorage.getItem('guest_id');

    try {
        const response = await axios.get(`${API_URL}/api/cart`, {
            params: {
                user_id: userId,
                guest_id: guestId
            }
        });

        // Lấy thông tin chi tiết sản phẩm
        const cartItemsWithDetails = await Promise.all(response.data.map(async item => {
            const productResponse = await axios.get(`${API_URL}/api/products/${item.product_id}`);
            const productDetails = productResponse.data;
            return {
                ...item,
                name: productDetails.name,
                price: productDetails.price,
                image: productDetails.images[0]?.image_path || '' // Sử dụng ảnh đầu tiên hoặc chuỗi rỗng nếu không có ảnh
            };
        }));

        cartItems.value = cartItemsWithDetails;
    } catch (error) {
        console.error('Error loading cart:', error);
        alert('Có lỗi xảy ra khi tải giỏ hàng');
    }
};



// Tăng số lượng sản phẩm
const incrementQty = (index) => {
    cartItems.value[index].quantity++;
    updateCart();
};

// Giảm số lượng sản phẩm
const decrementQty = (index) => {
    if (cartItems.value[index].quantity > 1) {
        cartItems.value[index].quantity--;
        updateCart();
    }
};

// Xóa sản phẩm khỏi giỏ hàng
const removeItem = (index) => {
    cartItems.value.splice(index, 1);
    updateCart();
};

// Cập nhật lại giỏ hàng trong localStorage
const updateCart = () => {
    localStorage.setItem('cart', JSON.stringify(cartItems.value));
};

// Tải dữ liệu giỏ hàng khi component được mount
onMounted(() => {
    loadCart();
});
</script>


<template>
  <!-- Breadcrumb Section Begin -->
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
  <!-- Breadcrumb Section End -->

  <!-- Shoping Cart Section Begin -->
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
                                      <img :src="`${API_URL}/storage/${item.image}`" :alt="item.image" alt="product-image">
                                  </td>
                                  <td class="shoping__cart__text">
                                    <h5>{{ item.name }}</h5>
                                  </td>
                                  <td class="shoping__cart__price">
                                      {{ item.price?.toLocaleString('vi-VN') ?? '0' }}đ
                                  </td>
                                  <td class="shoping__cart__quantity">
                                      <div class="quantity mx-auto">
                                          <button class="qty-btn decrement" @click="decrementQty(index)">-</button>
                                          <input type="text" v-model.number="item.quantity" class="qty-input">
                                          <button class="qty-btn increment" @click="incrementQty(index)">+</button>
                                      </div>
                                  </td>
                                  <td class="shoping__cart__total">{{ item.size }}</td>
                                  <td class="shoping__cart__total">
                                      {{ (item.price * item.quantity)?.toLocaleString('vi-VN') ?? '0' }}đ
                                  </td>
                                  <td class="shoping__cart__item__close">
                                      <span class="icon_clos" @click="removeItem(index)">X</span>
                                  </td>
                              </tr>
                          </tbody>
                      </table>
                  </div>
              </div>
          </div>
          <div class="row">
              <div class="col-lg-12">
                  <div class="shoping__cart__btns">
                      <router-link to="/san-pham" class="primary-btn cart-btn">
                          TIẾP TỤC MUA SẮM <font-awesome-icon :icon="['fas', 'bag-shopping']" />
                      </router-link>
                  </div>
              </div>
              <div class="col-lg-6">
                  <div class="shoping__continue">
                      <div class="shoping__discount">
                          <h5>ƯU ĐÃI GIẢM GIÁ</h5>
                          <form action="#">
                              <input type="text" placeholder="Nhập mã giảm giá nếu có">
                              <button type="submit" class="site-btn">
                                  ÁP DỤNG <font-awesome-icon :icon="['fas', 'ticket']" />
                              </button>
                          </form>
                      </div>
                  </div>
              </div>
              <div class="col-lg-6">
                  <div class="shoping__checkout">
                      <h5>TỔNG SẢN PHẨM</h5>
                      <ul>
                          <li>Tạm tính <span>{{ subtotal.toLocaleString('vi-VN') }}đ</span></li>
                          <li>Tổng thanh toán <span>{{ subtotal.toLocaleString('vi-VN') }}đ</span></li>
                      </ul>
                      <router-link to="/thanh-toan" class="primary-btn">
                          TIẾN HÀNH THANH TOÁN <font-awesome-icon :icon="['far', 'credit-card']" />
                      </router-link>
                  </div>
              </div>
          </div>
      </div>
  </section>
  <!-- Shoping Cart Section End -->
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
</style>
