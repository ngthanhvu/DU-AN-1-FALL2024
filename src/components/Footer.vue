<template>
  <footer class="footer mt-5">
    <div class="container">
      <div class="mid-footer row">
        <div class="footer-left col-xs-12 col-md-4 col-lg-5">
          <router-link to="/" class="logo" title="Logo">
            <img
              width="88"
              height="37"
              src="//bizweb.dktcdn.net/100/483/998/themes/904984/assets/logo.png?1720275862057"
              alt="Hang Thể Thao"
            />
          </router-link>
          <p>
            Khách hàng có nhu cầu IN TÊN SỐ, đặt đội hoặc mua số lượng lớn từ 7 bộ vui lòng inbox để SHOP hỗ trợ với
            giá tốt nhất cùng nhiều ưu đãi quà tặng đặc biệt
          </p>
        </div>
        <div class="footer-center col-xs-12 col-sm-6 col-md-4 col-lg-5">
          <h4>Hỗ Trợ Khách Hàng</h4>
          <ul class="ul_menu_fot">
            <li><router-link to="/chinh-sach" title="Chính sách bảo mật">Chính sách bảo mật</router-link></li>
            <li><router-link to="/coc-giu-nhiet" title="Cốc Giữ Nhiệt">Cốc Giữ Nhiệt</router-link></li>
            <li><router-link to="/gioi-thieu" title="Liên hệ">Liên hệ</router-link></li>
            <li><router-link to="/pre-order" title="Pre Order">Pre Order</router-link></li>
            <li><router-link to="#" title="Hỗ trợ trực tiếp">Hỗ trợ trực tiếp</router-link></li>
          </ul>
        </div>
        <div class="footer-right col-xs-12 col-sm-6 col-md-4 col-lg-2">
          <ul class="footer-contact">
            <li><i class="bi bi-telephone-fill"></i> <p>0555 555 555</p></li>
            <li><i class="bi bi-globe"></i> <p>https://hangsport.online</p></li>
            <li>
              <i class="bi bi-facebook"></i>
              <a href="https://Fb.com/hangthethao88" class="text-decoration-none text-white">fb.com/hangsport88</a>
            </li>
            <li><i class="bi bi-envelope"></i> <p>shop@hangsport.com</p></li>
          </ul>
        </div>
      </div>
      <div class="copyright">Hangsport copyright © 2023</div>
    </div>
  </footer>
</template>

<script>
export default {
  name: "Footer",
  mounted() {
    this.initSlider();
    window.addEventListener("resize", this.updateSlidesToShow);
  },
  beforeDestroy() {
    window.removeEventListener("resize", this.updateSlidesToShow);
  },
  methods: {
    initSlider() {
      this.sliderContainers = document.querySelectorAll(".slider-container");
      this.sliderContainers.forEach((container) => {
        const prevButton = container.querySelector(".slider-button-prev");
        const nextButton = container.querySelector(".slider-button-next");
        const sliderWrapper = container.querySelector(".slider-wrapper");
        const slides = container.querySelectorAll(".slider-slide");
        this.slideWidth =
          slides[0].getBoundingClientRect().width +
          parseInt(window.getComputedStyle(slides[0]).marginRight);
        this.totalSlides = slides.length;
        this.slidesToShow = 4;
        this.currentIndex = 0;

        this.updateSlidesToShow();

        nextButton.addEventListener("click", this.nextSlide);
        prevButton.addEventListener("click", this.prevSlide);
      });
    },
    nextSlide() {
      if (this.currentIndex < this.totalSlides - this.slidesToShow) {
        this.currentIndex++;
      } else {
        this.currentIndex = 0;
      }
      this.updateSliderPosition();
    },
    prevSlide() {
      if (this.currentIndex > 0) {
        this.currentIndex--;
      } else {
        this.currentIndex = this.totalSlides - this.slidesToShow;
      }
      this.updateSliderPosition();
    },
    updateSlidesToShow() {
      const screenWidth = window.innerWidth;
      if (screenWidth < 576) {
        this.slidesToShow = 1;
      } else if (screenWidth < 768) {
        this.slidesToShow = 2;
      } else if (screenWidth < 992) {
        this.slidesToShow = 3;
      } else {
        this.slidesToShow = 4;
      }
      this.updateSliderPosition();
    },
    updateSliderPosition() {
      const offset = -this.currentIndex * this.slideWidth;
      this.sliderContainers.forEach((container) => {
        container.querySelector(".slider-wrapper").style.transform = `translateX(${offset}px)`;
      });
    },
  },
};
</script>

<style scoped>
.footer {
  margin-top: 5rem;
  background-color: #333;
  color: #fff;
  padding: 2rem 0;
}

.footer .logo img {
  width: 88px;
  height: 37px;
}

.footer .footer-contact i {
  margin-right: 10px;
}

.footer .ul_menu_fot li {
  list-style: none;
  margin-bottom: 5px;
}

.footer .ul_menu_fot li a {
  color: #fff;
  text-decoration: none;
}

.footer .ul_menu_fot li a:hover {
  text-decoration: underline;
}
</style>
