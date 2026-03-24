<?php
require_once __DIR__ . '/../services/JWTService.php';

class AuthMiddleware {

    public static function check() {

        // 1. جلب كل headers
        $headers = getallheaders();

        // 2. تحقق من وجود Authorization header
        if (!isset($headers['Authorization'])) {
            echo json_encode(["status" => false, "message" => "No token provided"]);
            exit;
        }

        // 3. استخراج التوكن
        $token = str_replace("Bearer ", "", $headers['Authorization']);

        // 4. تحقق من التوكن
        $jwtService = new JWTService();
        $decoded = $jwtService->validateToken($token);

        if (!$decoded) {
            echo json_encode(["status" => false, "message" => "Invalid or expired token"]);
            exit;
        }

        // 5. إرجاع بيانات المستخدم
        return $decoded;
    }
}