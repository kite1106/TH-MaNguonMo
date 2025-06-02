<!DOCTYPE html>
<html lang="vi">
<head>
    <?php
    include_once 'app/helpers/SessionHelper.php';
    SessionHelper::start();
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý sản phẩm</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/webbanhang/assets/style.css">
</head>

<body>
    <!-- ✅ Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">Quản lý sản phẩm</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="/webbanhang/Product/">📦 Sản phẩm</a></li>

                    <!-- Ẩn nút "Thêm sản phẩm" nếu không phải Admin -->
                    <?php if (SessionHelper::isAdmin()): ?>
                        <li class="nav-item"><a class="nav-link" href="/webbanhang/Product/add">➕ Thêm sản phẩm</a></li>
                    <?php endif; ?>
<?php if (SessionHelper::isAdmin()): ?>
                    <li class="nav-item"><a class="nav-link" href="/webbanhang/Category/Add">📂 Danh mục</a></li>
                    <?php endif; ?>

                </ul>

                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/webbanhang/product/cart">
                            <i class="fas fa-shopping-cart"></i> Giỏ hàng 
                            <span class="badge badge-light cart-count"><?= count($_SESSION['cart'] ?? []); ?></span>
                        </a>
                    </li>
                    <?php if (SessionHelper::isLoggedIn()): ?>
                        <li class="nav-item"><span class="nav-link text-white fw-bold">👤 <?= $_SESSION['username']; ?></span></li>
                        <li class="nav-item"><a class="nav-link" href="/webbanhang/account/logout">🚪 Đăng xuất</a></li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link" href="/webbanhang/account/login">🔑 Đăng nhập</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
</body>
</html>

<style>
/* ✅ Làm cho chữ trong navbar rõ nét hơn */
.navbar-nav .nav-link {
    font-size: 18px;
    font-weight: bold;
    color: #ffffff !important;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
    padding: 12px;
    transition: all 0.3s ease-in-out;
}

/* ✅ Hiệu ứng hover */
.navbar-nav .nav-link:hover {
    background-color: rgba(255, 255, 255, 0.2);
    border-radius: 8px;
    transform: scale(1.05);
}

/* ✅ Tăng độ tương phản của icon */
.navbar-nav .nav-link i {
    font-size: 20px;
    margin-right: 6px;
    color: #ffcc00;
}

.navbar {
    padding: 15px;
    box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
}

.navbar-nav .nav-link {
    font-size: 18px;
    transition: all 0.3s ease-in-out;
}

.navbar-nav .nav-link:hover {
    background-color: rgba(255, 255, 255, 0.2);
    border-radius: 8px;
}

.product-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    padding: 15px;
    border-radius: 12px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
}

.product-card:hover {
    transform: scale(1.05);
}

.price-tag {
    font-size: 22px;
    font-weight: bold;
    color: #ff6600;
}
</style>
