import { createRouter, createWebHistory } from 'vue-router';

// Import các component cho các route
import Home from '../components/Home.vue';
import Product from '../components/Product.vue';
import Detail_product from '../components/Detail_product.vue';
import Contact from '../components/Contact.vue';
import About from '../components/About.vue';
import Blog from '../components/Blog.vue';
import Login from '../components/Login.vue';
import Register from '../components/Register.vue';
import Cart from '../components/Cart.vue';
import Checkout from '../components/Checkout.vue';
import Profile from '../components/Profile.vue';
import Detail_post from '../components/Detail_post.vue';
import Forgot from '../components/Forgot.vue'
import OrderHistory from '@/components/OrderHistory.vue';
import Success from '@/components/Success.vue';

import AdminLayout from '../components/admin/AdminLayout.vue';
import AdminDashboard from '@/components/admin/AdminDashboard.vue';
import AdminProduct from '@/components/admin/AdminProduct.vue';
import AdminAddProduct from '@/components/admin/products/add.vue';
import AdminCategory from '@/components/admin/AdminCategory.vue';
import AdminAddCategory from '@/components/admin/category/add.vue';
import AdminUser from '@/components/admin/AdminUser.vue';
import AdminBlog from '@/components/admin/AdminBlog.vue';
import AdminAddBlog from '@/components/admin/blogs/add.vue';

const routes = [
  { path: '/', component: Home, meta: { title: 'Trang chủ' } },
  { path: '/san-pham', component: Product, meta: { title: 'Sản phẩm' } },
  { path: '/chi-tiet-san-pham/:id', component: Detail_product, meta: { title: 'Chi tiết sản phẩm' } },
  { path: '/lien-he', component: Contact, meta: { title: 'Liên hệ' } },
  { path: '/gioi-thieu', component: About, meta: { title: 'Giới thiệu' } },
  { path: '/tin-tuc', component: Blog, meta: { title: 'Tin tức' } },
  { path: '/login', component: Login, meta: { title: 'Đăng nhập' } },
  { path: '/register', component: Register, meta: { title: 'Đăng ký' } },
  { path: '/gio-hang', component: Cart, meta: { title: 'Giỏ hàng' } },
  { path: '/thanh-toan', component: Checkout, meta: { title: 'Thanh toán' } },
  { path: '/trang-ca-nhan', component: Profile, meta: { title: 'Thông tin cá nhân' } },
  { path: '/chi-tiet-tin-tuc/:id', component: Detail_post, meta: { title: 'Tin tức' } },
  { path: '/quen-mat-khau', component: Forgot, meta: { title: 'Quên mật khẩu' } },
  { path: '/lich-su-mua-hang', component: OrderHistory, meta: { title: 'Lịch sử mua hàng' } },
  { path: '/thanh-cong', component: Success, meta: { title: 'Thành công' } },
  {
    path: '/admin',
    component: AdminLayout,
    children: [
      { path: '', component: AdminDashboard, meta: { title: 'Admin Dashboard' } },
      { path: '/admin/products', component: AdminProduct, meta: { title: 'Admin Product' } },
      { path: '/admin/products/add', component: AdminAddProduct, meta: { title: 'Admin Add Product' } },
      { path: '/admin/category', component: AdminCategory, meta: { title: 'Admin Category' } },
      { path: '/admin/category/add', component: AdminAddCategory, meta: { title: 'Admin Add Category' } },
      { path: '/admin/user', component: AdminUser, meta: { title: 'Admin User' } },
      { path: '/admin/blog', component: AdminBlog, meta: { title: 'Admin Blog' } },
      { path: '/admin/blog/add', component: AdminAddBlog, meta: { title: 'Admin Add Blog' } },
    ],
  }

];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

router.beforeEach((to, from, next) => {
  document.title = `${to.meta.title} | Hangsport`;
  next();
});

export default router;
