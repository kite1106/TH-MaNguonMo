<?php include 'app/views/shares/header.php' ?>

<!-- 1. Include SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php if ($sp != null): ?>
    <div class="container my-5">
        <div class="row g-4 align-items-center">
            <!-- Hình ảnh -->
            <?php if ($sp->image != null): ?>
                <div class="col-md-6">
                    <img src="<?php echo $sp->image; ?>" class="img-fluid rounded shadow" alt="Ảnh sản phẩm">
                </div>
            <?php else: ?>
                <div class="col-md-6">
                    <img src="https://picsum.photos/id/<?php echo ($sp->id + 109); ?>/600/400" class="img-fluid rounded shadow" alt="Ảnh sản phẩm">
                </div>
            <?php endif ?>

            <div class="col-md-6">
                <!-- Thông tin chi tiết và form Update -->
                <form id="formUpdateProduct" action="/webbanhang/Product/SaveUpdate" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($sp->id) ?>" />
                    
                    <div class="mb-3">
                        <label class="form-label">Tên Sản Phẩm</label>
                        <input name="name" class="form-control fw-bold" value="<?php echo htmlspecialchars($sp->name, ENT_QUOTES, 'UTF-8') ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Giá Sản Phẩm</label>
                        <input type="number" name="price" class="form-control fw-bold" value="<?php echo htmlspecialchars($sp->price, ENT_QUOTES, 'UTF-8') ?>">
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label class="form-label">Hình Ảnh Hiện Tại</label>
                                <input readonly value="<?php echo htmlspecialchars($sp->image) ?>" class="form-control">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3 position-relative">
                                <label class="form-label">Chọn Ảnh Mới</label>
                                <input id="AnhVuaTai" type="file" name="hinhanh" class="form-control">
                                <div class="ChuaAnh"></div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mô Tả</label>
                        <textarea name="des" class="form-control"><?php echo htmlspecialchars($sp->description, ENT_QUOTES, 'UTF-8') ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Thể Loại</label>
                        <select name="categoryid" class="form-control">
                            <?php if ($theloai != null): ?>
                                <?php foreach ($theloai as $i): ?>
                                    <option 
                                        value="<?php echo htmlspecialchars($i->id) ?>" 
                                        <?php if ($i->id == $sp->CATEGORYID) echo 'selected'; ?>
                                    >
                                        <?php echo htmlspecialchars($i->name, ENT_QUOTES, 'UTF-8') ?>
                                    </option>
                                <?php endforeach ?>
                            <?php endif ?>
                        </select>
                    </div>

                    <!-- Nút hành động -->
                    <div class="mt-4">
                        <button id="btnSubmitUpdate" type="button" class="btn btn-warning me-2">
                            <i class="fas fa-edit"></i> Sửa
                        </button>
                        <a href="/webbanhang" class="btn btn-secondary ms-2">
                            <i class="fas fa-arrow-left"></i> Quay lại
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php endif ?>

<script>
    // 2. Hiển thị preview ảnh vừa chọn
    document.querySelector("#AnhVuaTai").addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            document.querySelector(".ChuaAnh").innerHTML = "";
            const objectUrl = URL.createObjectURL(file);
            const img = document.createElement('img');
            img.src = objectUrl;
            img.style.width = "100px";
            img.style.height = "100px";
            img.classList.add('my-2', 'rounded', 'shadow-sm');
            document.querySelector(".ChuaAnh").appendChild(img);
        }
    });

    // 3. Bắt sự kiện click vào nút "Sửa", hiển thị SweetAlert2
    document.querySelector("#btnSubmitUpdate").addEventListener('click', function() {
        Swal.fire({
            title: 'Bạn có chắc muốn sửa sản phẩm này?',
            text: "Thao tác không thể hoàn tác!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Vâng, tôi muốn sửa!',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
                // Nếu người dùng đồng ý, submit form
                document.querySelector("#formUpdateProduct").submit();
            }
        });
    });
</script>

<?php include 'app/views/shares/footer.php' ?>
