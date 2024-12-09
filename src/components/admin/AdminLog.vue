<template>
  <div id="layoutSidenav_content">
    <main>
      <div class="container-fluid px-4" style="margin-top: 80px;">
        <h3 class="mt-3 fw-bold">Log server</h3>
        <table class="table table-bordered table-hover text-center">
          <thead class="table-dark">
            <tr>
              <th>#</th>
              <th>Hành động</th>
              <th>Vị trí ( Model )</th>
              <th>Thay đổi</th>
              <th>Thời gian hành động</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(log, index) in pagedLogs" :key="log.id">
              <td>{{ index + 1 }}</td>
              <td>{{ log.action }}</td>
              <td>{{ log.model }}</td>
              <td>{{ log.changes }}</td>
              <td>{{ formatDate(log.created_at) }}</td>
            </tr>
          </tbody>
        </table>
        <!-- Phân trang -->
        <div class="pagination mb-3">
          <button @click="goToPage(currentPage - 1)" :disabled="currentPage === 1"><font-awesome-icon
              :icon="['fas', 'angles-left']" /></button>
          <button v-for="page in totalPages" :key="page" @click="goToPage(page)"
            :class="{ active: page === currentPage }">
            {{ page }}
          </button>
          <button @click="goToPage(currentPage + 1)" :disabled="currentPage === totalPages"><font-awesome-icon
              :icon="['fas', 'angles-right']" /></button>
        </div>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import axios from 'axios';

const API_URL = import.meta.env.VITE_API_URL;

const logs = ref([]);

const itemsPerPage = 10;
const currentPage = ref(1);

const totalPages = computed(() => {
  return Math.ceil(logs.value.length / itemsPerPage);
});

const pagedLogs = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage;
  const end = start + itemsPerPage;
  return logs.value.slice(start, end);
});

const goToPage = (page) => {
  if (page >= 1 && page <= totalPages.value) {
    currentPage.value = page;
  }
};

const fetchLogs = async () => {
  try {
    const response = await axios.get(`${API_URL}/api/logs`);
    logs.value = response.data;
  } catch (error) {
    console.error('Failed to fetch logs:', error);
  }
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
}

onMounted(() => {
  fetchLogs();
})
</script>

<style scoped>
h1 {
  color: #343a40;
}
</style>
