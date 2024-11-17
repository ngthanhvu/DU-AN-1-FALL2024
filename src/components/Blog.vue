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
            <li><strong><span class="text-danger"> Tin Tức</span></strong></li>
          </ul>
        </div>
      </div>
    </div>
    <section class="section-news">
      <div class="container">
        <h2 class="section-title mb-4">Tin Tức Mới Nhất</h2>
        <div class="row">
          <!-- Tin Tức 1 -->
          <div class="col-md-4 mb-4">
            <div class="news-item">
              <router-link to="/chi-tiet-tin-tuc" class="text-decoration-none">
                <img
                  src="https://cafefcdn.com/203337114487263232/2021/9/5/sport17bab263cf1original-ratio-1630800402561676628516.jpeg"
                  class="img-fluid" alt="News Image 1">
                <h4 class="mt-3">Man United lập kỷ lục thu về 1.366 tỷ từ bán áo đấu Ronaldo sau 12h,
                  bao giờ thu hồi "vốn"?</h4>
                <p class="text-muted">Theo LovetheSales.com, 12h sau khi áo đấu của Cristiano Ronaldo
                  phát hành, fan đã bỏ ra tổng cộng 32,5 triệu bảng (60 triệu USD – khoảng 1.366 tỷ
                </p>
              </router-link>
            </div>
          </div>
          <!-- Tin Tức 2 -->
          <div class="col-md-4 mb-4">
            <div class="news-item">
              <router-link to="/chi-tiet-tin-tuc" class="text-decoration-none">
                <img
                  src="https://cafefcdn.com/203337114487263232/2021/9/5/sport17bab263cf1original-ratio-1630800402561676628516.jpeg"
                  class="img-fluid" alt="News Image 2">
                <h4 class="mt-3">Man United lập kỷ lục thu về 1.366 tỷ từ bán áo đấu Ronaldo sau 12h,
                  bao giờ thu hồi "vốn"?</h4>
                <p class="text-muted">Theo LovetheSales.com, 12h sau khi áo đấu của Cristiano Ronaldo
                  phát hành, fan đã bỏ ra tổng cộng 32,5 triệu bảng (60 triệu USD – khoảng 1.366 tỷ
                </p>
              </router-link>
            </div>
          </div>
          <!-- Tin Tức 3 -->
          <div class="col-md-4 mb-4">
            <div class="news-item">
              <router-link to="/chi-tiet-tin-tuc" class="text-decoration-none">
                <img
                  src="https://cafefcdn.com/203337114487263232/2021/9/5/sport17bab263cf1original-ratio-1630800402561676628516.jpeg"
                  class="img-fluid" alt="News Image 3">
                <h4 class="mt-3">Man United lập kỷ lục thu về 1.366 tỷ từ bán áo đấu Ronaldo sau 12h,
                  bao giờ thu hồi "vốn"?</h4>
                <p class="text-muted">Theo LovetheSales.com, 12h sau khi áo đấu của Cristiano Ronaldo
                  phát hành, fan đã bỏ ra tổng cộng 32,5 triệu bảng (60 triệu USD – khoảng 1.366 tỷ
                </p>
              </router-link>
            </div>
          </div>
        </div>
      </div>
    </section>

  </section>
</template>

<script>
export default {
  name: 'Blog'
}
</script>
