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
                <div class="card col-lg-12 p-3">
                  <h4>Địa chỉ</h4>
                  <div v-for="(addresses, index) in address" :key="index" class="checkout__input">
                    <div class="row mt-2">
                      <div class="col-md-6">
                        <label for="fullName" class="form-label">Họ tên:</label>
                        <input type="text" class="form-control bg-light" v-model="addresses.full_name" id="fullName"
                          readonly />
                      </div>
                      <div class="col-md-6">
                        <label for="phone" class="form-label">Số điện thoại:</label>
                        <input type="text" class="form-control bg-light" v-model="addresses.phone" id="phone"
                          readonly />
                      </div>
                    </div>
                    <div class="row mt-2">
                      <div class="col-md-6">
                        <label for="province" class="form-label">Tỉnh/Thành phố:</label>
                        <input type="text" class="form-control bg-light" v-model="addresses.tinh_thanh" id="province"
                          readonly>
                      </div>
                      <div class="col-md-6">
                        <label for="district" class="form-label">Quận/Huyện:</label>
                        <input type="text" class="form-control bg-light" v-model="addresses.quan_huyen" id="district"
                          readonly>
                      </div>
                    </div>
                    <div class="row mt-2">
                      <div class="col-md-6">
                        <label for="ward" class="form-label">Xã/Phường:</label>
                        <input type="text" class="form-control bg-light" v-model="addresses.xa_phuong" id="ward"
                          readonly>
                      </div>
                      <div class="col-md-6">
                        <label for="hamlet" class="form-label">Thôn/Xóm:</label>
                        <input type="text" class="form-control bg-light" v-model="addresses.thon_xom" id="hamlet"
                          readonly />
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Phần bên phải, đơn hàng -->
            <div class="col-lg-4 col-md-6">
              <div class="checkout__order">
                <h4>ĐƠN HÀNG</h4>
                <div class="checkout__order__products">Sản phẩm <span>Giá tiền</span></div>
                <ul>
                  <li v-for="(product, index) in cartItems" :key="index" class="text-truncate">
                    {{ product.name }} <span>{{ product.price }}đ</span>
                  </li>
                </ul>
                <div class="checkout__order__subtotal">Tạm tính <span>1.000.000đ</span></div>
                <div class="checkout__order__total">Tổng thanh toán <span>1.100.000đ</span></div>

                <!-- Phương thức thanh toán -->
                <div class="checkout__input__checkbox">
                  <label for="cod">
                    Thanh Toán Khi Nhận Hàng
                    <img src="https://cdn-icons-png.flaticon.com/512/9368/9368523.png"
                      style="width: 25px; height: 25px;" alt="" class="">
                    <input type="radio" name="payment" id="cod" value="cod">
                    <span class="checkmark"></span>
                  </label>
                </div>

                <button type="submit" class="site-btn">Xác Nhận Thanh Toán</button>
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

const API_URL = 'http://127.0.0.1:8000';
const cartItems = ref([]);

const selectedProvince = ref('');
const selectedDistrict = ref('');
const selectedWard = ref('');


const isAddingNewAddress = ref(false);
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
  try {
    const response = await axios.get(`${API_URL}/api/address/${user_id}`);
    if (response.status === 200) {
      address.value = response.data;
    }
  } catch (error) {
    console.error("Error loading address:", error);
  }
}

const saveNewAddress = async () => {
  if (newAddress.value.full_name && newAddress.value.phone && newAddress.value.province && newAddress.value.district && newAddress.value.commune && newAddress.value.hamlet) {
    try {
      const response = await axios.post(`${API_URL}/api/address`, {
        full_name: newAddress.value.full_name,
        phone: newAddress.value.phone,
        tinh_thanh: newAddress.value.province,
        quan_huyen: newAddress.value.district,
        xa_phuong: newAddress.value.commune,
        thon_xom: newAddress.value.hamlet,
        user_id: user_id
      });
      if (response.status === 201) {
        alert("Địa chỉ đã được lưu thành công!");
        isAddingNewAddress.value = false;
        loadAddress();
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


onMounted(() => {
  loadCart();
  provinces.value = getProvinces();
});
</script>
