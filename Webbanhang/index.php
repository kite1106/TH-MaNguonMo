<?php
session_start();
require_once 'app/models/ProductModel.php';
require_once 'app/models/CategoryModel.php';

$url = $_GET['url'] ?? '';
$url = rtrim($url, '/');
$url = filter_var($url, FILTER_SANITIZE_URL);
$url = explode('/', $url);

$controllerName = isset($url[0]) && $url[0] != '' ? ucfirst($url[0]) . 'Controller' : 'ProductController';
$action = isset($url[1]) && $url[1] != '' ? ucfirst($url[1])  : 'Index';

// Kiểm tra file controller tồn tại
if (!file_exists('app/controllers/' . $controllerName . '.php')) {
    die("Không tìm thấy controller: " . $controllerName);
}

require_once 'app/controllers/' . $controllerName . '.php';

// Khởi tạo controller
$controller = new $controllerName();

// Lấy các tham số còn lại (từ URL)
$params = array_slice($url, 2);
    
// Kiểm tra hàm action có tồn tại không
if (method_exists($controller, $action)) {
    call_user_func_array([$controller, $action], $params);
} else {
    echo "Không tồn tại action '$action' trong controller '$controllerName'";
}

?>