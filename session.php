<?php
// Configuration de la durée de vie de la session (1 heure)
ini_set('session.gc_maxlifetime', 3600);

// Démarrage de la session
session_start();

// Redéfinir la durée de vie du cookie de session
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), $_COOKIE[session_name()], time() + 3600, "/");
}

// Redéfinir la durée de vie du cookie de session
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), $_COOKIE[session_name()], time() + 3600, "/");
}

// Vérifie si l'utilisateur veut supprimer la session
if (isset($_POST['logout'])) {
    // Supprimer toutes les variables de session
    session_unset();

    // Détruire la session
    session_destroy();

    // Rediriger l'utilisateur après la destruction de la session pour éviter la resoumission du formulaire
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Initialisation des informations de session si elles n'existent pas encore
if (!isset($_SESSION['user_profile'])) {
    $_SESSION['user_profile'] = [
        'username' => 'JeanDupont',
        'email' => 'jean.dupont@example.com',
        'profile_image' => 'assets/martin.jpg', // Chemin vers l'image de profil
        'theme_preference' => 'dark', // Préférence de thème
    ];
}

// Mise à jour du profil utilisateur si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_POST['logout'])) {
    if (isset($_POST['username'])) {
        $_SESSION['user_profile']['username'] = $_POST['username'];
    }
    if (isset($_POST['email'])) {
        $_SESSION['user_profile']['email'] = $_POST['email'];
    }
    if (isset($_POST['profile_image'])) {
        $_SESSION['user_profile']['profile_image'] = $_POST['profile_image'];
    }
    if (isset($_POST['theme'])) {
        $_SESSION['user_profile']['theme_preference'] = $_POST['theme'];
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Utilisateur</title>
</head>

<body>

    <h1>Profil Utilisateur</h1>
    <p>Nom d'utilisateur : <?php echo $_SESSION['user_profile']['username']; ?></p>
    <p>Email : <?php echo $_SESSION['user_profile']['email']; ?></p>
    <p>Thème : <?php echo $_SESSION['user_profile']['theme_preference']; ?></p>
    <img src="<?php echo $_SESSION['user_profile']['profile_image']; ?>" alt="Image de profil" width="150" height="150">


    <h2>Mettre à jour le profil</h2>
    <form method="post" action="">
        <label for="username">Nom d'utilisateur :</label>
        <input type="text" name="username" id="username" value="<?php echo $_SESSION['user_profile']['username']; ?>"><br>

        <label for="email">Email :</label>
        <input type="email" name="email" id="email" value="<?php echo $_SESSION['user_profile']['email']; ?>"><br>

        <label for="profile_image">URL de l'image de profil :</label>
        <input type="text" name="profile_image" id="profile_image" value="<?php echo $_SESSION['user_profile']['profile_image']; ?>"><br>

        <label for="theme">Préférence de thème :</label>
        <select name="theme" id="theme">
            <option value="light" <?php echo ($_SESSION['user_profile']['theme_preference'] == 'light') ? 'selected' : ''; ?>>Clair</option>
            <option value="dark" <?php echo ($_SESSION['user_profile']['theme_preference'] == 'dark') ? 'selected' : ''; ?>>Sombre</option>
        </select><br>

        <button type="submit">Mettre à jour</button>
    </form>

    <!-- Formulaire pour supprimer la session -->
    <form method="post" action="">
        <button type="submit" name="logout">Supprimer la session</button>
    </form>

</body>

</html>