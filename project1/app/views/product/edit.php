<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sửa sản phẩm</title>
    <!-- Import Bootstrap & SweetAlert -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmEdit(event) {
            event.preventDefault(); // Ngăn form gửi đi ngay lập tức
            Swal.fire({
                icon: 'success',
                title: 'Lưu thay đổi thành công!',
                showConfirmButton: false,
                timer: 1500
            }).then(() => {
                document.getElementById('editForm').submit(); // Gửi form sau khi hiển thị thông báo
            });
        }
    </script>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-warning text-dark">
                <h2 class="mb-0">Sửa sản phẩm</h2>
            </div>
            <div class="card-body">
                <form id="editForm" method="POST" action="/project1/product/edit/<?= htmlspecialchars($product->getID(), ENT_QUOTES, 'UTF-8') ?>" onsubmit="confirmEdit(event);">
                    <div class="mb-3">
                        <label for="name" class="form-label">Tên sản phẩm:</label>
                        <input type="text" id="name" name="name" class="form-control" value="<?= htmlspecialchars($product->getName(), ENT_QUOTES, 'UTF-8') ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Mô tả:</label>
                        <textarea id="description" name="description" class="form-control" required><?= htmlspecialchars($product->getDescription(), ENT_QUOTES, 'UTF-8') ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label">Giá:</label>
                        <input type="number" id="price" name="price" class="form-control" value="<?= htmlspecialchars($product->getPrice(), ENT_QUOTES, 'UTF-8') ?>" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                    <a href="/project1/product/list" class="btn btn-secondary">Quay lại danh sách sản phẩm</a>
                </form>
            </div>
        </div>
    </div>

    <!-- Import Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
