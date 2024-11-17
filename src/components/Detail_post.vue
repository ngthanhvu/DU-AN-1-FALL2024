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
                    <!-- Main Content -->
                    <div class="col-md-8">
                        <article class="main-article mb-5">
                            <!-- Thumbnail -->
                            <img src="https://via.placeholder.com/800x400" class="img-fluid mb-4"
                                alt="Article Thumbnail" />
                            <!-- Title -->
                            <h1 class="article-title mb-3">Tiêu đề bài viết</h1>
                            <!-- Meta Information -->
                            <div class="article-meta text-muted mb-3">
                                <span><i class="fas fa-user"></i> Tác giả: Admin</span>
                                <span class="mx-2">|</span>
                                <span><i class="fas fa-calendar-alt"></i> Ngày đăng: 17/11/2024</span>
                            </div>
                            <!-- Content -->
                            <p class="article-content">
                                Đây là phần nội dung chi tiết của bài viết. Bạn có thể sử dụng văn bản mẫu
                                hoặc dữ liệu thực tế để hiển thị thông tin. Nội dung bài viết cần được trình bày rõ ràng
                                với các đoạn văn dễ đọc, sử dụng hình ảnh và tiêu đề phụ nếu cần thiết.
                            </p>
                        </article>

                        <!-- Related Articles Section -->
                        <section class="related-articles">
                            <h3 class="section-title mb-4">Bài viết liên quan</h3>
                            <div class="row">
                                <div class="col-md-4 mb-3" v-for="i in 3" :key="i">
                                    <div class="card h-100">
                                        <img src="https://via.placeholder.com/400x200" class="card-img-top"
                                            alt="Related Article" />
                                        <div class="card-body">
                                            <h5 class="card-title">Tiêu đề bài viết {{ i }}</h5>
                                            <p class="card-text text-muted">
                                                Tóm tắt ngắn gọn nội dung của bài viết liên quan.
                                            </p>
                                            <router-link to="/tin-tuc" class="btn btn-primary btn-sm">Xem chi
                                                tiết</router-link>
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


<script>
export default {
    data() {
        return {
            categories: ["Thể thao", "Kinh tế", "Xã hội", "Công nghệ"],
        };
    },
};
</script>

<style scoped>
.article-title {
    font-size: 2rem;
    font-weight: bold;
}

.related-articles .card-title {
    font-size: 1rem;
}
</style>