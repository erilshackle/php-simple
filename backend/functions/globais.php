<?php


function debug($var)
{
    echo "<pre>" . print_r($var, true) . "</pre>";
    exit;
}

function template(string $filename, $data = [])
{
    $path = TEMPLATES . "/$filename" . '.php';
    if (file_exists($path)) {
        extract($data);
        return $path;
    }
}

function asset($file){
    global $baseUrl;
    return ltrim(($baseUrl ?? '') . "/assets/$file", '/');
}