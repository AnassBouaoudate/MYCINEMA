<?php

$host = 'localhost';
$dbname = 'cinema';
$username = 'Anass';
$password = 'Anass111';

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Erreur de connexion à la base de données: " . $e->getMessage();
    exit;
}

try {
    if(isset($_POST['search'])) {
        $search = $_POST['search'];
        $query = "SELECT user.firstname, user.lastname, subscription.name AS Abonnement 
                FROM user 
                JOIN membership ON user.id = membership.id_user 
                JOIN subscription ON membership.id_subscription = subscription.id 
                WHERE user.firstname LIKE :search OR user.lastname LIKE :search";

        $stmt = $db->prepare($query);
        $stmt->execute(array(':search' => '%' . $search . '%'));
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} catch(PDOException $e) {
    echo "Erreur lors de l'exécution de la requête de recherche: " . $e->getMessage();
}

//modif abo
try {
    if(isset($_POST['save'])) {
        $userId = $_POST['userId'];
        $newAbonnement = $_POST['newAbonnement'];
        $updateQuery = "UPDATE membership SET Abonnement = :newAbonnement WHERE id_user = :userId";
        $stmt = $db->prepare($updateQuery);
        $stmt->execute(array(':newAbonnement' => $newAbonnement, ':userId' => $userId));
        echo "Abonnement mis à jour avec succès!";
    }
} catch(PDOException $e) {
    echo "Erreur lors de la mise à jour de l'abonnement: " . $e->getMessage();
}

try {
    $aboQuery = "SELECT * FROM subscription";
    $stmt = $db->prepare($aboQuery);
    $stmt->execute();
    $abonnements = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    echo "Erreur lors de la récupération des abonnements: " . $e->getMessage();
}
?>

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
    <div class="search">
      <form method="post" action="">
        <label for="search">Recherche utilisateur :</label>
        <input type="text" name="search" id="search" required>
        <button type="submit"><i class="fas fa-search"></i></button>
      </form>
    </div>
  </header>

  <main class="main_body">
    <?php if(isset($users)): ?>
    <?php foreach($users as $user): ?>
      <?php echo $user['firstname'] . " " . $user['lastname'] . " - Abonnement: " . $user['Abonnement'] . "<br>"; ?>
    <?php endforeach; ?>
    <?php endif; ?>
  </main>

  <aside class="side_bar">

    <form method="post" action="">
      <h3>Modifier l'abonnement</h3>
      <input type="hidden" name="userId" id="userId">
      <label for="newAbonnement">Nouvel abonnement :</label>
      <select name="newAbonnement" id="newAbonnement" required>
        <?php foreach($abonnements as $abonnement): ?>
          <option value="<?php echo $abonnement['id']; ?>"><?php echo $abonnement['name']; ?></option>
        <?php endforeach; ?>
      </select>
      <button type="submit" name="save">Enregistrer</button>
    </form>
  </aside>
</body>

</html>
