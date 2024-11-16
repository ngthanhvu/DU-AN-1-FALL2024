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
        <form action="#">
          <div class="row">
            <div class="col-lg-8 col-md-6">
              <div class="row">
                <div class="col-lg-6">
                  <div class="checkout__input">
                    <p><b>Họ</b><span>*</span></p>
                    <input type="text">
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="checkout__input">
                    <p><b>Tên</b><span>*</span></p>
                    <input type="text">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-6">
                  <div class="checkout__input">
                    <p> <b>Số Điện Thoại</b><span>*</span></p>
                    <input type="text">
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="checkout__input">
                    <p><b>Email</b><span>*</span></p>
                    <input type="text">
                  </div>
                </div>
              </div>
              <form>
                <!-- Chọn Tỉnh/Thành -->
                <div class="form-group">
                  <label for="province">Tỉnh/Thành:</label>
                  <select id="province" class="form-control" v-model="selectedProvince" @change="onProvinceChange">
                    <option value="" disabled>Chọn Tỉnh/Thành</option>
                    <option v-for="province in provinces" :key="province.code" :value="province.code">
                      {{ province.name }}
                    </option>
                  </select>
                </div>

                <!-- Chọn Quận/Huyện -->
                <div class="form-group" v-if="districts.length > 0">
                  <label for="district">Quận/Huyện:</label>
                  <select id="district" class="form-control" v-model="selectedDistrict" @change="onDistrictChange">
                    <option value="" disabled>Chọn Quận/Huyện</option>
                    <option v-for="district in districts" :key="district.code" :value="district.code">
                      {{ district.name }}
                    </option>
                  </select>
                </div>
                <!-- Chọn Xã/Phường -->
                <div class="form-group" v-if="wards.length > 0">
                  <label for="ward">Xã/Phường:</label>
                  <select id="ward" class="form-control" v-model="selectedWard">
                    <option value="" disabled>Chọn Xã/Phường</option>
                    <option v-for="ward in wards" :key="ward.code" :value="ward.code">
                      {{ ward.name }}
                    </option>
                  </select>
                </div>
              </form>
              <div class="col-lg-12">
                  <div class="checkout__input">
                    <p><b>Thôn/Xóm</b><span>*</span></p>
                    <input type="text">
                  </div>
                </div>
              <div class="checkout__input__checkbox">
                <label for="acc">
                  Đồng ý với điều khoản & Dịch vụ ?
                  <input type="checkbox" id="acc">
                  <span class="checkmark"></span>
                </label>
              </div>
              <div class="checkout__input">
                <p>Ghi chú đơn hàng (tùy chọn)<span>*</span></p>
                <textarea rows="4" style="width: 100%; padding: 10px; opacity: 0.8"></textarea>
              </div>
            </div>
            <div class="col-lg-4 col-md-6">
              <div class="checkout__order">
                <h4>ĐƠN HÀNG</h4>
                <div class="checkout__order__products">Sản phẩm <span>Giá tiền</span></div>
                <ul>
                  <li>Áo MU đỏ <span>350.000đ</span></li>
                  <li>Áo MU Away (2024-2025) Màu xanh <span>250.000đ</span></li>
                  <li>Áo Đức Home (2024 - 2025) Màu trắng <span>450.000đ</span></li>
                </ul>
                <div class="checkout__order__subtotal">Tạm tính <span>1.000.000đ</span></div>
                <div class="checkout__order__total">Tổng thanh toán <span>1.100.000đ</span></div>

                <!-- Phương thức thanh toán -->
                <div class="checkout__input__checkbox">
                  <label for="cod">
                    Thanh Toán Khi Nhận Hàng
                    <img src="https://cdn-icons-png.flaticon.com/512/9368/9368523.png" style="width: 25px; height: 25px;" alt="" class="">
                    <input type="radio" name="payment" id="cod" value="cod">
                    <span class="checkmark"></span>
                  </label>
                </div>
                <div class="checkout__input__checkbox">
                  <label for="banking">
                    Thanh Toán Bằng Banking
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS9EtT711vIcfJWlsFu2NWU1fq-UY-S4igEpPFbIDcPkYDbXCmiymvKEtyzu54ZmLn5Sg0&usqp=CAU" style="width: 25px; height: 25px;" alt="" class="">
                    <input type="radio" name="payment" id="banking" value="banking">
                    <span class="checkmark"></span>
                  </label>
                </div>
                <div class="checkout__input__checkbox">
                  <label for="vnpay">
                    Thanh Toán Bằng VNPAY 
                    <img src="https://is1-ssl.mzstatic.com/image/thumb/Purple211/v4/62/46/37/62463711-9d15-39bd-d596-6dce575fd1ca/AppIcon-0-0-1x_U007emarketing-0-7-0-0-85-220.png/246x0w.webp" style="width: 25px; height: 25px;" alt="">
                    <input type="radio" name="payment" id="vnpay" value="vnpay">
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

<script>
export default {
  name: 'Checkout',
  data() {
    return {
      provinces: [], // Danh sách tỉnh thành
      districts: [], // Danh sách quận huyện
      wards: [],     // Danh sách phường xã
      selectedProvince: "", // Tỉnh được chọn
      selectedDistrict: "", // Quận được chọn
      selectedWard: "",     // Xã được chọn
    };
  },
  async created() {
    // Lấy danh sách tỉnh thành khi khởi tạo
    this.provinces = await getProvinces();
  },
  methods: {
    async onProvinceChange() {
      // Lấy danh sách quận huyện khi chọn tỉnh
      if (this.selectedProvince) {
        this.districts = await getDistricts(this.selectedProvince);
        this.wards = []; // Reset danh sách phường xã
        this.selectedDistrict = "";
        this.selectedWard = "";
      }
    },
    async onDistrictChange() {
      // Lấy danh sách phường xã khi chọn quận huyện
      if (this.selectedDistrict) {
        this.wards = await getWards(this.selectedDistrict);
        this.selectedWard = "";
      }
    },
  },
}
import { getProvinces, getDistricts, getWards } from "vietnam-provinces";

</script>

<style>
.site-btn {
  background-color: #ff0000;
  color: #fff;
  padding: 10px 15px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

.site-btn:hover {
  background-color: #ad3939;
  color: #fff;
}
.textarea-no-resize {
  resize: vertical; 
  width: 100%; 
}

</style>
