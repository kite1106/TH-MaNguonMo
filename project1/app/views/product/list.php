<!DOCTYPE html>
<html lang="vi">
<head
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Danh sách sản phẩm</title>
    <!-- Import Bootstrap & DataTables -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h2 class="mb-0">Danh sách sản phẩm</h2>
            </div>
            <div class="card-body">
                <a href="/project1/Product/add" class="btn btn-success mb-3">Thêm sản phẩm mới</a>
                <?php if (!empty($products)) : ?>
                    <div class="table-responsive">
                        <table id="productTable" class="table table-bordered table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>Tên sản phẩm</th>
                                    <th>Mô tả</th>
                                    <th>Giá</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($products as $product) : ?>
                                    <tr>
                                        <td><?= htmlspecialchars($product->getName(), ENT_QUOTES, 'UTF-8') ?></td>
                                        <td><?= htmlspecialchars($product->getDescription(), ENT_QUOTES, 'UTF-8') ?></td>
                                        <td><?= htmlspecialchars($product->getPrice(), ENT_QUOTES, 'UTF-8') ?> VNĐ</td>
                                        <td>
                                            <a href="/project1/Product/edit/<?= $product->getID() ?>" class="btn btn-warning btn-sm">Sửa</a>
                                            <button onclick="confirmDelete('<?= $product->getID() ?>')" class="btn btn-danger btn-sm">Xóa</button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else : ?>
                    <p class="text-muted">Hiện chưa có sản phẩm nào.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        // Kích hoạt DataTables
        document.addEventListener("DOMContentLoaded", function() {
            $('#productTable').DataTable({
                paging: true,
                searching: true,
                ordering: true,
                info: true,
                lengthMenu: [5, 10, 25, 50], // Giới hạn số sản phẩm trên mỗi trang
                language: {
                    search: "Tìm kiếm:",
                    lengthMenu: "Hiển thị _MENU_ sản phẩm",
                    info: "Hiển thị _START_ đến _END_ của _TOTAL_ sản phẩm",
                    paginate: {
                        next: "Trang tiếp",
                        previous: "Trang trước"
                    }
                }
            });
        });

        // Xác nhận xóa sản phẩm bằng SweetAlert
        function confirmDelete(productID) {
            Swal.fire({
                title: "Bạn có chắc chắn muốn xóa?",
                text: "Sản phẩm sẽ bị xóa vĩnh viễn!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Xóa",
                cancelButtonText: "Hủy"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "/project1/Product/delete/" + productID;
                }
            });
        }
    </script>

    <!-- Import Bootstrap, jQuery & DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
</body>
</html>
