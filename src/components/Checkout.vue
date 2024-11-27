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

  <!-- Checkout Section Begin -->
  <section class="checkout spad">
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

              <!-- Hiển thị thông tin địa chỉ nếu có -->
              <div class="row" v-if="address && address.length > 0">
                <div class="card col-lg-12">
                  <div v-for="(addresses, index) in address" :key="index" class="checkout__input">
                    <div class="row align-items-center mt-3">
                      <div class="col-md-1 text-center">
                        <input type="radio" :value="addresses" v-model="selectedAddress" name="addressSelection"
                          class="form-check-input" />
                      </div>
                      <div class="col-lg-11">
                        <p class="fw-bold fs-6 mb-1">{{ addresses.full_name }}</p>
                        <p class="mb-1">{{ addresses.province }}, {{ addresses.district }}, {{ addresses.commune }}, {{
                          addresses.hamlet }}</p>
                        <p class="mb-1">{{ addresses.phone }}</p>
                      </div>
                    </div>
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
                  </li>
                </ul>
                <div class="checkout__order__subtotal">Tạm tính <span>{{ formatVND(subtotal) }}</span></div>
                <div class="checkout__order__total">Tổng thanh toán <span>{{ formatVND(subtotal) }}</span></div>

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
                <button type="button" class="site-btn" @click.prevent="confirmPayment">Xác Nhận Thanh Toán</button>
                <!-- <button type="submit" class="site-btn" @click.prevent="confirmPayment">Xác Nhận Thanh Toán</button> -->
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import axios from 'axios';
import { getProvinces, getDistricts, getWards } from 'vietnam-provinces';
import { useRouter } from 'vue-router';

const router = useRouter();
const API_URL = 'http://127.0.0.1:8000';
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

const address = ref([]);

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
      return {
        ...item,
        name: productDetails.name,
        price: productDetails.price,
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
        alert("Địa chỉ đã được lưu thành công!");
        isAddingNewAddress.value = false;
        await loadAddress();
      } else {
        alert("Có lỗi xảy ra khi lưu địa chỉ!");
      }
    } catch (error) {
      console.error("Error saving address:", error);
      alert("Lỗi kết nối với máy chủ!");
    }
  } else {
    alert("Vui lòng điền đầy đủ thông tin!");
  }
};

const paymentMethod = ref(null);


const confirmPayment = async () => {
  console.log("Selected Address:", selectedAddress.value);
  console.log("Total Price:", subtotal.value);
  console.log("Payment Method:", paymentMethod.value);

  if (paymentMethod.value === 'cod' && (
    !selectedAddress.value ||
    !selectedAddress.value.full_name ||
    !selectedAddress.value.phone ||
    !selectedAddress.value.province ||
    !selectedAddress.value.district ||
    !selectedAddress.value.commune ||
    !selectedAddress.value.hamlet)) {
    alert("Vui lòng chọn địa chỉ đầy đủ để tiếp tục!");
    return;
  }

  const orderData = {
    user_id: user_id,
    full_name: selectedAddress.value?.full_name,
    phone: selectedAddress.value?.phone,
    province: selectedAddress.value?.province,
    district: selectedAddress.value?.district,
    commune: selectedAddress.value?.commune,
    hamlet: selectedAddress.value?.hamlet,
    total_price: subtotal.value,
    payment_method: paymentMethod.value,
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
            amount: subtotal.value,
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
          alert("Có lỗi xảy ra trong quá trình thanh toán.");
        }
      } else if (paymentMethod.value === 'momo') {
        try {
          const momoResponse = await axios.post(`${API_URL}/api/momo`, {
            amount: subtotal.value,
            order_id: response.data.order.id,
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
        alert("Đơn hàng đã được tạo thành công. Bạn sẽ thanh toán khi nhận hàng.");
        router.push('/thanh-cong');
      }
    } else {
      console.error("Có lỗi xảy ra trong quá trình tạo đơn hàng.");
      alert("Có lỗi xảy ra trong quá trình tạo đơn hàng.");
    }
  } catch (error) {
    console.error("Lỗi khi tạo đơn hàng:", error.response?.data || error);
    alert("Có lỗi xảy ra trong quá trình thanh toán.");
  }
};



const formatVND = value => new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(value);

onMounted(() => {
  loadCart();
  provinces.value = getProvinces();
  loadAddress();
});
</script>
