    <!DOCTYPE html>
    <html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historique</title>
    <link rel="stylesheet" type="text/css" href="./historique.css">
    </head>
    <body>
    <h1>Recherche de l'historique des films d'un abonné</h1>
    <form action="historique.php" method="get">
    <label for="searchInput">Nom ou prénom de l'utilisateur :</label>
    <input type="text" id="searchInput" name="searchInput">
    <button type="submit">Rechercher</button>
    </form>

    <div class="result">
    <?php
    if (isset($_GET['searchInput'])) {
    $searchInput = $_GET['searchInput'];

    $host = 'localhost';
    $dbname = 'cinema';
    $username = 'Anass';
    $password = 'Anass111';

    try {
    $db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $requete = "SELECT title, user.lastname,user.firstname FROM movie_schedule
                INNER JOIN movie ON movie_schedule.id_movie = movie.id
                INNER JOIN membership_log ON movie_schedule.id = membership_log.id_session
                INNER JOIN membership ON membership_log.id_membership = membership.id
                INNER JOIN user ON user.id = membership.id_user
                WHERE user.firstname LIKE :searchInput OR user.lastname LIKE :searchInput";

    $statement = $db->prepare($requete);
    $statement->bindValue(':searchInput', '%' . $searchInput . '%', PDO::PARAM_STR);
    $statement->execute();

    echo "<h2>Résultats de recherche :</h2>";
    if ($statement->rowCount() > 0) {
        echo "<ul>";
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            echo "<li>" . $row['title'] . " - Nom: " . $row['lastname'] . " - Prénom: " . $row['firstname'] ."</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>Aucun résultat trouvé pour la recherche : '$searchInput'.</p>";
    }
    } catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
    }
    }
    ?>
    </div>
    </body>
    </html>
