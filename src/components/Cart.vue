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
              <span class="icon-arrow-right text-danger"><font-awesome-icon :icon="['fas', 'arrow-right']" /> </span>
            </li>
            <li><strong><span class="text-danger"> Giỏ Hàng</span></strong></li>
          </ul>
        </div>
      </div>
    </div>
  </section>
    <!-- Breadcrumb Section End -->

    <!-- Shoping Cart Section Begin -->
    <section class="shoping-cart spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="shoping__cart__table">
                        <table>
                            <thead>
                                <tr>
                                    <th class="shoping__product">Sản Phẩm</th>
                                    <th>Giá</th>
                                    <th>Số Lượng</th>
                                    <th>Tổng</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="shoping__cart__item">
                                        <img src="https://bizweb.dktcdn.net/thumb/1024x1024/100/483/998/products/photo-2024-07-03-00-19-17.jpg" alt="">
                                        <h5>Áo MU đỏ</h5>
                                    </td>
                                    <td class="shoping__cart__price">
                                        350.000đ
                                    </td>
                                    <td class="shoping__cart__quantity">
                                        <div class="quantity">
                                            <button class="qty-btn decrement">-</button>
                                            <input type="text" value="1" class="qty-input">
                                            <button class="qty-btn increment">+</button>
                                        </div>
                                    </td>
                                    <td class="shoping__cart__total">
                                        350.000đ
                                    </td>
                                    <td class="shoping__cart__item__close">
                                        <span class="icon_clos">X</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="shoping__cart__btns">
                        <router-link to="/san-pham"  class="primary-btn cart-btn">TIẾP TỤC MUA SẮM <font-awesome-icon :icon="['fas', 'bag-shopping']" /></router-link>

                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="shoping__continue">
                        <div class="shoping__discount">
                            <h5>ƯU ĐÃI GIẢM GIÁ</h5>
                            <form action="#">
                                <input type="text" placeholder="Nhập mã giảm giá nếu có">
                                <button type="submit" class="site-btn">ÁP DỤNG <font-awesome-icon :icon="['fas', 'ticket']" /></button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="shoping__checkout">
                        <h5>TỔNG SẢN PHẨM</h5>
                        <ul>
                            <li>Tạm tính <span>380.000đ</span></li>
                            <li>Tổng thanh toán <span>380.000đ</span></li>
                        </ul>
                        <router-link to="/thanh-toan" class="primary-btn">TIẾN HÀNH THANH TOÁN <font-awesome-icon :icon="['far', 'credit-card']" /></router-link>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Shoping Cart Section End -->


</template>

<script>
export default {
    name: 'Cart'
}


</script>

<style scoped>
.quantity {
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    width: 100px;
    /* Điều chỉnh kích thước */
}

.qty-btn {
    background-color: #f7f7f7;
    border: none;
    width: 30px;
    height: 30px;
    font-size: 18px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
}

.qty-btn:active {
    background-color: #e0e0e0;
    /* Hiệu ứng khi nhấn */
}

.qty-input {
    text-align: center;
    width: 40px;
    border: none;
    font-size: 16px;
    background-color: #f7f7f7;
}
</style>