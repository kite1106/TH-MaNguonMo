<?php include 'app/views/shares/header.php'; ?>

<!-- Hero Section -->
<section class="hero-section mb-5" style="background: linear-gradient(135deg,rgb(231, 173, 92),rgb(254, 155, 166)); color: white;">
    <div class="container py-5">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="display-5 fw-bold">Giảm giá lên đến 50%</h1>
                <p class="lead">Khám phá hàng ngàn sản phẩm chất lượng với mức giá tốt nhất</p>
                <a href="/webbanhang/product" class="btn btn-light btn-lg px-4">Mua ngay</a>
            </div>
            <div class="col-md-6">
                <img src="https://picsum.photos/id/684/600/400" alt="Hero Image" class="img-fluid rounded shadow">
            </div>
        </div>
    </div>
</section>

<!-- Categories Section -->


<!-- Featured Products -->
<section class="container mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Sản phẩm nổi bật</h2>
        <div>
            <a href="/webbanhang/product/add" class="btn btn-primary me-2">
                <i class="fas fa-plus me-1"></i> Thêm sản phẩm
            </a>
            <a href="/webbanhang/product" class="btn btn-outline-primary">
                Xem tất cả
            </a>
        </div>
    </div>

    <div class="row g-4">
        <?php if (!empty($ds)): ?>
            <?php foreach ($ds as $j): ?>
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="product-card p-3 bg-white shadow-sm rounded-3 h-100">
                        <div class="position-relative mb-3">
                            <?php if ($j->image != null): ?>
                                <img src="<?php echo $j->image; ?>"
                                    class="img-fluid product-img rounded w-100"
                                    alt="<?php echo htmlspecialchars($j->name, ENT_QUOTES, 'UTF-8'); ?>"
                                    style="height: 200px; object-fit: cover;">

                            <?php else: ?>
                                <img src="https://picsum.photos/id/<?php echo ($j->ID + 109); ?>/600/400"
                                    class="img-fluid product-img rounded w-100"
                                    alt="<?php echo htmlspecialchars($j->name, ENT_QUOTES, 'UTF-8'); ?>"
                                    style="height: 200px; object-fit: cover;">

                            <?php endif ?>

                        </div>
                        <h5 class="mb-1"><?php echo htmlspecialchars($j->name, ENT_QUOTES, 'UTF-8'); ?></h5>
                        <div class="mb-2">

                            <span class="text-dark fw-bold"><?php echo number_format($j->price, 0, ',', '.'); ?>đ</span>

                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-auto">

                            <div class="btn-group">
                                <a href="/webbanhang/product/Detail/<?php echo $j->id; ?>"
                                    class="btn btn-sm btn-outline-info"
                                    title="Xem chi tiết">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="/webbanhang/product/Update/<?php echo $j->id; ?>"
                                    class="btn btn-sm btn-outline-warning"
                                    title="Chỉnh sửa">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="/webbanhang/product/delete/<?php echo $j->id; ?>"
                                    class="btn btn-sm btn-outline-danger"
                                    title="Xóa sản phẩm"
                                    onclick="XoaSanPham(<?php echo $j->id; ?>)">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center py-5">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i> Chưa có sản phẩm nào
                </div>
                <a href="/webbanhang/product/add" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i> Thêm sản phẩm mới
                </a>
            </div>
        <?php endif; ?>
    </div>
</section>




<script>
    function XoaSanPham(id) {
        if (confirm("Bạn có muốn xóa sp với id " + id)) {
            window.location.href = "/webBanHang/Product/Delete/" + id;

        }
    }
</script>


<?php include 'app/views/shares/footer.php'; ?>