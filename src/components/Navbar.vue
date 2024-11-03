<!-- src/components/Header.vue -->
<template>
    <header>
        <div class="container-fluid">
            <div class="row py-3 border-bottom">
                <div class="col-sm-4 col-lg-3 text-center text-sm-start">
                    <div class="main-logo">
                        <a href="index.html">
                            <img src="#" alt="logo" class="img-fluid">
                        </a>
                    </div>
                </div>
                <div class="col-sm-6 offset-sm-2 offset-md-0 col-lg-5 d-none d-lg-block">
                    <div class="search-bar row bg-light p-2 my-2 rounded-4">
                        <div class="col-md-4 d-none d-md-block">
                            <select class="form-select border-0 bg-transparent">
                                <option>DANH MỤC</option>
                                <option>TRÁI CÂY NHẬP KHẨU</option>
                                <option>TRÁI CÂY VIỆT NAM</option>
                                <option>GIỎ TRÁI CÂY</option>
                            </select>
                        </div>
                        <div class="col-11 col-md-7">
                            <form id="search-form" class="text-center" action="index.html" method="post">
                                <input type="text" class="form-control border-0 bg-transparent"
                                    placeholder="Nhập tên sản phẩm cần tìm...." />
                            </form>
                        </div>
                        <div class="col-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="M21.71 20.29L18 16.61A9 9 0 1 0 16.61 18l3.68 3.68a1 1 0 0 0 1.42 0a1 1 0 0 0 0-1.39ZM11 18a7 7 0 1 1 7-7a7 7 0 0 1-7 7Z" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div
                    class="col-sm-8 col-lg-4 d-flex justify-content-end gap-5 align-items-center mt-4 mt-sm-0 justify-content-center justify-content-sm-end">
                    <div class="support-box text-end d-none d-xl-block">
                        <span class="fs-6 text-muted">TƯ VẤN & HỖ TRỢ</span>
                        <span class="mb-0">+980-34984089</span>
                    </div>
                    <ul class="d-flex justify-content-end list-unstyled m-0">
                        <li><a href="#" class="rounded-circle bg-light p-2 mx-1"><svg width="24" height="24"
                                    viewBox="0 0 24 24">
                                    <use xlink:href="#user"></use>
                                </svg></a></li>
                        <li><a href="#" class="rounded-circle bg-light p-2 mx-1"><svg width="24" height="24"
                                    viewBox="0 0 24 24">
                                    <use xlink:href="#heart"></use>
                                </svg></a></li>
                        <li class="d-lg-none"><a href="#" class="rounded-circle bg-light p-2 mx-1"
                                data-bs-toggle="offcanvas" data-bs-target="#offcanvasCart"
                                aria-controls="offcanvasCart"><svg width="24" height="24" viewBox="0 0 24 24">
                                    <use xlink:href="#cart"></use>
                                </svg></a></li>
                        <li class="d-lg-none"><a href="#" class="rounded-circle bg-light p-2 mx-1"
                                data-bs-toggle="offcanvas" data-bs-target="#offcanvasSearch"
                                aria-controls="offcanvasSearch"><svg width="24" height="24" viewBox="0 0 24 24">
                                    <use xlink:href="#search"></use>
                                </svg></a></li>
                    </ul>
                    <div class="cart text-end d-none d-lg-block dropdown">
                        <button class="border-0 bg-transparent d-flex flex-column gap-2 lh-1" type="button"
                            data-bs-toggle="offcanvas" data-bs-target="#offcanvasCart" aria-controls="offcanvasCart">
                            <span class="fs-6 text-muted dropdown-toggle">GIỎ HÀNG</span>
                            <span class="cart-total fs-5 fw-bold">120.000 VNĐ</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row py-3">
                <nav class="main-menu d-flex navbar navbar-expand-lg">
                    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar"
                        aria-labelledby="offcanvasNavbarLabel">
                        <div class="offcanvas-header justify-content-center">
                            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                                aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body">
                            <select class="filter-categories border-0 mb-0 me-5">
                                <option>KHUYẾN MÃI HOT 💣</option>
                                <option>MÃ QUÀ TẶNG</option>
                                <option>TRI ÂN KHÁCH HÀNG</option>
                            </select>
                            <ul class="navbar-nav justify-content-end menu-list list-unstyled d-flex gap-md-3 mb-0">
                                <li class="nav-item active"><a href="index.html" class="nav-link">TRANG CHỦ</a></li>
                                <li class="nav-item dropdown"><a href="gioithieu.html" class="nav-link">GIỚI THIỆU</a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="product.html" role="button" id="pages"
                                        aria-expanded="false">SẢN PHẨM</a>
                                    <ul class="dropdown-menu" aria-labelledby="pages">
                                        <li><a href="#" class="dropdown-item">TRÁI CÂY NHẬP KHẨU</a></li>
                                        <li><a href="#" class="dropdown-item">GIỎ TRÁI CÂY</a></li>
                                        <li><a href="#" class="dropdown-item">TRÁI CÂY VIỆT NAM</a></li>
                                        <li><a href="#" class="dropdown-item">ĐỒ UỐNG TRÁI CÂY</a></li>
                                        <li><a href="#" class="dropdown-item">TRÁI CÂY SẤY</a></li>
                                        <li><a href="#" class="dropdown-item">BÁNH KẸO TRÁI CÂY</a></li>
                                    </ul>
                                </li>
                                <li class="nav-item"><a href="tintuc.html" class="nav-link">TIN TỨC</a></li>
                                <li class="nav-item"><a href="lienhe.html" class="nav-link">LIÊN HỆ</a></li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </header>
</template>

<script>
export default {
    name: 'Header'
};
</script>

<style scoped>
/* Style của Header */
</style>