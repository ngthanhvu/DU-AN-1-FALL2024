<template>
  <div id="layoutSidenav_content">
    <main>
      <div class="container-fluid px-4" style="margin-top: 80px;">
        <h1 class="mt-4">Bảng điều khiển</h1>
        <div class="row">
          <!-- Card 1 -->
          <div class="col-md-3">
            <div class="card text-center shadow-sm">
              <div class="card-body bg-success text-white">
                <i class="bi bi-graph-up fs-1 text-white"></i>
                <h6 class="mt-2">Số đơn hàng</h6>
                <h5 class="fw-bold">{{ orders.length }} đơn</h5>
              </div>
            </div>
          </div>
          <!-- Card 2 -->
          <div class="col-md-3">
            <div class="card text-center shadow-sm">
              <div class="card-body bg-primary text-white">
                <i class="bi bi-person-fill fs-1 text-white"></i>
                <h6 class="mt-2">Số người dùng</h6>
                <h5 class="fw-bold">{{ users.length }} người</h5>
              </div>
            </div>
          </div>
          <!-- Card 3 -->
          <div class="col-md-3">
            <div class="card text-center shadow-sm">
              <div class="card-body bg-danger text-white">
                <i class="bi bi-graph-up-arrow fs-1 text-white"></i>
                <h6 class="mt-2">Doanh thu hôm nay</h6>
                <h5 class="fw-bold">$1234</h5>
              </div>
            </div>
          </div>
          <!-- Card 4 -->
          <div class="col-md-3">
            <div class="card text-center shadow-sm">
              <div class="card-body bg-warning text-white">
                <i class="bi bi-pie-chart fs-1 text-white"></i>
                <h6 class="mt-2">Doanh thu tổng</h6>
                <h5 class="fw-bold">$1234</h5>
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
import { ref, onMounted } from 'vue';
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

const dailyRevenueData = ref({
  labels: ['Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7', 'CN'],
  datasets: [
    {
      label: 'Doanh thu ($)',
      data: [150, 250, 350, 450, 550, 650, 750],
      borderColor: 'rgba(75, 192, 192, 1)',
      backgroundColor: 'rgba(75, 192, 192, 0.2)',
    },
  ],
});

const monthlyRevenueData = ref({
  labels: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6'],
  datasets: [
    {
      label: 'Doanh thu ($)',
      data: [3000, 4000, 5000, 6000, 7000, 8000],
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

const fetchOrders = async () => {
  try {
    const response = await axios.get(`${API_URL}/api/orders`);
    orders.value = response.data;
  } catch (error) {
    console.error('Error fetching orders:', error);
  }
};


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
