<?php
// edit.php
use App\Model\User;
// Récupérer l'ID de l'utilisateur depuis la requête
$userId = $_GET['id'];

// Utilisez l'ID pour récupérer les informations de l'utilisateur à partir de la base de données
$userModel = new User();
$user = $userModel->getUserById($userId);

// Affichez le formulaire d'édition avec les informations actuelles de l'utilisateur
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <!-- Ajoutez ici le lien vers le CDN de Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Ajoutez ici votre propre fichier de style si nécessaire -->
</head>
<body class="bg-gray-100">

<div class="container mx-auto mt-8">
    <h1 class="text-3xl font-semibold mb-4">Edit User</h1>

    <form method="post" action="/user/update/<?php echo $user['id']; ?>">
        <!-- Vos champs de formulaire pré-remplis avec les informations de l'utilisateur -->
        <label for="email">Email:</label>
        <input type="text" id="email" name="email" value="<?php echo $user['email']; ?>">
    
        <!-- Ajoutez d'autres champs de formulaire si nécessaire -->
    
        <button type="submit">Mettre à jour</button>
    </form>
</div>

</body>
</html>
