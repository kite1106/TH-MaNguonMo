<?php include 'app/views/shares/header.php'; ?>
<!-- Featured Products -->
<section class="container mb-5">
    <div class="row g-4">
        <?php if (!empty($ds)): ?>
            <?php foreach ($ds as $j): ?>
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="product-card p-3 bg-white shadow-sm rounded-3 h-100 d-flex flex-column">
                        <div class="position-relative mb-3">
                            <?php if (!empty($j->image)): ?>
                                <img src="<?php echo $j->image; ?>"
                                     class="img-fluid product-img rounded w-100"
                                     alt="<?php echo htmlspecialchars($j->name, ENT_QUOTES, 'UTF-8'); ?>"
                                     style="height: 200px; object-fit: cover;">
                            <?php else: ?>
                                <img src="https://picsum.photos/id/<?php echo ($j->ID + 109); ?>/600/400"
                                     class="img-fluid product-img rounded w-100"
                                     alt="<?php echo htmlspecialchars($j->name, ENT_QUOTES, 'UTF-8'); ?>"
                                     style="height: 200px; object-fit: cover;">
                            <?php endif; ?>
                        </div>

                        <h5 class="mb-1"><?php echo htmlspecialchars($j->name, ENT_QUOTES, 'UTF-8'); ?></h5>
                        <div class="mb-2">
                            <span class="text-dark fw-bold">
                                <?php echo number_format($j->price, 0, ',', '.'); ?>đ
                            </span>
                        </div>

                        <div class="btn-group mb-2">
                            <a href="/webbanhang/product/Detail/<?php echo $j->id; ?>"
                               class="btn btn-sm btn-outline-info" title="Xem chi tiết">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="/webbanhang/product/Update/<?php echo $j->id; ?>"
                               class="btn btn-sm btn-outline-warning" title="Chỉnh sửa">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="/webbanhang/product/delete/<?php echo $j->id; ?>"
                               class="btn btn-sm btn-outline-danger" title="Xóa sản phẩm"
                               onclick="XoaSanPham(<?php echo $j->id; ?>)">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </div>

                        <button class="btn btn-sm btn-primary w-100 btn-add-to-cart" data-id="<?php echo $j->id; ?>">
    <i class="fas fa-cart-plus me-1"></i> Thêm vào giỏ hàng
</button>

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
        if (confirm("Bạn có muốn xóa sản phẩm với ID " + id + "?")) {
            window.location.href = "/webbanhang/Product/Delete/" + id;
        }
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.btn-add-to-cart').forEach(btn => {
            btn.addEventListener('click', function () {
                const productId = this.getAttribute('data-id');

                fetch(`/webbanhang/product/addToCartAjax/${productId}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: '✅ Thêm thành công!',
                                text: data.message,
                                timer: 1200,
                                showConfirmButton: false
                            }).then(() => {
                                // ✅ Sau alert, load lại trang
                                location.reload();
                            });
                        } else {
                            Swal.fire('Lỗi', data.message, 'error');
                        }
                    })
                    .catch(err => {
                        Swal.fire('Lỗi hệ thống', err.toString(), 'error');
                    });
            });
        });
    });
</script>


<?php include 'app/views/shares/footer.php'; ?>
