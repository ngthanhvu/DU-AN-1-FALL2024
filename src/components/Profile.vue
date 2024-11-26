<template>
  <section class="shop1 text-center">
    <span class="crumb-border"></span>
    <div class="container">
      <div class="row">
        <div class="col-xs-12">
          <ul class="breadcrumb">
            <li class="home">
              <router-link to="/"><b>Trang chủ</b></router-link>
              <span class="icon-arrow-right text-danger">
                <font-awesome-icon :icon="['fas', 'arrow-right']" />
              </span>
            </li>
            <li><strong><span class="text-danger">Thông Tin Tài Khoản</span></strong></li>
          </ul>
        </div>
      </div>
    </div>
  </section>
  <div class="container profile-section" style="height: 60vh;">
    <div class="row mb-5">
      <div class="col-md-3">
        <ul class="list-group">
          <li class="list-group-item" @click="activeTab = 'account'">
            <span><font-awesome-icon icon="circle-user" /> Thông Tin Tài Khoản</span>
          </li>
          <li class="list-group-item" @click="activeTab = 'profile'">
            <span><font-awesome-icon icon="location-dot" /> Địa Chỉ</span>
          </li>
          <li class="list-group-item" @click="activeTab = 'orders'">
            <span><font-awesome-icon icon="list" /> Đơn Hàng</span>
          </li>
        </ul>
      </div>
      <div class="col-md-9">
        <div class="card">
          <div class="profile-header">
            <h5 class="card-title fw-bold fs-4">{{ activeTab === 'account' ? 'Thông Tin Tài Khoản' : activeTab ===
              'profile' ? 'Thông Tin Địa Chỉ' : 'Đơn Hàng' }}</h5>
          </div>

          <!-- Account Section -->
          <div class="card-body" v-if="activeTab === 'account'">
            <div class="mb-3">
              <label for="username" class="form-label">Tên đăng nhập:</label>
              <input type="text" class="form-control" id="username" v-model="profile.username" disabled />
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Email:</label>
              <input type="email" class="form-control" id="email" v-model="profile.email" disabled />
            </div>
            <div class="mb-3">
              <label for="name" class="form-label">Họ tên:</label>
              <input type="text" class="form-control" id="name" v-model="profile.name" disabled />
            </div>
            <div class="mb-3">
              <label for="phone" class="form-label">Số điện thoại:</label>
              <input type="text" class="form-control" id="phone" v-model="profile.phone" disabled />
            </div>
          </div>

          <!-- Profile Section (Address) -->
          <div class="card-body" v-if="activeTab === 'profile'">
            <button type="button" class="btn btn-secondary justify-content-end" @click="toggleNewAddressForm">
              Thêm Địa Chỉ Mới <font-awesome-icon :icon="['fas', 'plus']" />
            </button>
            <div v-if="isAddingNewAddress" class="mt-3 border p-3">
              <h5>Thêm Địa Chỉ Mới</h5>
              <div class="row mt-2">
                <div class="col-md-6">
                  <label for="fullName" class="form-label">Họ tên:</label>
                  <input type="text" class="form-control" id="fullName" v-model="newAddress.full_name" required />
                </div>
                <div class="col-md-6">
                  <label for="phone" class="form-label">Số điện thoại:</label>
                  <input type="text" class="form-control" id="phone" v-model="newAddress.phone" required />
                </div>
              </div>

              <!-- Province, District, Ward Section -->
              <div class="row mt-2">
                <div class="col-md-6">
                  <label for="province" class="form-label">Tỉnh/Thành phố:</label>
                  <select class="form-select" id="province" v-model="newAddress.province" @change="onProvinceChange">
                    <option value="">Chọn Tỉnh/Thành phố</option>
                    <option v-for="province in provinces" :key="province.code" :value="province.code">
                      {{ province.name }}
                    </option>
                  </select>
                </div>
                <div class="col-md-6">
                  <label for="district" class="form-label">Quận/Huyện:</label>
                  <select class="form-select" id="district" v-model="newAddress.district" @change="onDistrictChange"
                    :disabled="!newAddress.province">
                    <option value="">Chọn Quận/Huyện</option>
                    <option v-for="district in districts" :key="district.code" :value="district.code">
                      {{ district.name }}
                    </option>
                  </select>
                </div>
              </div>

              <div class="row mt-2">
                <div class="col-md-6">
                  <label for="ward" class="form-label">Xã/Phường:</label>
                  <select class="form-select" id="ward" v-model="newAddress.commune" :disabled="!newAddress.district">
                    <option value="">Chọn Xã/Phường</option>
                    <option v-for="ward in wards" :key="ward.code" :value="ward.code">
                      {{ ward.name }}
                    </option>
                  </select>
                </div>
                <div class="col-md-6">
                  <label for="hamlet" class="form-label">Thôn/Xóm:</label>
                  <input type="text" class="form-control" id="hamlet" v-model="newAddress.hamlet" required />
                </div>
              </div>
              <button type="button" class="btn btn-primary mt-3" @click="saveNewAddress" :disabled="!isFormValid">
                <i class="bi bi-floppy"></i> Lưu Địa Chỉ
              </button>
            </div>

            <table class="table mt-3 table-bordered">
              <thead>
                <tr>
                  <th>STT</th>
                  <th>Họ tên</th>
                  <th>Số điện thoại</th>
                  <th>Tỉnh/Thành phố</th>
                  <th>Quận/Huyện</th>
                  <th>Xã/Phường</th>
                  <th>Thôn/Xóm</th>
                  <th>Thao tác</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(addresses, index) in address" :key="addresses.id">
                  <td>{{ index + 1 }}</td>
                  <td>{{ addresses.full_name }}</td>
                  <td>{{ addresses.phone }}</td>
                  <td>{{ addresses.tinh_thanh }}</td>
                  <td>{{ addresses.quan_huyen }}</td>
                  <td>{{ addresses.xa_phuong }}</td>
                  <td>{{ addresses.thon_xom }}</td>
                  <td>
                    <button class="btn btn-primary" @click="editAddress(addresses)">
                      <font-awesome-icon :icon="['fas', 'pen-to-square']" />
                    </button>
                    |
                    <button class="btn btn-danger" @click="deleteAddress(addresses.id)">
                      <font-awesome-icon :icon="['far', 'trash-can']" />
                    </button>
                  </td>
                </tr>
                <tr v-if="address.length === 0" class="text-center">
                  <td colspan="8">Không có địa chỉ</td>
                </tr>
              </tbody>
            </table>
          </div>

          <!-- Orders Section -->
          <div class="card-body" v-if="activeTab === 'orders'">
            <button class="btn btn-primary" @click="addNewOrder">
              Thêm Đơn Hàng <font-awesome-icon :icon="['fas', 'plus']" />
            </button>
            <table class="table table-bordered mt-3">
              <thead>
                <tr>
                  <th>STT</th>
                  <th>Mã Đơn Hàng</th>
                  <th>Ngày Đặt</th>
                  <th>Tình Trạng</th>
                  <th>Chi Tiết</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(order, index) in orders" :key="order.id">
                  <td>{{ index + 1 }}</td>
                  <td>{{ order.orderCode }}</td>
                  <td>{{ order.date }}</td>
                  <td>{{ order.status }}</td>
                  <td>
                    <button class="btn btn-info" @click="viewOrderDetails(order)">
                      <font-awesome-icon :icon="['fas', 'eye']" />
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import { getProvinces, getDistricts, getWards } from 'vietnam-provinces';
import axios from 'axios';
import Swal from 'sweetalert2';

const API_URL = 'http://127.0.0.1:8000';
const user_id = localStorage.getItem('user_id');
const activeTab = ref('account');
const profile = ref({
  name: 'Nguyen Van A',
  email: 'user@example.com',
  phone: '0901234567',
  username: 'Username123',
});
const orders = ref([
  { id: 1, orderCode: 'ORD001', date: '2024-11-22', status: 'Đang xử lý' },
  { id: 2, orderCode: 'ORD002', date: '2024-11-23', status: 'Đã giao' },
]);

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

const toggleNewAddressForm = () => {
  isAddingNewAddress.value = !isAddingNewAddress.value;
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

const deleteAddress = async (id) => {
  const result = await Swal.fire({
    title: 'Xác nhận xóa?',
    text: "Không thể hoàn tác sau khi xóa!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Xóa',
    cancelButtonText: 'Hủy'
  });

  if (result.isConfirmed) {
    try {
      const response = await axios.delete(`${API_URL}/api/address/${id}`);
      if (response.status === 200) {
        loadAddress();
      }
    } catch (error) {
      console.error("Error deleting address:", error);
    }
  }
}

const saveNewAddress = async () => {
  if (newAddress.value.full_name && newAddress.value.phone && newAddress.value.province && newAddress.value.district && newAddress.value.commune && newAddress.value.hamlet) {
    try {
      const response = await axios.post(`${API_URL}/api/address`, {
        full_name: newAddress.value.full_name,
        phone: newAddress.value.phone,
        tinh_thanh: selectedProvinceName.value, // Tên của tỉnh thành
        quan_huyen: selectedDistrictName.value, // Tên của quận huyện
        xa_phuong: selectedWardName.value, // Tên của xã phường
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

const isFormValid = computed(() => {
  return newAddress.value.full_name && newAddress.value.phone && newAddress.value.province && newAddress.value.district && newAddress.value.commune && newAddress.value.hamlet;
});

const viewOrderDetails = (order) => {
  alert(`Chi tiết đơn hàng ${order.orderCode}`);
};

onMounted(() => {
  provinces.value = getProvinces();
  loadAddress();
});
</script>



<style scoped>
.profile-section {
  padding-top: 20px;
}

.card-header {
  background-color: #f8f9fa;
}

.card-body {
  background-color: #ffffff;
  padding: 20px;
}

.modal {
  display: none;
  position: fixed;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgba(0, 0, 0, 0.4);
}

.close:hover,
.close:focus {
  color: black;
  text-decoration: none;
  cursor: pointer;
}

.profile-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  /* padding: 15px; */
  padding-left: 15px;
  padding-top: 15px;
  margin-bottom: -10px;
}
</style>
