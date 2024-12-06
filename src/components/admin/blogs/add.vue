<template>
  <div id="layoutSidenav_content">
    <main>
      <div class="container-fluid px-4" style="margin-top: 80px;">
        <h2>Thêm bài viết</h2>
        <form @submit.prevent="submitForm">
          <div class="mb-3">
            <label for="title" class="form-label">Tiêu đề</label>
            <input v-model="form.title" type="text" id="title" class="form-control" placeholder="Nhập tiêu đề bài viết"
              required @blur="checkTitleExists" />
            <small v-if="titleError" class="text-danger">{{ titleError }}</small>
          </div>

          <div class="mb-3">
            <label for="content" class="form-label">Nội dung</label>
            <div id="editor"></div>
          </div>

          <div class="mb-3">
            <label for="image" class="form-label">Hình ảnh</label>
            <input @change="handleFileUpload" type="file" id="image" class="form-control" accept="image/*" required />
          </div>

          <button type="submit" class="btn btn-primary">Thêm bài viết</button>
        </form>
        <div style="height: 100vh"></div>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, onMounted, shallowRef } from "vue";
import axios from "axios";
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";

const API_URL = import.meta.env.VITE_API_URL;

const form = ref({
  title: "",
  content: "",
  image: null,
  user_id: null,
});

const editor = shallowRef(null);
const editorContent = ref("");
const titleError = ref("");

const handleFileUpload = (event) => {
  form.value.image = event.target.files[0];
};

const validateTitle = () => {
  const regex = /^[A-Za-z0-9\s.,?!'-À-ÿáéíóúàèìòùâêôíàèìòùĂ-ỹ]*$/;

  if (!regex.test(form.value.title)) {
    titleError.value = "Tiêu đề không được chứa ký tự đặc biệt ~`!@#$%^&*()_+=/?><|\\";
    return false;
  }

  titleError.value = "";
  return true;
};



const checkTitleExists = async () => {
  if (!form.value.title.trim()) {
    titleError.value = ""; 
    return;
  }

  try {
    const response = await axios.get(`${API_URL}/api/posts/check-title?title=${form.value.title}`);
    if (response.data.exists) {
      titleError.value = "Tiêu đề đã tồn tại. Vui lòng chọn một tiêu đề khác.";
    } else {
      titleError.value = ""; 
    }
  } catch (error) {
    console.error("Lỗi khi kiểm tra tiêu đề:", error);
  }
};


const submitForm = async () => {
  form.value.content = editorContent.value;

  // Validate title
  if (!validateTitle() || titleError.value) return; // Ensure title is valid and not duplicated

  if (!form.value.title.trim()) {
    alert("Vui lòng nhập tiêu đề");
    return;
  }

  if (!form.value.content.trim()) {
    alert("Vui lòng nhập nội dung");
    return;
  }

  if (!form.value.image) {
    alert("Vui lòng chọn hình ảnh");
    return;
  }

  const userId = localStorage.getItem("user_id");
  if (!userId) {
    alert("Vui lòng đăng nhập");
    return;
  }
  form.value.user_id = userId;

  try {
    const formData = new FormData();
    formData.append("title", form.value.title);
    formData.append("content", form.value.content);
    formData.append("image", form.value.image);
    formData.append("user_id", form.value.user_id);

    const response = await axios.post(`${API_URL}/api/posts`, formData, {
      headers: {
        "Content-Type": "multipart/form-data",
      },
    });

    console.log("Thêm bài viết thành công:", response.data);
    alert("Thêm bài viết thành công!");

    form.value.title = "";
    editorContent.value = "";
    editor.value.setData("");
    document.getElementById("image").value = "";
    form.value.image = null;
  } catch (error) {
    console.error("Lỗi thêm bài viết:", error);

    if (error.response) {
      console.error("Chi tiết lỗi:", error.response.data);
      alert(`Lỗi: ${error.response.data.message || "Có lỗi xảy ra"}`);
    } else if (error.request) {
      alert("Không nhận được phản hồi từ server. Kiểm tra kết nối mạng.");
    } else {
      alert(`Lỗi: ${error.message}`);
    }
  }
};

onMounted(() => {
  ClassicEditor.create(document.querySelector("#editor"), {}).then(
    (editorInstance) => {
      editor.value = editorInstance;

      editorInstance.model.document.on("change:data", () => {
        editorContent.value = editorInstance.getData();
      });
    }
  );
});
</script>

<style scoped>
h2 {
  color: #343a40;
}
</style>
