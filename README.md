# showplace-api

Дамп базы данных прилагается.

Описание методов API.
Сущности:
showplace, city, traveler, score
Запросы:
GET localhost/showplace – получение списка всех элементов этой сущности
GET localhost/showplace/1 – получение элемента этой сущности с id = 1
POST localhost/showplace – создание сущности с очередным порядковым id (передача данных в теле запроса)
PATCH localhost/showplace/1 – изменение некоторых полей элемента этой сущности с id = 1
DELETE localhost/showplace/1 – удаление элемента этой сущности с id = 1

Фильтрация и сортировка.

Достопримечательности в городе:
GET localhost/showplace?id_city=6

Города, которые посетил путешественник:
GET localhost/traveler?id_traveler=2

Путешественники, побывавшие в городе:
GET localhost/city?id_city=2

Сортировка, по средней оценке, достопримечательности
Сначала высокая оценка
GET localhost/showplace?sortByScore=DESC
Сначала низкая оценка
GET localhost/showplace?sortByScore=ASC

Примеры тел запросов для создания сущностей:
{
    "showplace": {
        "id_city": 9,
        "title": "Independence Hall",
        "distance": 2.3
    },
    "city": {
        "title": "Tokio"
    },
    "traveler": {
        "name": "Rich"
    },
    "score": {
        "id_showplace": 3,
        "id_traveler": 2,
        "score": 3
    }
}
