<template>
    <section class="section-3 mt-5">
        <div class="container">
            <div class="heading-container">
                <h2>{{ title }}</h2>
                <router-link to="/product" class="text-decoration-none text-black"><b>Xem thêm</b></router-link>
            </div>
            <div class="slider-container">
                <div class="slider" :style="{ transform: 'translateX(' + (-currentSlide * 20) + '%)' }">
                    <div class="slide" v-for="(item, index) in products" :key="index">
                        <a href="/detail" class="text-decoration-none text-black">
                            <div class="card border-0 py-5">
                                <img :src="item.image" class="border" alt="Product Image" />
                                <div class="card-body">
                                    <div class="rating">
                                        <font-awesome-icon :icon="['far', 'star']" class="star-icon" v-for="i in 5" :key="i" />
                                    </div>
                                    <p class="card-title text-left">
                                        <b>{{ item.name }}</b>
                                    </p>
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
    </section>
</template>

<script>
export default {
    props: {
        title: String,
        products: Array
    },
    data() {
        return {
            currentSlide: 0
        };
    },
    methods: {
        prevSlide() {
            if (this.currentSlide > 0) {
                this.currentSlide--;
            } 
        },
        nextSlide() {
            if (this.currentSlide < this.products.length - 5) {
                this.currentSlide++;
            } else {
                this.currentSlide = 0;
            }
        }
    }
};
</script>

<style scoped>
</style>
