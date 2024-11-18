<template>
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
                        <li><strong><span class="text-danger"> Lịch sử mua hàng</span></strong></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <div class="order-history container mt-5">
        <h2 class="mb-4">Đơn hàng đã mua gần đây</h2>
        <div v-if="orders.length > 0" class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Mã đơn hàng</th>
                        <th>Ngày đặt</th>
                        <th>Trạng thái</th>
                        <th>Tổng tiền</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="order in orders" :key="order.id">
                        <td>{{ order.code }}</td>
                        <td>{{ order.date }}</td>
                        <td>
                            <span :class="statusClass(order.status)">{{ order.status }}</span>
                        </td>
                        <td>{{ formatCurrency(order.total) }}</td>
                        <td>
                            <button class="btn btn-primary btn-sm" @click="viewDetails(order)">
                                Xem chi tiết
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div v-else class="text-center">
            <p>Không có đơn hàng nào.</p>
        </div>

        <!-- Chi tiết đơn hàng -->
        <div v-if="selectedOrder" class="order-details mt-4">
            <h3>Chi tiết đơn hàng</h3>
            <p><strong>Mã đơn hàng:</strong> {{ selectedOrder.code }}</p>
            <p><strong>Ngày đặt:</strong> {{ selectedOrder.date }}</p>
            <p><strong>Trạng thái:</strong> {{ selectedOrder.status }}</p>
            <p><strong>Tổng tiền:</strong> {{ formatCurrency(selectedOrder.total) }}</p>
            <h4>Danh sách sản phẩm:</h4>
            <div class="order-items">
                <div v-for="item in selectedOrder.items" :key="item.id"
                    class="order-item d-flex align-items-center mb-3">
                    <img :src="item.image" alt="Hình ảnh sản phẩm" class="item-image me-3" />
                    <div>
                        <p class="mb-1"><strong>{{ item.name }}</strong></p>
                        <p class="mb-1">Số lượng: {{ item.quantity }}</p>
                        <p class="mb-1">Đơn giá: {{ formatCurrency(item.price) }}</p>
                    </div>
                    <button class="btn btn-success btn-sm ms-auto" @click="buyAgain(item)">
                        Mua lại
                    </button>
                </div>
            </div>
            <button class="btn btn-secondary btn-sm mt-3" @click="selectedOrder = null">
                Đóng
            </button>
        </div>

    </div>
</template>

<script>
export default {
    data() {
        return {
            orders: [
                {
                    id: 1,
                    code: "DH001",
                    date: "2024-11-15",
                    status: "Đã giao",
                    total: 150000,
                    items: [
                        {
                            id: 1,
                            name: "Áo MU",
                            quantity: 2,
                            price: 50000,
                            image: "https://bizweb.dktcdn.net/thumb/1024x1024/100/483/998/products/photo-2024-07-03-00-19-17.jpg", // Thay URL hình ảnh
                        },
                        {
                            id: 2,
                            name: "Áo MU",
                            quantity: 1,
                            price: 50000,
                            image: "https://bizweb.dktcdn.net/thumb/1024x1024/100/483/998/products/photo-2024-07-03-00-19-17.jpg", // Thay URL hình ảnh
                        },
                    ],
                },
                {
                    id: 2,
                    code: "DH002",
                    date: "2024-11-16",
                    status: "Đang giao",
                    total: 200000,
                    items: [
                        {
                            id: 3,
                            name: "Áo Mu",
                            quantity: 5,
                            price: 20000,
                            image: "https://bizweb.dktcdn.net/thumb/1024x1024/100/483/998/products/photo-2024-07-03-00-19-17.jpg", // Thay URL hình ảnh
                        },
                    ],
                },
            ],
            selectedOrder: null,
        };
    },
    methods: {
        formatCurrency(amount) {
            return new Intl.NumberFormat("vi-VN", { style: "currency", currency: "VND" }).format(amount);
        },
        statusClass(status) {
            switch (status) {
                case "Đã giao":
                    return "badge bg-success";
                case "Đang giao":
                    return "badge bg-warning";
                case "Đã hủy":
                    return "badge bg-danger";
                default:
                    return "badge bg-secondary";
            }
        },
        viewDetails(order) {
            this.selectedOrder = order;
        },
        buyAgain(item) {
            alert(`Mua lại sản phẩm: ${item.name}`);
        },
    },

};
</script>

<style scoped>
.order-history {
    font-family: Arial, sans-serif;
}

.order-details {
    border: 1px solid #ddd;
    padding: 15px;
    border-radius: 5px;
    background-color: #f9f9f9;
}

.table th,
.table td {
    text-align: center;
    vertical-align: middle;
}
.order-item {
  border: 1px solid #ddd;
  padding: 10px;
  border-radius: 5px;
  background-color: #fff;
}
.item-image {
  width: 80px;
  height: 80px;
  object-fit: cover;
  border: 1px solid #ccc;
  border-radius: 5px;
}

</style>