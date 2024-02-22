
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Mon compte</title>
        <!-- Ajoutez ici le lien vers le CDN de Tailwind CSS -->
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
        <!-- Ajoutez ici votre propre fichier de style si nécessaire -->
    </head>
    <body class="bg-gray-100">
        <div class="container mx-auto mt-8">
            <a href="/" class="bg-yellow-500 text-right text-blue-900 hover:bg-blue-900 hover:text-white transition px-6 py-3 rounded-md cursor-pointer inline-block my-4 ml-0">Accueil</a>

            <h1 class="text-3xl text-center font-semibold mb-4">Mon compte</h1>

            <form method="post" action="/profil/update/<?php echo $_SESSION['user']['userNumber']; ?>" class="max-w-md mx-auto p-8 bg-white rounded-lg shadow-md">
                <!-- Vos champs de formulaire pré-remplis avec les informations de l'utilisateur -->

                <h2 class="text-xl mb-4">Mes informations personnelles</h2>

                <label for="email" class="block mb-2 text-blue-900">Email:</label>
                <input type="text" id="email" name="email" value="<?php echo $_SESSION['user']['email']; ?>" class="text-blue-900 w-full px-4 py-2 mb-4 border rounded-md">

                <label for="first_name" class="block mb-2 text-blue-900">Prénom:</label>
                <input type="text" id="first_name" name="first_name" value="<?php echo $_SESSION['user']['firstName']; ?>" class="text-blue-900 w-full px-4 py-2 mb-4 border rounded-md">

                <label for="last_name" class="block mb-2 text-blue-900">Nom:</label>
                <input type="text" id="last_name" name="last_name" value="<?php echo $_SESSION['user']['lastName']; ?>" class="text-blue-900 w-full px-4 py-2 mb-4 border rounded-md">

                <label for="role" class="block mb-2 text-blue-900">Role : <?php echo $_SESSION['user']['role']; ?></label>
                
                <!-- Ajoutez d'autres champs de formulaire si nécessaire -->

                <button type="submit" class="bg-yellow-500 text-blue-900 px-6 py-3 rounded-md cursor-pointer hover:bg-yellow-400">Mettre à jour</button>
                <button><a href="/profil/delete/<?php echo $_SESSION['user']['userNumber']; ?>" onclick="return confirm('Are you sure?')" class="bg-red-500 text-white px-6 py-3 rounded-md cursor-pointer hover:bg-yellow-400">Supprimer mon compte</a></button>
            </form>
        </div>
    </body>
</html>
