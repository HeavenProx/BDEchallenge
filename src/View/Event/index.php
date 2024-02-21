<!-- View/Event/index.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des évévenements</title>
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
        <h1 class="text-3xl font-semibold mb-4 text-white">Liste des évévenements</h1>
        <div>
        <a href="/" class="bg-yellow-500 text-blue-900 hover:bg-blue-900 hover:text-white transition px-6 py-3 rounded-md cursor-pointer inline-block mt-4 ml-4">Accueil</a> 
            <a href="/event/create" class="bg-yellow-500 text-blue-900 hover:bg-blue-900 hover:text-white transition px-6 py-3 rounded-md cursor-pointer inline-block mt-4 ml-4">Filtrer par catégorie</a>
            <?php if (isset($_SESSION['user']['role']) && $_SESSION['user']['role'] == 'Admin' || $_SESSION['user']['role'] == 'BDE'): ?>
            <a href="/event/create" class="bg-yellow-500 text-blue-900 hover:bg-blue-900 hover:text-white transition px-6 py-3 rounded-md cursor-pointer inline-block mt-4 ml-4">Ajouter Event</a>  
            <?php endif; ?> 
        </div>
    </div>

    <!-- Affichage des utilisateurs -->
    <ul class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <?php foreach ($events as $event): ?>
            <li class="bg-white p-4 rounded shadow">
                <p class="text-xl font-bold mb-2 text-gray-800"><?php echo $event['name'] . ' - ' . $event['eventDate']; ?></p>
                <p class="text-lg text-gray-500 mb-2"><?php echo $event['category'] . ' à ' . $event['location']; ?></p>
                <p class="text-gray-700"><?php echo $event['description']; ?></p>

                <?php if (isset($_SESSION['user']['role']) && $_SESSION['user']['role'] == 'Admin' || $_SESSION['user']['role'] == 'BDE'): ?>
                <a href="/event/edit/<?php echo $event['eventNumber']; ?>" class="bg-blue-900 text-white hover:bg-yellow-500 hover:text-blue-900 transition px-8 py-2 rounded-md cursor-pointer inline-block mt-4">Edit</a>
                <a href="/event/delete/<?php echo $event['eventNumber']; ?>" onclick="return confirm('Are you sure?')" class="bg-red-900 text-white hover:bg-blue-500 hover:text-white transition px-8 py-2 rounded-md cursor-pointer inline-block mt-4">Delete</a>
                <?php endif; ?>
                <div class="flex gap-2">
                    <a href="event/add/wish/<?php echo $event['eventNumber']; ?>" class="bg-blue-900 text-white hover:bg-yellow-500 hover:text-blue-900 transition px-5 py-2 rounded-md cursor-pointer inline-block mt-4">Ajouter aux Favoris</a>
                    <a href="/event/delete/<?php echo $event['eventNumber']; ?>" onclick="return confirm('Are you sure?')" class="bg-red-900 text-white hover:bg-blue-500 hover:text-white transition px-5 py-2 rounded-md cursor-pointer inline-block mt-4">Enlever des favoris</a>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>

</div>


</body>
</html>
