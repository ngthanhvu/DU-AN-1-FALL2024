<template>
    <section class="shop1 text-center">
        <span class="crumb-border"></span>
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <ul class="breadcrumb">
                        <li class="home">
                            <router-link to="/"><b>Trang chủ </b></router-link>
                            <span class="icon-arrow-right text-danger"><font-awesome-icon
                                    :icon="['fas', 'arrow-right']" /> </span>
                        </li>
                        <li><strong><span class="text-danger"> Thông Tin Tài Khoản</span></strong></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>


    <!-- User Profile Section Begin -->

    <!-- Profile Details Section -->
    <div class="container profile-section">
        <div class="row mb-5">
            <!-- Profile Card -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <img src="https://hotprintdesign.com/wp-content/uploads/2019/02/Sani-Sebastian.png"
                            class="rounded-circle mb-3" alt="Profile Picture" width="150">
                        <h5 class="card-title">Username <i class="bi bi-patch-check-fill text-primary"></i></h5>
                        <p class="card-text">user@example.com</p>
                        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                            <i class="bi bi-person-circle"></i> Tài khoản khách hàng</button>
                    </div>
                </div>
            </div>

            <!-- Profile Edit Form -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Chi tiết hồ sơ</h5>
                    </div>
                    <div class="card-body">
                        <form action="/update-profile?id=1" method="POST">
                            <div class="mb-3">
                                <label for="username" class="form-label">Tên đăng nhập</label>
                                <input name="username" type="text" class="form-control" id="username"
                                    placeholder="Nhập username của bạn" value="Username123">
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input name="email" type="email" class="form-control" id="email"
                                    placeholder="Nhập email của bạn" value="user@example.com">
                            </div>
                            <div class="mb-3">
                                <label for="fullname" class="form-label">Họ tên</label>
                                <input type="text" class="form-control" id="fullname" name="full_name"
                                    placeholder="Nhập họ tên của bạn" value="Nguyen Van A">
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Số điện thoại</label>
                                <input name="phone" type="text" class="form-control" id="phone"
                                    placeholder="Nhập số điện thoại của bạn" value="0901234567">
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Địa chỉ</label>
                                <input name="address" type="text" class="form-control" id="address" rows="3"
                                    placeholder="Nhập địa chỉ của bạn" value="123 Đường ABC, Quận 1, TP.HCM">
                            </div>
                            <button type="submit" class="btn btn-primary"><i class="bi bi-floppy"></i> Lưu chỉnh
                                sửa</button>
                        </form>
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

    <!-- End of Profile Section -->

    <!-- Footer Inclusion (giả sử đây là một phần tĩnh bạn sẽ chèn vào trong HTML) -->

</template>

<script>
export default {
    name: 'Profile'
}
</script>