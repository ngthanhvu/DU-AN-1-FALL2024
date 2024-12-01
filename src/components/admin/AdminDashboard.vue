<template>
  <div id="layoutSidenav_content">
    <main>
      <div class="container-fluid px-4" style="margin-top: 80px;">
        <h1 class="mt-4">Bảng điều khiển</h1>
        <div class="row">
          <!-- Card 1 -->
          <div class="col-md-4">
            <div class="card text-center shadow-sm">
              <div class="card-body bg-success text-white">
                <i class="bi bi-graph-up fs-1 text-white"></i>
                <h6 class="mt-2">Số đơn hàng</h6>
                <h5 class="fw-bold">{{ orders.length }} đơn</h5>
              </div>
            </div>
          </div>
          <!-- Card 2 -->
          <div class="col-md-4">
            <div class="card text-center shadow-sm">
              <div class="card-body bg-primary text-white">
                <i class="bi bi-person-fill fs-1 text-white"></i>
                <h6 class="mt-2">Số người dùng</h6>
                <h5 class="fw-bold">{{ users.length }} người</h5>
              </div>
            </div>
          </div>
          <!-- Card 3 -->
          <div class="col-md-4">
            <div class="card text-center shadow-sm">
              <div class="card-body bg-danger text-white">
                <i class="bi bi-graph-up-arrow fs-1 text-white"></i>
                <h6 class="mt-2">Doanh thu tổng</h6>
                <h5 class="fw-bold">{{ totalRevenueFormatted }}</h5>
              </div>
            </div>
          </div>
        </div>

        <div class="row mt-3">
          <!-- Biểu đồ Doanh thu theo ngày -->
          <div class="col-xl-6">
            <div class="card mb-4">
              <div class="card-header">
                <font-awesome-icon :icon="['fas', 'chart-column']" /> Doanh thu theo ngày
              </div>
              <div class="card-body">
                <LineChart :chartData="dailyRevenueData" :options="chartOptions" />
              </div>
            </div>
          </div>
          <!-- Biểu đồ Doanh thu theo tháng -->
          <div class="col-xl-6">
            <div class="card mb-4">
              <div class="card-header">
                <font-awesome-icon :icon="['fas', 'chart-simple']" /> Doanh thu theo tháng
              </div>
              <div class="card-body">
                <BarChart :chartData="monthlyRevenueData" :options="chartOptions" />
              </div>
            </div>
          </div>
        </div>
        <div style="height: 100vh"></div>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import axios from 'axios';
import { LineChart, BarChart } from 'vue-chart-3';
import { Chart as ChartJS, Title, Tooltip, Legend, LineElement, BarElement, CategoryScale, LinearScale, LineController, BarController, PointElement } from 'chart.js';

const API_URL = 'http://127.0.0.1:8000';
const users = ref([]);
const orders = ref([]);

const token = localStorage.getItem('token');

ChartJS.register(
  Title,
  Tooltip,
  Legend,
  LineElement,
  BarElement,
  CategoryScale,
  LinearScale,
  LineController,
  BarController,
  PointElement
);

// Dữ liệu chart cho doanh thu theo ngày
const dailyRevenueData = ref({
  labels: ['Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7', 'CN'],
  datasets: [
    {
      label: 'Doanh thu ($)',
      data: [0, 0, 0, 0, 0, 0, 0], // Mảng sẽ được cập nhật sau
      borderColor: 'rgba(75, 192, 192, 1)',
      backgroundColor: 'rgba(75, 192, 192, 0.2)',
    },
  ],
});

// Dữ liệu chart cho doanh thu theo tháng (Cập nhật để có 12 tháng)
const monthlyRevenueData = ref({
  labels: [
    'Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6',
    'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'
  ],
  datasets: [
    {
      label: 'Doanh thu ($)',
      data: new Array(12).fill(0), // Mảng 12 phần tử, khởi tạo giá trị doanh thu cho từng tháng
      backgroundColor: 'rgba(54, 162, 235, 0.2)',
      borderColor: 'rgba(54, 162, 235, 1)',
    },
  ],
});

const chartOptions = ref({
  responsive: true,
  maintainAspectRatio: false,
  plugins: {
    legend: {
      display: true,
      position: 'top',
    },
  },
});

// Fetch dữ liệu người dùng
const fetchUsers = async () => {
  try {
    const response = await axios.get(`${API_URL}/api/admin/users`, {
      headers: {
        Authorization: `Bearer ${token}`
      }
    });
    users.value = response.data;
  } catch (error) {
    console.error('Error fetching users:', error);
  }
};

// Fetch dữ liệu đơn hàng
const fetchOrders = async () => {
  try {
    const response = await axios.get(`${API_URL}/api/orders`);
    orders.value = response.data;
    getDailyRevenue();  // Cập nhật dữ liệu doanh thu theo ngày
    getMonthlyRevenue();  // Cập nhật dữ liệu doanh thu theo tháng
  } catch (error) {
    console.error('Error fetching orders:', error);
  }
};

// Tính toán doanh thu theo ngày
const getDailyRevenue = () => {
  const dailyRevenue = new Array(7).fill(0); // Mảng với 7 phần tử, đại diện cho 7 ngày trong tuần
  orders.value.forEach(order => {
    const orderDate = new Date(order.created_at);
    const dayOfWeek = orderDate.getDay(); // Lấy ngày trong tuần (0: Chủ nhật, 1: Thứ 2, ...)
    dailyRevenue[dayOfWeek] += parseFloat(order.total_price); // Cộng tổng doanh thu cho ngày tương ứng
  });
  dailyRevenueData.value.datasets[0].data = dailyRevenue; // Cập nhật dữ liệu vào biểu đồ
};

// Tính toán doanh thu theo tháng (Cập nhật cho 12 tháng)
const getMonthlyRevenue = () => {
  const monthlyRevenue = new Array(12).fill(0); // Mảng với 12 phần tử, đại diện cho 12 tháng trong năm
  orders.value.forEach(order => {
    const orderDate = new Date(order.created_at);
    const month = orderDate.getMonth(); // Lấy tháng (0-11)
    monthlyRevenue[month] += parseFloat(order.total_price); // Cộng tổng doanh thu cho tháng tương ứng
  });
  monthlyRevenueData.value.datasets[0].data = monthlyRevenue; // Cập nhật dữ liệu vào biểu đồ
};

// Tính tổng doanh thu
const totalRevenueFormatted = computed(() => {
  const revenue = orders.value.reduce((sum, order) => sum + parseFloat(order.total_price), 0);
  return formatVND(revenue);
});

// Hàm định dạng VND
const formatVND = (amount) => {
  return amount.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
};

// Lấy dữ liệu khi trang được load
onMounted(() => {
  fetchUsers();
  fetchOrders();
});
</script>

<style scoped>
h1 {
  color: #343a40;
}
</style>