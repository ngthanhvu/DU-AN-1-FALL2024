<template>
  <div id="layoutSidenav_content">
    <main>
      <div class="container-fluid px-4" style="margin-top: 80px;">
        <h2 class="mt-4">Quản lý bài viết</h2>
        <div v-if="posts.length === 0" class="alert alert-info text-center">
          Hiện chưa có bài viết nào.
        </div>
        <div v-else>
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
              <tr v-for="(post, index) in posts" :key="post.id">
                <td class="text-center">{{ index + 1 }}</td>
                <td>{{ post.title }}</td>
                <td>{{ truncateContent(post.content) }}</td>
                <td class="text-center">
                  <img v-if="post.image" :src="`${API_URL}/storage/${post.image}`" alt="Hình ảnh bài viết"
                    class="img-thumbnail" style="max-width: 100px; object-fit: cover;" />
                </td>

                <td>{{ post.user?.name || "Ẩn danh" }}</td>
                <td>
                  <button class="btn btn-primary" @click="editPost(post)"><font-awesome-icon
                      :icon="['fas', 'pen-to-square']" /></button> |
                  <button class="btn btn-danger" @click="deletePost(post.id)"><font-awesome-icon
                      :icon="['far', 'trash-can']" /></button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div style="height: 100vh"></div>

      </div>
    </main>
  </div>
</template>

<script setup>
import axios from 'axios';
import { ref, onMounted } from 'vue';
const API_URL = 'http://127.0.0.1:8000';
const posts = ref([]);

const fetchPosts = async () => {
  try {
    const response = await axios.get('http://127.0.0.1:8000/api/posts');
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

const truncateContent = (content) => {
  return cleanContent(content);
};

onMounted(fetchPosts);
</script>

<style scoped>

</style>