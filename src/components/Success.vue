<template>
  <div class="d-flex justify-content-center align-items-center min-vh-100">
    <div class="text-center">
      <!-- Hình dấu tích -->
      <div class="mb-4">
        <font-awesome-icon :icon="['far', 'circle-check']" style="font-size: 150px; color: green;" />
        <p class="mt-3 fw-bold fs-3 text-success">THÀNH CÔNG</p>
        <p class="mt-3">Giao dịch của bạn đã hoàn tất thành công. Chúng tôi đã gửi cho bạn một email thông tin về chi tiết đơn hàng của bạn.</p>
      </div>

      <!-- Hai nút -->
      <router-link to="/san-pham" class="btn btn-danger m-2">Trở về mua hàng</router-link>
      <router-link to="/trang-ca-nhan" class="btn btn-success m-2">Xem đơn hàng</router-link>
    </div>
  </div>
</template>

<script setup>

</script>

<style scoped>
/* Tùy chỉnh thêm nếu cần */
</style>
