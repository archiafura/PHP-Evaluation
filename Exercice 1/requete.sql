"SELECT *
FROM artiles
INNER JOIN users
ON articles.id_user = users.id
WHERE articles.id=10";