<?php
require_once 'app/model/ProductModel.php';

$url  = $_GET['url'] ?? '';
$url = rtrim($url, '/');
$url = filter_var($url, FILTER_SANITIZE_URL);
$url =explode('/',$url);

  $controllerName = isset($url[0]) && $url[0] != '' ? ucfirst($url[0]). 'Controller' : 'DefaultController';

  $action = isset($url[1]) && $url[1] != '' ? $url[1] : 'index';

  if (!file_exists('app/controllers/' . $controllerName . '.php')) {
   die('Controller not found');
  }

  require_once 'app/controllers/' . $controllerName . '.php';


  $controller = new $controllerName();

  if (!method_exists($controller, $action)) {
   die('Action not found');
  }

  $params = array_slice($url, 2);  // Lấy các phần tử URL sau controller và action làm tham số
  call_user_func_array([$controller, $action], $params);

?>