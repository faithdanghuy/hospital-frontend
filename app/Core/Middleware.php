<?php
namespace App\Core;

class Middleware {
    public static function auth(): callable {
        return function () {
            if (!Auth::check()) {
                header('Location: /auth/login');
                return false;
            }
            return true;
        };
    }

    public static function roles(array $roles): callable {
        return function () use ($roles) {
            if (!Auth::check() || !in_array(Auth::role(), $roles)) {
                http_response_code(403);
                echo 'Forbidden';
                return false;
            }
            return true;
        };
    }
}
