<?php
require_once('app/config/database.php');
require_once('app/models/CategoryModel.php');
require_once('app/models/ProductModel.php');


class ProductController
{

    private $db;
    private  $ProductModel;
    private $CategoryModel;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->ProductModel = new ProductModel($this->db);
        $this->CategoryModel = new CategoryModel($this->db);
        session_start();
    }


    public function Index()
    {

        $SuccessMessage = isset($_SESSION["SuccessMessage"]) ? $_SESSION["SuccessMessage"] : null;
        unset($_SESSION["SuccessMessage"]);


        $ErrorMessage = isset($_SESSION["ErrorMessage"]) ? $_SESSION["ErrorMessage"] : null;
        unset($_SESSION["ErrorMessage"]);


        $WarningMessage = isset($_SESSION["WarningMessage"]) ? $_SESSION["WarningMessage"] : null;
        unset($_SESSION["WarningMessage"]);


        $InfoMessage = isset($_SESSION["InfoMessage"]) ? $_SESSION["InfoMessage"] : null;
        unset($_SESSION["InfoMessage"]);

        $ds = $this->ProductModel->DanhSachSanPham();
        $theloai = $this->CategoryModel->DanhSachTheLoai();

        include 'app/views/Product/Index.php';
    }
        public function show($id) 
    { 
        $product = $this->ProductModel->LaySanPhamTheoID($id); 
 
        if ($product) { 
            include 'app/views/product/show.php'; 
        } else { 
            echo "Không thấy sản phẩm."; 
        } 
    } 

    public function Detail($id)
    {
        $sp = $this->ProductModel->LaySanPhamTheoID($id);

        if ($sp) {
            include 'app/views/Product/Detail.php';
        }

        echo "Khong tìm thấy sản phẩm";
    }


    public function Add()
    {
        $theloai = $this->CategoryModel->DanhSachTheLoai();

        include 'app/views/Product/Add.php';
    }


    function SaveImage($imageFile, $subFolder)
    {
        // Kiểm tra file hợp lệ
        if (!isset($imageFile) || $imageFile['error'] !== UPLOAD_ERR_OK || $imageFile['size'] == 0) {
            throw new Exception("File không hợp lệ!");
        }

        // Đường dẫn thư mục lưu ảnh trong public/uploads/
        // $uploadsFolder = __DIR__ . '/../public/uploads/' . $subFolder;
        $uploadsFolder = __DIR__ . '/../../public/uploads/' . $subFolder;

        // Tạo thư mục nếu chưa tồn tại
        if (!file_exists($uploadsFolder)) {
            mkdir($uploadsFolder, 0777, true);
        }

        // Tạo tên file duy nhất
        $fileExtension = pathinfo($imageFile['name'], PATHINFO_EXTENSION);
        $fileName = pathinfo($imageFile['name'], PATHINFO_FILENAME);
        $uniqueFileName = $fileName . '_' . uniqid() . '.' . $fileExtension;
        $filePath = $uploadsFolder . '/' . $uniqueFileName;

        // Lưu file vào thư mục
        if (!move_uploaded_file($imageFile['tmp_name'], $filePath)) {
            throw new Exception("Không thể lưu file!");
        }

        // Trả về đường dẫn tương đối
        return '/webbanhang/public/uploads/' . $subFolder . '/' . $uniqueFileName;
    }


    function DeleteImage($imageURL, $subFolder)
    {
        if (empty($imageURL)) {
            return false;
        }

        // Lấy đường dẫn tuyệt đối
        $fileName = basename($imageURL);
        $filePath = __DIR__ . '/../../public/uploads/' . $subFolder . '/' . $fileName;


        // Kiểm tra và xóa file
        if (file_exists($filePath)) {
            if (!unlink($filePath)) {
                return false;
            } else {
                return true;
            }
        }
    }


    public function SaveAdd()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            $price = $_POST['price'];
            $des = $_POST['des'];
            $categoryid = $_POST['categoryid'];

            $hinhanh = null;

            // Xử lý upload ảnh nếu có
            if (isset($_FILES['hinhanh']) && $_FILES['hinhanh']['error'] === UPLOAD_ERR_OK) {
                $hinhanh = $this->SaveImage($_FILES['hinhanh'], 'san-pham');
            }


            $edit = $this->ProductModel->ThemSanPham($name, $price, $des, $categoryid, $hinhanh);


            if ($edit == true) {
                $_SESSION["SuccessMessage"] = "Thêm Thành Công";
                header('Location: /webbanhang/Product');
                exit();
            } else {

                // Nếu có ảnh đã upload nhưng thêm CSDL thất bại, xóa ảnh đi
                if (isset($_FILES['hinhanh']) && $_FILES['hinhanh']['error'] === UPLOAD_ERR_OK) {
                    $hinhanh = $this->DeleteImage($_FILES['hinhanh'], 'san-pham');
                }
                include 'app/views/Product/Add.php';
            }
        }
    }

    public function Update($id)
    {
        $sp = $this->ProductModel->LaySanPhamTheoID($id);
        $theloai = $this->CategoryModel->DanhSachTheLoai();

        include 'app/views/Product/Update.php';
    }

    public function SaveUpdate()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $price = $_POST['price'];
            $des = $_POST['des'];
            $categoryid = $_POST['categoryid'];
            $hinhanh = null;
            if (isset($_FILES['hinhanh']) && $_FILES['hinhanh']['error'] === UPLOAD_ERR_OK) {
                $sp = $this->ProductModel->LaySanPhamTheoID($id);
                $this->DeleteImage($sp->image, "san-pham");

                $hinhanh = $this->SaveImage($_FILES['hinhanh'], 'san-pham');
            }



            $edit = $this->ProductModel->ChinhSuaSanPham($id, $name, $price, $des, $categoryid, $hinhanh);


            if ($edit == true) {
                header('Location: /webbanhang/Product');
                exit();
            } else {
                include 'app/views/Product/Update.php';
            }
        }
    }

    public function Delete($id)
    {
        if ($this->ProductModel->XoaSanPham($id)) {

            $_SESSION["SuccessMessage"] = "Xóa Thành Công";
            header('Location: /webbanhang/Product');
            exit();
        } else {
            $_SESSION["ErrorMessage"] = "Xóa Thất Bại";
            header('Location: /webbanhang/Product');
            exit();
        }
    }
     private function uploadImage($file) 
    { 
        $target_dir = "uploads/"; 
         
        // Kiểm tra và tạo thư mục nếu chưa tồn tại 
        if (!is_dir($target_dir)) { 
            mkdir($target_dir, 0777, true); 
        } 
     
        $target_file = $target_dir . basename($file["name"]); 
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION)); 
     
        // Kiểm tra xem file có phải là hình ảnh không 
        $check = getimagesize($file["tmp_name"]); 
        if ($check === false) { 
            throw new Exception("File không phải là hình ảnh."); 
        } 
     
         // Kiểm tra kích thước file (10 MB = 10 * 1024 * 1024 bytes) 
        if ($file["size"] > 10 * 1024 * 1024) { 
        throw new Exception("Hình ảnh có kích thước quá lớn."); 
        } 
     
        // Chỉ cho phép một số định dạng hình ảnh nhất định 
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != 
"jpeg" && $imageFileType != "gif") { 
            throw new Exception("Chỉ cho phép các định dạng JPG, JPEG, PNG và GIF."); 
        } 
     
        // Lưu file 
        if (!move_uploaded_file($file["tmp_name"], $target_file)) { 
            throw new Exception("Có lỗi xảy ra khi tải lên hình ảnh."); 
        } 
     
        return $target_file; 
    } 
     
public function addToCartAjax($id)
{
    $product = $this->ProductModel->LaySanPhamTheoID($id);

    if (!$product) {
        echo json_encode([
            'success' => false,
            'message' => 'Không tìm thấy sản phẩm.'
        ]);
        exit;
    }

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]['quantity']++;
    } else {
        $_SESSION['cart'][$id] = [
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => 1,
            'image' => $product->image
        ];
    }

    echo json_encode([
        'success' => true,
        'message' => 'Đã thêm sản phẩm vào giỏ hàng.'
    ]);
    
    exit;

}

 
    public function cart() 
    { 
        $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : []; 
        include 'app/views/product/cart.php'; 
    } 
 
    public function checkout() 
    { 
        include 'app/views/product/checkout.php'; 
    } 
 public function processCheckout() 
{ 
    if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
        $name = $_POST['name']; 
        $phone = $_POST['phone']; 
        $address = $_POST['address']; 

        // Kiểm tra giỏ hàng
        if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) { 
            echo "Giỏ hàng đang trống."; 
            return; 
        } 

        // Bắt đầu giao dịch
        $this->db->beginTransaction(); 

        try { 
            // Lưu thông tin đơn hàng vào bảng orders
            $query = "INSERT INTO orders (name, phone, address) VALUES (:name, :phone, :address)"; 
            $stmt = $this->db->prepare($query); 
            $stmt->bindParam(':name', $name); 
            $stmt->bindParam(':phone', $phone); 
            $stmt->bindParam(':address', $address); 
            $stmt->execute(); 
            $order_id = $this->db->lastInsertId(); 

            // Lưu chi tiết đơn hàng vào bảng order_details
            $cart = $_SESSION['cart']; 
            foreach ($cart as $product_id => $item) { 
                    $total_price = $item['price'] * $item['quantity']; // ✅ Tính tổng tiền

                $query = "INSERT INTO order_details (order_id, product_id, quantity, price) VALUES (:order_id, :product_id, :quantity, :price)"; 
                $stmt = $this->db->prepare($query); 
                $stmt->bindParam(':order_id', $order_id); 
                $stmt->bindParam(':product_id', $product_id); 
                $stmt->bindParam(':quantity', $item['quantity']); 
                $stmt->bindParam(':price', $total_price); 
                $stmt->execute(); 
            } 

            // Xóa giỏ hàng sau khi đặt hàng thành công
            unset($_SESSION['cart']); 

            // Commit giao dịch
            $this->db->commit(); 

            $_SESSION["SuccessMessage"] = "Đặt hàng thành công! Cảm ơn bạn đã mua hàng."; 
            header('Location: /webbanhang/Product/orderConfirmation'); 
            exit(); 

        } catch (Exception $e) { 
            // Rollback giao dịch nếu có lỗi
            $this->db->rollBack(); 
            $_SESSION["ErrorMessage"] = "Đã xảy ra lỗi khi xử lý đơn hàng: " . $e->getMessage(); 
            header('Location: /webbanhang/Product/checkout'); 
            exit(); 
        } 
    } 
}

    public function orderConfirmation() 
    { 
        include 'app/views/product/orderConfirmation.php'; 
    }
}

?> 
