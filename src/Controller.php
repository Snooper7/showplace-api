<?php

class Controller
{
    public function __construct(private Gateway $gateway)
    {
    }

    /*
     * Разделяем входящие запросы на отдельные ресурсы и на коллекции ресурсов.
     * Для обработки каждого из них создаем отдельный метод.
     */
    public function processRequest(string $method, string $substance, string | null $id): void
    {
        if ($id) {
            $this->processResourceRequest($method, $substance, $id);
        } else {
            $this->processCollectionRequest($method, $substance);
        }
    }
    // Метод для отдельных ресурсов
    private function processResourceRequest (string $method, string $substance, string $id): void
    {
        $resource = $this->gateway->get($substance, $id);

        if (!$resource) {
            http_response_code(404);
            echo json_encode(["message" => "$substance not found"]);
            return;
        }

        switch ($method) {
            case "GET":
                echo json_encode($resource);
                break;
            case "PATCH":
                $data =(array) json_decode(file_get_contents("php://input"), true);

                $errors = $this->getValidationErrors($data, false);

                if (!empty($errors)) {
                    echo json_encode($errors);
                    break;
                }

                $rows = $this->gateway->update($resource, $data);

                echo json_encode([
                    "message" => "$substance $id updated",
                    "rows" => $rows
                ]);
                break;
            case "DELETE":
                $rows = $this->gateway->delete($substance, $id);

                echo json_encode([
                    "message" => "$substance $id deleted",
                    "rows" => $rows
                ]);
                break;

            default:
                http_response_code(405);
                header("Allow: GET, PATCH, DELETE");
        }
    }
    // Метод для коллекций
    private function processCollectionRequest ($method, $substance): void
    {
        switch ($method) {
            case "GET":
                echo json_encode($this->gateway->getAll($substance));
                break;

            case "POST":
                $data =(array) json_decode(file_get_contents("php://input"), true);

//                $errors = $this->getValidationErrors($data);

                if (!empty($errors)) {
                    echo json_encode($errors);
                    break;
                }

                $id = $this->gateway->create($data, $substance);

                http_response_code(201);
                echo json_encode([
                   "message" => "$substance created",
                   "id" => $id
                ]);
                break;

            default:
                http_response_code(405);
                header("Allow: GET, POST");
        }
    }

    private function getValidationErrors(array $data, bool $is_new = true): array
    {
        $errors = [];

        if ($is_new && empty($data["title"])) {
            $errors[] = "name is required";
        }

        if (array_key_exists("city", $data)) {
            if (filter_var($data["id_city"], FILTER_VALIDATE_INT) === false)
            $errors[] = "city is must be integer";
        }

        return $errors;
    }

}