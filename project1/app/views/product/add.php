<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Thêm sản phẩm</title>
    <!-- Import Bootstrap & SweetAlert -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function validateForm(event) {
            let name = document.getElementById('name').value;
            let price = document.getElementById('price').value;
            let errors = [];

            if (name.length < 10 || name.length > 100) {
                errors.push('Tên sản phẩm phải có từ 10 đến 100 ký tự.');
            }

            if (price <= 0 || isNaN(price)) {
                errors.push('Giá phải là một số dương lớn hơn 0.');
            }

            if (errors.length > 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi!',
                    text: errors.join('\n'),
                    confirmButtonText: 'OK'
                });
                event.preventDefault(); // Ngăn form gửi đi nếu có lỗi
                return false;
            }

            // Nếu hợp lệ, hiển thị thông báo và tự động quay về danh sách
            event.preventDefault(); // Ngăn form gửi đi ngay lập tức
            Swal.fire({
                icon: 'success',
                title: 'Thêm sản phẩm thành công!',
                showConfirmButton: false,
                timer: 1500
            }).then(() => {
                document.getElementById('productForm').submit(); // Gửi form sau khi hiển thị thông báo
            });

            return false;
        }
    </script>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h2 class="mb-0">Thêm sản phẩm mới</h2>
            </div>
            <div class="card-body">
                <form id="productForm" method="POST" action="/project1/product/add" onsubmit="return validateForm(event);">
                    <div class="mb-3">
                        <label for="name" class="form-label">Tên sản phẩm:</label>
                        <input type="text" id="name" name="name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Mô tả:</label>
                        <textarea id="description" name="description" class="form-control" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label">Giá:</label>
                        <input type="number" id="price" name="price" class="form-control" step="0.01" required>
                    </div>

                    <button type="submit" class="btn btn-success">Thêm sản phẩm</button>
                    <a href="/project1/product/list" class="btn btn-secondary">Quay lại danh sách sản phẩm</a>
                </form>
            </div>
        </div>
    </div>

    <!-- Import Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
