<?php include 'app/views/shares/header.php'; ?>

<!-- Danh sách Sản phẩm -->
<section class="container mb-5">
    <div class="row g-4">
        <?php if (!empty($ds)): ?>
            <?php foreach ($ds as $j): ?>
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="product-card p-3 bg-white shadow-sm rounded-3 h-100 d-flex flex-column align-items-center">
                        <!-- Hình ảnh sản phẩm với hiệu ứng hover -->
                        <div class="position-relative mb-3 overflow-hidden">
                            <img src="<?= !empty($j->image) ? htmlspecialchars($j->image, ENT_QUOTES, 'UTF-8') : "https://picsum.photos/id/" . ($j->id + 109) . "/600/400"; ?>"
                                 class="img-fluid product-img rounded w-100 transition-transform"
                                 alt="<?= htmlspecialchars($j->name, ENT_QUOTES, 'UTF-8'); ?>"
                                 style="height: 200px; object-fit: cover;">
                        </div>

                        <!-- Tên sản phẩm -->
                        <h5 class="text-center fw-bold mb-1"><?= htmlspecialchars($j->name, ENT_QUOTES, 'UTF-8'); ?></h5>
                        <div class="mb-2 text-center">
                            <span class="text-primary fw-bold fs-5">
                                <?= number_format($j->price, 0, ',', '.'); ?>đ
                            </span>
                        </div>

                        <!-- Các nút thao tác -->
                        <div class="btn-group mb-3">
                            <a href="/webbanhang/product/Detail/<?= $j->id; ?>"
                               class="btn btn-sm btn-outline-info btn-lg" title="Xem chi tiết">
                                <i class="fas fa-eye">Xem chi tiết</i>
                            </a>
                          
                            <button class="btn btn-sm btn-outline-danger btn-lg" title="Xóa sản phẩm"
                                    onclick="XoaSanPham(<?= $j->id; ?>)">
                                <i class="fas fa-trash-alt">Xóa sản phẩm</i>
                            </button>
                        </div>

                        <!-- Nút thêm vào giỏ hàng -->
                        <button class="btn btn-primary w-100 btn-lg btn-add-to-cart"
                                data-id="<?= $j->id; ?>">
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
                <a href="/webbanhang/product/add" class="btn btn-primary btn-lg">
                    <i class="fas fa-plus me-2"></i> Thêm sản phẩm mới
                </a>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- JavaScript -->
<script>
    // Xóa sản phẩm với xác nhận
    function XoaSanPham(id) {
        Swal.fire({
            title: "Bạn có chắc muốn xóa sản phẩm?",
            text: "Thao tác này không thể hoàn tác!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Xóa ngay!"
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/webbanhang/product/delete/${id}`, { method: "DELETE" })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire("Đã xóa!", data.message, "success").then(() => location.reload());
                        } else {
                            Swal.fire("Lỗi!", data.message, "error");
                        }
                    })
                    .catch(err => Swal.fire("Lỗi hệ thống!", err.toString(), "error"));
            }
        });
    }

    // Thêm vào giỏ hàng với kiểm tra lỗi
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.btn-add-to-cart').forEach(btn => {
            btn.addEventListener('click', function () {
                const productId = this.getAttribute('data-id');

                fetch(`/webbanhang/product/addToCartAjax/${productId}`)
                    .then(res => {
                        if (!res.ok) throw new Error("Server không phản hồi!");
                        return res.json();
                    })
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                toast: true,
                                position: "top-end",
                                icon: 'success',
                                title: '✅ Đã thêm vào giỏ hàng!',
                                text: data.message,
                                timer: 1200,
                                showConfirmButton: false
                            });
                        } else {
                            Swal.fire("Lỗi", data.message, "error");
                        }
                    })
                    .catch(err => Swal.fire("Lỗi kết nối!", err.toString(), "error"));
            });
        });
    });
</script>

<?php include 'app/views/shares/footer.php'; ?>
<style>
/* ✅ Giá sản phẩm - làm nổi bật */
.price-tag {
    font-size: 22px;
    font-weight: bold;
    color: #ff6600; /* Màu cam nổi bật */
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
}

/* ✅ Thanh tiến trình - hiệu ứng gradient */
.progress-bar {
    height: 12px;
    border-radius: 8px;
    background: linear-gradient(to right, #66ccff, #ffffff, #ff0000);
    box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.2);
}

/* ✅ Nút "Thêm vào giỏ hàng" - hiệu ứng hover */
.btn-add-to-cart {
    background: #007bff; /* Màu xanh đẹp */
    color: #fff;
    font-size: 18px;
    font-weight: bold;
    padding: 10px 15px;
    border-radius: 10px;
    transition: all 0.3s ease-in-out;
}

.btn-add-to-cart:hover {
    background: #0056b3; /* Màu xanh đậm hơn khi hover */
    transform: scale(1.05);
}

/* ✅ Căn chỉnh toast alert */
.swal2-popup {
    font-size: 16px;
    border-radius: 10px;
    padding: 15px;
}

</style>