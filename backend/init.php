<?php

define('ROOT', __DIR__ . '/..');
define('TEMPLATES', ROOT . '/templates');
define('PAGES', ROOT . '/pages');
define('BACKEND', __DIR__);

// Incluir todos os arquivos da pasta 'configs' e 'functions'
foreach (['configs', 'functions'] as $path) {
    foreach (glob(__DIR__ . "/$path/*.php") as $filename) {
        require_once $filename;
    }
}

// Configurar o autoloader para a pasta 'classes'
spl_autoload_register(function ($class) {
    // Substituir barras invertidas de namespace por barras de diretório
    $classPath = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    $filePath = __DIR__ . '/classes/' . $classPath . '.php';
    // Se o arquivo da classe existir, incluí-lo
    if (file_exists($filePath)) {
        require_once $filePath;
    }
});

/**
 * Roteia a REQUEST_URI para arquivos dentro da pasta 'pages/'.
 *
 * @param string $site A subpasta dentro do htdocs ou www do seu xamp/wamp (se tiver).
 */
function routeToPage($site = '')
{
    // 1. Pegar e limpar a URI
    $uri = $_SERVER['REQUEST_URI'];
    $path = strtok($uri, '?');
    $path = trim($path, '/');


    // Se a URI for vazia (raiz), busca por 'index'
    if (empty($path)) {
        $path = 'index';
    }

    // Remove o prefixo
    if (str_starts_with($path, $site)) {
        $path = substr($path, strlen($site));
    }

    // Remove o sufixo
    if (str_ends_with($path, '.php')) {
        $path = substr($path, 0, -4); // -4 para remover '.php'
    }

    // 2. Construir e verificar os caminhos possíveis
    $filePath = '';

    // Opção 1: Arquivo diretamente (ex: pages/sobre.php)
    $fileCandidate = PAGES . $path . '.php';
    if (file_exists($fileCandidate)) {
        $filePath = $fileCandidate;
    }
    // Opção 2: Subdiretório com index.php (ex: pages/contato/index.php)
    else {
        $fileCandidate = PAGES . $path . '/index.php';
        if (file_exists($fileCandidate)) {
            $filePath = $fileCandidate;
        }
    }

    // 3. Incluir o arquivo ou mostrar 404
    if (!empty($filePath)) {
        @chdir(dirname($filePath));
        require_once($filePath);
    } else {
        // Exibe uma página de erro 404
        header("HTTP/1.0 404 Not Found");
        // Tenta incluir um arquivo de erro 404 se existir
        $errorPage = PAGES . '404.php';
        if (file_exists($errorPage)) {
            require_once($errorPage);
        } else {
            echo "<h1>Erro 404 - Página não encontrada</h1>";
        }
    }
}
