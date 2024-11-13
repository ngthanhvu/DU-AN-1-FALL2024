<template>
    <div>
        <!-- Section 1: Carousel -->
        <section class="section-1">
            <div class="container">
                <div id="carouselExampleIndicators" class="carousel slide carousel-fade" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        <button v-for="(slide, index) in carouselImages" :key="index" type="button"
                            data-bs-target="#carouselExampleIndicators" :data-bs-slide-to="index"
                            :class="{ active: index === 0 }" :aria-current="index === 0"
                            :aria-label="'Slide ' + (index + 1)"></button>
                    </div>
                    <div class="carousel-inner">
                        <div v-for="(slide, index) in carouselImages" :key="index"
                            :class="['carousel-item', { active: index === 0 }]">
                            <img v-if="isDesktop" :src="slide.desktop" class="d-block w-100" alt="...">
                            <img v-else :src="slide.mobile" class="d-block w-100" alt="...">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </section>

        <!-- Section 2: Product Categories -->
        <section class="section-2 mt-5">
            <div class="container">
                <div class="row">
                    <!-- Category Card 1 -->
                    <div class="col-md-4">
                        <div class="product-card">
                            <div class="product-info">
                                <h3>Đồ bóng đá</h3>
                                <p>Áo bóng đá, giày bóng đá, tất bóng đá,...</p>
                                <a href="#" class="btn btn-custom">Mua Ngay</a>
                            </div>
                            <div class="product-image">
                                <img src="https://bizweb.dktcdn.net/thumb/large/100/483/998/products/photo-2024-07-01-20-38-03-3.jpg?v=1719845875673"
                                    alt="Đồ bóng đá">
                            </div>
                        </div>
                    </div>

                    <!-- Category Card 2 -->
                    <div class="col-md-4">
                        <div class="product-card">
                            <div class="product-info">
                                <h3>Đồ thể thao</h3>
                                <p>Áo thể thao, giày thể thao, tất thể thao,...</p>
                                <a href="#" class="btn btn-custom">Mua Ngay</a>
                            </div>
                            <div class="product-image">
                                <img src="https://bizweb.dktcdn.net/thumb/large/100/483/998/products/photo-2024-07-01-20-38-03-3.jpg?v=1719845875673"
                                    alt="Đồ thể thao">
                            </div>
                        </div>
                    </div>

                    <!-- Category Card 3 -->
                    <div class="col-md-4">
                        <div class="product-card">
                            <div class="product-info">
                                <h3>Phụ kiện thể thao</h3>
                                <p>Băng đầu gối, băng cổ tay, băng mắt cá chân,...</p>
                                <a href="#" class="btn btn-custom">Mua Ngay</a>
                            </div>
                            <div class="product-image">
                                <img src="https://bizweb.dktcdn.net/thumb/large/100/483/998/products/photo-2024-07-01-20-38-03-3.jpg?v=1719845875673"
                                    alt="Phụ kiện thể thao">
                            </div>
                        </div>
                    </div>

                    <!-- Thêm các thẻ sản phẩm khác nếu cần -->
                </div>
            </div>
        </section>

        <section class="section-3 mt-5">
            <div class="container">
                <h2>Cháy cùng Euro/Copa</h2>
                <swiper :slides-per-view="5" :loop="true" :autoplay="{ delay: 3000 }"  pagination
                    class="mySwiper">
                    <swiper-slide v-for="(item, index) in products" :key="index">
                        <a href="/detail_product" class="text-decoration-none text-black">
                            <div class="card border-0">
                                <img src="https://bizweb.dktcdn.net/thumb/1024x1024/100/483/998/products/9b098813-1-1722496273940.jpg"
                                    class="border" alt="Product Image">
                                <div class="card-body">
                                    <div class="rating">
                                        <font-awesome-icon :icon="['far', 'star']" class="star-icon" v-for="i in 5"
                                            :key="i" />
                                    </div>
                                    <p class="card-title text-left"><b>MU Home (2012/2013) Màu đỏ + Cộc tay | Bản
                                            CLASSIC [Không có quần]</b></p>
                                    <p class="card-text text-left">
                                        <span class="text-danger me-2"><b>250.000đ</b></span>
                                        <span class="text-decoration-line-through">300.000đ</span>
                                    </p>
                                </div>
                            </div>
                        </a>
                    </swiper-slide>
                </swiper>
            </div>
        </section>

        <section class="section-3 mt-5">
            <div class="container">
                <h2>Cháy cùng Euro/Copa</h2>
                <swiper :slides-per-view="5" :loop="true" :autoplay="{ delay: 3000 }"  pagination
                    class="mySwiper">
                    <swiper-slide v-for="(item, index) in products" :key="index">
                        <a href="/detail_product" class="text-decoration-none text-black">
                            <div class="card border-0">
                                <img src="https://bizweb.dktcdn.net/thumb/1024x1024/100/483/998/products/9b098813-1-1722496273940.jpg"
                                    class="border" alt="Product Image">
                                <div class="card-body">
                                    <div class="rating">
                                        <font-awesome-icon :icon="['far', 'star']" class="star-icon" v-for="i in 5"
                                            :key="i" />
                                    </div>
                                    <p class="card-title text-left"><b>MU Home (2012/2013) Màu đỏ + Cộc tay | Bản
                                            CLASSIC [Không có quần]</b></p>
                                    <p class="card-text text-left">
                                        <span class="text-danger me-2"><b>250.000đ</b></span>
                                        <span class="text-decoration-line-through">300.000đ</span>
                                    </p>
                                </div>
                            </div>
                        </a>
                    </swiper-slide>
                </swiper>
            </div>
        </section>

        <section class="section awe-section-4">
            <div class="section_banner_adv">
                <div class="container">
                    <div class="text-center  row mb-3 ">
                        <a class="col-12 px-md-0" href="https://b2b.farmersmarket.vn/" title="Quà Tết Doanh Nghiệp">
                            <img class="img-fluid lazyload loaded"
                                src="//theme.hstatic.net/1000141988/1001239110/14/section_hot_banner.png?v=343"
                                data-src="//theme.hstatic.net/1000141988/1001239110/14/section_hot_banner.png?v=343"
                                alt="Quà Tết Doanh Nghiệp" data-was-processed="true">
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <section class="section-3 mt-5">
            <div class="container">
                <h2>Cốc giữ nhiệt</h2>
                <swiper :slides-per-view="5" :loop="true" :autoplay="{ delay: 3000 }"  pagination
                    class="mySwiper">
                    <swiper-slide v-for="(item, index) in products" :key="index">
                        <a href="/detail_product" class="text-decoration-none text-black">
                            <div class="card border-0">
                                <img src="https://bizweb.dktcdn.net/thumb/1024x1024/100/483/998/products/9b098813-1-1722496273940.jpg"
                                    class="border" alt="Product Image">
                                <div class="card-body">
                                    <div class="rating">
                                        <font-awesome-icon :icon="['far', 'star']" class="star-icon" v-for="i in 5"
                                            :key="i" />
                                    </div>
                                    <p class="card-title text-left"><b>MU Home (2012/2013) Màu đỏ + Cộc tay | Bản
                                            CLASSIC [Không có quần]</b></p>
                                    <p class="card-text text-left">
                                        <span class="text-danger me-2"><b>250.000đ</b></span>
                                        <span class="text-decoration-line-through">300.000đ</span>
                                    </p>
                                </div>
                            </div>
                        </a>
                    </swiper-slide>
                </swiper>
            </div>
        </section>

        <!-- Section: Tin Tức -->
        <section class="section-news mt-5">
            <div class="container">
                <h2 class="section-title mb-4">Tin Tức Mới Nhất</h2>
                <div class="row">
                    <!-- Tin Tức 1 -->
                    <div class="col-md-4 mb-4">
                        <div class="news-item">
                            <a href="#" class="text-decoration-none">
                                <img src="https://cafefcdn.com/203337114487263232/2021/9/5/sport17bab263cf1original-ratio-1630800402561676628516.jpeg"
                                    class="img-fluid" alt="News Image 1">
                                <h4 class="mt-3">Man United lập kỷ lục thu về 1.366 tỷ từ bán áo đấu Ronaldo sau 12h,
                                    bao giờ thu hồi "vốn"?</h4>
                                <p class="text-muted">Theo LovetheSales.com, 12h sau khi áo đấu của Cristiano Ronaldo
                                    phát hành, fan đã bỏ ra tổng cộng 32,5 triệu bảng (60 triệu USD – khoảng 1.366 tỷ
                                </p>
                            </a>
                        </div>
                    </div>
                    <!-- Tin Tức 2 -->
                    <div class="col-md-4 mb-4">
                        <div class="news-item">
                            <a href="#" class="text-decoration-none">
                                <img src="https://cafefcdn.com/203337114487263232/2021/9/5/sport17bab263cf1original-ratio-1630800402561676628516.jpeg"
                                    class="img-fluid" alt="News Image 2">
                                <h4 class="mt-3">Man United lập kỷ lục thu về 1.366 tỷ từ bán áo đấu Ronaldo sau 12h,
                                    bao giờ thu hồi "vốn"?</h4>
                                <p class="text-muted">Theo LovetheSales.com, 12h sau khi áo đấu của Cristiano Ronaldo
                                    phát hành, fan đã bỏ ra tổng cộng 32,5 triệu bảng (60 triệu USD – khoảng 1.366 tỷ
                                </p>
                            </a>
                        </div>
                    </div>
                    <!-- Tin Tức 3 -->
                    <div class="col-md-4 mb-4">
                        <div class="news-item">
                            <a href="#" class="text-decoration-none">
                                <img src="https://cafefcdn.com/203337114487263232/2021/9/5/sport17bab263cf1original-ratio-1630800402561676628516.jpeg"
                                    class="img-fluid" alt="News Image 3">
                                <h4 class="mt-3">Man United lập kỷ lục thu về 1.366 tỷ từ bán áo đấu Ronaldo sau 12h,
                                    bao giờ thu hồi "vốn"?</h4>
                                <p class="text-muted">Theo LovetheSales.com, 12h sau khi áo đấu của Cristiano Ronaldo
                                    phát hành, fan đã bỏ ra tổng cộng 32,5 triệu bảng (60 triệu USD – khoảng 1.366 tỷ
                                </p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Section 6: Banner -->
        <section class="section-6 mt-5">
            <div class="home-two-banner">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 content_banner">
                            <div class="title_banner">
                                <h3>ĐẶT IN ÁO LIÊN HỆ NGAY</h3>
                                <span>Khách hàng có nhu cầu IN TÊN SỐ, đặt đội hoặc mua số lượng lớn từ 7 bộ vui lòng
                                    inbox để SHOP hỗ trợ với giá tốt nhất cùng nhiều ưu đãi quà tặng đặc biệt</span>
                            </div>
                            <div class="group-banner">
                                <a class="banner-1" href="#" title="ĐẶT IN ÁO LIÊN HỆ NGAY">
                                    <img class="img-responsive" :src="banner1" width="350" height="204" alt="Handmade">
                                </a>
                                <div class="des">
                                    <a href="#" class="lien-he btn btn-danger mb-4 btn-lg" title="Xem thêm">Liên hệ
                                        ngay</a>
                                    <p>Hỗ trợ, tư vấn ngay qua messenger FB hoặc qua SĐT: 0987654321</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 content_banner_2">
                            <a href="#" title="">
                                <img class="img-responsive" :src="banner2" alt="Hang Thể Thao" width="100%">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
import { Swiper, SwiperSlide } from 'swiper/vue';

export default {
    components: { Swiper, SwiperSlide },
    data() {
        return {
            carouselImages: [
                { desktop: "https://bizweb.dktcdn.net/100/483/998/themes/904984/assets/slider_1.jpg?1720275862057", mobile: "https://bizweb.dktcdn.net/100/483/998/themes/904984/assets/silde_m_1.png?1717181462123" },
                { desktop: "https://bizweb.dktcdn.net/100/483/998/themes/904984/assets/slider_2.jpg?1722078914172", mobile: "https://bizweb.dktcdn.net/100/483/998/themes/904984/assets/silde_m_2.png?1717181462123" },
                { desktop: "https://bizweb.dktcdn.net/100/483/998/themes/904984/assets/slider_3.jpg?1722078914172", mobile: "https://bizweb.dktcdn.net/100/483/998/themes/904984/assets/silde_m_3.png?1717181462123" },
                { desktop: "https://bizweb.dktcdn.net/100/483/998/themes/904984/assets/slider_4.jpg?1722078914172", mobile: "https://bizweb.dktcdn.net/100/483/998/themes/904984/assets/silde_m_4.png?1717181462123" }
            ],
            products: [
                {
                    id: 1,
                    name: 'MU Home (2012/2013) Màu đỏ + Cộc tay | Bản CLASSIC [Không có quần]',
                    price: 250000,
                    oldPrice: 300000,
                    image: 'https://bizweb.dktcdn.net/thumb/1024x1024/100/483/998/products/9b098813-1-1722496273940.jpg',
                },
                {
                    id: 2,
                    name: 'Real Madrid Away (2021/2022) Màu đen',
                    price: 260000,
                    oldPrice: 320000,
                    image: 'https://bizweb.dktcdn.net/thumb/1024x1024/100/483/998/products/real-madrid.jpg',
                },
                {
                    id: 3,
                    name: 'Juventus Home (2021/2022) Màu trắng đen',
                    price: 270000,
                    oldPrice: 330000,
                    image: 'https://bizweb.dktcdn.net/thumb/1024x1024/100/483/998/products/juventus.jpg',
                },
                {
                    id: 4,
                    name: 'BĐN Home (2024 - 2025) Màu đỏ + Cộc tay | Bản PLAYER [Có quần]',
                    price: 280000,
                    oldPrice: 340000,
                    image: 'https://bizweb.dktcdn.net/thumb/1024x1024/100/483/998/products/9b098813-1-1722496273940.jpg',
                },
                {
                    id: 5,
                    name: 'BĐN Home (2024 - 2025) Màu đỏ + Cộc tay | Bản PLAYER [Có quần]',
                    price: 290000,
                    oldPrice: 350000,
                    image: 'https://bizweb.dktcdn.net/thumb/1024x1024/100/483/998/products/9b098813-1-1722496273940.jpg',
                },
                {
                    id: 6,
                    name: 'BĐN Home (2024 - 2025) Màu đỏ + Cộc tay | Bản PLAYER [Có quần]',
                    price: 300000,
                    oldPrice: 360000,
                    image: 'https://bizweb.dktcdn.net/thumb/1024x1024/100/483/998/products/9b098813-1-1722496273940.jpg',
                },
            ],
            categories: [],
            banner1: "//bizweb.dktcdn.net/100/483/998/themes/904984/assets/twobanner_1.png?1720275862057",
            banner2: "//bizweb.dktcdn.net/100/483/998/themes/904984/assets/twobanner_2.png?1720275862057"
        };
    },
    computed: {
        isDesktop() {
            return window.innerWidth > 768;
        }
    },
    methods: {
        formatVND(number) {
            return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(number);
        }
    }
};
</script>

<style scoped>
.star-icon {
    color: gold;
    font-size: 18px;
}

.slider-slide img {
    transition: transform 0.3s ease;
}

.slider-slide:hover img {
    transform: scale(1.1);
}

.card-title {
    transition: color 0.3s ease, transform 0.3s ease;
}

.card-title:hover {
    color: #ff0000;
}

</style>