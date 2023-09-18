<?php

// Устанавливаем автозагрузчике классов
spl_autoload_register(function ($class) {
    require __DIR__ . "/src/$class.php";
});

// Задаем собствеенный обработчик исключений и ошибок
set_error_handler("ErrorHandler::handleError");
set_exception_handler("ErrorHandler::handleException");

// Прописываем принудительно тип контента
header("Content-type: application/json; charset=UTF-8");

// Проверяем наличие GET параметров и записываем их в переменную
$get = [];

if ($_GET) {
    $get = $_GET;
}

// Отсекаем GET параметры
$path_w_get = explode('?', $_SERVER['REQUEST_URI']);
$path_wo_get = $path_w_get[0];

// Разбиваем запрос на части
$path = explode('/', $path_wo_get);

$substance = $path[1];
$substances = ['showplace', 'city', 'traveler', 'score'];

// Простейшая проверка на соответствие сущестувующим в API сущностям
if (!in_array($substance, $substances)) {
    http_response_code(404);
    exit;
}

// Заполняем $id значением или нулем если его небыло в запросе
$id = $path[2] ?? null;

// Задаем подключение. Данные для подключения можно потом перенести в config файл
$database = new Database("localhost", "showplace", "root", "");

// Подключаемся к базе через Gateway
$gateway = new Gateway($database);

// Запускаем контроллер
$controller = new Controller($gateway);

$controller->processRequest($_SERVER['REQUEST_METHOD'], $substance, $id, $get);