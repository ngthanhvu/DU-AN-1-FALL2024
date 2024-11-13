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
            <h4>Phone</h4>
            <p>+01-3-8888-6868</p>
          </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 text-center">
          <div class="contact__widget">
            <font-awesome-icon icon="map-marker-alt" class="icon-green fa-2x" />
            <h4>Address</h4>
            <p>60-49 Road 11378 New York</p>
          </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 text-center">
          <div class="contact__widget">
            <font-awesome-icon icon="clock" class="icon-green fa-2x"/>
            <h4>Open time</h4>
            <p>10:00 am to 23:00 pm</p>
          </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 text-center">
          <div class="contact__widget">
            <font-awesome-icon icon="envelope" class="icon-green fa-2x"/>
            <h4>Email</h4>
            <p>hello@colorlib.com</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Contact Section End -->
  <!-- Map Begin -->
  <div class="map">
    <iframe
      src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d49116.39176087041!2d-86.41867791216099!3d39.69977417971648!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x886ca48c841038a1%3A0x70cfba96bf847f0!2sPlainfield%2C%20IN%2C%20USA!5e0!3m2!1sen!2sbd!4v1586106673811!5m2!1sen!2sbd"
      height="500" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
    <div class="map-inside">
      <i class="icon_pin"></i>
      <div class="inside-widget">
        <h4>New York</h4>
        <ul>
          <li>Phone: +12-345-6789</li>
          <li>Add: 16 Creek Ave. Farmingdale, NY</li>
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
            <h2>Bạn Muốn Báo Cáo</h2>
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
    color: #7fad39;
}

</style>
