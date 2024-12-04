<template>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4" style="margin-top: 80px;">
                <h2>Danh sách mã giảm giá</h2>
                <!-- Discounts Table -->
                <table v-if="discounts.length" class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>Code</th>
                            <th>% Giảm Giá</th>
                            <th>Kiểu Giảm Giá</th>
                            <th>Giới Hạn Sử Dụng</th>
                            <th>Số Lần Sử Dụng</th>
                            <th>Ngày Hết Hạn</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="discount in pagedDiscounts" :key="discount.id">
                            <td>{{ discount.code }}</td>
                            <td>{{ discount.value }}</td>
                            <td>{{ discount.type }}</td>
                            <td>{{ discount.usage_limit ? discount.usage_limit : 'Unlimited' }}</td>
                            <td>{{ discount.used_count }}</td>
                            <td>{{ discount.expires_at ? discount.expires_at : 'N/A' }}</td>
                            <td>
                                <button class="btn btn-danger" @click="deleteDiscount(discount.id)">
                                    <font-awesome-icon :icon="['far', 'trash-can']" />
                                </button> |
                                <button class="btn btn-primary" @click="editDiscount(discount)">
                                    <font-awesome-icon :icon="['fas', 'pen-to-square']" />
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>


                <div v-else>
                    <p>No discount codes available.</p>
                </div>
                <!-- phân trang -->
                <div class="d-flex justify-content-center mt-3">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <li class="page-item" :class="{ disabled: currentPage === 1 }">
                                <a class="page-link" href="#" @click.prevent="goToPage(currentPage - 1)">Previous</a>
                            </li>
                            <li class="page-item" v-for="page in totalPages" :key="page"
                                :class="{ active: page === currentPage }">
                                <a class="page-link" href="#" @click.prevent="goToPage(page)">{{
                                    page
                                    }}</a>
                            </li>
                            <li class="page-item" :class="{ disabled: currentPage === totalPages }">
                                <a class="page-link" href="#" @click.prevent="goToPage(currentPage + 1)">Next</a>
                            </li>
                        </ul>
                    </nav>
                </div>

                <!-- Modal for Edit Form -->
                <div v-if="isModalVisible" class="modal-overlay" @click="closeModal"></div>
                <div v-if="isModalVisible" class="modal fade show" style="display: block;" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Chỉnh sửa mã giảm giá</h5>
                                <button type="button" class="close" @click="closeModal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <form @submit.prevent="updateDiscount">
                                    <div class="form-group">
                                        <label for="code">Mã giảm giá</label>
                                        <input type="text" v-model="editingDiscount.code" class="form-control" />
                                        <div v-if="errors.code" class="text-danger">{{ errors.code }}</div>
                                    </div>
                                    <div class="form-group">
                                        <label for="value">Phần trăm giảm giá / Số tiền giảm giá</label>
                                        <input type="number" v-model="editingDiscount.value" class="form-control"
                                            min="0" />
                                        <div v-if="errors.value" class="text-danger">{{ errors.value }}</div>
                                    </div>
                                    <div class="form-group">
                                        <label for="type">Hình thức giảm giá</label>
                                        <select v-model="editingDiscount.type" class="form-control">
                                            <option value="percentage">% Giảm Giá</option>
                                            <option value="fixed">Số tiền cố định</option>
                                        </select>
                                        <div v-if="errors.type" class="text-danger">{{ errors.type }}</div>
                                    </div>
                                    <div class="form-group">
                                        <label for="expires_at">Ngày hết hạn</label>
                                        <input type="date" v-model="editingDiscount.expires_at" class="form-control" />
                                    </div>
                                    <div class="form-group">
                                        <label for="usage_limit">Giới hạn sử dụng</label>
                                        <input type="number" v-model="editingDiscount.usage_limit" class="form-control"
                                            min="1" />
                                        <div v-if="errors.usage_limit" class="text-danger">{{ errors.usage_limit }}
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-success" style="width: 100%;">Cập nhật</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div style="height: 100vh"></div>
        </main>
    </div>
</template>


<script setup>
import { ref, onMounted, computed } from 'vue';
import axios from 'axios';
import Swal from 'sweetalert2';

const API_URL = import.meta.env.VITE_API_URL;

const discounts = ref([]);
const editingDiscount = ref(null);
const isModalVisible = ref(false);

// Define validation error messages
const errors = ref({
    code: '',
    value: '',
    type: '',
    expires_at: '',
    usage_limit: '',
});

const itemsPerPage = 10;
const currentPage = ref(1);

const totalPages = computed(() => {
    return Math.ceil(discounts.value.length / itemsPerPage);
});

const pagedDiscounts = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    return discounts.value.slice(start, end);
});

const goToPage = (page) => {
    if (page >= 1 && page <= totalPages.value) {
        currentPage.value = page;
    }
};

// Fetch the list of discounts
const fetchDiscounts = async () => {
    try {
        const response = await axios.get(`${API_URL}/api/discounts`);
        discounts.value = response.data;
    } catch (error) {
        console.error('Error fetching discounts:', error);
    }
};

// Delete a discount
const deleteDiscount = async (id) => {
    try {
        const response = await axios.delete(`${API_URL}/api/discounts/${id}`);
        Swal.fire({
            icon: 'success',
            title: 'Deleted!',
            text: response.data.message,
        });
        fetchDiscounts();
    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Không thể xóa mã giảm giá.',
        });
        console.error('Error deleting discount:', error);
    }
};

// Edit a discount
const editDiscount = (discount) => {
    editingDiscount.value = { ...discount };
    isModalVisible.value = true;
};

// Close the modal
const closeModal = () => {
    isModalVisible.value = false;
    editingDiscount.value = null;
    clearErrors();
};

// Clear validation errors
const clearErrors = () => {
    errors.value = {
        code: '',
        value: '',
        type: '',
        expires_at: '',
        usage_limit: '',
    };
};

// Update the discount
const updateDiscount = async () => {
    // Reset errors before validation
    clearErrors();

    // Validate form fields
    if (!editingDiscount.value.code) {
        errors.value.code = 'Mã giảm giá là bắt buộc.';
    }

    if (editingDiscount.value.value <= 0) {
        errors.value.value = 'Phần trăm giảm giá / Số tiền giảm giá phải lớn hơn 0.';
    }
    const specialCharacterRegex = /[^a-zA-Z0-9]/;
    if (specialCharacterRegex.test(editingDiscount.value.code)) {
        errors.value.code = 'Mã giảm giá không được chứa kí tự đặc biệt.';
    }
    if (!editingDiscount.value.type) {
        errors.value.type = 'Hình thức giảm giá là bắt buộc.';
    }

    if (editingDiscount.value.usage_limit && editingDiscount.value.usage_limit < 1) {
        errors.value.usage_limit = 'Giới hạn sử dụng phải lớn hơn 0.';
    }

    // If validation fails, return early
    if (Object.values(errors.value).some((error) => error !== '')) {
        return;
    }

    try {
        const response = await axios.put(`http://localhost:8000/api/discounts/${editingDiscount.value.id}`, editingDiscount.value);
        Swal.fire({
            icon: 'success',
            title: 'Cập nhật thành công!',
            text: response.data.message,
        });
        fetchDiscounts();
        closeModal();
    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Không thể cập nhật mã giảm giá.',
        });
        console.error('Error updating discount:', error);
    }
};

// Fetch discounts on page load
onMounted(() => {
    fetchDiscounts();
});

</script>



<style scoped>
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 1040;
}

.modal {
    display: none;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: #fff;
    z-index: 1050;
    width: 50%;
    max-width: 600px;
}

.modal.show {
    display: block;
}

.modal-header {
    padding: 10px;
    color: rgb(0, 0, 0);
    text-align: center;
}

.modal-body {
    padding: 20px;
}

.close {
    font-size: 24px;
    border: none;
    background: none;
    color: #505050;
    cursor: pointer;
}

.close:hover {
    color: #000000;
}
</style>