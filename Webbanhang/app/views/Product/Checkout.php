<?php include 'app/views/shares/header.php'; ?>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="text-center mb-4">
                <h1 class="text-primary">🧾 Thanh toán</h1>
                <p class="lead text-muted">Vui lòng điền thông tin nhận hàng để hoàn tất đơn</p>
            </div>

            <form id="checkoutForm" method="POST" action="/webbanhang/Product/processCheckout">
                <div class="form-group mb-3">
                    <label for="name">Họ tên:</label>
                    <input type="text" id="name" name="name" class="form-control" required>
                </div>

                <div class="form-group mb-3">
                    <label for="phone">Số điện thoại:</label>
                    <input type="text" id="phone" name="phone" class="form-control" required>
                </div>

                <div class="form-group mb-4">
                    <label for="address">Địa chỉ:</label>
                    <textarea id="address" name="address" rows="3" class="form-control" required></textarea>
                </div>

                <div class="d-grid">
                    <button id="btnSubmitCheckout" type="button" class="btn btn-success btn-block">
                        <i class="fas fa-credit-card me-2"></i> Xác nhận thanh toán
                    </button>
                </div>
            </form>

            <div class="text-center mt-3">
                <a href="/webbanhang/Product/Cart" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Quay lại giỏ hàng
                </a>
            </div>

        </div>
    </div>
</div>

<script>
    document.querySelector('#btnSubmitCheckout').addEventListener('click', function() {
        // Hiển thị SweetAlert xác nhận trước khi gửi form
        Swal.fire({
            title: 'Xác nhận đặt hàng?',
            text: 'Bạn có chắc muốn thanh toán ngay bây giờ?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Có, thanh toán!',
            cancelButtonText: 'Hủy',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33'
        }).then((result) => {
            if (result.isConfirmed) {
                // Sau khi người dùng xác nhận, hiển thị SweetAlert thành công
                Swal.fire({
                    title: '🎉 Đặt hàng thành công!',
                    text: 'Cảm ơn bạn đã mua hàng.',
                    icon: 'success',
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    // Khi alert đóng, submit form thật
                    document.querySelector('#checkoutForm').submit();
                });
            }
        });
    });
</script>

<?php include 'app/views/shares/footer.php'; ?>
