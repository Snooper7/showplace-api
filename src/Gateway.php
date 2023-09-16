<?php

class Gateway
{
    private PDO $conn;
    public function __construct(Database $database)
    {
        $this->conn = $database->getConnection();
    }

    public function getAll($substance): array
    {
        if ($substance == "showplace") {
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
        } elseif ($substance == "city") {
            $sql = "SELECT * FROM city";
        } elseif ($substance == "traveler") {
            $sql = "SELECT * FROM traveler";
        }

        $stmt = $this->conn->query($sql);

        $data = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }

        return $data;
    }

    public function create(array $data, string $substance): string
    {
        if ($substance == "showplace") {
            $sql = "INSERT INTO showplace (id_city, title, distance)
                VALUES (:id_city, :title, :distance)";
        } elseif ($substance == "city") {
            $sql = "INSERT INTO city (title)
                VALUES (:title)";
        } elseif ($substance == "traveler") {
            $sql = "INSERT INTO traveler (name)
                VALUES (:name)";
        } elseif ($substance == "score") {
            $sql = "INSERT INTO score (id_showplace, id_traveler, score)
                VALUES (:id_showplace, :id_traveler, :score)";
        }


        $stmt = $this->conn->prepare($sql);

        if ($substance == "showplace") {
            $stmt->bindValue(":id_city", $data["id_city"], PDO::PARAM_INT);
            $stmt->bindValue(":title", $data["title"], PDO::PARAM_STR);
            $stmt->bindValue(":distance", $data["distance"]);
        } elseif ($substance == "city") {
            $stmt->bindValue(":title", $data["title"], PDO::PARAM_STR);
        } elseif ($substance == "traveler") {
            $stmt->bindValue(":name", $data["name"], PDO::PARAM_STR);
        } elseif ($substance == "score") {
            $stmt->bindValue(":id_showplace", $data["id_showplace"], PDO::PARAM_INT);
            $stmt->bindValue(":id_traveler", $data["id_traveler"], PDO::PARAM_INT);
            $stmt->bindValue(":score", $data["score"], PDO::PARAM_INT);
        }

        $stmt->execute();

        return $this->conn->lastInsertId();
    }

    public function get(string $substance, string $id): array | false
    {
        $sql = "SELECT *
                FROM $substance 
                WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":id", $id, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update(array $current, array $new, string $substance): int
    {
        if ($substance == "showplace") {
            $sql = "UPDATE showplace
                SET id_city = :id_city, title = :title, distance = :distance, avg_score = :avg_score
                WHERE id = :id";
        } elseif ($substance == "city") {
            $sql = "UPDATE city
                SET title = :title
                WHERE id = :id";
        } elseif ($substance == "traveler") {
            $sql = "UPDATE traveler
                SET name = :name
                WHERE id = :id";
        }

        $stmt = $this->conn->prepare($sql);

        if ($substance == "showplace") {
            $stmt->bindValue(":id_city", $new["id_city"] ?? $current["id_city"]);
            $stmt->bindValue(":title", $new["title"] ?? $current["title"]);
            $stmt->bindValue(":distance", $new["distance"] ?? $current["distance"]);
            $stmt->bindValue(":avg_score", $new["avg_score"] ?? $current["avg_score"]);

            $stmt->bindValue(":id", $current["id"], PDO::PARAM_INT);
        } elseif ($substance == "city") {
            $stmt->bindValue(":title", $new["title"] ?? $current["title"]);
            $stmt->bindValue(":id", $current["id"], PDO::PARAM_INT);
        } elseif ($substance == "traveler") {
            $stmt->bindValue(":name", $new["name"] ?? $current["name"]);
            $stmt->bindValue(":id", $current["id"], PDO::PARAM_INT);
        }

        $stmt->execute();

        return $stmt->rowCount();
    }

    public function delete(string $substance, string $id): int
    {
        $sql = "DELETE FROM $substance
                WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":id", $id, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->rowCount();
    }
}
