<template>
    <section class="article-detail py-5">
        <!-- Breadcrumb Section -->
        <section class="breadcrumb-section shop1 text-center mb-4">
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
                            <li class="home">
                                <router-link to="/tin-tuc"><b>Tin tức </b></router-link>
                                <span class="icon-arrow-right text-danger">
                                    <font-awesome-icon :icon="['fas', 'arrow-right']" />
                                </span>
                            </li>
                            <li>
                                <strong><span class="text-danger"> Bài viết</span></strong>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- Article Content Section -->
        <section class="content-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <article class="main-article mb-5">
                            <img v-if="article.image" :src="`${API_URL}/storage/${article.image}`"
                                alt="Article Thumbnail" class="img-fluid mb-4" style="width: 1000px; height: 500px" />
                            <h1 class="article-title mb-3">{{ article.title }}</h1>
                            <div class="article-meta text-muted mb-3">
                                <span><i class="fas fa-user"></i> Tác giả: {{ article.author }}</span>
                                <span class="mx-2">|</span>
                                <span><i class="fas fa-calendar-alt"></i> Ngày đăng: {{ article.date }}</span>
                            </div>
                            <p class="article-content" v-html="article.content"></p>
                        </article>
                        <section class="related-articles">
                            <h3 class="section-title mb-4">Bài viết liên quan</h3>
                            <div class="row">
                                <div class="col-md-4 mb-3" v-for="relatedArticle in relatedArticles"
                                    :key="relatedArticle.id">
                                    <div class="card h-100">
                                        <img :src="relatedArticle.image" class="card-img-top" alt="Related Article" />
                                        <div class="card-body">
                                            <h5 class="card-title">{{ relatedArticle.title }}</h5>
                                            <p class="card-text text-muted">{{ relatedArticle.summary }}</p>
                                            <router-link :to="'/chi-tiet-tin-tuc/' + relatedArticle.id"
                                                class="btn btn-primary btn-sm">Xem chi tiết</router-link>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>

                    <!-- Sidebar Section -->
                    <div class="col-md-4">
                        <aside class="sidebar">
                            <h4 class="sidebar-title mb-4">Danh mục</h4>
                            <ul class="list-group">
                                <li class="list-group-item" v-for="category in categories" :key="category">
                                    <router-link to="#" class="text-decoration-none">{{ category }}</router-link>
                                </li>
                            </ul>
                        </aside>
                    </div>
                </div>
            </div>
        </section>
    </section>
</template>
<script setup>
import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import axios from 'axios';

const API_URL = 'http://127.0.0.1:8000';
const article = ref({
    title: '',
    author: '',
    date: '',
    image: '',
    content: ''
});

const categories = ref(['Category 1', 'Category 2', 'Category 3']);
const route = useRoute();
const id = route.params.id;

const fetchArticle = async () => {
  try {
    const response = await axios.get(`${API_URL}/api/posts/${id}`);
    const post = response.data.post;
    
    article.value = {
      title: post.title,
      author: post.user.username,
      date: post.created_at,
      image: post.image,
      content: post.content,
    };

    const relatedResponse = await axios.get(`${API_URL}/api/posts/related/${post.category_id}`);
    relatedArticles.value = relatedResponse.data.articles;

  } catch (error) {
    console.error('Failed to fetch article or related articles:', error);
  }
};


onMounted(() => {
    fetchArticle();
});
</script>
