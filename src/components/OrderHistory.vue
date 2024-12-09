<template>
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
            <li><strong><span class="text-danger"> Lịch sử mua hàng</span></strong></li>
          </ul>
        </div>
      </div>
    </div>
  </section>
  <div class="order-history container mt-5" style="min-height: 100vh;">
    <h2 class="mb-4">Đơn hàng đã mua gần đây</h2>
    <div class="table-responsive">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>#</th>
            <th>Mã đơn hàng</th>
            <th>Ngày đặt</th>
            <th>Trạng thái</th>
            <th>Tổng tiền</th>
            <th>Hành động</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(order, index) in orders" :key="order.id">
            <td>{{ index + 1 }}</td>
            <td>#00{{ order.id }}</td>
            <td>{{ formatDate(order.created_at) }}</td>
            <td>
              <span v-if="order.status === 'paid'" class="badge text-bg-success">Đã thanh toán</span>
              <span v-else-if="order.status === 'pending'" class="badge text-bg-warning text-white">Đang chờ thanh
                toán</span>
              <span v-else-if="order.status === 'shipping'" class="badge text-bg-info text-white">Đang vận
                chuyển</span>
              <span v-else-if="order.status === 'completed'" class="badge text-bg-success">Hoàn thành</span>
              <span v-else-if="order.status === 'canceled'" class="badge text-bg-danger">Hủy</span>
            </td>
            <td>{{ formatCurrency(order.total_price) }}</td>
            <td>
              <button class="btn btn-primary btn-sm" @click="viewDetails(order)">
                <font-awesome-icon :icon="['fas', 'circle-info']" />
              </button>
            </td>
          </tr>
          <tr v-if="orders.length === 0">
            <td colspan="5">Không có đơn hàng</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Modal Chi tiết đơn hàng -->
  <div v-if="isModalVisible" class="modal fade show" style="display: block;" tabindex="-1"
    aria-labelledby="orderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="orderModalLabel">Chi tiết đơn hàng #00{{ selectedOrder?.id }}</h5>
          <button type="button" class="btn-close" @click="closeModal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p><strong>Mã đơn hàng:</strong> #00{{ selectedOrder?.id }}</p>
          <p><strong>Ngày đặt:</strong> {{ formatDate(selectedOrder?.created_at) }}</p>
          <p>
            <strong>Trạng thái:</strong>
            <span v-if="selectedOrder?.status === 'paid'" class="badge text-bg-success">Đã thanh toán</span>
            <span v-else-if="selectedOrder?.status === 'pending'" class="badge text-bg-warning text-white">Đang chờ
              thanh
              toán</span>
            <span v-else-if="selectedOrder?.status === 'shipping'" class="badge text-bg-info text-white">Đang vận
              chuyển</span>
            <span v-else-if="selectedOrder?.status === 'completed'" class="badge text-bg-success">Hoàn thành</span>
            <span v-else-if="selectedOrder?.status === 'canceled'" class="badge text-bg-danger">Hủy</span>
          </p>
          <p><strong>Tổng tiền:</strong> {{ formatCurrency(selectedOrder?.total_price) }}</p>
          <h4>Danh sách sản phẩm:</h4>
          <div class="order-items">
            <div v-for="item in selectedOrder?.order_details" :key="item.id"
              class="order-item d-flex align-items-center mb-3">
              <div>
                <p class="mb-1"><strong>{{ item.product.name }}</strong></p>
                <p class="mb-1">Số lượng: {{ item.quantity }}</p>
                <p class="mb-1">Đơn giá: {{ formatCurrency(item.price) }}</p>
                <p class="mb-1" v-html="item.product.description"></p>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" @click="closeModal">Đóng</button>
          <button v-if="selectedOrder?.status === 'pending'" class="btn btn-danger"
            @click="cancelOrder(selectedOrder?.id)">
            Hủy đơn hàng
          </button>
          <button class="btn btn-success" @click="buyAgain()">Mua lại</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';
import Swal from 'sweetalert2';

const router = useRouter();
const API_URL = import.meta.env.VITE_API_URL;

const orders = ref([]);
const selectedOrder = ref(null);
const isModalVisible = ref(false);
const user_id = localStorage.getItem('user_id');

const fetchOrders = async () => {
  try {
    const response = await axios.get(`${API_URL}/api/orders/user/${user_id}`);
    orders.value = response.data;
  } catch (error) {
    console.error(error);
  }
};

const formatCurrency = (amount) => {
  return new Intl.NumberFormat("vi-VN", { style: "currency", currency: "VND" }).format(amount);
};

const formatDate = (dateString) => {
  const date = new Date(dateString);
  if (isNaN(date.getTime())) {
    return null;
  }
  const options = {
    year: 'numeric',
    month: '2-digit',
    day: '2-digit',
    hour: '2-digit',
    minute: '2-digit',
    second: '2-digit',
    hour12: false
  };
  return new Intl.DateTimeFormat('vi-VN', options).format(date);
};

const viewDetails = (order) => {
  selectedOrder.value = order;
  isModalVisible.value = true;
};

const closeModal = () => {
  isModalVisible.value = false;
};

const buyAgain = () => {
  router.push('/san-pham');
};

const cancelOrder = async (orderId) => {
  const result = await Swal.fire({
    title: 'Xác nhận hủy',
    text: 'Bạn có chắc chắn muốn hủy đơn hàng này không?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Hủy đơn hàng',
    cancelButtonText: 'Không',
  });

  if (result.isConfirmed) {
    try {
      await axios.put(`${API_URL}/api/order/${orderId}`, { status: 'canceled' });
      fetchOrders();
      Swal.fire('Đã hủy!', 'Đơn hàng đã được hủy.', 'success');
    } catch (error) {
      console.error(error);
      Swal.fire('Lỗi!', 'Không thể hủy đơn hàng.', 'error');
    }
  }
};

onMounted(() => {
  fetchOrders();
});
</script>

<style scoped>
.order-history {
  font-family: Arial, sans-serif;
}

.order-details {
  border: 1px solid #ddd;
  padding: 15px;
  border-radius: 5px;
  background-color: #f9f9f9;
}

.table th,
.table td {
  text-align: center;
  vertical-align: middle;
}

.order-item {
  border: 1px solid #ddd;
  padding: 10px;
  border-radius: 5px;
  background-color: #fff;
}

.item-image {
  width: 80px;
  height: 80px;
  object-fit: cover;
  border: 1px solid #ccc;
  border-radius: 5px;
}
</style>
