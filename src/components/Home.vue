<template>
    <main>
    <section class="py-3" :style="{ backgroundImage: `url(${backgroundImage})`, backgroundRepeat: 'no-repeat', backgroundSize: 'cover' }">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="banner-blocks">
              <!-- Main Swiper -->
              <div class="banner-ad large bg-info block-1">
                <swiper  class="main-swiper">
                  <swiper-slide v-for="(slide, index) in slides" :key="index">
                    <div class="row banner-content p-5">
                      <div class="content-wrapper col-md-7">
                        <div class="categories my-3">{{ slide.category }}</div>
                        <h3 class="display-4">{{ slide.title }}</h3>
                        <p>{{ slide.description }}</p>
                        <a href="#" class="btn btn-outline-dark btn-lg text-uppercase fs-6 rounded-1 px-4 py-3 mt-3">Mua Sắm Ngay</a>
                      </div>
                      <div class="img-wrapper col-md-5">
                        <img :src="slide.image" class="img-fluid" />
                      </div>
                    </div>
                  </swiper-slide>
                </swiper>
              </div>
  
              <!-- Additional Banner Ads -->
              <div v-for="(ad, index) in ads" :key="index" :class="`banner-ad ${ad.bgClass} block-${index + 2}`" :style="{ background: `url(${ad.background}) no-repeat`, backgroundPosition: 'right bottom' }">
                <div class="row banner-content p-5">
                  <div class="content-wrapper col-md-7">
                    <div class="categories sale mb-3 pb-3" :style="{ color: '#ff0000' }">{{ ad.discount }}</div>
                    <h3 class="banner-title">{{ ad.title }}</h3>
                    <button class="btn btn-primary d-flex align-items-center">MUA NGAY
                    <svg width="24" height="24" class="ml-2"><use xlink:href="#arrow-right"></use></svg>
                    </button>
                  </div>
                </div>
              </div>
            </div>
            <!-- / Banner Blocks -->
          </div>
        </div>
      </div>
    </section>

    <section class="py-5 overflow-hidden">
        <div class="container-fluid">
            <!-- <div class="row">
                <div class="col-md-12">
                    <div class="section-header d-flex flex-wrap justify-content-between mb-5">
                        <h2 class="section-title">Newly Arrived Brands</h2>
                        <div class="d-flex align-items-center">
                            <a href="#" class="btn-link text-decoration-none">View All Categories →</a>
                        </div>
                    </div>
                </div>
            </div> -->
            <div class="row row-cols-1 row-cols-md-3 g-4">
                <div class="col">
                    <div class="card mb-3 p-3 rounded-4 shadow border-0">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="http://127.0.0.1:5500/images/thumb-bananas.png" class="img-fluid rounded" alt="" style="height: 150px; width: 150px">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body py-0">
                                    <p class="text-muted mb-0">Trái Cây ViỆt Nam</p>
                                    <h5 class="card-title">Chuối là để liếmmmm</h5>
                                    <a href="#" class="btn btn-primary mt-2">Xem ngay</a> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card mb-3 p-3 rounded-4 shadow border-0">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="https://tse2.mm.bing.net/th?id=OIP.k9gmqa15eKvfbKKQ7HFCdgHaEK&pid=Api&P=0&h=220" class="img-fluid rounded" alt="" style="height: 150px; width: 150px">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body py-0">
                                    <p class="text-muted mb-0">Đồ Uống Trái Cây</p>
                                    <h5 class="card-title">Dùng để uống</h5>
                                    <a href="#" class="btn btn-primary mt-2">Xem ngay</a> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card mb-3 p-3 rounded-4 shadow border-0">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="https://tse4.mm.bing.net/th?id=OIP.xZ0FfenSusUSJq5Rwj-1TwHaGq&pid=Api&P=0&h=220" class="img-fluid rounded" alt="" style="height: 150px; width: 150px">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body py-0">
                                    <p class="text-muted mb-0">Giỏ Trái Cây</p>
                                    <h5 class="card-title">Dùng để ăn hoặc trang trí</h5>
                                    <a href="#" class="btn btn-primary mt-2">Xem ngay</a> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <section class="py-5 overflow-hidden">
        <div class="container-fluid">
            <div class="row">
            <div class="col-md-12">
                <div class="section-header d-flex flex-wrap justify-content-between my-5">
                <h2 class="section-title">Sản Phẩm Khuyến Mãi</h2>
                <div class="d-flex align-items-center">
                    <a href="#" class="btn-link text-decoration-none">Xem tất cả →</a>
                    <div class="swiper-buttons">
                    <button class="swiper-prev products-carousel-prev btn btn-primary">❮</button>
                    <button class="swiper-next products-carousel-next btn btn-primary">❯</button>
                    </div>
                </div>
                </div>
            </div>
            </div>
            <div class="row">
            <div class="col-md-3">
                <div class="swiper-container">
                <div class="swiper-wrapper">
                    <!-- Product Item 1 -->
                    <div class="product-item swiper-slide">
                    <span class="badge bg-success position-absolute m-3">-15%</span>
                    <a href="#" class="btn-wishlist"><svg width="24" height="24"><use xlink:href="#heart"></use></svg></a>
                    <figure>
                        <a href="#1" title="Sunstar Fresh Melon Juice">
                        <img src="https://traicayxanh.vn/wp-content/uploads/2024/07/gio-trai-cay-tang-thay-co-300x300.jpg" class="tab-image" alt="Sunstar Fresh Melon Juice">
                        </a>
                    </figure>
                    <h3>Sunstar Fresh Melon Juice</h3>
                    <span class="qty">1 Unit</span>
                    <span class="rating">
                        <svg width="24" height="24" class="text-primary"><use xlink:href="#star-solid"></use></svg> 4.5
                    </span>
                    <span class="price">$18.00</span>
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="input-group product-qty">
                        <span class="input-group-btn">
                            <button type="button" class="quantity-left-minus btn btn-danger btn-number" data-type="minus">
                            <svg width="16" height="16"><use xlink:href="#minus"></use></svg>
                            </button>
                        </span>
                        <input type="text" id="quantity" name="quantity" class="form-control input-number" value="1">
                        <span class="input-group-btn">
                            <button type="button" class="quantity-right-plus btn btn-success btn-number" data-type="plus">
                            <svg width="16" height="16"><use xlink:href="#plus"></use></svg>
                            </button>
                        </span>
                        </div>
                        <a href="#" class="nav-link">Add to Cart <iconify-icon icon="uil:shopping-cart"></iconify-icon></a>
                    </div>
                    </div>
                    <!-- End Product Item 1 -->
                    
                </div>
                <div class="swiper-pagination"></div>
                </div>
            </div>
            </div>
        </div>
    </section>

    <section class="py-5 overflow-hidden">
        <div class="container-fluid">
            <div class="row">
            <div class="col-md-12">
                <div class="section-header d-flex flex-wrap justify-content-between my-5">
                <h2 class="section-title">Sản Phẩm Nổi Bật</h2>
                <div class="d-flex align-items-center">
                    <a href="#" class="btn-link text-decoration-none">Xem tất cả →</a>
                    <div class="swiper-buttons">
                    <button class="swiper-prev products-carousel-prev btn btn-primary">❮</button>
                    <button class="swiper-next products-carousel-next btn btn-primary">❯</button>
                    </div>
                </div>
                </div>
            </div>
            </div>
            <div class="row">
            <div class="col-md-3">
                <div class="swiper-container">
                <div class="swiper-wrapper">
                    <!-- Product Item 1 -->
                    <div class="product-item swiper-slide">
                    <a href="#" class="btn-wishlist"><svg width="24" height="24"><use xlink:href="#heart"></use></svg></a>
                    <figure>
                        <a href="#1" title="Sunstar Fresh Melon Juice">
                        <img src="https://traicayxanh.vn/wp-content/uploads/2024/07/gio-trai-cay-tang-thay-co-300x300.jpg" class="tab-image" alt="Sunstar Fresh Melon Juice">
                        </a>
                    </figure>
                    <h3>Sunstar Fresh Melon Juice</h3>
                    <span class="qty">1 Unit</span>
                    <span class="rating">
                        <svg width="24" height="24" class="text-primary"><use xlink:href="#star-solid"></use></svg> 4.5
                    </span>
                    <span class="price">$18.00</span>
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="input-group product-qty">
                        <span class="input-group-btn">
                            <button type="button" class="quantity-left-minus btn btn-danger btn-number" data-type="minus">
                            <svg width="16" height="16"><use xlink:href="#minus"></use></svg>
                            </button>
                        </span>
                        <input type="text" id="quantity" name="quantity" class="form-control input-number" value="1">
                        <span class="input-group-btn">
                            <button type="button" class="quantity-right-plus btn btn-success btn-number" data-type="plus">
                            <svg width="16" height="16"><use xlink:href="#plus"></use></svg>
                            </button>
                        </span>
                        </div>
                        <a href="#" class="nav-link">Add to Cart <iconify-icon icon="uil:shopping-cart"></iconify-icon></a>
                    </div>
                    </div>
                    <!-- End Product Item 1 -->
                    
                </div>
                <div class="swiper-pagination"></div>
                </div>
            </div>
            </div>
        </div>
    </section>

    <section class="py-5 overflow-hidden">
        <div class="container-fluid">
            <div class="row">
            <div class="col-md-12">
                <div class="section-header d-flex flex-wrap justify-content-between my-5">
                <h2 class="section-title">Trái Cây Việt Nam</h2>
                <div class="d-flex align-items-center">
                    <a href="#" class="btn-link text-decoration-none">Xem tất cả →</a>
                    <div class="swiper-buttons">
                    <button class="swiper-prev products-carousel-prev btn btn-primary">❮</button>
                    <button class="swiper-next products-carousel-next btn btn-primary">❯</button>
                    </div>
                </div>
                </div>
            </div>
            </div>
            <div class="row">
            <div class="col-md-3">
                <div class="swiper-container">
                <div class="swiper-wrapper">
                    <!-- Product Item 1 -->
                    <div class="product-item swiper-slide">
                    <a href="#" class="btn-wishlist"><svg width="24" height="24"><use xlink:href="#heart"></use></svg></a>
                    <figure>
                        <a href="#1" title="Sunstar Fresh Melon Juice">
                        <img src="https://traicayxanh.vn/wp-content/uploads/2024/07/gio-trai-cay-tang-thay-co-300x300.jpg" class="tab-image" alt="Sunstar Fresh Melon Juice">
                        </a>
                    </figure>
                    <h3>Sunstar Fresh Melon Juice</h3>
                    <span class="qty">1 Unit</span>
                    <span class="rating">
                        <svg width="24" height="24" class="text-primary"><use xlink:href="#star-solid"></use></svg> 4.5
                    </span>
                    <span class="price">$18.00</span>
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="input-group product-qty">
                        <span class="input-group-btn">
                            <button type="button" class="quantity-left-minus btn btn-danger btn-number" data-type="minus">
                            <svg width="16" height="16"><use xlink:href="#minus"></use></svg>
                            </button>
                        </span>
                        <input type="text" id="quantity" name="quantity" class="form-control input-number" value="1">
                        <span class="input-group-btn">
                            <button type="button" class="quantity-right-plus btn btn-success btn-number" data-type="plus">
                            <svg width="16" height="16"><use xlink:href="#plus"></use></svg>
                            </button>
                        </span>
                        </div>
                        <a href="#" class="nav-link">Add to Cart <iconify-icon icon="uil:shopping-cart"></iconify-icon></a>
                    </div>
                    </div>
                    <!-- End Product Item 1 -->
                    
                </div>
                <div class="swiper-pagination"></div>
                </div>
            </div>
            </div>
        </div>
    </section>

    
</main>
  </template>
  
  <script>
  import { Swiper, SwiperSlide } from 'swiper/vue';
  import 'swiper/swiper-bundle.css';
  
  export default {
    name: 'Home',
    components: {
      Swiper,
      SwiperSlide
    },
    data() {
      return {  
        backgroundImage: 'images/background-pattern.jpg',
        slides: [
          {
            category: '100% An Toàn',
            title: 'Trái cây nhập khẩu',
            description: 'Khám phá bộ sưu tập trái cây nhập khẩu tươi ngon, chất lượng cao với hương vị tuyệt vời. Mỗi loại trái cây đều được lựa chọn kỹ lưỡng từ những vườn cây tốt nhất trên thế giới, đảm bảo mang lại sự an toàn và sức khỏe cho gia đình bạn. Hãy để chúng tôi mang đến những trải nghiệm tuyệt vời với trái cây tươi mới ngay trong tầm tay của bạn',
            image: 'https://traicayxanh.vn/wp-content/uploads/2024/11/Gio-qua-Mung-ngay-Nha-giao-Viet-Nam-20-11.jpg'
          },
          {
            category: '100% Sạch',
            title: 'Fresh Smoothie & Summer Juice',
            description: 'Hãy thưởng thức sự tươi mát của những ly smoothie và nước trái cây mùa hè hoàn toàn tự nhiên! Chúng tôi sử dụng nguyên liệu tươi ngon nhất, không chứa phẩm màu hay chất bảo quản, mang lại hương vị đích thực từ thiên nhiên. Đây là lựa chọn hoàn hảo để giải khát trong những ngày hè oi ả, cung cấp vitamin và năng lượng cho bạn suốt cả ngày dài.',
            image: 'https://traicayxanh.vn/wp-content/uploads/2024/11/Gio-qua-Mung-ngay-Nha-giao-Viet-Nam-20-11.jpg'
          },
          {
            category: '100% tự nhiên',
            title: 'Heinz Tomato Ketchup',
            description: 'Đưa hương vị đặc trưng đến bữa ăn của bạn với sốt cà chua Heinz, một sản phẩm nổi tiếng toàn cầu. Được làm từ những quả cà chua tươi ngon nhất, sốt ketchup của chúng tôi không chỉ thơm ngon mà còn hoàn toàn tự nhiên, không chứa chất bảo quản. Dùng kèm với khoai tây chiên, burger hay salad, sốt Heinz sẽ là lựa chọn hoàn hảo cho mọi bữa ăn!',
            image: 'https://traicayxanh.vn/wp-content/uploads/2024/11/Gio-qua-Mung-ngay-Nha-giao-Viet-Nam-20-11.jpg'
          }
        ],
        ads: [
          {
            discount: 'Giảm 20%',
            title: 'KHI MUA TRÁI CÂY',
            background: 'https://kienthuctieuduong.vn/wp-content/uploads/2019/03/nhung-loai-trai-cay-chua-nhieu-duong-20.jpg',
            bgClass: 'bg-success-subtle'
          },
          {
            discount: 'Giảm 15% ',
            title: 'KHI MUA TRÁI CÂY',
            background: 'http://cachlammonngon.vn/wp-content/uploads/2016/07/trai-cay-uop-lanh-4.jpg',
            bgClass: 'bg-danger'
          }
        ]
      };
    }
  };
  
  </script>
  
  <style scoped>
.white-text {
  color: #ff0000; /* Đặt màu chữ trắng */
}
</style>

  