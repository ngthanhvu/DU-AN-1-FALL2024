<template>
    <div class="mt-5">
        <h2>Quản lý sản phẩm</h2>
        <button class="btn btn-primary" @click="openModal">
            <font-awesome-icon :icon="['fas', 'plus']" /> Thêm sản phẩm
        </button>

        <!-- Modal -->
        <div v-if="isModalVisible" class="modal fade show" tabindex="-1" style="display: block;" aria-hidden="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Thêm sản phẩm mới</h5>
                        <button type="button" class="btn-close" @click="closeModal"></button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="submitForm">
                            <div class="mb-3">
                                <label for="productName" class="form-label">Tên sản phẩm</label>
                                <input type="text" class="form-control" id="productName" v-model="newProduct.name" required />
                            </div>
                            <div class="mb-3">
                                <label for="productPrice" class="form-label">Giá sản phẩm</label>
                                <input type="number" class="form-control" id="productPrice" v-model="newProduct.price" required />
                            </div>
                            <div class="mb-3">
                                <label for="productDescription" class="form-label">Mô tả</label>
                                <textarea class="form-control" id="productDescription" v-model="newProduct.description"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Thêm sản phẩm</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table to display products -->
        <table class="table table-bordered mt-3">
            <thead class="table-dark text-center">
                <tr>
                    <th>Tên sản phẩm</th>
                    <th>Giá</th>
                    <th>Mô tả</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <tr v-for="(product, index) in products" :key="index">
                    <td>{{ product.name }}</td>
                    <td>{{ product.price }}</td>
                    <td>{{ product.description }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    data() {
        return {
            isModalVisible: false,
            newProduct: {
                name: '',
                price: '',
                description: ''
            },
            products: []
        };
    },
    methods: {
        openModal() {
            this.isModalVisible = true;
        },
        closeModal() {
            this.isModalVisible = false;
        },
        submitForm() {
            this.products.push({ ...this.newProduct });
            this.newProduct = { name: '', price: '', description: '' };
            this.closeModal();
        }
    }
};
</script>

<style scoped>
.modal {
    display: none;
    position: fixed;
    z-index: 1050;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: hidden;
    background-color: rgba(0, 0, 0, 0.5);
}
.modal-dialog {
    margin: 5% auto;
}
</style>