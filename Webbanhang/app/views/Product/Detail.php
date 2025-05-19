<?php include 'app/views/shares/header.php'; ?>

<?php if ($sp != null): ?>
    <div class="container my-5">
        <div class="row g-4 align-items-center">
            <!-- Hình ảnh -->
            <div class="col-md-6">
 <img 
      src="<?php echo htmlspecialchars($sp->image, ENT_QUOTES, 'UTF-8'); ?>" 
      class="img-fluid rounded shadow" 
      alt="Ảnh sản phẩm"
      style="height: 400px; object-fit: cover;" 
    >            </div>

            <!-- Thông tin chi tiết -->
            <div class="col-md-6">
                <h2 class="fw-bold mb-3"><?php echo htmlspecialchars($sp->name, ENT_QUOTES, 'UTF-8') ?></h2>
                <h4 class="text-danger mb-4">
                    <?php echo number_format($sp->price, 0, ',', '.') ?> đ
                </h4>
                <p class="text-muted" style="white-space: pre-line;">
                    <?php echo htmlspecialchars($sp->description, ENT_QUOTES, 'UTF-8') ?>
                </p>

                <!-- Nút hành động -->
                <div class="mt-4">
                    <a href="/webbanhang/product/Update/<?php echo $sp->id ?>" class="btn btn-warning me-2">
                        <i class="fas fa-edit"></i> Sửa
                    </a>
                    <a href="/webbanhang/product/delete/<?php echo $sp->id ?>" class="btn btn-danger" onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này không?')">
                        <i class="fas fa-trash-alt"></i> Xóa
                    </a>
                    <a href="/webbanhang" class="btn btn-secondary ms-2">
                        <i class="fas fa-arrow-left"></i> Quay lại
                    </a>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<script>
    function XoaSanPham($id) {


    }
</script>

<?php include 'app/views/shares/footer.php'; ?>