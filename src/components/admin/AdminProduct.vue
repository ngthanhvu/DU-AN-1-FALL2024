<template>
  <div id="layoutSidenav_content">
    <main>
      <div class="container-fluid px-4" style="margin-top: 80px;">
        <h1 class="mt-4">Quản lý sản phẩm</h1>
        <div class="d-flex justify-content-end mb-3">
          <button class="btn btn-primary">Add Product</button>
        </div>
        <div class="card mb-3">
            <div class="card-header">Danh sách sản phẩm</div>
            <div class="card-body">
                <table class="table table-bordered" id="productTable">
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Images</th>
                            <th>Sku Code</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data will be loaded here -->
                    </tbody>
                </table>
            </div>
        </div>
        <div style="height: 100vh"></div>
      </div>
    </main>
  </div>
</template>
