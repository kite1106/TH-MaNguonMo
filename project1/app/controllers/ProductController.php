<?php
require_once 'app/model/ProductModel.php';

class ProductController {
    private $products = [];

    public function __construct() {
        session_start();

        if (isset($_SESSION['products'])) {
            $this->products = $_SESSION['products'];
        }
    }

    public function index() {
        $this->list();
    }

    public function list() {
        $products = $this->products;
        include 'app/views/product/list.php';
    }

    public function add() {
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];

            if (empty($name)) {
                $errors[] = 'Tên sản phẩm là bắt buộc.';
            } elseif (strlen($name) < 10 || strlen($name) > 100) {
                $errors[] = 'Tên sản phẩm phải có từ 10 đến 100 ký tự.';
            }

            if (!is_numeric($price) || $price <= 0) {
                $errors[] = 'Giá phải là một số dương lớn hơn 0.';
            }

            if (empty($errors)) {
                $id = count($this->products) + 1;

                $product = new ProductModel($id, $name, $description, $price);
                $this->products[] = $product;

                $_SESSION['products'] = $this->products;
                header('Location: /project1/Product/list');
                exit();
            }
        }

        include 'app/views/product/add.php';
    }

    public function edit($id) {
        $errors = [];
        $productToEdit = null;

        // Tìm sản phẩm theo ID
        foreach ($this->products as $product) {
            if ($product->getId() == $id) {
                $productToEdit = $product;
                break;
            }
        }

        if (!$productToEdit) {
            // Nếu không tìm thấy sản phẩm, chuyển hướng về danh sách
            exit();
        }

        // Nếu có dữ liệu POST thì xử lý việc sửa sản phẩm
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];

            if (empty($name)) {
                $errors[] = 'Tên sản phẩm là bắt buộc.';
            } elseif (strlen($name) < 10 || strlen($name) > 100) {
                $errors[] = 'Tên sản phẩm phải có từ 10 đến 100 ký tự.';
            }

            if (!is_numeric($price) || $price <= 0) {
                $errors[] = 'Giá phải là một số dương lớn hơn 0.';
            }

            if (empty($errors)) {
                // Cập nhật sản phẩm
                $productToEdit->setName($name);
                $productToEdit->setDescription($description);
                $productToEdit->setPrice($price);

                $_SESSION['products'] = $this->products;
                header('Location: /project1/Product/list');
                exit();
            }
        }

        include 'app/views/product/edit.php';
    }

    public function delete($id) {
        // Tìm và xóa sản phẩm theo ID
        foreach ($this->products as $index => $product) {
            if ($product->getId() == $id) {
                unset($this->products[$index]);
                $_SESSION['products'] = $this->products;
                break;
            }
        }
        header('Location: /project1/Product/list');
        // Sau khi xóa xong, chuyển hướng về danh sách sản phẩm
        exit();
    }
}
?>