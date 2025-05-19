<!-- Banner Section -->
<section class="container mb-5">
    <div class="row">
        <div class="col-md-6">
            <div class="bg-light p-4 rounded shadow-sm text-center">
                <h3 class="text-primary fw-bold">🚚 Miễn phí vận chuyển</h3>
                <p class="text-muted">Cho đơn hàng từ 500.000đ trở lên</p>
                <button class="btn btn-primary" onclick="showInfo('Chương trình miễn phí vận chuyển đang được áp dụng!')">
                    Tìm hiểu thêm
                </button>
            </div>
        </div>
        <div class="col-md-6">
            <div class="bg-light p-4 rounded shadow-sm text-center">
                <h3 class="text-success fw-bold">🎉 Ưu đãi thành viên</h3>
                <p class="text-muted">Giảm thêm 5% cho khách hàng thân thiết</p>
                <button class="btn btn-success" onclick="showInfo('Hãy đăng ký thành viên ngay để nhận ưu đãi!')">
                    Đăng ký ngay
                </button>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="footer py-5 bg-dark text-white">
    <div class="container">
        <div class="row">
            <div class="col-md-3 mb-4">
                <h5 class="fw-bold"><i class="fas fa-shopping-bag me-2"></i>SHOPPY</h5>
                <p class="text-muted">Nền tảng mua sắm trực tuyến hàng đầu Việt Nam</p>
                <div class="d-flex">
                    <a href="#" class="text-white me-3"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-white me-3"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-white me-3"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-white"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
            <div class="col-md-3">
                <h5 class="fw-bold">Về chúng tôi</h5>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-muted">Giới thiệu</a></li>
                    <li><a href="#" class="text-muted">Tuyển dụng</a></li>
                    <li><a href="#" class="text-muted">Hệ thống cửa hàng</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <h5 class="fw-bold">Hỗ trợ khách hàng</h5>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-muted">Trung tâm trợ giúp</a></li>
                    <li><a href="#" class="text-muted">Hướng dẫn mua hàng</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <h5 class="fw-bold">Đăng ký nhận tin</h5>
                <p class="text-muted">Nhận thông báo về sản phẩm mới và ưu đãi đặc biệt</p>
                <div class="input-group">
                    <input type="email" class="form-control" placeholder="Email của bạn">
                    <button class="btn btn-primary">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            </div>
        </div>
        <hr class="my-4 bg-secondary">
        <div class="text-center">
            <p class="text-muted mb-0">© 2025 Shoppy. All rights reserved.</p>
        </div>
    </div>
</footer>

<!-- Bootstrap & SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function showInfo(message) {
    Swal.fire({
        icon: 'info',
        title: 'Thông báo',
        text: message,
        confirmButtonColor: '#007bff'
    });
}
</script>
