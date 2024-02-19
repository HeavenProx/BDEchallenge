<!-- View/User/index.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Utilisateurs</title>
    <!-- Ajoutez ici le lien vers le CDN de Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Ajoutez ici votre propre fichier de style si nécessaire -->
</head>
<body class="bg-gray-100">

<div class="container mx-auto mt-8">
    <h1 class="text-3xl font-semibold mb-4">Liste des Utilisateurs</h1>

    <!-- Affichage des utilisateurs -->
    <ul class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <?php foreach ($users as $user): ?>
            <li class="bg-white p-4 rounded shadow">
                <p class="text-xl font-semibold mb-2"><?php echo $user['firstName'] . ' ' . $user['lastName']; ?></p>
                <p class="text-gray-600"><?php echo $user['email']; ?></p>
                <?php echo $user['userNumber']; ?>
                <!-- Ajoutez d'autres informations d'utilisateur si nécessaire -->
                <a href="/user/edit/<?php echo $user['userNumber']; ?>"><button>Edit</button></a>
            </li>
        <?php endforeach; ?>
    </ul>

    
</div>

</body>
</html>
