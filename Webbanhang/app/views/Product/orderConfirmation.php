<?php include 'app/views/shares/header.php'; ?>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Hiển thị popup cảm ơn khi vào trang
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
            title: '🎉 Đặt hàng thành công!',
            text: 'Cảm ơn bạn đã mua hàng. Đơn hàng của bạn đang được xử lý.',
            icon: 'success',
            confirmButtonText: 'Tiếp tục mua sắm',
            confirmButtonColor: '#3085d6'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "/webbanhang/Product/Index";
            }
        });
    });
</script>

<!-- Nếu user không nhấn nút trong alert, vẫn có fallback -->
<div class="container text-center mt-5">
    <h1 class="text-success">✅ Đơn hàng đã được xác nhận!</h1>
    <p class="lead">Chúng tôi sẽ xử lý và giao hàng trong thời gian sớm nhất.</p>
    <a href="/webbanhang/Product/Index" class="btn btn-primary mt-3">Tiếp tục mua sắm</a>
</div>

<?php include 'app/views/shares/footer.php'; ?>
