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
<style>
        body {
            background-color: #082B43;
            color: #FFFFFF;
            font-family: 'Arial', sans-serif;
        }

        h2 {
            color: #FDC040;
        }

        form {
            @apply max-w-md mx-auto p-8 bg-white rounded-lg shadow-md;
        }

        label {
            @apply block mb-2 text-blue-900;
        }

        input {
            @apply w-full px-4 py-2 mb-4 border rounded-md;
        }

        button {
            @apply bg-yellow-500 text-blue-900 px-6 py-3 rounded-md cursor-pointer;
        }

        button:hover {
            @apply bg-yellow-400;
        }
    </style>
<body>

<div class="container mx-auto mt-8">
    <div class="flex justify-between mb-6">
        <h1 class="text-3xl font-semibold mb-4 text-white">Liste des Utilisateurs</h1>
        <a href="/user/create" class="bg-yellow-500 text-blue-900 hover:bg-blue-900 hover:text-white transition px-6 py-3 rounded-md cursor-pointer inline-block mt-4">Add User</a>    
    </div>

    <!-- Affichage des utilisateurs -->
    <ul class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <?php foreach ($users as $user): ?>
            <li class="bg-white p-4 rounded shadow">
                <p class="text-xl font-semibold mb-2 text-gray-600"><?php echo $user['firstName'] . ' ' . $user['lastName']; ?></p>
                <p class="text-gray-600"><?php echo $user['email']; ?></p>
                <?php echo $user['userNumber']; ?>
                <!-- Ajoutez d'autres informations d'utilisateur si nécessaire -->
                <a href="/user/edit/<?php echo $user['userNumber']; ?>" class="bg-blue-900 text-white hover:bg-yellow-500 hover:text-blue-900 transition px-8 py-2 rounded-md cursor-pointer inline-block mt-4">Edit</a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>


</body>
</html>
