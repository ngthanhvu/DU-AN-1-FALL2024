<template>
  <div id="layoutSidenav_content">
    <main>
      <div class="container-fluid px-4" style="margin-top: 80px;">
        <h2>Thêm bài viết</h2>
        <form @submit.prevent="submitForm">
          <div class="mb-3">
            <label for="title" class="form-label">Tiêu đề</label>
            <input v-model="form.title" type="text" id="title" class="form-control" placeholder="Nhập tiêu đề bài viết"
              required />
          </div>

          <div class="mb-3">
            <label for="content" class="form-label">Nội dung</label>
            <textarea ref="editor" id="content" class="form-control"></textarea>
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
import { ref, onMounted } from "vue";
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";

const form = ref({
  title: "",
  content: "",
  image: null,
});

const editor = ref(null);

const handleFileUpload = (event) => {
  form.value.image = event.target.files[0];
};

const submitForm = () => {
  form.value.content = editor.value.getData();
  console.log("Form data:", form.value);
  // Gửi form lên server hoặc xử lý logic khác tại đây
};

onMounted(() => {
  ClassicEditor.create(document.querySelector("#content"))
    .then((editorInstance) => {
      editor.value = editorInstance;
    })
    .catch((error) => {
      console.error("CKEditor error:", error);
    });
});
</script>

<style scoped>
h2 {
  color: #343a40;
}
</style>
