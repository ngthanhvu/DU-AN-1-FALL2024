<template>
    <!-- Breadcrumb Section Begin -->
    <section class="shop1 text-center">
        <span class="crumb-border"></span>
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <ul class="breadcrumb">
                        <li class="home">
                            <router-link to="/"><b>Trang chủ </b></router-link>
                            <span class="icon-arrow-right text-danger"><font-awesome-icon
                                    :icon="['fas', 'arrow-right']" /> </span>
                        </li>
                        <li><strong><span class="text-danger"> Thanh Toán</span></strong></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Checkout Section Begin -->
    <section class="checkout spad">
        <div class="container">
            <div class="checkout__form">
                <h4>Thông Tin Thanh Toán</h4>
                <form action="#">
                    <div class="row">
                        <div class="col-lg-8 col-md-6">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Họ<span>*</span></p>
                                        <input type="text">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Tên<span>*</span></p>
                                        <input type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="checkout__input">
                                <p>Quốc gia<span>*</span></p>
                                <input type="text">
                            </div>
                            <div class="checkout__input">
                                <p>Tỉnh/Thành Phố<span>*</span></p>
                                <input type="text">
                            </div>
                            <div class="checkout__input">
                                <p>Quận/Huyện<span>*</span></p>
                                <input type="text">
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Xã / Phường<span>*</span></p>
                                        <input type="text">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Số nhà / Đường / Hẻm<span>*</span></p>
                                        <input type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Số Điện Thoại<span>*</span></p>
                                        <input type="text">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Email<span>*</span></p>
                                        <input type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="checkout__input__checkbox">
                                <label for="acc">
                                    Đồng ý với điều khoản & Dịch vụ ?
                                    <input type="checkbox" id="acc">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="checkout__order">
                                <h4>ĐƠN HÀNG</h4>
                                <div class="checkout__order__products">Sản phẩm <span>Giá tiền</span></div>
                                <ul>
                                    <li>Áo MU đỏ <span>350.000đ</span></li>
                                    <li>Áo MU Away (2024-2025) Màu xanh  <span>250.000đ</span></li>
                                    <li>Áo Đức Home (2024 - 2025) Màu trắng <span>450.000đ</span></li>  
                                </ul>
                                <div class="checkout__order__subtotal">Tạm tính <span>1.000.000đ</span></div>
                                <div class="checkout__order__total">Tổng thanh toán <span>1.100.000đ</span></div>

                                <!-- Phương thức thanh toán -->
                                <div class="checkout__input__checkbox">
                                    <label for="cod">
                                        Thanh Toán Khi Nhận Hàng
                                        <input type="radio" name="payment" id="cod" value="cod">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="checkout__input__checkbox">
                                    <label for="banking">
                                        Thanh Toán Bằng Banking
                                        <input type="radio" name="payment" id="banking" value="banking">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="checkout__input__checkbox">
                                    <label for="vnpay">
                                        Thanh Toán Bằng VNPAY
                                        <input type="radio" name="payment" id="vnpay" value="vnpay">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>

                                <button type="submit" class="site-btn">Xác Nhận Thanh Toán</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    name: 'Checkout'
}
</script>