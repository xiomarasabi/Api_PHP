<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthController {
    private $db;
    private $usuario;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->usuario = new Usuario($this->db);
    }

    public function login() {
        $data = json_decode(file_get_contents("php://input"), true);

        if (isset($data['email']) && isset($data['contrasena']) && !empty($data['email']) && !empty($data['contrasena'])) {
            $email = $data['email'];
            $contrasena = $data['contrasena'];

            if ($this->usuario->login($email, $contrasena)) {
                $secret_key = "xiomara123456789101112131415161718192021";
                $issuer = "localhost";
                $issued_at = time();
                $expiration_time = $issued_at + (60 * 60);

                $payload = [
                    'iat' => $issued_at,
                    'iss' => $issuer,
                    'exp' => $expiration_time,
                    'sub' => $this->usuario->identificacion,
                    'email' => $this->usuario->email,
                    'rol' => $this->usuario->fk_id_rol
                ];

                $jwt = JWT::encode($payload, $secret_key, 'HS256');

                http_response_code(200);
                echo json_encode([
                    'status' => 'Success',
                    'message' => 'Login exitoso',
                    'token' => $jwt,
                    'expires' => $expiration_time
                ]);
            } else {
                http_response_code(401);
                echo json_encode(['status' => 'Error', 'message' => 'Credenciales inválidas']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['status' => 'Error', 'message' => 'Email y contraseña son requeridos']);
        }
    }
}
?>