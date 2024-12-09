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
            <li><strong><span class="text-danger"> Liên Hệ</span></strong></li>
          </ul>
        </div>
      </div>
    </div>
  </section>
  <!-- Breadcrumb Section End -->
  <!-- Contact Section Begin -->
  <section class="contact spad">
    <div class="container">
      <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-6 text-center">
          <div class="contact__widget">
            <font-awesome-icon icon="phone" class="icon-green fa-2x" />
            <h4>Số Điện Thoại</h4>
            <p>+84-345-67890</p>
          </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 text-center">
          <div class="contact__widget">
            <font-awesome-icon icon="map-marker-alt" class="icon-green fa-2x" />
            <h4>Địa Chỉ</h4>
            <p>60-49 Hà Huy Tập, BMT, Đăk Lăk</p>
          </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 text-center">
          <div class="contact__widget">
            <font-awesome-icon icon="clock" class="icon-green fa-2x" />
            <h4>Thời Gian Mở Cửa</h4>
            <p>10:00 am to 23:00 pm</p>
          </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 text-center">
          <div class="contact__widget">
            <font-awesome-icon icon="envelope" class="icon-green fa-2x" />
            <h4>Email</h4>
            <p>Support@hangsport.online</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Contact Section End -->
  <!-- Map Begin -->
  <div class="map">
    <iframe
      src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d289.2792165084034!2d108.0674514376715!3d12.709396018295823!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1zSMOgIEh1eSBU4bqtcCwgVMOibiBM4bujaSwgQnXDtG4gTWEgVGh14buZdCwgxJDhuq9rIEzhuq9r!5e0!3m2!1svi!2s!4v1731549411652!5m2!1svi!2s"
      width="600" height="550" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"
      referrerpolicy="no-referrer-when-downgrade"></iframe>
    <div class="map-inside">
      <i class="icon_pin"></i>
      <div class="inside-widget">
        <h4>Việt Nam 🚩 </h4>
        <ul>
          <li>Điện thoại: +84-345-67890</li>
          <li>Địa chỉ: 60-49 Hà Huy Tập, BMT, Đăk Lăk</li>
        </ul>
      </div>
    </div>
  </div>

  <!-- Contact Form Begin -->
  <div class="contact-form spad">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="contact__form__title">
            <h2>Liên hệ với chúng tôi</h2>
          </div>
        </div>
      </div>
      <form action="#">
        <div class="row">
          <div class="col-lg-6 col-md-6">
            <input type="text" placeholder="Tên Của Bạn">
          </div>
          <div class="col-lg-6 col-md-6">
            <input type="phone" placeholder="Số Điện Thoại">
          </div>
          <div class="col-lg-12 col-md-6">
            <input type="text" placeholder="Địa Chỉ Email">
          </div>
          <div class="col-lg-12 text-center">
            <textarea placeholder="Nội Dung"></textarea>
            <button type="submit" class="site-btn">GỬI PHẢN HỒI</button>
          </div>
        </div>
      </form>
    </div>
  </div>
  <!-- Contact Form End -->

</template>

<script>
export default {
  name: 'Contact'
}
</script>

<style scoped>
.icon-green {
  color: #ef1d1d;
}
</style>
