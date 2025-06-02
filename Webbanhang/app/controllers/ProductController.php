<?php


require_once 'app/config/database.php';
require_once 'app/helpers/SessionHelper.php';
require_once 'app/models/CategoryModel.php';
require_once 'app/models/ProductModel.php';

class ProductController
{
    private $db;
    private $ProductModel;
    private $CategoryModel;

    public function __construct()
    {
        // Kết nối đến database
        $this->db = (new Database())->getConnection();
        // Khởi tạo model
        $this->ProductModel  = new ProductModel($this->db);
        $this->CategoryModel = new CategoryModel($this->db);
    }

    // Kiểm tra xem người dùng có phải Admin không
    private function isAdmin()
    {
        return SessionHelper::isAdmin();
    }

    // Trang danh sách sản phẩm
    public function Index()
    {
        // Lấy các flash message
        $SuccessMessage = isset($_SESSION["SuccessMessage"]) ? $_SESSION["SuccessMessage"] : null;
        unset($_SESSION["SuccessMessage"]);

        $ErrorMessage = isset($_SESSION["ErrorMessage"]) ? $_SESSION["ErrorMessage"] : null;
        unset($_SESSION["ErrorMessage"]);

        $WarningMessage = isset($_SESSION["WarningMessage"]) ? $_SESSION["WarningMessage"] : null;
        unset($_SESSION["WarningMessage"]);

        $InfoMessage = isset($_SESSION["InfoMessage"]) ? $_SESSION["InfoMessage"] : null;
        unset($_SESSION["InfoMessage"]);

        // Lấy danh sách sản phẩm và thể loại
        $ds = $this->ProductModel->DanhSachSanPham();
        $theloai = $this->CategoryModel->DanhSachTheLoai();

        include 'app/views/Product/Index.php';
    }

    // Hiển thị trang show (nếu có nút “chi tiết” riêng)
    public function show($id)
    {
        $product = $this->ProductModel->LaySanPhamTheoID($id);
        if ($product) {
            include 'app/views/Product/show.php';
        } else {
            echo "Không thấy sản phẩm.";
        }
    }

    // Hiển thị trang Detail (chi tiết)
    public function Detail($id)
    {
        $sp = $this->ProductModel->LaySanPhamTheoID($id);
        if ($sp) {
            include 'app/views/Product/Detail.php';
        } else {
            echo "Không tìm thấy sản phẩm";
        }
    }

    // Hiển thị form Add (chỉ Admin)
    public function Add()
    {
        if (!$this->isAdmin()) {
            $_SESSION["ErrorMessage"] = "Bạn không có quyền truy cập chức năng này!";
            header('Location: /webbanhang/Product');
            exit();
        }

        $theloai = $this->CategoryModel->DanhSachTheLoai();
        include 'app/views/Product/Add.php';
    }

    // Xử lý lưu sản phẩm mới (chỉ Admin)
    public function SaveAdd()
    {
        if (!$this->isAdmin()) {
            $_SESSION["ErrorMessage"] = "Bạn không có quyền truy cập chức năng này!";
            header('Location: /webbanhang/Product');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name       = $_POST['name'] ?? '';
            $price      = $_POST['price'] ?? 0;
            $des        = $_POST['des'] ?? '';
            $categoryid = $_POST['categoryid'] ?? '';

            $hinhanh = null;
            if (isset($_FILES['hinhanh']) && $_FILES['hinhanh']['error'] === UPLOAD_ERR_OK) {
                $hinhanh = $this->SaveImage($_FILES['hinhanh'], 'san-pham');
            }

            $result = $this->ProductModel->ThemSanPham($name, $price, $des, $categoryid, $hinhanh);
            if ($result === true) {
                $_SESSION["SuccessMessage"] = "Thêm thành công";
                header('Location: /webbanhang/Product');
                exit();
            } else {
                // Nếu đã upload ảnh nhưng thêm vào DB thất bại thì xóa file
                if (!empty($hinhanh)) {
                    $this->DeleteImage($hinhanh, 'san-pham');
                }
                $theloai = $this->CategoryModel->DanhSachTheLoai();
                include 'app/views/Product/Add.php';
            }
        }
    }

    // Hiển thị form Update (chỉ Admin)
    public function Update($id)
    {
        if (!$this->isAdmin()) {
            $_SESSION["ErrorMessage"] = "Bạn không có quyền truy cập chức năng này!";
            header('Location: /webbanhang/Product');
            exit();
        }

        $sp = $this->ProductModel->LaySanPhamTheoID($id);
        if (!$sp) {
            $_SESSION["ErrorMessage"] = "Không tìm thấy sản phẩm để sửa";
            header('Location: /webbanhang/Product');
            exit();
        }

        $theloai = $this->CategoryModel->DanhSachTheLoai();
        include 'app/views/Product/Update.php';
    }

    // Xử lý lưu chỉnh sửa (chỉ Admin)
    public function SaveUpdate()
    {
        if (!$this->isAdmin()) {
            $_SESSION["ErrorMessage"] = "Bạn không có quyền truy cập chức năng này!";
            header('Location: /webbanhang/Product');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id         = $_POST['id'] ?? '';
            $name       = $_POST['name'] ?? '';
            $price      = $_POST['price'] ?? 0;
            $des        = $_POST['des'] ?? '';
            $categoryid = $_POST['categoryid'] ?? '';
            $hinhanh    = null;

            // Nếu có upload ảnh mới, xóa ảnh cũ và lưu ảnh mới
            if (isset($_FILES['hinhanh']) && $_FILES['hinhanh']['error'] === UPLOAD_ERR_OK) {
                $sp = $this->ProductModel->LaySanPhamTheoID($id);
                if ($sp && !empty($sp->image)) {
                    $this->DeleteImage($sp->image, 'san-pham');
                }
                $hinhanh = $this->SaveImage($_FILES['hinhanh'], 'san-pham');
            }

            $result = $this->ProductModel->ChinhSuaSanPham($id, $name, $price, $des, $categoryid, $hinhanh);
            if ($result === true) {
                $_SESSION["SuccessMessage"] = "Cập nhật thành công";
                header('Location: /webbanhang/Product');
                exit();
            } else {
                $theloai = $this->CategoryModel->DanhSachTheLoai();
                include 'app/views/Product/Update.php';
            }
        }
    }

    // Xóa sản phẩm (chỉ Admin)
    public function Delete($id)
    {
        if (!$this->isAdmin()) {
            $_SESSION["ErrorMessage"] = "Bạn không có quyền thực hiện hành động này!";
            header('Location: /webbanhang/Product');
            exit();
        }

        // Xóa file ảnh cũ nếu có
        $sp = $this->ProductModel->LaySanPhamTheoID($id);
        if ($sp && !empty($sp->image)) {
            $this->DeleteImage($sp->image, 'san-pham');
        }

        if ($this->ProductModel->XoaSanPham($id)) {
            $_SESSION["SuccessMessage"] = "Xóa thành công";
            header('Location: /webbanhang/Product');
            exit();
        } else {
            $_SESSION["ErrorMessage"] = "Xóa thất bại";
            header('Location: /webbanhang/Product');
            exit();
        }
    }

    // Hàm lưu file ảnh vào thư mục public/uploads/<subFolder>
    private function SaveImage($imageFile, $subFolder)
    {
        if (!isset($imageFile) || $imageFile['error'] !== UPLOAD_ERR_OK || $imageFile['size'] === 0) {
            throw new Exception("File không hợp lệ!");
        }

        $uploadsFolder = __DIR__ . '/../../public/uploads/' . $subFolder;
        if (!file_exists($uploadsFolder)) {
            mkdir($uploadsFolder, 0777, true);
        }

        $fileExtension  = pathinfo($imageFile['name'], PATHINFO_EXTENSION);
        $fileName       = pathinfo($imageFile['name'], PATHINFO_FILENAME);
        $uniqueFileName = $fileName . '_' . uniqid() . '.' . $fileExtension;
        $filePath       = $uploadsFolder . '/' . $uniqueFileName;

        if (!move_uploaded_file($imageFile['tmp_name'], $filePath)) {
            throw new Exception("Không thể lưu file!");
        }

        // Trả về đường dẫn tương đối để lưu vào cơ sở dữ liệu
        return '/webbanhang/public/uploads/' . $subFolder . '/' . $uniqueFileName;
    }

    // Hàm xóa file ảnh trên server
    private function DeleteImage($imageURL, $subFolder)
    {
        if (empty($imageURL)) {
            return false;
        }
        $fileName = basename($imageURL);
        $filePath = __DIR__ . '/../../public/uploads/' . $subFolder . '/' . $fileName;

        if (file_exists($filePath)) {
            return unlink($filePath);
        }
        return false;
    }

    // Thêm sản phẩm vào giỏ hàng qua AJAX
    public function addToCartAjax($id)
    {
        $product = $this->ProductModel->LaySanPhamTheoID($id);
        if (!$product) {
            echo json_encode([
                'success' => false,
                'message' => 'Không tìm thấy sản phẩm.'
            ]);
            exit();
        }

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity']++;
        } else {
            $_SESSION['cart'][$id] = [
                'name'     => $product->name,
                'price'    => $product->price,
                'quantity' => 1,
                'image'    => $product->image
            ];
        }

        echo json_encode([
            'success' => true,
            'message' => 'Đã thêm sản phẩm vào giỏ hàng.'
        ]);
        exit();
    }

    // Hiển thị trang giỏ hàng
    public function cart()
    {
        $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
        include 'app/views/Product/cart.php';
    }

    // Hiển thị form checkout
    public function checkout()
    {
        include 'app/views/Product/checkout.php';
    }

    // Xử lý lưu đơn hàng (checkout)
    public function processCheckout()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            // Nếu không phải POST, redirect về trang checkout
            header('Location: /webbanhang/Product/checkout');
            exit();
        }

        $name    = isset($_POST['name']) ? trim($_POST['name']) : '';
        $phone   = isset($_POST['phone']) ? trim($_POST['phone']) : '';
        $address = isset($_POST['address']) ? trim($_POST['address']) : '';

        // Kiểm tra giỏ hàng
        if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
            $_SESSION["ErrorMessage"] = "Giỏ hàng đang trống.";
            header('Location: /webbanhang/Product/checkout');
            exit();
        }

        // Bắt đầu transaction
        $this->db->beginTransaction();
        try {
            // Lưu thông tin đơn hàng vào bảng orders
            $query = "INSERT INTO orders (name, phone, address) VALUES (:name, :phone, :address)";
            $stmt  = $this->db->prepare($query);
            $stmt->bindParam(':name',    $name);
            $stmt->bindParam(':phone',   $phone);
            $stmt->bindParam(':address', $address);
            $stmt->execute();

            $order_id = $this->db->lastInsertId();
            $cart     = $_SESSION['cart'];

            // Lưu chi tiết đơn hàng vào bảng order_details
            $insertDetails = "INSERT INTO order_details 
                (order_id, product_id, quantity, price) 
                VALUES (:order_id, :product_id, :quantity, :price)";
            $stmt2 = $this->db->prepare($insertDetails);

            foreach ($cart as $product_id => $item) {
                $total_price = $item['price'] * $item['quantity'];
                $stmt2->bindParam(':order_id',   $order_id);
                $stmt2->bindParam(':product_id', $product_id);
                $stmt2->bindParam(':quantity',   $item['quantity']);
                $stmt2->bindParam(':price',      $total_price);
                $stmt2->execute();
            }

            // Xóa giỏ hàng sau khi đặt thành công
            unset($_SESSION['cart']);

            // Commit transaction
            $this->db->commit();

            $_SESSION["SuccessMessage"] = "Đặt hàng thành công! Cảm ơn bạn đã mua hàng.";
            header('Location: /webbanhang/Product/orderConfirmation');
            exit();
        } catch (Exception $e) {
            // Rollback nếu có lỗi
            $this->db->rollBack();
            $_SESSION["ErrorMessage"] = "Đã xảy ra lỗi khi xử lý đơn hàng: " . $e->getMessage();
            header('Location: /webbanhang/Product/checkout');
            exit();
        }
    }

    // Hiển thị trang xác nhận đơn hàng
    public function orderConfirmation()
    {
        include 'app/views/Product/orderConfirmation.php';
    }
}
?>
