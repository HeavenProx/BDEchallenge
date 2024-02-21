
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edit évènement</title>
        <!-- Ajoutez ici le lien vers le CDN de Tailwind CSS -->
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
        <!-- Ajoutez ici votre propre fichier de style si nécessaire -->
    </head>
    <body class="bg-gray-100">
        <div class="container mx-auto mt-8">
            <h1 class="text-3xl font-semibold mb-4">Modifier un évènement</h1>

            <form method="post" action="/event/update/<?php echo $event['eventNumber']; ?>" class="max-w-md mx-auto p-8 bg-white rounded-lg shadow-md">
                <!-- Vos champs de formulaire pré-remplis avec les informations de l'utilisateur -->
                <label for="name" class="block mb-2 text-blue-900">Nom :</label>
                <input type="text" id="name" name="name" value="<?php echo $event['name']; ?>" class="text-blue-900 w-full px-4 py-2 mb-4 border rounded-md">

                <label for="category" class="block mb-2 text-blue-900">Categorie :</label>
                <input type="text" id="category" name="category" value="<?php echo $event['category']; ?>" class="text-blue-900 w-full px-4 py-2 mb-4 border rounded-md">

                <label for="eventDate" class="block mb-2 text-blue-900">Date :</label>
                <input type="text" id="eventDate" name="eventDate" value="<?php echo $event['eventDate']; ?>" class="text-blue-900 w-full px-4 py-2 mb-4 border rounded-md">

                <label for="description" class="block mb-2 text-blue-900">Description :</label>
                <input type="text" id="description" name="description" value="<?php echo $event['description']; ?>" class="text-blue-900 w-full px-4 py-2 mb-4 border rounded-md">

                <label for="location" class="block mb-2 text-blue-900">Location :</label>
                <input type="text" id="location" name="location" value="<?php echo $event['location']; ?>" class="text-blue-900 w-full px-4 py-2 mb-4 border rounded-md">

                <!-- Ajoutez d'autres champs de formulaire si nécessaire -->

                <button type="submit" class="bg-yellow-500 text-blue-900 px-6 py-3 rounded-md cursor-pointer hover:bg-yellow-400">Mettre à jour</button>
            </form>
        </div>
    </body>
</html>
