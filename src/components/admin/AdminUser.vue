<template>
  <div id="layoutSidenav_content">
    <main>
      <div class="container-fluid px-4" style="margin-top: 80px;">
        <h2 class="mt-4">Quản lý người dùng</h2>
        <div class="mt-4" v-if="pagedUsers.length === 0">Đang tải danh sách người dùng...</div>
        <table class="table table-hover" v-else>
          <thead class="table-dark text-center">
            <tr>
              <th>#</th>
              <th>Tên người dùng</th>
              <th>Email</th>
              <th>Quyền</th>
              <th>Hành động</th>
            </tr>
          </thead>
          <tbody class="text-center">
            <tr v-for="(user, index) in pagedUsers" :key="index">
              <td>{{ index + 1 }}</td>
              <td>{{ user.username }}</td>
              <td>{{ user.email }}</td>
              <td>{{ user.role }}</td>
              <td v-if="user.role !== 'admin'">
                <button class="btn btn-primary" @click="editUser(user)">
                  <font-awesome-icon :icon="['fas', 'pen-to-square']" />
                </button>
                |
                <button class="btn btn-danger" @click="deleteUser(user.id)">
                  <font-awesome-icon :icon="['far', 'trash-can']" />
                </button>
              </td>
              <td v-else class="text-danger">không có quyền để xoá</td>
            </tr>
          </tbody>
        </table>

        <!-- Phân trang -->
        <div class="pagination mb-3">
          <button @click="goToPage(currentPage - 1)" :disabled="currentPage === 1">Trang trước</button>
          <button v-for="page in totalPages" :key="page" @click="goToPage(page)"
            :class="{ active: page === currentPage }">
            {{ page }}
          </button>
          <button @click="goToPage(currentPage + 1)" :disabled="currentPage === totalPages">Trang sau</button>
        </div>

        <!-- Modal hiển thị bằng v-if -->
        <div v-if="isModalVisible" class="modal-overlay">
          <div class="modal-content">
            <h5>Cập nhật quyền</h5>
            <form @submit.prevent="updateRole">
              <div class="mb-3">
                <label for="username" class="form-label">Tên người dùng</label>
                <input type="text" class="form-control" id="username" v-model="selectedUser.username" disabled />
              </div>
              <div class="mb-3">
                <label for="role" class="form-label">Quyền</label>
                <select class="form-select" id="role" v-model="selectedUser.role">
                  <option value="admin">Admin</option>
                  <option value="user">User</option>
                </select>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" @click="closeModal">Hủy</button>
                <button type="submit" class="btn btn-primary">Cập nhật</button>
              </div>
            </form>
          </div>
        </div>

      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import axios from 'axios';
import Swal from 'sweetalert2';

const API_URL = import.meta.env.VITE_API_URL;

const users = ref([]);
const token = localStorage.getItem('token');
const selectedUser = ref({});
const isModalVisible = ref(false);

const itemsPerPage = 10;
const currentPage = ref(1);

const totalPages = computed(() => {
  return Math.ceil(users.value.length / itemsPerPage);
});

const pagedUsers = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage;
  const end = start + itemsPerPage;
  return users.value.slice(start, end);
});

const goToPage = (page) => {
  if (page >= 1 && page <= totalPages.value) {
    currentPage.value = page;
  }
};
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

const editUser = (user) => {
  selectedUser.value = { ...user };
  isModalVisible.value = true;
};

const closeModal = () => {
  isModalVisible.value = false;
};

const updateRole = async () => {
  try {
    await axios.put(
      `${API_URL}/api/users/${selectedUser.value.id}/role`,
      { role: selectedUser.value.role },
      {
        headers: {
          Authorization: `Bearer ${token}`
        }
      }
    );
    Swal.fire({
      icon: 'success',
      title: 'Thành công!',
      text: 'Cập nhật quyền thành công!'
    })
    fetchUsers();
    closeModal();
  } catch (error) {
    console.error('Error updating role:', error);
  }
};

const deleteUser = async (id) => {
  try {
    const result = await Swal.fire({
      title: 'Bạn có chắc chắn?',
      text: 'Hành động này không thể hoàn tác!',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Xóa',
      cancelButtonText: 'Hủy',
    });

    if (result.isConfirmed) {
      const response = await axios.delete(`${API_URL}/api/users/${id}`, {
        headers: {
          Authorization: `Bearer ${token}`,
        },
      });

      Swal.fire({
        icon: 'success',
        title: 'Thành công!',
        text: 'Xóa người dùng thành công!',
      });

      fetchUsers();
    }
  } catch (error) {
    if (error.response && error.response.status === 400) {
      Swal.fire({
        icon: 'error',
        title: 'Không thể xóa người dùng!',
        text: error.response.data.message,
      });
    } else {
      Swal.fire({
        icon: 'error',
        title: 'Lỗi!',
        text: 'Đã có lỗi xảy ra khi xóa người dùng.',
      });
    }
  }
};


onMounted(() => {
  fetchUsers();
});
</script>

<style scoped>
h1 {
  color: #343a40;
}

.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
}

.modal-content {
  background: white;
  padding: 20px;
  border-radius: 5px;
  width: 400px;
}

.modal-footer {
  display: flex;
  justify-content: flex-end;
  margin-top: 10px;
}

.modal-footer .btn {
  margin-left: 10px;
}
</style>
