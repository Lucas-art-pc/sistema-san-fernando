<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/db-connection.php'; // função conectarBanco()

use App\Core\Container;
use App\Middleware\AuthMiddleware;

// --- Monta o container e registra o que ele não sabe construir sozinho ---
$container = new Container();
$container->set(PDO::class, conectarBanco());

$routes = require __DIR__ . '/../config/Rotas.php';

// --- Captura método e URI da requisição ---
$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = '/' . trim($uri, '/');

// --- Tenta casar a URI com alguma rota ---
$found = false;

foreach ($routes as $key => $action) {
    [$routeMethod, $routePath] = explode('|', $key, 2);

    if ($routeMethod !== $method) {
        continue;
    }

    $pattern = preg_replace('#\{([a-zA-Z_][a-zA-Z0-9_]*)\}#', '(?P<$1>[^/]+)', $routePath);
    $pattern = '#^' . rtrim($pattern, '/') . '$#';
    $pattern = str_replace('^$', '^/$', $pattern);

    if (preg_match($pattern, $uri, $matches)) {
        $found = true;

        $params = array_filter(
            $matches,
            fn($k) => is_string($k),
            ARRAY_FILTER_USE_KEY
        );

        $requiresAuth = is_array($action) && ($action['auth'] ?? false);
        $routeAction = is_array($action) && isset($action[0]) ? $action[0] : $action;

        if ($requiresAuth) {
            $authMiddleware = new AuthMiddleware();

            if (!$authMiddleware->handle()) {
                header('Location: /');
                exit();
            }
        }

        dispatch($routeAction, $params, $container);
        break;
    }
}

if (!$found) {
    http_response_code(404);
    echo '404 - Página não encontrada';
}

function dispatch(string|array $action, array $params, Container $container): void
{
    if (is_array($action)) {
        [$class, $methodName] = $action;
    } else {
        $class = $action;
        $methodName = 'requestProcess';
    }

    if (!class_exists($class)) {
        http_response_code(500);
        echo "Controller {$class} não encontrado.";
        return;
    }

    try {
        $controller = $container->make($class);
    } catch (\Exception $e) {
        http_response_code(500);
        echo "Erro ao instanciar {$class}: " . $e->getMessage();
        return;
    }

    if (!method_exists($controller, $methodName)) {
        http_response_code(500);
        echo "Método {$methodName} não encontrado em {$class}.";
        return;
    }

    call_user_func_array([$controller, $methodName], $params);
}