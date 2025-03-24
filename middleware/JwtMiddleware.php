<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtMiddleware {
    public static function validate() {
        $headers = apache_request_headers();
        $secret_key = "xiomara123456789101112131415161718192021"; // La misma clave secreta usada al generar el token

        // Verificar si el encabezado Authorization existe
        if (!isset($headers['Authorization'])) {
            self::errorResponse("Token requerido");
        }

        $auth_header = trim($headers['Authorization']);
        $token = str_replace('Bearer ', '', $auth_header);

        try {
            // Intentar decodificar el token
            $decoded = JWT::decode($token, new Key($secret_key, 'HS256'));
            return $decoded; // Retorna los datos del token
        } catch (Exception $e) {
            self::errorResponse("Token inválido o expirado", $e->getMessage());
        }
    }

    // Método auxiliar para manejar respuestas de error
    private static function errorResponse($message, $error = null) {
        http_response_code(401);
        echo json_encode([
            'status' => 'Error',
            'message' => $message,
            'error' => $error ?? null
        ]);
        exit();
    }
}
?>
