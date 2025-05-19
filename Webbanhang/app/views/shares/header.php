<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>web ban hang re so 1 the gioi</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.css">

    <style>
        :root {
            --primary-color: #007bff;
            --secondary-color: #ff7675;
            --dark-color: #2c3e50;
            --light-color: #ecf0f1;
        }

        .navbar {
            background: var(--primary-color);
        }

        .navbar-brand {
            font-size: 1.8rem;
            font-weight: bold;
            color: white !important;
        }

        .navbar-nav .nav-link {
            font-size: 1.2rem;
            font-weight: bold;
            color: white !important;
            padding: 10px 15px;
            transition: all 0.3s ease-in-out;
        }

        .navbar-nav .nav-link:hover {
            background-color: var(--secondary-color);
            color: white !important;
            border-radius: 5px;
        }

        .btn-search {
            background-color: var(--secondary-color);
            color: white;
        }

        .btn-search:hover {
            background-color: #d63031;
        }

        .cart-badge {
            position: absolute;
            top: 0;
            right: 0;
            transform: translate(50%, -50%);
            font-size: 0.75rem;
        }
    </style>
</head>

<body>

<!-- Header -->
<nav class="navbar navbar-expand-lg shadow">
    <div class="container">
        <a class="navbar-brand" href="#">
            <i class="fas fa-shopping-bag me-2"></i>SHOPPY
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="#">Trang chủ</a></li>
                <li class="nav-item"><a class="nav-link" href="/WebBanHang/Product">Sản phẩm</a></li>
                <li class="nav-item"><a class="nav-link" href="/WebBanHang/Category">Danh mục</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Giới thiệu</a></li>
            </ul>

            <!-- Thanh tìm kiếm -->
            <div class="input-group me-3" style="width: 300px;">
                <input type="text" class="form-control" placeholder="Tìm kiếm sản phẩm..." id="searchInput">
                <button class="btn btn-search" type="button" onclick="showSearchAlert()">
                    <i class="fas fa-search"></i>
                </button>
            </div>

            <!-- Biểu tượng tài khoản & giỏ hàng -->
            <div class="d-flex align-items-center">
                <button class="btn btn-outline-light me-3">
                    <i class="fas fa-user"></i>
                </button>
                <button class="btn btn-outline-light position-relative">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="badge bg-danger rounded-pill cart-badge">3</span>
                </button>
            </div>
        </div>
    </div>
</nav>

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js"></script>
<script>
function showSearchAlert() {
    const searchValue = document.getElementById("searchInput").value.trim();
    if (searchValue === "") {
        Swal.fire({
            icon: 'warning',
            title: 'Oops...',
            text: 'Vui lòng nhập nội dung tìm kiếm!',
            confirmButtonColor: '#007bff'
        });
    } else {
        Swal.fire({
            icon: 'success',
            title: 'Tìm kiếm!',
            text: `Bạn đang tìm: "${searchValue}"`,
            confirmButtonColor: '#007bff'
        });
    }
}
</script>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
