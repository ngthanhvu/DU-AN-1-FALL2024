<template>
    <section class="article-detail">
        <!-- <section class="breadcrumb-section shop1 text-center mb-4">
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
        </section> -->

        <!-- Article Content Section -->
        <section class="content-section mt-5 py-5">
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <article class="main-article mb-5 shadow-lg p-4 rounded bg-white">
                            <img v-if="article.image" :src="`${API_URL}/storage/${article.image}`"
                                alt="Article Thumbnail" class="img-fluid mb-4 rounded"
                                style="height: 500px; object-fit: cover;" />
                            <h1 class="article-title mb-3 text-dark">{{ article.title }}</h1>
                            <div class="article-meta text-muted mb-3">
                                <span><i class="fas fa-user"></i> Tác giả: <span class="fw-semibold">{{ article.author
                                        }}</span></span>
                                <span class="mx-2">|</span>
                                <span><i class="fas fa-calendar-alt"></i> Ngày đăng: <span class="fw-semibold">{{
                                    article.date }}</span></span>
                            </div>
                            <div class="article-content" v-html="article.content"></div>
                        </article>
                    </div>

                    <div class="col-md-4 sidebar-wrapper">
                        <aside class="sidebar fixed-sidebar">
                            <h4 class="sidebar-title mb-4">Có Thể Bạn Quan Tâm</h4>
                            <ul class="list-group">
                                <li v-for="latest in latestArticles" :key="latest.id"
                                    class="list-group-item d-flex align-items-center hover-item">
                                    <img v-if="latest.image" :src="`${API_URL}/storage/${latest.image}`"
                                        alt="Article Image" class="img-thumbnail me-3 rounded"
                                        style="width: 60px; height: 60px; object-fit: cover;" />
                                    <router-link :to="'/chi-tiet-tin-tuc/' + latest.id"
                                        class="text-decoration-none text-dark hover-link">
                                        {{ latest.title }}
                                    </router-link>
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

const API_URL = import.meta.env.VITE_API_URL;

const article = ref({
    title: '',
    author: '',
    date: '',
    image: '',
    content: ''
});

const latestArticles = ref([]);
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

        const allArticlesResponse = await axios.get(`${API_URL}/api/posts`);
        const allArticles = allArticlesResponse.data.posts;
        latestArticles.value = allArticles.slice(0, 4);

    } catch (error) {
        console.error('Failed to fetch article or all articles:', error);
    }
};

onMounted(() => {
    fetchArticle();
});
</script>
<style scoped>
/* General Styles */
body {
    font-family: 'Arial', sans-serif;
}

.breadcrumb {
    margin-top: 20px;
}

.breadcrumb-item {
    font-weight: 500;
}

.breadcrumb-link {
    color: #007bff;
    transition: color 0.3s;
}

.breadcrumb-link:hover {
    color: #d9534f;
}

.main-article {
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.article-title {
    font-size: 2rem;
    font-weight: 600;
}

.article-meta {
    font-size: 0.9rem;
    color: #777;
}

.article-meta .fw-semibold {
    font-weight: 600;
}

.article-content {
    font-size: 1.1rem;
    line-height: 1.8;
    color: #333;
    margin-top: 1.5rem;
}

.article-content p {
    margin-bottom: 1.5rem;
}

.article-content h2,
.article-content h3,
.article-content h4 {
    margin-top: 2rem;
    color: #2c3e50;
}

/* Sidebar */
.sidebar-title {
    font-size: 1.2rem;
    font-weight: 600;
    color: #333;
}

.list-group-item {
    border: 1px solid #e0e0e0;
    padding: 12px 15px;
    margin-bottom: 1rem;
    background-color: #f9f9f9;
    transition: background-color 0.3s, transform 0.2s ease-in-out;
}

.list-group-item:hover {
    background-color: #f1f1f1;
    transform: scale(1.03);
}

.list-group-item .hover-item img {
    border-radius: 5px;
}

.hover-link {
    color: #333;
    font-weight: 500;
    transition: color 0.3s;
}

.hover-link:hover {
    color: #d9534f;
}

img {
    width: 100%;

}

.fixed-sidebar {
    position: fixed;
    top: 100px;
    right: 50;
    width: 30%;
    height: calc(70vh - 70px);
    overflow-y: auto;
    padding: 15px;
    background-color: #f9f9f9;
    border-left: 1px solid #e0e0e0;
    box-shadow: -2px 0 8px rgba(0, 0, 0, 0.1);
}
</style>