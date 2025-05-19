<?php
require_once('app/config/database.php');
require_once('app/models/CategoryModel.php');
require_once('app/models/ProductModel.php');


class productController
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


    public function Detail($id)
    {
        $sp = $this->ProductModel->LaySanPhamTheoID($id);

        if ($sp) {
            include 'app/views/Product/Detail.php';
        }

        echo "Ko tìm thấy sản phẩm";
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
}
