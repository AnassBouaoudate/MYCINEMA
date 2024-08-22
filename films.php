<!DOCTYPE html>
<html lang="en">

<head>
    <title>Cinéma</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./cinema.css">
    <script src="./cinema.js"></script>
</head>

<body>
    <header class="header" id="header">
        <div class="logo">
            <h6>CINEMA</h6>
        </div>

        <div class="search">
            <form method="post" action="">
                <label for="nomFilm">Nom du film :</label>
                <input type="text" name="nomFilm" id="nomFilm" required>
                <button type="submit"><i class="fas fa-search"></i></button>
            </form>
        </div>

        <div class="btns">
            <div class="filmss">
                <a href="cinema.php">Home</a>
            </div>

            <div class="membre">
                <a href="membre.php">Membre</a>
            </div>

            <div class="abonnement">
                <a href="abonnement.php">Abonnement</a>
            </div>

            <div class="historique">
                <a href="historique.php">Historique</a>
            </div>

            <ul class="icons">
                <li class="facebook"><i class="fab fa-facebook-f"></i></li>
                <li class="email"><i class="far fa-envelope"></i></li>
                <li class="insta"><i class="fab fa-instagram"></i></li>
                <li class="tweet"><i class="fab fa-twitter"></i></li>
            </ul>
        </div>
    </header>

    <div class="filtre">
        <form method="post" action="">
            <label for="films">Genre:</label>
            <select name="genre" id="films">
                <option class="option" value="choisir une option">--choose an option--</option>
                <option class="option" value="action">Action</option>
                <option class="option" value="adventure">Adventure</option>
                <option class="option" value="animation">Animation</option>
                <option class="option" value="biography">Biography</option>
                <option class="option" value="comedy">Comedy</option>
                <option class="option" value="crime">Crime</option>
                <option class="option" value="drama">Drama</option>
                <option class="option" value="family">Family</option>
                <option class="option" value="fantasy">Fantasy</option>
                <option class="option" value="horror">Horror</option>
                <option class="option" value="mystery">Mystery</option>
                <option class="option" value="romance">Romance</option>
                <option class="option" value="sci-fi">Sci-Fi</option>
                <option class="option" value="thriller">Thriller</option>
            </select>

            <label for="distributeur">Distributeur :</label>
            <input type="text" name="distributeur" id="distributeur">

            <label for="datePicker">Choisissez une date :</label>
            <input type="text" id="datePicker" name="selectedDate" placeholder="YYYY-MM-DD">
            <button id="button" type="submit" name="button">Rechercher</button>
        </form>
    </div><br><br><br>

    <div class="result">
        <?php
        $host = 'localhost';
        $dbname = 'cinema';
        $username = 'Anass';
        $password = 'Anass111';

        try {
            $db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            //nom film
            if (isset($_POST['nomFilm'])) {
                $nomFilm = $_POST['nomFilm'];
                $requete = "SELECT * FROM movie WHERE title LIKE '%$nomFilm%'";
                $result = $db->query($requete);

                if ($result->rowCount() > 0) {
                    echo "<h2>Résultats de la recherche :</h2>";
                    echo "<ul>";
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                        echo "<li>" . $row['title'] . "</li>";
                    }
                    echo "</ul>";
                } else {
                    echo "<p>Aucun résultat trouvé pour le film '$nomFilm'.</p>";
                }
            }

            //genre
            if (isset($_POST['button'])) {
                $selectedGenre = $_POST['genre'];

                $requete = "SELECT movie.title, genre.name 
                            FROM movie 
                            JOIN genre ON movie.id_distributor=genre.id 
                            WHERE genre.name = '$selectedGenre'";
                $resultat = $db->query($requete);

                echo "<h2>Résultats pour le genre '$selectedGenre' :</h2>";

                if ($resultat->rowCount() > 0) {
                    echo "<ul>";
                    while ($row = $resultat->fetch(PDO::FETCH_ASSOC)) {
                        echo "<li>" . $row['title'] . " - Genre: " . $row['name'] . "</li>";
                    }
                    echo "</ul>";
                } else {
                    echo "<p>Aucun résultat trouvé pour le genre '$selectedGenre'.</p>";
                }
            }

            //distributeur
            if (isset($_POST['button'])) {
                $selectedDistributor = $_POST['distributeur'];

                $requete = "SELECT movie.title, distributor.name as 'distributor', movie.release_date, genre.name as 'genre'
                            FROM movie 
                            JOIN distributor ON movie.id_distributor = distributor.id 
                            JOIN movie_genre ON movie.id = movie_genre.id_movie 
                            JOIN genre ON movie_genre.id_genre = genre.id 
                            WHERE distributor.name='$selectedDistributor'";
                
                $resultat = $db->query($requete);

                echo "<h2>Résultats pour le distributeur '$selectedDistributor' :</h2>";

                if ($resultat->rowCount() > 0) {
                    echo "<ul>";
                    while ($row = $resultat->fetch(PDO::FETCH_ASSOC)) {
                        echo "<li>" . $row['title'] . " - Distributeur: " . $row['distributor'] . "</li>";
                    }
                    echo "</ul>";
                } else {
                    echo "<p>Aucun résultat trouvé pour le distributeur '$selectedDistributor'.</p>";
                }
            }

            // genre & distributeur
            if (isset($_POST['button'])) {
                $selectedGenre = $_POST['genre'];
                $selectedDistributor = $_POST['distributeur'];

                $requete = "SELECT movie.title, distributor.name as 'distributor', movie.release_date, genre.name as 'genre' FROM movie JOIN distributor ON movie.id_distributor = distributor.id JOIN movie_genre ON movie.id = movie_genre.id_movie JOIN genre ON movie_genre.id_genre = genre.id WHERE genre.name = '$selectedGenre' AND distributor.name = '$selectedDistributor'";

                $resultat = $db->query($requete);

                echo "<h2>Résultats de votre recherche '$selectedGenre' et '$selectedDistributor':</h2>";

                if ($resultat->rowCount() > 0) {
                    echo "<ul>";
                    while ($row = $resultat->fetch(PDO::FETCH_ASSOC)) {
                        echo "<li>" . $row['title'] . " - Distributeur: " . $row['distributor'] . " - Genre: " . $row['genre'] . "</li>";
                    }
                    echo "</ul>";
                } else {
                    echo "<p>Aucun résultat trouvé pour le genre '$selectedGenre' et le distributeur '$selectedDistributor'.</p>";
                }
            }

             //date
            if (isset($_POST['button'])) {
                $selectedDate = $_POST['selectedDate'];

                $requete = "SELECT movie_schedule.date_begin, movie.title FROM movie_schedule JOIN movie ON movie_schedule.id = movie.id WHERE movie_schedule.date_begin like '$selectedDate%'";
                $resultat = $db->query($requete);

                echo "<h2>Résultats pour la date '$selectedDate' :</h2>";

                if ($resultat->rowCount() > 0) {
                    echo "<ul>";
                    while ($row = $resultat->fetch(PDO::FETCH_ASSOC)) {
                        echo "<li>" . $row['title'] . " - Date de début: " . $row['date_begin'] . "</li>";
                    }
                    echo "</ul>";
                } else {
                    echo "<p>Aucun résultat trouvé pour la date '$selectedDate'.</p>";
                }
            }

        } catch (PDOException $e) {
            print "Erreur :" . $e->getMessage() . "<br/>";
        }
        ?>
    </div>
    <div class="pagination">
    <a href="#" class="active">1</a>
    <a href="#">2</a>
    <a href="#">3</a>
    <a href="#">4</a>
    <a href="#">5</a>
</div>


    <main class="main_body">
        <aside class="side_bar">
        </aside>
    </main>
</body>

</html>
