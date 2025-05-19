
<?php

require_once 'app/models/ProductModel.php';
require_once 'app/models/CategoryModel.php';

$url = $_GET['url'] ?? '';
$url = rtrim($url, '/');
$url = filter_var($url, FILTER_SANITIZE_URL);
$url = explode('/', $url);

$controllerName = isset($url[0]) && $url[0] != '' ? ucfirst($url[0]) . 'Controller' : 'ProductController';

$action = isset($url[1]) && $url[1] != '' ? ucfirst($url[1])  : 'Index';

if (!file_exists('app/controllers/' . $controllerName . '.php')) {
    die("controllrer not found ");
}

require_once 'app/controllers/' . $controllerName . ".php";
$controller = new $controllerName();

if (!method_exists($controller, $action)) {
    die("Ko có action này");
}

call_user_func_array([$controller, $action], array_slice($url, 2));


?>