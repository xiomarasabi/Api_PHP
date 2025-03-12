<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Content-Type: application/json; charset=UTF-8");

require_once 'config/autoload.php';

$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$request = explode('/', trim($requestUri, '/'));

$resource = isset($request[1]) ? ucfirst(strtolower($request[1])) . 'Controller' : null;
$id = isset($request[2]) ? $request[2] : null;
$method = $_SERVER['REQUEST_METHOD'];

if (!$resource || !class_exists($resource)) {
    echo json_encode(["status" => "Error", "message" => "Recurso no encontrado"]);
    http_response_code(404);
    exit;
}

$controller = new $resource();

switch ($method) {
    case "GET":
        $controller->getAll();
        break;
    case "POST":
        $controller->create();
        break;
    case "PUT":
        $id ? $controller->update($id) : errorResponse("ID requerido para actualizar");
        break;
    case "DELETE":
        $id ? $controller->delete($id) : errorResponse("ID requerido para eliminar");
        break;
    default:
        errorResponse("Método no permitido", 405);
}

function errorResponse($message, $status = 400) {
    echo json_encode(["status" => "Error", "message" => $message]);
    http_response_code($status);
    exit;
}
?>
