<?php

class Gateway
{
    private PDO $conn;
    public function __construct(Database $database)
    {
        $this->conn = $database->getConnection();
    }

    public function getAll(): array
    {
        $sql = "SELECT
                    s.id AS id,
                    c.title AS city,
                    s.title AS title,
                    s.distance AS 'distance from center',
                    s.avg_score AS 'average score'
                FROM
                    showplace AS s
                LEFT JOIN
                    city AS c
                ON
                    s.id_city = c.id";

        $stmt = $this->conn->query($sql);

        $data = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }

        return $data;
    }

    public function create(array $data): string
    {
        $sql = "INSERT INTO showplace (id_city, title, distance)
                VALUES (:id_city, :title, :distance)";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":id_city", $data["id_city"], PDO::PARAM_INT);
        $stmt->bindValue(":title", $data["title"], PDO::PARAM_STR);
        $stmt->bindValue(":distance", $data["distance"]);

        $stmt->execute();

        return $this->conn->lastInsertId();
    }

    public function get(string $id): array | false
    {
        $sql = "SELECT *
                FROM showplace 
                WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":id", $id, PDO::PARAM_INT);

        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $data;
    }

    public function update(array $current, array $new): int
    {
        $sql = "UPDATE showplace
                SET id_city = :id_city, title = :title, distance = :distance, avg_score = :avg_score
                WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":id_city", $new["id_city"] ?? $current["id_city"], PDO::PARAM_INT);
        $stmt->bindValue(":title", $new["title"] ?? $current["title"], PDO::PARAM_STR);
        $stmt->bindValue(":distance", $new["distance"] ?? $current["distance"]);
        $stmt->bindValue(":avg_score", $new["avg_score"] ?? $current["avg_score"]);

        $stmt->bindValue(":id", $current["id"], PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->rowCount();
    }

    public function delete(string $id): int
    {
        $sql = "DELETE FROM showplace
                WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":id", $id, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->rowCount();
    }
}
