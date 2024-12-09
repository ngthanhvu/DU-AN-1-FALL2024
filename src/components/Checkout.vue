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
              <span class="icon-arrow-right text-danger"><font-awesome-icon :icon="['fas', 'arrow-right']" /> </span>
            </li>
            <li><strong><span class="text-danger"> Thanh Toán</span></strong></li>
          </ul>
        </div>
      </div>
    </div>
  </section>
  <!-- Breadcrumb Section End -->
  <div v-if="cartItems.length === 0" style="min-height: 100vh;"
    class="d-flex align-items-center justify-content-center">
    <div class="text-center">
      <i class="bi bi-cart-x display-1 text-danger"></i>
      <p class="mt-3 fs-4 text-muted">Vui lòng thêm sản phẩm vào giỏ hàng trước khi thanh toán</p>
    </div>
  </div>

  <!-- Checkout Section Begin -->
  <section class="checkout spad" v-else>
    <div class="container">
      <div class="checkout__form">
        <h4>Thông Tin Thanh Toán</h4>
        <form @submit.prevent="saveNewAddress">

          <div class="row">
            <div class="col-lg-8 col-md-6">
              <!-- Form thêm địa chỉ nếu không có địa chỉ -->
              <div class="row" v-if="!address || address.length === 0">
                <div class="col-lg-12">
                  <div class="form-group">
                    <label for="">Họ tên<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" v-model="newAddress.full_name">
                  </div>
                </div>
                <div class="col-lg-12">
                  <div class="form-group">
                    <label for="">Số Điện Thoại<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" v-model="newAddress.phone">
                  </div>
                </div>
                <!-- Các trường khác cho địa chỉ -->
                <div class="col-lg-12">
                  <div class="form-group">
                    <label for="province" class="form-label">Tỉnh/Thành phố:</label>
                    <select class="form-select" id="province" v-model="newAddress.province" @change="onProvinceChange">
                      <option value="">Chọn Tỉnh/Thành phố</option>
                      <option v-for="province in provinces" :key="province.code" :value="province.code">
                        {{ province.name }}
                      </option>
                    </select>
                  </div>
                </div>
                <div class="col-lg-12">
                  <div class="form-group" v-if="districts.length > 0">
                    <label for="district" class="form-label">Quận/Huyện:</label>
                    <select class="form-select" id="district" v-model="newAddress.district" @change="onDistrictChange"
                      :disabled="!newAddress.province">
                      <option value="">Chọn Quận/Huyện</option>
                      <option v-for="district in districts" :key="district.code" :value="district.code">
                        {{ district.name }}
                      </option>
                    </select>
                  </div>
                  <div class="col-lg-12">
                    <div class="form-group" v-if="wards.length > 0">
                      <label for="ward" class="form-label">Xã/Phường:</label>
                      <select class="form-select" id="ward" v-model="newAddress.commune"
                        :disabled="!newAddress.district">
                        <option value="">Chọn Xã/Phường</option>
                        <option v-for="ward in wards" :key="ward.code" :value="ward.code">
                          {{ ward.name }}
                        </option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-lg-12">
                  <div class="form-group">
                    <label for="hamlet" class="form-label">Thôn/Xóm:</label>
                    <input type="text" class="form-control" id="hamlet" v-model="newAddress.hamlet" required />
                  </div>
                </div>
                <!-- Button để thêm địa chỉ -->
                <div class="col-lg-12">
                  <button type="submit" class="site-btn">Thêm Địa Chỉ</button>
                </div>
              </div>

              <!-- Dropdown để chọn địa chỉ -->
              <div class="row" v-if="address && address.length > 0">
                <div class="col-lg-12">
                  <div class="form-group">
                    <label for="addressSelect">Chọn Địa Chỉ</label>
                    <select id="addressSelect" class="form-select" v-model="selectedAddress"
                      style="padding: 20px 20px;">
                      <option value="">Chọn Địa Chị</option>
                      <option v-for="(addresses, index) in address" :key="index" :value="addresses">
                        {{ addresses.full_name }} - {{ addresses.province }}, {{ addresses.district }}, {{
                          addresses.commune }}, {{ addresses.hamlet }} - {{ addresses.phone }}
                      </option>
                    </select>
                  </div>
                </div>
              </div>


            </div>
            <div class="col-lg-4 col-md-6">
              <div class="checkout__order">
                <h4>ĐƠN HÀNG</h4>
                <div class="checkout__order__products">Sản phẩm <span>Giá tiền</span></div>
                <ul>
                  <li v-for="(product, index) in cartItems" :key="index" class="text-truncate">
                    {{ product.name }} <span>{{ formatVND(product.price) }}</span>
                    <p class="product-quantity text-muted">Số lượng: {{ product.quantity }}</p>
                  </li>
                </ul>
                <div class="checkout__order__subtotal">Tạm tính <span>{{ formatVND(subtotal) }}</span></div>
                <div class="checkout__order__total" v-if="discountApplied">Giảm giá <span>{{ formatVND(discountValue)
                    }}</span></div>
                <div class="checkout__order__total">Tổng tiền <span>{{ formatVND(totalAfterDiscount) }}</span></div>

                <!-- Thêm ô input cho mã giảm giá -->
                <div class="form-group">
                  <form @submit.prevent="applyDiscount">
                    <label for="discountCode">Ưu đãi giảm giá:</label>
                    <input type="text" class="form-control" v-model="discountCode" placeholder="Nhập mã giảm giá">
                    <button type="submit" class="site-btn mt-2">Áp Dụng <font-awesome-icon
                        :icon="['fas', 'ticket']" /></button>
                  </form>
                </div>
                <div class="checkout__order__total">Tổng thanh toán <span>{{ formatVND(totalAfterDiscount) }}</span>
                </div>

                <div class="checkout__input__checkbox">
                  <label for="cod">
                    Thanh Toán Khi Nhận Hàng
                    <input type="radio" name="payment" id="cod" value="cod" v-model="paymentMethod">
                    <span class="checkmark"></span>
                  </label>
                </div>

                <div class="checkout__input__checkbox">
                  <label for="payment">
                    Thanh Toán Qua Thẻ
                    <input type="radio" name="payment" id="payment" value="vnpay" v-model="paymentMethod">
                    <span class="checkmark"></span>
                  </label>
                </div>

                <div class="checkout__input__checkbox">
                  <label for="momo">
                    Thanh Toán Qua MoMo
                    <input type="radio" name="payment" id="momo" value="momo" v-model="paymentMethod">
                    <span class="checkmark"></span>
                  </label>
                </div>

                <!-- Nút xác nhận thanh toán -->
                <button type="button" class="site-btn" @click.prevent="confirmPayment">Thanh Toán
                  <font-awesome-icon :icon="['fas', 'credit-card']" /></button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted, computed, watch } from 'vue';
import axios from 'axios';
import { getProvinces, getDistricts, getWards } from 'vietnam-provinces';
import { useRouter } from 'vue-router';
import Swal from 'sweetalert2';

const router = useRouter();
const API_URL = import.meta.env.VITE_API_URL;

const cartItems = ref([]);

const selectedAddress = ref(null);
const isAddingNewAddress = ref(false);
const isLoadingAddress = ref(true);
const provinces = ref([]);
const districts = ref([]);
const wards = ref([]);
const newAddress = ref({
  full_name: '',
  phone: '',
  province: '',
  district: '',
  commune: '',
  hamlet: '',
  houseNumber: '',
});
const discountApplied = ref(false);
const discountCode = ref('');
const discountValue = ref(0);
const totalAfterDiscount = computed(() =>
  subtotal.value - discountValue.value
);
const address = ref([]);
const users = ref([]);
const user_id = localStorage.getItem('user_id');

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

      // Nếu có SKU, lấy giá SKU
      const sku = productDetails.skus.find(sku => sku.size === item.size);
      const price = sku ? sku.price : productDetails.price;

      return {
        ...item,
        name: productDetails.name,
        price: price, // Cập nhật giá từ SKU hoặc giá mặc định
        image: productDetails.images[0]?.image_path || ''
      };
    }));

    cartItems.value = cartItemsWithDetails;
  } catch (error) {
    console.error('Error loading cart:', error);
    alert('Có lỗi xảy ra khi tải giỏ hàng');
  }
};

const subtotal = computed(() => {
  return cartItems.value.reduce((total, product) => {
    return total + (product.price * product.quantity);
  }, 0);
});


const selectedProvinceName = computed(() => {
  const province = provinces.value.find((item) => item.code === newAddress.value.province);
  return province ? province.name : '';
});

const selectedDistrictName = computed(() => {
  const district = districts.value.find((item) => item.code === newAddress.value.district);
  return district ? district.name : '';
});

const selectedWardName = computed(() => {
  const ward = wards.value.find((item) => item.code === newAddress.value.commune);
  return ward ? ward.name : '';
});

const onProvinceChange = (event) => {
  const selectedProvince = event.target.value;
  if (selectedProvince) {
    districts.value = getDistricts(selectedProvince);
    newAddress.value.district = '';
    newAddress.value.commune = '';
  } else {
    districts.value = [];
    wards.value = [];
  }
};

const onDistrictChange = (event) => {
  const selectedDistrict = event.target.value;
  if (selectedDistrict) {
    wards.value = getWards(selectedDistrict);
  } else {
    wards.value = [];
  }
};

const loadAddress = async () => {
  isLoadingAddress.value = true;
  try {
    const response = await axios.get(`${API_URL}/api/address/${user_id}`);
    if (response.status === 200 && Array.isArray(response.data)) {
      address.value = response.data.map(item => ({
        id: item.id,
        full_name: item.full_name,
        phone: item.phone,
        province: item.tinh_thanh,
        district: item.quan_huyen,
        commune: item.xa_phuong,
        hamlet: item.thon_xom,
      }));
    } else {
      address.value = [];
    }
  } catch (error) {
    console.error("Error loading address:", error);
    address.value = [];
  } finally {
    isLoadingAddress.value = false;
  }
};


const saveNewAddress = async () => {
  if (newAddress.value.full_name && newAddress.value.phone && newAddress.value.province && newAddress.value.district && newAddress.value.commune && newAddress.value.hamlet) {
    try {
      const response = await axios.post(`${API_URL}/api/address`, {
        full_name: newAddress.value.full_name,
        phone: newAddress.value.phone,
        tinh_thanh: selectedProvinceName.value,
        quan_huyen: selectedDistrictName.value,
        xa_phuong: selectedWardName.value,
        thon_xom: newAddress.value.hamlet,
        user_id: user_id
      });
      if (response.status === 201) {
        Swal.fire('Thành công', 'Thêm điạ chỉ giao hàng thành công!', 'success');
        isAddingNewAddress.value = false;
        await loadAddress();
      } else {
        Swal.fire('Lỗi', 'Có lỗi xảy ra khi lưu điạ chỉ giao hàng!', 'error');
      }
    } catch (error) {
      console.error("Error saving address:", error);
      Swal.fire('Lỗi', 'Có lỗi xảy ra khi lưu địa chỉ giao hàng!', 'error');
    }
  } else {
    Swal.fire('Lỗi', 'Vui lòng điền đầy đủ thông tin!', 'error');
  }
};

const paymentMethod = ref(null);

// console.log(cartItems.product.id);

const confirmPayment = async () => {
  console.log("Selected Address:", selectedAddress.value);
  console.log("Total Price:", totalAfterDiscount.value);
  console.log("Payment Method:", paymentMethod.value);

  if (paymentMethod.value === 'cod' && (
    !selectedAddress.value ||
    !selectedAddress.value.full_name ||
    !selectedAddress.value.phone ||
    !selectedAddress.value.province ||
    !selectedAddress.value.district ||
    !selectedAddress.value.commune ||
    !selectedAddress.value.hamlet)) {
    Swal.fire('Lỗi', 'Vui lòng điền đầy đủ thông tin giao hàng!', 'error');
    return;
  }

  const products = cartItems.value.map(item => ({
    id: item.product_id,
    quantity: item.quantity
  }));

  const orderData = {
    user_id: user_id,
    full_name: selectedAddress.value?.full_name,
    phone: selectedAddress.value?.phone,
    province: selectedAddress.value?.province,
    district: selectedAddress.value?.district,
    commune: selectedAddress.value?.commune,
    hamlet: selectedAddress.value?.hamlet,
    total_price: totalAfterDiscount.value,
    payment_method: paymentMethod.value,
    products: products
  };

  if (paymentMethod.value === 'vnpay' || paymentMethod.value === 'momo') {
    orderData.amount = subtotal.value;
  }

  console.log("Order Data:", orderData);

  try {
    const response = await axios.post(`${API_URL}/api/orders`, orderData);
    console.log("API /orders Response:", response.data);

    if (response.status === 201 && response.data.order) {
      console.log("Order Created:", response.data.order);

      if (paymentMethod.value === 'vnpay') {
        try {
          const paymentResponse = await axios.post(`${API_URL}/api/payment`, {
            amount: totalAfterDiscount.value,
            order_id: response.data.order.id,
          }, {
            headers: {
              'Content-Type': 'application/json'
            }
          });
          console.log("API /payment Response:", paymentResponse.data);

          if (paymentResponse.status === 200 && paymentResponse.data.url) {
            const paymentUrl = paymentResponse.data.url;
            window.location.replace(paymentUrl);
          } else {
            console.error("Không có URL thanh toán!");
            alert("Không có URL thanh toán!");
          }
        } catch (error) {
          console.error("Lỗi khi thực hiện thanh toán:", error);
          Swal.fire('Lỗi', 'Có lỗi xảy ra trong quá trình thanh toán.', 'error');
        }
      }
      else if (paymentMethod.value === 'momo') {
        try {
          const momoResponse = await axios.post(`${API_URL}/api/momo`, {
            amount: totalAfterDiscount.value,
            order_id: `momo_${response.data.order.id}`,
          });
          console.log("API /momo Response:", momoResponse.data);

          if (momoResponse.status === 200 && momoResponse.data.payUrl) {
            const momoPaymentUrl = momoResponse.data.payUrl;
            window.location.href = momoPaymentUrl;
          } else {
            console.error("Không có URL thanh toán MoMo!");
            alert("Không có URL thanh toán MoMo!");
          }
        } catch (error) {
          console.error("Lỗi khi thực hiện thanh toán MoMo:", error);
          alert("Có lỗi xảy ra trong quá trình thanh toán MoMo.");
        }
      } else if (paymentMethod.value === 'cod') {
        // Swal.fire('Thành công', 'Thanh toán thành công', 'success');
        try {
          await axios.post(`${API_URL}/api/orders/${response.data.order.id}/decrease-quantity`, {
            quantity: products.reduce((total, item) => total + item.quantity, 0)
          });
          const mailResponse = await axios.post(`${API_URL}/api/sendMail`, {
            email: String(users.value.email),
            subject: "Đặt hàng thành công!",
            total: String(totalAfterDiscount.value),
            name: String(users.value.username),
            order: String(response.data.order.id),

            // messageContent: "Cảm ơn bạn đã đặt hàng, đơn hàng sẽ sớm được giao trong 24h tới !",
          });
          console.log("API /sendMail Response:", mailResponse.data);
          router.push('/thanh-cong?status=00&order_id=' + response.data.order.id);
        } catch (error) {
          console.error("Error decreasing quantity:", error);
        }
      }
    } else {
      console.error("Có lỗi xảy ra trong quá trình tạo đơn hàng.");
      Swal.fire('Lỗi', 'Có lỗi xảy ra trong quá trình tạo đơn hàng.', 'error');
      router.push('/thanh-cong?status=01&order_id=' + response.data.order.id);
    }
  } catch (error) {
    console.error("Lỗi khi tạo đơn hàng:", error.response?.data || error);
    Swal.fire('Lỗi', 'Có lỗi xảy ra trong quá trình tạo đơn hàng.', 'error');
    router.push('/thanh-cong?status=01&order_id=' + response.data.order.id);
  }
};

const applyDiscount = async () => {
  if (!discountCode.value.trim()) {
    Swal.fire('Lỗi', 'Vui lòng nhập mã giảm giá', 'error');
    return;
  }

  const userId = localStorage.getItem('user_id');
  const guestId = localStorage.getItem('guest_id');
  const totalAmount = subtotal.value;

  try {
    const response = await axios.post(`${API_URL}/api/discounts/apply`, {
      code: discountCode.value,
      user_id: userId,
      guest_id: guestId,
      total_amount: totalAmount
    });

    if (response.data.success) {
      discountValue.value = response.data.discount_value;
      discountApplied.value = true;
    } else {
      Swal.fire('Lỗi', 'Mã giảm giá khó hợp lệ hoặc hết hạn', 'error');
    }
  } catch (error) {
    console.error('Error applying discount:', error);
    Swal.fire('Lỗi', 'Mã giảm giá hết lượt sử dụng hoặc không tồn tại', 'error');
  }
};

const getEmaillUser = async () => {
  try {
    const response = await axios.get(`${API_URL}/api/users/${user_id}`, {
      headers: {
        Authorization: `Bearer ${localStorage.getItem('token')}`
      }
    });
    if (response.status === 200) {
      users.value = response.data;
      console.log(users.value);
    }
  } catch (error) {
    console.error('Error fetching user email:', error);
  }
}

// console.log(email.value);

const formatVND = value => new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(value);

onMounted(() => {
  loadCart();
  provinces.value = getProvinces();
  loadAddress();
  getEmaillUser();
});
</script>
