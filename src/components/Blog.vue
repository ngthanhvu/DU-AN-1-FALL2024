<template>
  <!-- Breadcrumb Section Begin -->
  <section class="shop1 text-center" style="min-height: 100vh;">
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
            <li><strong><span class="text-danger"> Tin Tức</span></strong></li>
          </ul>
        </div>
      </div>
    </div>
    <section class="section-news">
      <div class="container">
        <h2 class="section-title mb-4">Tin Tức Mới Nhất</h2>
        <div class="row">
          <!-- Tin Tức 1 -->
          <div class="col-md-4 mb-4" v-for="post in posts" :key="post.id">
            <div class="news-item">
              <router-link :to="`/chi-tiet-tin-tuc/${post.id}`" class="text-decoration-none">
                <img v-if="post.image" :src="`${API_URL}/storage/${post.image}`" alt="Hình ảnh bài viết"
                  class="img-thumbnail" style="width: 450px; height: 300px " />

                <h4 class="mt-3" style="font-weight: bold; color: black">{{ post.title }}</h4>
                <p class="text-muted " v-html="truncateContent(post.content, 100)"></p>
              </router-link>
            </div>
          </div>
          <div v-if="posts.length === 0">
            <p>Không có bài viết</p>
          </div>
        </div>
      </div>
    </section>
  </section>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
const API_URL = import.meta.env.VITE_API_URL;

const posts = ref([]);


onMounted(async () => {
  try {
    const response = await axios.get(`${API_URL}/api/posts`);
    posts.value = response.data.posts;
  } catch (error) {
    console.error('Failed to fetch posts:', error);
  }
});
const cleanContent = (content) => {
  const cleanedContent = content.replace(/<\/?[^>]+(>|$)/g, "");
  return cleanedContent.length > 100 ? cleanedContent.slice(0, 100) + '...' : cleanedContent;
};

const truncateContent = (content) => {
  return cleanContent(content);
};
</script>
<style scoped>
.text-muted {
  --bs-text-opacity: 1;
  color: var(--bs-secondary-color) !important;
  text-align: left;
}

.news-item h4 {
  font-size: 1.7rem;
  text-align: left;
}
</style>
