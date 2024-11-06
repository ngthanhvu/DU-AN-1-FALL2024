<template>
    <main>
        <section id="selling-product" class="single-product mt-0 mt-md-5">
            <div class="container-fluid">
                <nav class="breadcrumb">
                    <a class="breadcrumb-item" href="#">Trang Chủ</a>
                    <a class="breadcrumb-item" href="#">Sản Phẩm</a>
                    <span class="breadcrumb-item active" aria-current="page">Nho xanh</span>
                </nav>
                <div class="row g-5">
                    <div class="col-lg-7">
                        <div class="row flex-column-reverse flex-lg-row">
                            <div class="col-md-12 col-lg-2">
                                <!-- product-thumbnail-slider -->
                                <Swiper direction="vertical" thumbs :spaceBetween="10" :slidesPerView="4"
                                    class="product-thumbnail-slider" :navigation="false"
                                    :pagination="{ clickable: true }">
                                    <SwiperSlide v-for="(image, index) in thumbnails" :key="index" @click="setActiveImage(index)">
                                        <img :src="image" alt="" class="thumb-image img-fluid">
                                    </SwiperSlide>
                                </Swiper>
                                <!-- / product-thumbnail-slider -->
                            </div>

                            <div class="col-md-12 col-lg-10">
                                <!-- product-large-slider -->
                                <Swiper :spaceBetween="10" :slidesPerView="1" pagination>
                                    <SwiperSlide>
                                        <div class="image-zoom" :data-image="largeImages[activeIndex]">
                                            <img :src="largeImages[activeIndex]" alt="product-large" class="img-fluid">
                                        </div>
                                    </SwiperSlide>
                                </Swiper>
                                <!-- / product-large-slider -->
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <div class="product-info">
                            <!-- Product details here -->
                            <h2 itemprop="name" class="display-6">Cashew Butter 500mg CBD</h2>
                            <div class="rating-container d-flex gap-0 align-items-center">
                                <div v-for="rating in 5" :key="rating" class="rating" :data-rating="rating">
                                    <svg width="32" height="32"
                                        :class="rating <= 3 ? 'text-primary' : 'text-secondary'">
                                        <use xlink:href="#star-solid"></use>
                                    </svg>
                                </div>
                                <span class="rating-count">(3.5)</span>
                            </div>
                            <div class="product-price pt-3 pb-3">
                                <strong class="text-primary display-6 fw-bold">$870.00</strong><del
                                    class="ms-2">$940.00</del>
                            </div>
                            <p>Justo, cum feugiat imperdiet nulla molestie ac vulputate scelerisque amet...</p>
                            <div class="cart-wrap py-5">
                                <div class="color-options product-select">
                                    <div class="color-toggle" data-option-index="0">
                                        <h6 class="item-title text-uppercase text-dark">Khối Lượng:</h6>
                                        <ul class="select-list list-unstyled d-flex">
                                            <li class="select-item pe-3" data-val="kilogam" title="kilogam">
                                                <a href="#" class="btn btn-light active">0,5 KG</a>
                                            </li>
                                            <li class="select-item pe-3" data-val="kilogam" title="kilogam">
                                                <a href="#" class="btn btn-light ">1 KG</a>
                                            </li>
                                            <li class="select-item pe-3" data-val="kilogam" title="kilogam">
                                                <a href="#" class="btn btn-light ">1,5 KG</a>
                                            </li>
                                            <li class="select-item pe-3" data-val="kilogam" title="kilogam">
                                                <a href="#" class="btn btn-light">2 KG</a>
                                            </li>
                                        
                                        </ul>
                                    </div>
                                </div>
                        
                                <div class="product-quantity pt-3">
                                    <div class="stock-number text-dark"><em>Số lượng:</em></div>
                                    <div class="stock-button-wrap">

                                        <div class="input-group product-qty" style="max-width: 150px;">
                                            <span class="input-group-btn">
                                                <button type="button" class="quantity-left-minus btn btn-light btn-number"
                                                    data-type="minus" data-field="">
                                                    <font-awesome-icon :icon="['fas', 'minus']" />

                                                </button>
                                            </span>
                                            <input type="text" id="quantity" name="quantity"
                                                class="form-control input-number text-center" value="1" min="1" max="100">
                                            <span class="input-group-btn">
                                                <button type="button" class="quantity-right-plus btn btn-light btn-number"
                                                    data-type="plus" data-field="">
                                                    <font-awesome-icon :icon="['fas', 'plus']" />

                                                </button>
                                            </span>
                                        </div>
                                        <div class="qty-button d-flex flex-wrap pt-3">
                                            <button type="submit"
                                                class="btn btn-primary py-3 px-4 text-uppercase me-3 mt-3">Mua ngay</button>
                                            <button type="submit" name="add-to-cart" value="1269"
                                                class="btn btn-dark py-3 px-4 text-uppercase mt-3">Thêm giỏ hàng</button>
                                        </div>
                                    </div>
                                </div>
                              
                            </div>
                            <div class="meta-product py-2">
                                <div class="meta-item d-flex align-items-baseline">
                                    <h6 class="item-title no-margin pe-2">Mã SP:</h6>
                                    <ul class="select-list list-unstyled d-flex">
                                        <li class="select-item">1223</li>
                                    </ul>
                                </div>
                                <div class="meta-item d-flex align-items-baseline">
                                    <h6 class="item-title no-margin pe-2">Danh Mục:</h6>
                                    <ul class="select-list list-unstyled d-flex">
                                        <li class="select-item">
                                            <a href="#">Trái cây nhập khẩu</a>,
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="product-info-tabs py-5">
        <div class="container-fluid">
            <div class="row">
                <div class="d-flex flex-column flex-md-row align-items-start gap-5">
                    <div class="nav flex-column nav-pills me-3 col-lg-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <button class="nav-link active" id="v-pills-description-tab" data-bs-toggle="pill" data-bs-target="#v-pills-description" type="button" role="tab" aria-controls="v-pills-description" aria-selected="true">MÔ TẢ</button>
                        <button class="nav-link" id="v-pills-additional-tab" data-bs-toggle="pill" data-bs-target="#v-pills-additional" type="button" role="tab" aria-controls="v-pills-additional" aria-selected="false">THÔNG TIN BỔ SUNG</button>
                        <button class="nav-link" id="v-pills-reviews-tab" data-bs-toggle="pill" data-bs-target="#v-pills-reviews" type="button" role="tab" aria-controls="v-pills-reviews" aria-selected="false">ĐÁNH GIÁ KHÁCH HÀNG</button>
                    </div>
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-pills-description" role="tabpanel" aria-labelledby="v-pills-description-tab">
                            <h5>MÔ TẢ SẢN PHẨM</h5>
                            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis eros.</p>
                            <ul class="list-unstyled ps-4">
                                <li>Donec nec justo eget felis facilisis fermentum.</li>
                                <li>Suspendisse urna viverra non, semper suscipit pede.</li>
                                <li>Aliquam porttitor mauris sit amet orci.</li>
                            </ul>
                        </div>
                        <div class="tab-pane fade" id="v-pills-additional" role="tabpanel" aria-labelledby="v-pills-additional-tab">
                            <p>It is Comfortable and Best</p>
                            <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
                        </div>
                        <div class="tab-pane fade" id="v-pills-reviews" role="tabpanel" aria-labelledby="v-pills-reviews-tab">
                            <div class="review-box d-flex flex-wrap">
                                <div class="col-lg-6 d-flex flex-wrap gap-3">
                                    <div class="col-md-2"><img src="#" alt="review" class="img-fluid rounded-circle"></div>
                                    <div class="col-md-8">
                                        <div class="review-content">
                                            <div class="rating-container d-flex align-items-center">
                                                <div class="rating" data-rating="1"><svg width="24" height="24" class="text-primary"><use xlink:href="#star-solid"></use></svg></div>
                                                <div class="rating" data-rating="2"><svg width="24" height="24" class="text-primary"><use xlink:href="#star-solid"></use></svg></div>
                                                <div class="rating" data-rating="3"><svg width="24" height="24" class="text-primary"><use xlink:href="#star-solid"></use></svg></div>
                                                <div class="rating" data-rating="4"><svg width="24" height="24" class="text-secondary"><use xlink:href="#star-solid"></use></svg></div>
                                                <div class="rating" data-rating="5"><svg width="24" height="24" class="text-secondary"><use xlink:href="#star-solid"></use></svg></div>
                                                <span class="rating-count">(3.5)</span>
                                            </div>
                                            <div class="review-header"><span class="author-name">Tina Johnson</span> <span class="review-date">– 03/07/2023</span></div>
                                            <p>Vitae tortor condimentum lacinia quis vel eros donec ac.</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- Thêm phần đánh giá khác nếu cần -->
                            </div>
                            <div class="add-review mt-5">
                                <h3>THÊM ĐÁNH GIÁ SẢN PHẨM</h3>
                                <p>Địa chỉ email của bạn sẽ không được công bố. Các trường bắt buộc được đánh dấu *</p>
                                <form id="form" class="form-group">
                                    <div class="pb-3">
                                        <span>Đánh giá *</span>
                                        <div class="rating-container d-flex align-items-center">
                                            <div class="rating" data-rating="1"><svg width="24" height="24" class="text-primary"><use xlink:href="#star-solid"></use></svg></div>
                                            <div class="rating" data-rating="2"><svg width="24" height="24" class="text-primary"><use xlink:href="#star-solid"></use></svg></div>
                                            <div class="rating" data-rating="3"><svg width="24" height="24" class="text-primary"><use xlink:href="#star-solid"></use></svg></div>
                                            <div class="rating" data-rating="4"><svg width="24" height="24" class="text-secondary"><use xlink:href="#star-solid"></use></svg></div>
                                            <div class="rating" data-rating="5"><svg width="24" height="24" class="text-secondary"><use xlink:href="#star-solid"></use></svg></div>
                                        </div>
                                    </div>
                                    <div class="pb-3"><label>Đánh giá của bạn *</label><textarea class="form-control" placeholder="Nhập đánh giá của bạn"></textarea></div>
                                    <div class="pb-3"><label>Tên của bạn *</label><input type="text" name="name" placeholder="Nhập tên của bạn" class="form-control"></div>
                                    <div class="pb-3"><label>Email của bạn *</label><input type="text" name="email" placeholder="Nhập email của bạn" class="form-control"></div>
                                    <div class="pb-3"><label><input type="checkbox" required=""><span class="label-body">Lưu tên, email và trang web của tôi.</span></label></div>
                                    <button type="submit" class="btn btn-dark btn-large text-uppercase w-100">GỬI ĐÁNH GIÁ</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="related-products py-5">
    <div class="container-fluid">
        <h3 class="text-left">Sản phẩm liên quan</h3>
        <Swiper :spaceBetween="10" :slidesPerView="5">
            <SwiperSlide v-for="(product, index) in relatedProducts" :key="index">
                <div class="product-card text-left">
                    <img :src="product.image" alt="product.name" class="img-fluid">
                    <h5 class="product-title">{{ product.name }}</h5>
                    <div class="product-price">
                        <strong class="text-primary">{{ product.price }}</strong>
                        <del class="ms-2">{{ product.oldPrice }}</del>
                    </div>
                    <div class="text-center mt-2">
                        <button class="btn btn-primary">Xem chi tiết</button>
                    </div>
                </div>
            </SwiperSlide>
        </Swiper>
    </div>
</section>




</main>
</template>

<script>
import { Swiper, SwiperSlide } from 'swiper/vue';
import 'swiper/swiper-bundle.css';

export default {
    name: 'Detail',
    components: {
        Swiper,
        SwiperSlide
    },
    data() {
        return {
            activeIndex: 0,
            thumbnails: [
                "https://cdn.tgdd.vn/Products/Images/8788/234962/bhx/tao-fuji-mini-nhap-khau-hop-500g-202102061738567884.jpg",
                "https://demo.templatesjungle.com/foodmart/images/product-large-1.jpg",
                "https://demo.templatesjungle.com/foodmart/images/product-large-2.jpg",
                "https://demo.templatesjungle.com/foodmart/images/product-large-3.jpg"
            ],
            largeImages: [
                "https://cdn.tgdd.vn/Products/Images/8788/234962/bhx/tao-fuji-mini-nhap-khau-hop-500g-202102061738567884.jpg",
                "https://demo.templatesjungle.com/foodmart/images/product-large-1.jpg",
                "https://demo.templatesjungle.com/foodmart/images/product-large-2.jpg",
                "https://demo.templatesjungle.com/foodmart/images/product-large-3.jpg"
            ],
            relatedProducts: [
            {
                name: "Táo",
                price: "$150.00",
                oldPrice: "$200.00",
                image: "https://cdn.tgdd.vn/Products/Images/8788/234962/bhx/tao-fuji-mini-nhap-khau-hop-500g-202102061738567884.jpg"
            },
            {
                name: "Táo",
                price: "$150.00",
                oldPrice: "$200.00",
                image: "https://cdn.tgdd.vn/Products/Images/8788/234962/bhx/tao-fuji-mini-nhap-khau-hop-500g-202102061738567884.jpg"
            },
            {
                name: "Táo",
                price: "$150.00",
                oldPrice: "$200.00",
                image: "https://cdn.tgdd.vn/Products/Images/8788/234962/bhx/tao-fuji-mini-nhap-khau-hop-500g-202102061738567884.jpg"
            },
            {
                name: "Táo",
                price: "$150.00",
                oldPrice: "$200.00",
                image: "https://cdn.tgdd.vn/Products/Images/8788/234962/bhx/tao-fuji-mini-nhap-khau-hop-500g-202102061738567884.jpg"
            },
            {
                name: "Táo",
                price: "$150.00",
                oldPrice: "$200.00",
                image: "https://cdn.tgdd.vn/Products/Images/8788/234962/bhx/tao-fuji-mini-nhap-khau-hop-500g-202102061738567884.jpg"
            },
            {
                name: "Táo",
                price: "$150.00",
                oldPrice: "$200.00",
                image: "https://cdn.tgdd.vn/Products/Images/8788/234962/bhx/tao-fuji-mini-nhap-khau-hop-500g-202102061738567884.jpg"
            }
        ]
        };
    },
    methods: {
        setActiveImage(index) {
            this.activeIndex = index; 
        }
    }
};
</script>

<style scoped>

.product-card {
    border: none;
    overflow: hidden;
    box-shadow: 1px 3px 4px rgba(0, 0, 0, 0.1);
    transition: box-shadow 0.3s;
    background-color: white;
    padding: 15px; 
}

.product-card:hover {
    box-shadow: 6px 8px 20px rgba(0, 0, 0, 0.2); 
}

.product-title {
    font-size: 1.2em;
    margin: 10px 0;
    color: #333;
}

.product-price {
    font-size: 1em;
    color: #555;
    text-align: left; 
    margin-bottom: 10px;
}

.product-price .text-primary {
    font-weight: bold;
}

.text-center {
    text-align: center;
    margin-top: 10px; 
}
.input-number{
    margin:0 0 20px;
}
</style>
