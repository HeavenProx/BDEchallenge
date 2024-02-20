
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

            <form method="post" action="/user/update/<?php echo $user['userNumber']; ?>" class="max-w-md mx-auto p-8 bg-white rounded-lg shadow-md">
                <!-- Vos champs de formulaire pré-remplis avec les informations de l'utilisateur -->
                <label for="email" class="block mb-2 text-blue-900">Email:</label>
                <input type="text" id="email" name="email" value="<?php echo $user['email']; ?>" class="text-blue-900 w-full px-4 py-2 mb-4 border rounded-md">

                <label for="first_name" class="block mb-2 text-blue-900">Prénom:</label>
                <input type="text" id="first_name" name="first_name" value="<?php echo $user['firstName']; ?>" class="text-blue-900 w-full px-4 py-2 mb-4 border rounded-md">

                <label for="last_name" class="block mb-2 text-blue-900">Nom:</label>
                <input type="text" id="last_name" name="last_name" value="<?php echo $user['lastName']; ?>" class="text-blue-900 w-full px-4 py-2 mb-4 border rounded-md">

                <label for="password" class="block mb-2 text-blue-900">Mot de passe:</label>
                <input type="password" id="password" name="password" value="<?php echo $user['password']; ?>" class="text-blue-900 w-full px-4 py-2 mb-4 border rounded-md">

                <!-- Ajoutez d'autres champs de formulaire si nécessaire -->

                <button type="submit" class="bg-yellow-500 text-blue-900 px-6 py-3 rounded-md cursor-pointer hover:bg-yellow-400">Mettre à jour</button>
            </form>
        </div>
    </body>
</html>
