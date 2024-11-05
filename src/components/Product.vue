<template>
    <main>
        <section class="py-5 mb-5" style="">
            <div class="container-fluid">
                <div class="d-flex justify-content-between">
                    <h1 class="page-title pb-2">Sản Phẩm</h1>
                    <nav class="breadcrumb fs-6">
                        <a class="breadcrumb-item nav-link" href="#">Trang Chủ</a>
                        <a class="breadcrumb-item nav-link" href="#">Sản Phẩm</a>
                        <span class="breadcrumb-item active" aria-current="page">Shop</span>
                    </nav>
                </div>
            </div>
            <div class="shopify-grid">
                <div class="container-fluid">
                    <div class="row g-5">
                        <aside class="col-md-2">
                            <div class="sidebar">
                                <div class="widget-menu">
                                    <div class="widget-search-bar">
                                        <form role="search" method="get" class="d-flex position-relative">

                                            <input class="form-control form-control-lg rounded-2 bg-light" type="email"
                                                placeholder="Search here" aria-label="Search here">
                                            <button class="btn bg-transparent position-absolute end-0"
                                                type="submit"><svg width="24" height="24" viewBox="0 0 24 24">
                                                    <use xlink:href="#search"></use>
                                                </svg></button>
                                        </form>

                                    </div>
                                </div>
                                <div class="widget-product-categories pt-5">
                                    <h5 class="widget-title">Danh Mục</h5>
                                    <ul class="product-categories sidebar-list list-unstyled">
                                        <li class="cat-item">
                                            <a href="#">Tất cả</a>
                                        </li>
                                        <li class="cat-item">
                                            <a href="#" class="nav-link">Trái cây Việt Nam</a>
                                        </li>
                                        <li class="cat-item">
                                            <a href="#" class="nav-link">Trái cây NhẬp khẨu</a>
                                        </li>
                                        <li class="cat-item">
                                            <a href="#" class="nav-link">Trái cây sấy</a>
                                        </li>
                                        <li class="cat-item">
                                            <a href="#" class="nav-link">Đồ uồng trái cây</a>
                                        </li>
                                        <li class="cat-item">
                                            <a href="#" class="nav-link">Giỏ trái cây</a>
                                        </li>
                                        <li class="cat-item">
                                            <a href="#" class="nav-link">Bánh kẹo trái cãy</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="widget-price-filter pt-3">
                                    <h5 class="widget-titlewidget-title">Tìm Theo Giá</h5>
                                    <ul class="product-tags sidebar-list list-unstyled">
                                        <li class="tags-item">
                                            <a href="#" class="nav-link">Dưới 100k</a>
                                        </li>
                                        <li class="tags-item">
                                            <a href="#" class="nav-link">100k - 200k</a>
                                        </li>
                                        <li class="tags-item">
                                            <a href="#" class="nav-link">200k - 300k</a>
                                        </li>
                                        <li class="tags-item">
                                            <a href="#" class="nav-link">300k - 400k</a>
                                        </li>
                                        <li class="tags-item">
                                            <a href="#" class="nav-link">400k - 500k</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </aside>

                        <main class="col-md-10">
                            <div class="filter-shop d-flex justify-content-between">
                                <div class="showing-product">
                                    <p>Hiển thị 1–9 trong số 55 kết quả</p>
                                </div>
                                <div class="sort-by">
                                    <select id="input-sort" class="form-control" data-filter-sort=""
                                        data-filter-order="">
                                        <option value="">Sắp xếp mặc định</option>
                                        <option value="">Từ (A - Z)</option>
                                        <option value="">Từ (Z - A)</option>
                                        <option value="">Giá (Thấp-Cao)</option>
                                        <option value="">Giá (Cao-Thấp)</option>
                                    </select>
                                </div>
                            </div>

                            <div class="product-grid row row-cols-sm-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4">

                                <div class="col">
                                    <div class="product-item">
                                        <span class="badge bg-success position-absolute m-3">-30%</span>
                                        <a href="#" class="btn-wishlist"><font-awesome-icon :icon="['far', 'heart']" /></a>
                                        <figure>
                                            <router-link to="/detail" title="Product Title">
                                                <img src="https://cdn.tgdd.vn/Products/Images/8788/234962/bhx/tao-fuji-mini-nhap-khau-hop-500g-202102061738567884.jpg"
                                                    alt="Product Thumbnail" class="tab-image" />
                                            </router-link>
                                        </figure>
                                        <h3>Sunstar Fresh Melon Juice</h3>
                                        <span class="qty">1 Unit</span><span class="rating"><svg width="24" height="24"
                                                class="text-primary">
                                                <use xlink:href="#star-solid"></use>
                                            </svg> 4.5</span>
                                        <span class="price">18.000₫</span>
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="input-group product-qty">
                                                <span class="input-group-btn">
                                                    <button type="button"
                                                        class="quantity-left-minus btn btn-danger btn-number"
                                                        data-type="minus">
                                                        <font-awesome-icon :icon="['fas', 'minus']" />                            

                                                    </button>
                                                </span>
                                                <input type="text" name="quantity"
                                                    class="form-control input-number quantity" value="1">
                                                <span class="input-group-btn">
                                                    <button type="button"
                                                        class="quantity-right-plus btn btn-success btn-number"
                                                        data-type="plus">
                                                        <font-awesome-icon :icon="['fas', 'plus']" />

                                                    </button>
                                                </span>
                                            </div>
                                            <button class="btn btn-primary">
                                                <a href="#" class="nav-link">Mua Ngay</a>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="product-item">
                                        <span class="badge bg-success position-absolute m-3">-30%</span>
                                        <a href="#" class="btn-wishlist"><font-awesome-icon :icon="['far', 'heart']" /></a>
                                        <figure>
                                            <router-link to="/detail" title="Product Title">
                                                <img src="https://cdn.tgdd.vn/Products/Images/8788/234962/bhx/tao-fuji-mini-nhap-khau-hop-500g-202102061738567884.jpg"
                                                    alt="Product Thumbnail" class="tab-image" />
                                            </router-link>
                                        </figure>
                                        <h3>Sunstar Fresh Melon Juice</h3>
                                        <span class="qty">1 Unit</span><span class="rating"><svg width="24" height="24"
                                                class="text-primary">
                                                <use xlink:href="#star-solid"></use>
                                            </svg> 4.5</span>
                                        <span class="price">18.000₫</span>
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="input-group product-qty">
                                                <span class="input-group-btn">
                                                    <button type="button"
                                                        class="quantity-left-minus btn btn-danger btn-number"
                                                        data-type="minus">
                                                        <font-awesome-icon :icon="['fas', 'minus']" />                            

                                                    </button>
                                                </span>
                                                <input type="text" name="quantity"
                                                    class="form-control input-number quantity" value="1">
                                                <span class="input-group-btn">
                                                    <button type="button"
                                                        class="quantity-right-plus btn btn-success btn-number"
                                                        data-type="plus">
                                                        <font-awesome-icon :icon="['fas', 'plus']" />

                                                    </button>
                                                </span>
                                            </div>
                                            <button class="btn btn-primary">
                                                <a href="#" class="nav-link">Mua Ngay</a>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <nav class="text-center py-4" aria-label="Page navigation">
                                <ul class="pagination d-flex justify-content-center">
                                    <li class="page-item disabled">
                                        <a class="page-link bg-none border-0" href="#" aria-label="Previous">
                                            <span aria-hidden="true">«</span>
                                        </a>
                                    </li>
                                    <li class="page-item active" aria-current="page"><a class="page-link border-0"
                                            href="#">1</a></li>
                                    <li class="page-item"><a class="page-link border-0" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link border-0" href="#">3</a></li>
                                    <li class="page-item">
                                        <a class="page-link border-0" href="#" aria-label="Next">
                                            <span aria-hidden="true">»</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>

                        </main>

                    </div>
                </div>
            </div>
        </section>
    </main>
</template>

<script>
export default {
    name: 'Product'
};

</script>