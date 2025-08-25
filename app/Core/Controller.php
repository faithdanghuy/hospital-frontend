<?php
namespace App\Core;

class Controller {
    protected array $config;
    public function __construct() {
        $this->config = require __DIR__ . '/../../config/config.php';
        if (session_status() === PHP_SESSION_NONE) session_start();
        // Basic CSRF init
        if (empty($_SESSION['csrf_token'])) $_SESSION['csrf_token'] = bin2hex(random_bytes(16));
    }
    
    protected function view(string $template, array $data = []) {
        echo View::render($template, $data);
    }

    protected function redirect(string $path) {
        header('Location: ' . $path); exit;
    }

    protected function isPost(): bool { 
        return $_SERVER['REQUEST_METHOD'] === 'POST'; 
    }

    protected function requireCsrf() {
        if ($this->isPost()) {
            $token = $_POST['_csrf'] ?? '';
            if (!$token || !hash_equals($_SESSION['csrf_token'], $token)) {
                http_response_code(419); exit('CSRF token mismatch');
            }
        }
    }
}
