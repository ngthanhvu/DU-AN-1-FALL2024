<template>
  <div id="layoutSidenav_content">
    <main>
      <div class="container-fluid px-4" style="margin-top: 80px;">
        <h2 class="mt-4">Quản lý bài viết</h2>

        <!-- No posts available message -->
        <div v-if="posts.length === 0" class="alert alert-info text-center">
          Hiện chưa có bài viết nào.
        </div>

        <div v-else>
          <!-- Posts table -->
          <table class="table table-bordered table-hover">
            <thead class="table-dark text-center">
              <tr>
                <th>#</th>
                <th>Tiêu Đề</th>
                <th>Nội Dung</th>
                <th>Hình Ảnh</th>
                <th>Người Đăng</th>
                <th>Hành Động</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(post, index) in pagedPosts" :key="post.id">
                <td class="text-center">{{ index + 1 }}</td>
                <td>{{ post.title }}</td>
                <td>{{ truncateContent(post.content) }}</td>
                <td class="text-center">
                  <img v-if="post.image" :src="`${API_URL}/storage/${post.image}`" alt="Hình ảnh bài viết"
                    class="img-thumbnail" style="max-width: 100px; object-fit: cover;" />
                </td>

                <td>{{ post.user?.name || "Ẩn danh" }}</td>
                <td>
                  <!-- Edit post button -->
                  <button class="btn btn-primary" @click="editPost(post)">
                    <font-awesome-icon :icon="['fas', 'pen-to-square']" />
                  </button> |
                  <!-- Delete post button -->
                  <button class="btn btn-danger" @click="deletePost(post.id)">
                    <font-awesome-icon :icon="['far', 'trash-can']" />
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
          <!-- phân trang -->
          <div class="d-flex justify-content-center mt-3">
            <nav aria-label="Page navigation example">
              <ul class="pagination">
                <li class="page-item" :class="{ disabled: currentPage === 1 }">
                  <a class="page-link" href="#" @click.prevent="goToPage(currentPage - 1)">Previous</a>
                </li>
                <li class="page-item" v-for="page in totalPages" :key="page" :class="{ active: page === currentPage }">
                  <a class="page-link" href="#" @click.prevent="goToPage(page)">{{
                    page
                  }}</a>
                </li>
                <li class="page-item" :class="{ disabled: currentPage === totalPages }">
                  <a class="page-link" href="#" @click.prevent="goToPage(currentPage + 1)">Next</a>
                </li>
              </ul>
            </nav>
          </div>
        </div>

        <!-- Edit Post Modal -->
        <div v-if="showEditModal" class="modal fade show" style="display: block;" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Chỉnh Sửa Bài Viết</h5>
                <button type="button" class="btn-close" @click="closeEditModal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form @submit.prevent="updatePost">
                  <div class="mb-3">
                    <label for="title" class="form-label">Tiêu Đề</label>
                    <input type="text" class="form-control" id="title" v-model="editingPost.title" required />
                  </div>
                  <div class="mb-3">
                    <label for="content" class="form-label">Nội Dung</label>
                    <textarea class="form-control" id="content" v-model="editingPost.content" rows="4"
                      required></textarea>
                  </div>
                  <div class="mb-3">
                    <label for="image" class="form-label">Hình Ảnh</label>
                    <input type="file" class="form-control" id="image" @change="handleImageChange" />
                  </div>
                  <div class="mb-3">
                    <button type="submit" class="btn btn-success">Cập Nhật</button>
                    <button type="button" class="btn btn-secondary" @click="closeEditModal">Hủy</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>

        <!-- For spacing -->
        <div style="height: 100vh"></div>
      </div>
    </main>
  </div>
</template>

<script setup>
import axios from 'axios';
import { ref, onMounted, computed } from 'vue';
const editingPost = ref({
  id: null,
  title: '',
  content: '',
  image: null
});
const showEditModal = ref(false);

const API_URL = import.meta.env.VITE_API_URL;

const posts = ref([]);

const itemsPerPage = 10;
const currentPage = ref(1);

const totalPages = computed(() => {
  return Math.ceil(posts.value.length / itemsPerPage);
});

const pagedPosts = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage;
  const end = start + itemsPerPage;
  return posts.value.slice(start, end);
});

const goToPage = (page) => {
  if (page >= 1 && page <= totalPages.value) {
    currentPage.value = page;
  }
};

const fetchPosts = async () => {
  try {
    const response = await axios.get(`${API_URL}/api/posts`);
    posts.value = response.data.posts;
  } catch (error) {
    console.error('Lỗi khi tải bài viết:', error);
    alert('Không thể tải danh sách bài viết!');
  }
};

const cleanContent = (content) => {
  const cleanedContent = content.replace(/<\/?[^>]+(>|$)/g, "");
  return cleanedContent.length > 100 ? cleanedContent.slice(0, 100) + '...' : cleanedContent;
};

const truncateContent = (content) => cleanContent(content);

const deletePost = async (id) => {
  try {
    await axios.delete(`${API_URL}/api/posts/${id}`);
    posts.value = posts.value.filter(post => post.id !== id);
    alert('Bài viết đã được xóa.');
  } catch (error) {
    console.error('Lỗi khi xóa bài viết:', error);
    alert('Không thể xóa bài viết!');
  }
};

const editPost = (post) => {
  editingPost.value = { ...post };
  showEditModal.value = true;
};
const closeEditModal = () => {
  showEditModal.value = false;
};
const handleImageChange = (event) => {
  editingPost.value.image = event.target.files[0];
};
const updatePost = async () => {
  try {
    const formData = new FormData();
    formData.append('title', editingPost.value.title);
    formData.append('content', editingPost.value.content);
    formData.append('user_id', editingPost.value.user_id);

    if (editingPost.value.image) {
      formData.append('image', editingPost.value.image);
    }

    const response = await axios.put(`${API_URL}/api/posts/${editingPost.value.id}`, formData);
    const index = posts.value.findIndex(post => post.id === editingPost.value.id);
    posts.value[index] = response.data.post;
    showEditModal.value = false;
    alert('Bài viết đã được cập nhật!');
  } catch (error) {
    console.error('Lỗi khi cập nhật bài viết:', error);
    alert('Không thể cập nhật bài viết!');
  }
};

onMounted(fetchPosts);
</script>

<style scoped></style>
