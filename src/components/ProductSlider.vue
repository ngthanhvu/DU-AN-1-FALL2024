<template>
    <!-- <section class="section-3 mt-5">
        <div class="container">
            <div class="heading-container">
                <h3><strong>{{ title }}</strong></h3>
                <router-link to="/san-pham" class="text-decoration-none text-black"><b>Xem thêm</b></router-link>
            </div>
            <div class="slider-container">
                <div class="slider" :style="{ transform: 'translateX(' + (-currentSlide * 20) + '%)' }">
                    <div class="slide" v-for="(item, index) in products" :key="index">
                        <a href="/chi-tiet-san-pham" class="text-decoration-none text-black">
                            <div class="card border-0 py-5">
                                <img :src="item.image" class="border" alt="Product Image" />
                                <div class="card-body">
                                    <div class="rating">
                                        <font-awesome-icon :icon="['far', 'star']" class="star-icon" v-for="i in 5" :key="i" />
                                    </div>
                                    <h5 class="card-title text-left">
                                        <b>{{ item.name }}</b>
                                    </h5>
                                    <p class="card-text text-left">
                                        <span class="text-danger me-2"><b>{{ item.price }}</b></span>
                                        <span class="text-decoration-line-through">{{ item.oldPrice }}</span>
                                    </p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <button @click="prevSlide" class="prev-button">
                    <font-awesome-icon :icon="['fas', 'arrow-left']" />
                </button>
                <button @click="nextSlide" class="next-button">
                    <font-awesome-icon :icon="['fas', 'arrow-right']" />
                </button>
            </div>
        </div>
    </section> -->
</template>

<script setup>
// import { ref } from 'vue';
// import { useRoute } from 'vue-router';

// const props = defineProps({
//     title: String,
//     products: Array
// });

// const currentSlide = ref(0);

// const prevSlide = () => {
//     if (currentSlide.value > 0) {
//         currentSlide.value--;
//     }
// };

// const nextSlide = () => {
//     if (currentSlide.value < props.products.length - 5) {
//         currentSlide.value++;
//     } else {
//         currentSlide.value = 0;
//     }
// };
</script>

<style scoped>
/* .slide img {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.slide img:hover {
    transform: scale(1.1);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
}
.card-body h5:hover {
    color:rgb(253, 0, 0);
}
.card-body h5 {
    font-size: 16px;
}
.heading-container a:hover {

}
.rating {
    color: gold;
} */
</style>
