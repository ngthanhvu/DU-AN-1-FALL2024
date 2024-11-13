<template>
  <div>
    <!-- Breadcrumb Section Begin -->
    <section class="shop1 text-center">
      <span class="crumb-border"></span>
      <div class="container">
        <div class="row">
          <div class="col-xs-12">
            <ul class="breadcrumb">
              <li class="home">
                <router-link to="/"><b>Trang chủ </b></router-link>
                <span class="icon-arrow-right text-danger">
                  <font-awesome-icon :icon="['fas', 'arrow-right']" />
                </span>
              </li>
              <li><strong><span class="text-danger"> Giới Thiệu</span></strong></li>
            </ul>
          </div>
        </div>
      </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- About Content Section Begin -->
    <section class="container mt-5">
      <div class="row">
        <!-- About Image Section -->
        <div class="col-md-6">
          <img src="https://via.placeholder.com/500x300" alt="About Image" class="img-fluid rounded">
        </div>
        <!-- About Text Section -->
        <div class="col-md-6">
          <h2>Giới Thiệu Về Chúng Tôi</h2>
          <p>
            Chúng tôi là một công ty chuyên cung cấp các sản phẩm chất lượng cao, cam kết mang đến cho khách hàng những trải nghiệm tuyệt vời. Với đội ngũ nhân viên tận tâm và sản phẩm đa dạng, chúng tôi tự hào là lựa chọn hàng đầu trong ngành.
          </p>
          <p>
            Tại [Tên công ty], chúng tôi luôn nỗ lực không ngừng để cải tiến sản phẩm và dịch vụ của mình. Mục tiêu của chúng tôi là đáp ứng mọi nhu cầu của khách hàng, đồng thời giữ vững uy tín và cam kết với chất lượng.
          </p>
          <p>
            Hãy cùng chúng tôi khám phá thêm về các sản phẩm và dịch vụ mà chúng tôi cung cấp. Nếu có bất kỳ câu hỏi nào, đừng ngần ngại liên hệ với chúng tôi.
          </p>
        </div>
      </div>
    </section>
    <!-- About Content Section End -->
  </div>
</template>

<script>
export default {
  name: 'About',
}
</script>

<style scoped>
.shop1 {
  background-color: #f9f9f9;
  padding: 20px 0;
}

.crumb-border {
  display: block;
  width: 100px;
  height: 2px;
  background-color: #ddd;
  margin: 10px auto;
}

.breadcrumb {
  background-color: transparent;
  padding: 0;
  list-style: none;
}

.breadcrumb li {
  display: inline;
}

.breadcrumb .icon-arrow-right {
  margin-left: 5px;
}

img.img-fluid {
  border-radius: 10px;
}
</style>
