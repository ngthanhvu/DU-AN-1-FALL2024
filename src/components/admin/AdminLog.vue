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
            <tr v-for="(log, index) in logs" :key="log.id">
              <td>{{ index + 1 }}</td>
              <td>{{ log.action }}</td>
              <td>{{ log.model }}</td>
              <td>{{ log.changes }}</td>
              <td>{{ formatDate(log.created_at) }}</td>
            </tr>
          </tbody>
        </table>

        <div style=" height: 100vh">
        </div>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const API_URL = import.meta.env.VITE_API_URL;

const logs = ref([]);
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
