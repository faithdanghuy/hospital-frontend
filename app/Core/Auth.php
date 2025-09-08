<?php
namespace App\Core;

class Auth {
    // Lưu toàn bộ data trả về từ backend
    public static function login(array $data): void {
        $_SESSION['access_token'] = $data['access_token'] ?? null;
        $_SESSION['role']         = $data['role'] ?? 'patient';
        $_SESSION['user']         = [
            'id'        => $data['id'] ?? null,
            'full_name' => $data['full_name'] ?? null,
            'email'     => $data['email'] ?? null,
            'phone'     => $data['phone'] ?? null,
            'avatar'    => $data['avatar'] ?? null,
            'birthday'  => $data['birthday'] ?? null,
            'address'   => $data['address'] ?? null,
            'gender'    => $data['gender'] ?? null
        ];
    }

    public static function updateUser(array $data): void {
        if (!isset($_SESSION['user'])) {
            $_SESSION['user'] = [];
        }

        // Chỉ update những field có trong mảng truyền vào
        foreach ($data as $key => $value) {
            $_SESSION['user'][$key] = $value;
        }
    }
    
    public static function check(): bool {
        return !empty($_SESSION['access_token']);
    }

    public static function role(): ?string {
        return $_SESSION['role'] ?? null;
    }

    public static function user(): ?array {
        return $_SESSION['user'] ?? null;
    }

    public static function token(): ?string {
        return $_SESSION['access_token'] ?? null;
    }

    public static function logout(): void {
        $_SESSION = [];
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }
    }
}
