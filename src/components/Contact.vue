<template>
<main>
    <section class="py-5 mb-5":style="{ backgroundImage: 'url(https://demo.templatesjungle.com/foodmart/images/background-pattern.jpg)', backgroundSize: 'cover', backgroundRepeat: 'no-repeat' }">
        <div class="container-fluid">
          <div class="d-flex justify-content-between">
            <h1 class="page-title pb-2">Liên Hệ</h1>
            <nav class="breadcrumb fs-6">
              <a class="breadcrumb-item nav-link" href="#">Trang Chủ</a>
              <span class="breadcrumb-item active" aria-current="page">Liên Hệ</span>
            </nav>
          </div>
        </div>
      </section>
      <section class="contact-us py-5">
        <div class="container-fluid">
          <div class="row">
            <div class="contact-info col-lg-6 pb-3">
              <p>Tortor dignissim convallis aenean et tortor at risus viverra adipiscing.</p>
              <div class="page-content d-flex flex-wrap">
                <div class="col-lg-6 col-sm-12">
                  <div class="content-box text-dark pe-4 mb-5">
                    <h3 class="card-title">Địa chỉ</h3>
                    <div class="contact-address pt-3">
                      <p>730 Glenstone Ave 65802, Springfield, US</p>
                    </div>
                    <div class="contact-number">
                      <p>
                        <a href="#">+123 987 321</a>
                      </p>
                      <p>
                        <a href="#">+123 123 654</a>
                      </p>
                    </div>
                    <div class="email-address">
                      <p>
                        <a href="#">contact@website.com</a>
                      </p>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6 col-sm-12">
                  <div class="content-box">
                    <h3 class="card-title">Thông tin liê hệ khác</h3>
                    <div class="contact-address pt-3">
                      <p>730 Glenstone Ave 65802, Springfield, US</p>
                    </div>
                    <div class="contact-number">
                      <p>
                        <a href="#">+123 987 321</a>
                      </p>
                      <p>
                        <a href="#">+123 123 654</a>
                      </p>
                    </div>
                    <div class="email-address">
                      <p>
                        <a href="#">contact@website.com</a>
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="inquiry-item col-lg-6">
              <div class="bg-light p-5 rounded-5">
                <h2 class="display-7 text-dark">Dự án 1 hân hạnh được hỗ trợ</h2>
                <p>Điền thông tin vào bên dưới để liên hệ.</p>
                <form id="form" class="form-group flex-wrap">
                  <div class="form-input col-lg-12 d-flex mb-3">
                    <input type="text" name="name" placeholder="Họ & Tên" class="form-control ps-3 me-3">
                    <input type="text" name="email" placeholder="Địa chỉ Email" class="form-control ps-3">
                  </div>
                  <div class="col-lg-12 mb-3">
                    <input type="text" name="phone" placeholder="Số điện thoại" class="form-control ps-3">
                  </div>
                  <div class="col-lg-12 mb-3 position-relative">
                    <select name="complaint-issue" class="form-control ps-3 dropdown-arrow">
                        <option selected disabled>Chọn vấn đề khiếu nại</option>
                        <option value="product-issue">Vấn đề về sản phẩm</option>
                        <option value="delivery-delay">Chậm trễ giao hàng</option>
                        <option value="payment-issue">Vấn đề thanh toán</option>
                        <option value="other">Khác</option>
                    </select>
                </div>
                  <div class="col-lg-12 mb-3">
                    <textarea placeholder="Mô tả vấn đề" class="form-control ps-3" style="height:150px;"></textarea>
                  </div>
                </form>
                <div class="d-grid">
                  <button class="btn btn-primary btn-lg text-uppercase btn-rounded-none">GỬI KHIẾU NẠI</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </main>
</template>


<script>
export default {
    name: 'Contact'
}; 

</script>