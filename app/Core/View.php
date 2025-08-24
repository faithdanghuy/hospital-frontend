<?php
namespace App\Core;

class View {
    public static function render(string $template, array $data = []): string {
        extract($data);
        ob_start();
        include __DIR__ . '/../Views/' . $template . '.php';
        return ob_get_clean();
    }
}
