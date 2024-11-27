<template>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4" style="margin-top: 80px;">
                <h2 class="mt-4">Quản lý mã giảm giá</h2>
                <table v-if="discounts.length" class="table">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Giảm Giá</th>
                            <th>Kiểu Giảm Giá</th>
                            <th>Giới Hạn Sử Dụng</th>
                            <th>Số Lần Sử Dụng</th>
                            <th>Ngày Hết Hạn</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="discount in discounts" :key="discount.id">
                            <td>{{ discount.code }}</td>
                            <td>{{ formatDiscountValue(discount.value, discount.type) }}</td> 
                            <td>{{ getDiscountType(discount.type) }}</td>
                            <td>{{ discount.usage_limit ? discount.usage_limit : 'Unlimited' }}</td>
                            <td>{{ discount.used_count }}</td>
                            <td>{{ discount.expires_at ? discount.expires_at : 'V/A' }}</td>
                            <td>
                                <button class="btn btn-primary" @click="editDiscount(discount)"><font-awesome-icon
                                        :icon="['fas', 'pen-to-square']" /></button> |
                                <button class="btn btn-danger" @click="deleteDiscount(discount.id)"><font-awesome-icon
                                        :icon="['far', 'trash-can']" /></button>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div v-else>
                    <p>Không có mã giảm giá nào.</p>
                </div>
                <div style="height: 100vh"></div>

            </div>
        </main>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const discounts = ref([]);
const fetchDiscounts = async () => {
    try {
        const response = await axios.get('http://localhost:8000/api/discounts');
        discounts.value = response.data;
    } catch (error) {
        console.error('Error fetching discounts:', error);
    }
};

const deleteDiscount = async (id) => {
    try {
        const response = await axios.delete(`http://localhost:8000/api/discounts/${id}`);
        alert(response.data.message);
        fetchDiscounts();
    } catch (error) {
        console.error('Error deleting discount:', error);
    }
};
const formatDiscountValue = (value, type) => {
    if (type === 'percentage') {
        return `${value}%`;
    }
    if (type === 'fixed') {
        return value.toLocaleString('vi-VN', {
            style: 'currency',
            currency: 'VND'
        });
    }
    return value;
};
const getDiscountType = (type) => {
    if (type === 'percentage') {
        return 'Giảm theo %';
    }
    if (type === 'fixed') {
        return 'Giảm theo số tiền';
    }
    return 'Không xác định';
}
onMounted(() => {
    fetchDiscounts();
});
</script>

<style scoped>
.discount-list {
    max-width: 1000px;
    margin: 0 auto;
    padding: 20px;
}

.table {
    width: 100%;
    border-collapse: collapse;
}

.table th,
.table td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}

.table th {
    background-color: #f2f2f2;
}

.btn-delete {
    padding: 5px 10px;
    background-color: red;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.btn-delete:hover {
    background-color: darkred;
}

p {
    font-size: 16px;
    color: #333;
}
</style>