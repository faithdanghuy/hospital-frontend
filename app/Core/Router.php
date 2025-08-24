<?php
namespace App\Core;

class Router {
    private array $routes = [];

    public function add(string $method, string $path, callable $handler, array $middleware = []): void {
        $this->routes[] = compact('method','path','handler','middleware');
    }

    public function dispatch(): void {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        foreach ($this->routes as $route) {
            if ($method === $route['method'] && $this->match($route['path'], $uri, $params)) {
                // Middleware chain
                foreach ($route['middleware'] as $mw) {
                    $res = $mw();
                    if ($res === false) {
                        return;
                    }
                }
                call_user_func_array($route['handler'], $params);
                return;
            }
        }

        // Not found
        http_response_code(404);
        echo \App\Core\View::render('partials/layout', [
            'content' => '<div class="p-4"><h2>404 Not Found</h2><p>No route for ' 
                         . htmlspecialchars($method.' '.$uri) . '</p></div>'
        ]);
    }

    private function match(string $pattern, string $uri, &$params): bool {
        $params = [];
        $pattern = preg_replace('#\{([a-zA-Z_][a-zA-Z0-9_]*)\}#', '(?P<$1>[^/]+)', $pattern);
        $pattern = '#^' . $pattern . '$#';
        if (preg_match($pattern, $uri, $matches)) {
            foreach ($matches as $k => $v) {
                if (!is_int($k)) $params[$k] = $v;
            }
            return true;
        }
        return false;
    }
}
