<template>
    <!-- Product Details Section Begin -->
    <section class="product-details spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="product__details__pic">
                        <div class="product__details__pic__item">
                            <img :src="largeImage" class="product__details__pic__item--large" alt="">
                        </div>
                        <div class="product__details__pic__slider">
                            <div class="thumbnail" v-for="(image, index) in thumbnails" :key="index"
                                :style="{ backgroundImage: `url(${image})` }" @click="changeImage(image)">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6">
                    <div class="product__details__text">
                        <h3>Áo Khoác Thể Thao</h3>
                        <div class="swatch clearfix mb-3" data-option-index="0">
                            <div class="mb-3"><strong>Hãng: </strong>
                                <label for="hang_sp">Đang cập nhập</label>
                            </div>
                            <div class="header"><strong>Size:</strong></div>

                            <div v-for="size in sizes" :key="size" :data-value="size"
                                :class="['swatch-element', size, { available: selectedSize !== size }]">
                                <input type="radio" :id="'swatch-0-' + size" name="option-0" :value="size"
                                    v-model="selectedSize" :disabled="false" />
                                <label :for="'swatch-0-' + size">{{ size }}</label>
                            </div>
                            <div class="mb-3"><strong>Số lượng trong kho: </strong>
                                <label for="sl_kho"> <b> <span class="badge text-bg-danger"> 0 </span> </b></label>
                            </div>

                            <div class="mb-3"><strong>Giá sản phẩm: </strong>
                                <label for="sl_kho"> <b> <span class="text-danger text-nowrap fs-5"> 257.000đ
                                        </span></b></label>
                            </div>
                        </div>

                        <div class="product__details__quantity mb-3">
                            <div><strong>Số Lượng:</strong></div>
                            <div class="quantity d-flex align-items-center">
                                <button @click="decreaseQuantity" class="qty-btn qty-decrease me-2">-</button>
                                <input type="text" :value="quantity" class="qty-input text-center" readonly>
                                <button @click="increaseQuantity" class="qty-btn qty-increase ms-2">+</button>
                            </div>
                        </div>
                        <div class="mb-3">
                            <router-link to="/cart" class="btn btn-danger mt-3">ADD TO CARD </router-link>
                        </div>

                        <ul>
                            <li><b>Sẵn có: </b> <span>Còn hàng</span></li>
                            <li><b>Thời gian giao hàng:</b> <span> 2 - 3 ngày. <samp>Giao hàng miễn phí</samp></span></li>
                            <li><b>Khối Lượng: </b> <span>0.2 kg</span></li>
                            <li><b>Share on</b>
                                <div class="share">
                                    <a href="#"><font-awesome-icon :icon="['fab', 'facebook']" /></a>
                                    <a href="#"><font-awesome-icon :icon="['fab', 'twitter']" /></a>
                                    <a href="#"><font-awesome-icon :icon="['fab', 'linkedin']" /></a>
                                    <a href="#"><font-awesome-icon :icon="['fab', 'pinterest-p']" /></a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="product__details__tab">
                        <!-- Tab Navigation -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item" v-for="(tab, index) in tabs" :key="index">
                                <a :class="['nav-link', { active: selectedTab === tab.id }]"
                                    @click="selectedTab = tab.id" href="javascript:void(0)" role="tab"
                                    :aria-selected="selectedTab === tab.id ? 'true' : 'false'">
                                    {{ tab.name }}
                                    <span v-if="tab.count">({{ tab.count }})</span>
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <div v-for="(tab, index) in tabs" :key="index" v-show="selectedTab === tab.id" :id="tab.id"
                                class="tab-pane" role="tabpanel">
                                <div class="product__details__tab__desc">
                                    <h6>{{ tab.name }}</h6>
                                    <p>{{ tab.content }}</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Product Details Section End -->
    <section class="section-3 mt-5">
        <div class="container">
            <div class="row">
                <!-- Category Section (Thay thế bằng các tên danh mục giả) -->
                <div class="col-md-12 mb-4">
                    <h2>Danh mục Sản phẩm 1</h2>

                    <div class="slider-container">
                        <div class="slider-wrapper">
                            <!-- Product Item 1 -->
                            <div class="slider-slide">
                                <a href="/detail" class="text-decoration-none text-black">
                                    <div class="card border-0">
                                        <img src="https://bizweb.dktcdn.net/thumb/1024x1024/100/483/998/products/9b098813-1-1722496273940.jpg"
                                            class="border" alt="Product Image 1">
                                        <div class="card-body">
                                            <div class="rating">
                                                <span class="fa fa-star checked"></span>
                                                <span class="fa fa-star checked"></span>
                                                <span class="fa fa-star checked"></span>
                                                <span class="fa fa-star checked"></span>
                                                <span class="fa fa-star"></span>
                                            </div>
                                            <p class="card-title text-left">Tên sản phẩm 1</p>
                                            <p class="card-text text-left">
                                                <span class="text-decoration-line-through">300.000đ</span>
                                                <span class="text-danger">250.000đ</span>
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <!-- Product Item 2 -->
                            <div class="slider-slide">
                                <a href="/detail?id=2" class="text-decoration-none text-black">
                                    <div class="card border-0">
                                        <img src="https://bizweb.dktcdn.net/thumb/1024x1024/100/483/998/products/fe1c5d8f-1722498244281.jpg"
                                            class="border" alt="Product Image 2">
                                        <div class="card-body">
                                            <div class="rating">
                                                <span class="fa fa-star checked"></span>
                                                <span class="fa fa-star checked"></span>
                                                <span class="fa fa-star checked"></span>
                                                <span class="fa fa-star"></span>
                                                <span class="fa fa-star"></span>
                                            </div>
                                            <p class="card-title text-left">Tên sản phẩm 2</p>
                                            <p class="card-text text-left">
                                                <span class="text-decoration-line-through">400.000đ</span>
                                                <span class="text-danger">350.000đ</span>
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <!-- Product Item 3 -->
                            <div class="slider-slide">
                                <a href="/detail" class="text-decoration-none text-black">
                                    <div class="card border-0">
                                        <img src="https://bizweb.dktcdn.net/thumb/1024x1024/100/483/998/products/image-1722497259028.png"
                                            class="border" alt="Product Image 3">
                                        <div class="card-body">
                                            <div class="rating">
                                                <span class="fa fa-star checked"></span>
                                                <span class="fa fa-star checked"></span>
                                                <span class="fa fa-star checked"></span>
                                                <span class="fa fa-star checked"></span>
                                                <span class="fa fa-star"></span>
                                            </div>
                                            <p class="card-title text-left">Tên sản phẩm 3</p>
                                            <p class="card-text text-left">
                                                <span class="text-decoration-line-through">500.000đ</span>
                                                <span class="text-danger">450.000đ</span>
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </div>


                        </div>

                        <!-- điều hướng -->
                        <button class="slider-button-prev">❮</button>
                        <button class="slider-button-next">❯</button>
                    </div>
                </div>

                <!-- Thêm các danh mục và sản phẩm khác tương tự nếu cần -->
            </div>
        </div>
    </section>

</template>

<script>
export default {
    name: 'Detail_product',
    data() {
        return {
            largeImage: 'https://bizweb.dktcdn.net/thumb/1024x1024/100/483/998/products/photo-2024-09-11-22-53-27.jpg?v=1726070059660',

            thumbnails: [
                'https://bizweb.dktcdn.net/thumb/1024x1024/100/483/998/products/photo-2024-09-11-22-53-27.jpg?v=1726070059660',
                'https://bizweb.dktcdn.net/thumb/1024x1024/100/483/998/products/photo-2024-09-11-22-53-28.jpg?v=1726070063893',
                'https://bizweb.dktcdn.net/thumb/compact/100/483/998/products/photo-2024-09-11-22-53-29-2.jpg?v=1726070065717',
                'https://bizweb.dktcdn.net/thumb/1024x1024/100/483/998/products/photo-2024-09-11-22-53-31-2.jpg?v=1726070069620'
            ],


            quantity: 1,
            selectedSize: 'S',
            sizes: ['S', 'M', 'L', 'XL', 'XXL'],
            selectedTab: 'tabs-1',  // Tab mặc định được chọn
            tabs: [
                {
                    id: 'tabs-1',
                    name: 'MÔ TẢ',
                    content: 'Nội dung mô tả sản phẩm tại đây.'
                },
                {
                    id: 'tabs-2',
                    name: 'XUẤT XỨ',
                    content: 'Nội dung thông tin sản phẩm tại đây.'
                },
                {
                    id: 'tabs-3',
                    name: 'ĐÁNH GIÁ',
                    content: 'Nội dung đánh giá sản phẩm tại đây.'
                },
            ],

        };
    },
    methods: {
        changeImage(image) {
            this.largeImage = image;
        },
        increaseQuantity() {
            this.quantity++;
        },
        decreaseQuantity() {
            if (this.quantity > 1) {
                this.quantity--;
            }
        },
        selectTab(tabId) {
            this.selectedTab = tabId;
        }

    }
};

</script>

<style scoped>
.product__details__pic__item--large {
    width: 100%;
    height: 600px;
    object-fit: cover;
}

.product__details__pic__slider .thumbnail {
    width: 60px;
    height: 60px;
    background-size: cover;
    background-position: center;
    cursor: pointer;
}

.product__details__pic__slider .thumbnail:hover {
    border: 2px solid #c8f3a2;
}

.product__details__pic__slider {
    display: flex;
    justify-content: space-between;
    overflow-x: auto;
    gap: 10px;
}

.product__details__pic__slider .thumbnail {
    width: 150px;
    height: 130px;
    background-size: cover;
    background-position: center;
    object-fit: cover;
    border: 1px solid #ddd;
    cursor: pointer;
}

.product__details__pic__slider .thumbnail:hover {
    border-color: #f56363;
}

/* Căn chỉnh các phần tử trong product quantity */
.product__details__quantity {
    display: flex;
    align-items: center;
    gap: 10px; /* Khoảng cách giữa số lượng và nút */
}

.quantity {
    display: flex;
    align-items: center;
}

.qty-btn {
    width: 30px;
    height: 39zpx;
    font-size: 18px;
    background-color: #f5f5f5;
    border: 1px solid #ccc;
    text-align: center;
    cursor: pointer;
}

.qty-input {
    width: 50px;
    text-align: center;
    margin: 0 5px;
    border: 1px solid #ccc;
    padding: 5px;
    font-size: 16px;
    background-color: #fff;
}

.qty-btn:hover {
    background-color: #e0e0e0;
}

.swatch-element {
    display: inline-block;
    margin: 15px;
}

.swatch-element input[type="radio"] {
    display: none;
}

.swatch-element label {
    cursor: pointer;
    padding: 8px 20px;
    background-color: #ffffff;
    border-radius: 5px;
}

.swatch-element input[type="radio"]:checked+label {
    background-color: #ed1010;
    color: white;
}

.swatch-element.available label {
    background-color: #f0f0f0;
}

.swatch-element input[type="radio"]:disabled+label {
    background-color: #ddd;
    cursor: not-allowed;
}
</style>