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
        <a href="films.php">Films</a>
    </div>
    <div class="membre">
    <a href="membre.php">Membre</a>
    </div>
    <div class="abonnement">
    <a href="abonnement.php">Abonnement</a>
    </div>

        <ul class="icons">
        <li class="facebook"><i class="fab fa-facebook-f"></i></li>
        <li class="email"><i class="far fa-envelope"></i></li>
        <li class="insta"><i class="fab fa-instagram"></i></li>
        <li class="tweet"><i class="fab fa-twitter"></i></li>
        </ul>
    </div>
    </header><br><br>
<br><br>

    <form method="post" action="">
    <label for="nom">Nom :</label>
        <input type="text" name="nom" id="nom" >
    <label for="prenom">Prénom :</label>
        <input type="text" name="prenom" id="prenom" >
    <button id= "button" type="submit" name="button">Rechercher</button>

    <!-- <button id= "button1" type="submit" name="button1">Rechercher</button> -->


    </form>
    <br><br>

      <?php
    $host = 'localhost';
    $dbname = 'cinema';
    $username = 'Anass';
    $password = 'Anass111';

    try {
    $db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


        //prénom
         if (isset($_POST['button'])) {
            $selectedFirstname = $_POST['prenom'];
            $requete = "SELECT user.email, user.firstname, user.birthdate, subscription.name AS Abonnement FROM user JOIN membership ON user.id=membership.id_user JOIN subscription ON membership.id_subscription = subscription.id WHERE firstname='$selectedFirstname';";
            $resultat = $db->query($requete);
        
            echo "<h2>Résultats pour le prénom '$selectedFirstname' :</h2>";
        
            if ($resultat->rowCount() > 0) {
                echo "<ul>";
                while ($row = $resultat->fetch(PDO::FETCH_ASSOC)) {
                    echo "<li>Email: " . $row['email'] . " - Nom: " . $row['lastname'] . " - Prénom: " . $row['firstname'] . " - Date de naissance: " . $row['birthdate'] . " - Abonnement: " . $row['Abonnement'] . "<button>Modifier</button><form action='historique.php' method='get'><input type='hidden' name='idUser' value='" . $row['id'] . "'><button type='submit' name='historique'>Historique</button></form></li>";
                }
                
                echo "</ul>";
            } else {
                echo "<p>Aucun résultat trouvé pour le prénom '$selectedFirstname'.</p>";
            }
        }    
        
        //nom
        if (isset($_POST['button'])) {
        $selectedLastname = $_POST['nom'];
        $requete = "SELECT user.email, user.lastname, user.birthdate, subscription.name AS Abonnement FROM user JOIN membership ON user.id=membership.id_user JOIN subscription ON membership.id_subscription = subscription.id WHERE lastname='$selectedLastname'";
        $resultat = $db->query($requete);

        echo "<h2>Résultats pour le nom '$selectedLastname' :</h2>";

        if ($resultat->rowCount() > 0) {
            echo "<ul>";
            while ($row = $resultat->fetch(PDO::FETCH_ASSOC)) {
                echo "<li>Email: " . $row['email'] . " - Nom: " . $row['lastname'] . " - Prénom: " . $row['firstname'] . " - Date de naissance: " . $row['birthdate'] . " - Abonnement: " . $row['Abonnement'] . "<button>Modifier</button><form action='historique.php' method='get'><input type='hidden' name='idUser' value='" . $row['id'] . "'><button type='submit' name='historique'>Historique</button></form></li>";
            }
            echo "</ul>";
        } else {
            echo "<p>Aucun résultat trouvé pour le nom '$selectedLastname'.</p>";
        }
    }   
    
    //nom & prenom
    if (isset($_POST['button'])) {
        $selectedFirstname = $_POST['prenom'];
        $selectedLastname = $_POST['nom'];
    
        $requete = "SELECT user.email, user.lastname, user.firstname, user.birthdate, subscription.name AS Abonnement FROM user JOIN membership ON user.id = membership.id_user JOIN subscription ON membership.id_subscription = subscription.id WHERE firstname = '$selectedFirstname' AND lastname = '$selectedLastname'";
    
        $resultat = $db->query($requete);
    
        echo "<h2>Résultats pour le prénom '$selectedFirstname' et le nom '$selectedLastname' :</h2>";
    
        if ($resultat->rowCount() > 0) {
            echo "<ul>";
            while ($row = $resultat->fetch(PDO::FETCH_ASSOC)) {

                echo "<li>Email: " . $row['email'] . " - Nom: " . $row['lastname'] . " - Prénom: " . $row['firstname'] . " - Date de naissance: " . $row['birthdate'] . " - Abonnement: " . $row['Abonnement'] . "<button>Modifier</button><form action='historique.php' method='get'><input type='hidden' name='idUser' value='" . $row['id'] . "'><button type='submit' name='historique'>Historique</button></form></li>";
            }
            echo "</ul>";
        } else {
            echo "<p>Aucun résultat trouvé pour le prénom '$selectedFirstname' et le nom '$selectedLastname'.</p>";
        }
    }
}  

    
    catch (PDOException $e) {
    print "Erreur :" . $e->getMessage() . "<br/>";
    }

    ?>

    <main class="main_body">
    <aside class="side_bar">
    </aside>
    </main>

    </body>

    </html>