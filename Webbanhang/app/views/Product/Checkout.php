<?php include 'app/views/shares/header.php'; ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="text-center mb-4">
                <h1 class="text-primary">🧾 Thanh toán</h1>
                <p class="lead text-muted">Vui lòng điền thông tin nhận hàng để hoàn tất đơn</p>
            </div>

            <form method="POST" action="/webbanhang/Product/processCheckout">
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
                    <button type="submit" class="btn btn-success btn-block">
                        <i class="fas fa-credit-card me-2"></i> Xác nhận thanh toán
                    </button>
                </div>
            </form>

            <div class="text-center mt-3">
                <a href="/webbanhang/Product/cart" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Quay lại giỏ hàng
                </a>
            </div>

        </div>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>
