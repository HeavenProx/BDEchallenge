
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Détails évènement</title>
        <!-- Ajoutez ici le lien vers le CDN de Tailwind CSS -->
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
        <!-- Ajoutez ici votre propre fichier de style si nécessaire -->
    </head>
    <body class="bg-gray-800">
        <div class="container mx-auto mt-8">
            
            <a href="/" class="bg-yellow-500 text-blue-900 hover:bg-blue-900 hover:text-white transition px-6 py-3 rounded-md cursor-pointer inline-block mt-4 ml-4">Accueil</a>
            <a href="/events" class="bg-yellow-500 text-blue-900 hover:bg-blue-900 hover:text-white transition px-6 py-3 rounded-md cursor-pointer inline-block mt-4 ml-4">Page évènement</a>
            
            <div class="max-w-md mx-auto p-8 bg-white rounded-lg shadow-md">
                <h1 class="text-3xl text-center font-semibold mb-5">Détails de l'évènement</h1>
                
                <div class="text-left mt-5 pt-3">
                    <p for="name" class="text-xl block my-5">Nom : <?php echo $event['name']; ?></p>

                    <p for="eventDate" class="text-xl block my-5">Catégorie : <?php echo $event['category']; ?></p>

                    <p for="eventDate" class="text-xl block my-5">Date : <?php echo $event['eventDate']; ?></p>

                    <p for="description" class="text-xl block my-5">Description : <?php echo $event['description']; ?></p>
                
                    <p for="location" class="text-xl block my-5">Localisation : <?php echo $event['location']; ?></p>
                </div>
                
            </div>
        </div>
    </body>
</html>
