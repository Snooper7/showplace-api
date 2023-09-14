<?php

spl_autoload_register(function ($class) {
    require __DIR__ . "/src/$class.php";
});

// Задаем собствеенный обработчик исключений и ошибок
set_error_handler("ErrorHandler::handleError");
set_exception_handler("ErrorHandler::handleException");

// Прописываем принудительно тип контента
header("Content-type: application/json; charset=UTF-8");

// Разбиваем запрос на части
$parts = explode('/', $_SERVER['REQUEST_URI']);

// Простейшая проверка на соответствие сущестувующим в API сущностям
if ($parts[1] != 'showplace') {
    http_response_code(404);
    exit;
}

// Заполняем $id нулем даже если его небыло в запросе
$id = $parts[2] ?? null;

// Задаем подключение. Данные для подключения можно потом перенести в config файл
$database = new Database("localhost", "showplace", "root", "");

// Подключаемся к базе через Gateway
$gateway = new ShowplaceGateway($database);


$controller = new ShowplaceController($gateway);

$controller->processRequest($_SERVER['REQUEST_METHOD'], $id);