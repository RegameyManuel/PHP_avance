<?php
session_start(); 

// Définir les valeurs par défaut
$default_image_path = "/assets/b1.jpg";
$base64_image = $default_image_path;
$flip_status = "false";

// Initialisation de la session
if (!isset($_SESSION['initial_load'])) {
    $_SESSION['initial_load'] = true;
} else {
    $_SESSION['initial_load'] = false;
}

// Chargement du retournement horizontal de l'image
if (isset($_POST["flip"])) {
    $_SESSION["flip_status"] = $_POST["flip"];
}
if (isset($_SESSION["flip_status"])) {
    $flip_status = $_SESSION["flip_status"];
}

// Chargement de l'image
if (isset($_FILES["image_file"])) {
    $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
    $file_tmp_path = $_FILES["image_file"]['tmp_name'];
    $file_extension = pathinfo($_FILES["image_file"]['name'], PATHINFO_EXTENSION);

    if (file_exists($file_tmp_path) && in_array($file_extension, $allowed_types) && $_FILES["image_file"]['size'] < 5000000) {
        $file_data = file_get_contents($file_tmp_path);
        $base64_image = 'data:image/' . $file_extension . ';base64,' . base64_encode($file_data);
        $_SESSION["current_image"] = $base64_image;
    } else {
        if (isset($_SESSION["current_image"])) {
            $base64_image = $_SESSION["current_image"];
        }
    }
}

$data = [
    'base64_image' => $base64_image,
    'flip_status' => $flip_status
];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Image Upload</title>
</head>
<body>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="image_file">Choisir une image :</label>
        <input type="file" name="image_file" id="image_file" accept="image/*">
        <label for="flip">Retourner l'image :</label>
        <input type="checkbox" name="flip" id="flip" value="true" <?php if ($flip_status === "true") echo "checked"; ?>>
        <button type="submit">Télécharger</button>
    </form>

    <h2>Image:</h2>
    <img src="<?php echo $base64_image; ?>" alt="Image" style="<?php echo $flip_status === 'true' ? 'transform: scaleX(-1);' : ''; ?>">

</body>
</html>
