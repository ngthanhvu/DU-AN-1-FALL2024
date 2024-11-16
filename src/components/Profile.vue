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
                        <li><strong><span class="text-danger"> Thông Tin Tài Khoản</span></strong></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- User Profile Section Begin -->
    <div class="container profile-section">
        <div class="row mb-5">
            <!-- Profile Card -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <img src="https://hotprintdesign.com/wp-content/uploads/2019/02/Sani-Sebastian.png"
                            class="rounded-circle mb-3" alt="Profile Picture" width="150" />
                        <h5 class="card-title">Username <i class="bi bi-patch-check-fill text-primary"></i></h5>
                        <p class="card-text">user@example.com</p>
                        <button class="btn btn-danger" @click="openEditModal">
                            <i class="bi bi-person-circle"></i> Tài khoản khách hàng
                        </button>
                    </div>
                </div>
            </div>

            <!-- Profile Edit Form -->
            <div class="col-md-8">
                <div class="card">
                    <div class="profile-header">
                        <h5 class="card-title">Chi tiết hồ sơ</h5>
                        <button type="button" class="btn btn-primary mt-3" @click="openEditModal">
                            <i class="bi bi-floppy"></i> Sửa Thông Tin
                        </button>
                    </div>
                    <div class="card-body">
                        <form action="/update-profile?id=1" method="POST">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Tên đăng nhập</th>
                                        <th>Email</th>
                                        <th>Họ tên</th>
                                        <th>Số điện thoại</th>
                                        <th>Địa chỉ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Username123</td>
                                        <td><input name="email" type="email" class="form-control" id="email"
                                                value="user@example.com" /></td>
                                        <td><input name="full_name" type="text" class="form-control" id="fullname"
                                                value="Nguyen Van A" /></td>
                                        <td><input name="phone" type="text" class="form-control" id="phone"
                                                value="0901234567" /></td>
                                        <td>
                                            <input name="address" type="text" class="form-control" id="address"
                                                value="123 Đường ABC, Quận 1, TP.HCM" />
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>

                <!-- Modal Form -->
                <div v-if="isModalVisible" class="modal fade show" style="display: block;" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Sửa Thông Tin</h5>
                                <button type="button" class="btn-close" @click="closeModal" aria-label="Close"></button>
                            </div>
                            <form @submit.prevent="handleSubmit">
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="username" class="form-label">Tên Đăng Nhập:</label>
                                        <input type="text" class="form-control" id="name" v-model="profile.username"
                                            required />
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email:</label>
                                        <input type="text" class="form-control" id="email" v-model="profile.email"
                                            required />
                                    </div>
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Họ Tên:</label>
                                        <input type="text" class="form-control" id="name" v-model="profile.name"
                                            required />
                                    </div>
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">Số Điện Thoại:</label>
                                        <input type="phone" class="form-control" id="phone" v-model="profile.phone"
                                            required />
                                    </div>
                                    <div class="mb-3">
                                        <label for="address" class="form-label">Địa Chỉ:</label>
                                        <input type="text" class="form-control" id="address" v-model="profile.address"
                                            placeholder="Nhập số nhà, tên đường..." required />

                                        <!-- Nút Thêm Địa Chỉ Mới -->
                                        <button type="button" class="btn btn-secondary mt-3"
                                            @click="toggleNewAddressForm">
                                            Thêm Địa Chỉ Mới <font-awesome-icon :icon="['fas', 'plus']" />
                                        </button>

                                        <!-- Form Thêm Địa Chỉ Mới -->
                                        <div v-if="isAddingNewAddress" class="mt-3 border p-3">
                                            <h5>Thêm Địa Chỉ Mới</h5>
                                            <div class="row mt-2">
                                                <div class="col-md-6">
                                                    <label for="newProvince" class="form-label">Tỉnh:</label>
                                                    <input type="text" class="form-control" id="newProvince"
                                                        v-model="newAddress.province" placeholder="Nhập Tỉnh"
                                                        required />
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="newDistrict" class="form-label">Huyện:</label>
                                                    <input type="text" class="form-control" id="newDistrict"
                                                        v-model="newAddress.district" placeholder="Nhập Huyện"
                                                        required />
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <div class="col-md-6">
                                                    <label for="newCommune" class="form-label">Xã:</label>
                                                    <input type="text" class="form-control" id="newCommune"
                                                        v-model="newAddress.commune" placeholder="Nhập Xã" required />
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="newHamlet" class="form-label">Thôn:</label>
                                                    <input type="text" class="form-control" id="newHamlet"
                                                        v-model="newAddress.hamlet" placeholder="Nhập Thôn" required />
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <div class="col-md-12">
                                                    <label for="newHouseNumber" class="form-label">Số nhà:</label>
                                                    <input type="text" class="form-control" id="newHouseNumber"
                                                        v-model="newAddress.houseNumber" placeholder="Nhập Số Nhà"
                                                        required />
                                                </div>
                                            </div>
                                            <!-- Nút Lưu Địa Chỉ -->
                                            <button type="button" class="btn btn-primary mt-3" @click="saveNewAddress">
                                                <i class="bi bi-floppy"></i> Lưu Địa Chỉ
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary"><i class="bi bi-floppy"></i> Lưu Thay
                                        Đổi</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Change Password Section -->
                <div class="card mt-3">
                    <div class="card-header">
                        <h5 class="card-title">Đổi mật khẩu</h5>
                    </div>
                    <div class="card-body">
                        <form action="/update-new-password" method="POST">
                            <div class="mb-3">
                                <label for="oldPassword" class="form-label">Mật khẩu cũ</label>
                                <input type="password" class="form-control" id="oldPassword" name="old_password"
                                    placeholder="Điền mật khẩu cũ">
                            </div>
                            <div class="mb-3">
                                <label for="newPassword" class="form-label">Mật khẩu mới</label>
                                <input type="password" class="form-control" id="newPassword" name="new_password"
                                    placeholder="Điền mật khẩu mới">
                            </div>
                            <input type="hidden" name="id" value="1">
                            <button type="submit" class="btn btn-primary"><i class="bi bi-pencil-square"></i> Đổi mật
                                khẩu</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
import { ref } from "vue";

export default {
    setup() {
        const isModalVisible = ref(false);
        const isAddingNewAddress = ref(false); // Trạng thái hiển thị form thêm địa chỉ mới

        const profile = ref({
            name: "",
            email: "",
            address: "",
            phone: "",
            username: "",
            province: "",
            district: "",
            commune: "",
            hamlet: "",
        });

        const newAddress = ref({
            province: "",
            district: "",
            commune: "",
            hamlet: "",
            houseNumber: "",
        });

        const openEditModal = () => {
            isModalVisible.value = true;
        };

        const closeModal = () => {
            isModalVisible.value = false;
        };

        const toggleNewAddressForm = () => {
            isAddingNewAddress.value = !isAddingNewAddress.value;
        };

        const saveNewAddress = () => {
            if (
                newAddress.value.province &&
                newAddress.value.district &&
                newAddress.value.commune &&
                newAddress.value.hamlet &&
                newAddress.value.houseNumber
            ) {
                console.log("Địa chỉ mới đã lưu:", newAddress.value);
                // Gán địa chỉ mới vào profile (hoặc xử lý theo nhu cầu)
                profile.value.address = `
                    ${newAddress.value.houseNumber}, 
                    ${newAddress.value.hamlet}, 
                    ${newAddress.value.commune}, 
                    ${newAddress.value.district}, 
                    ${newAddress.value.province}
                `.trim();
                // Đóng form thêm địa chỉ
                isAddingNewAddress.value = false;
            } else {
                alert("Vui lòng nhập đầy đủ thông tin địa chỉ!");
            }
        };

        const handleSubmit = () => {
            console.log("Profile Added:", profile.value);
            closeModal();
        };

        return {
            isModalVisible,
            isAddingNewAddress,
            profile,
            newAddress,
            openEditModal,
            closeModal,
            toggleNewAddressForm,
            saveNewAddress,
            handleSubmit,
        };
    },
};
</script>


<style scoped>
.modal {
    display: none;
    position: fixed;

    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.4);
}


.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

.profile-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px;
}
</style>