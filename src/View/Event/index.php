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
            <?php if (isset($_SESSION['logged']) && $_SESSION['logged'] == true && isset($_SESSION['user']['role']) && $_SESSION['user']['role'] == 'Admin' || $_SESSION['user']['role'] == 'BDE'): ?>
            <a href="/event/create" class="bg-yellow-500 text-blue-900 hover:bg-blue-900 hover:text-white transition px-6 py-3 rounded-md cursor-pointer inline-block mt-4 ml-4">Ajouter Event</a>  
            <?php endif; ?> 
        </div>
    </div>
</div>
<div class="container mx-auto">
    <form action="/events" class="flex gap-4 my-8 items-center">
        <div class="flex flex-col gap-1">
            <label for="category" class="block mb-2 text-blue-900">Catégorie :</label>
            <select id="category" name="category" class="text-blue-900 w-full px-4 py-3 mb-4 border rounded-md">
                <option value="All">Toutes les catégories</option>
                <option value="Soiree">Soirée</option>
                <option value="Concert">Concert</option>
                <option value="Cinema">Cinéma</option>
            </select>
        </div>
        
        <div class="flex flex-col gap-1">
            <label for="date" class="block mb-2 text-blue-900">Date :</label>
            <input value="<?php echo date('Y-m-d') ?>" type="date" id="date" name="date" class="text-blue-900 w-full px-4 py-2 mb-4 border rounded-md">
        </div>
        
        <div class="flex items-end">
            <button type="submit" class="bg-yellow-500 text-blue-900 px-6 py-3 rounded-md cursor-pointer h-1/3 mt-4">Filtrer</button>
        </div>
        
    </form>
</div>


    <!-- Affichage des utilisateurs -->
    <ul id="events-list" class="container mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <?php foreach ($events as $event): ?>
            <li class="bg-white p-4 rounded shadow">
                <p class="text-xl font-bold mb-2 text-gray-800"><?php echo $event['name'] . ' - ' . $event['eventDate']; ?></p>
                <p class="text-lg text-gray-500 mb-2"><?php echo $event['category'] . ' à ' . $event['location']; ?></p>
                <p class="text-gray-700"><?php echo $event['description']; ?></p>

                <?php if (isset($_SESSION['user']['role']) && $_SESSION['user']['role'] == 'Admin' || $_SESSION['user']['role'] == 'BDE'): ?>
                <a href="/event/edit/<?php echo $event['eventNumber']; ?>" class="bg-blue-900 text-white hover:bg-yellow-500 hover:text-blue-900 transition px-8 py-2 rounded-md cursor-pointer inline-block mt-4">Edit</a>
                <a href="/event/delete/<?php echo $event['eventNumber']; ?>" onclick="return confirm('Are you sure?')" class="bg-red-900 text-white hover:bg-blue-500 hover:text-white transition px-8 py-2 rounded-md cursor-pointer inline-block mt-4">Delete</a>
                <?php endif; ?>
                <?php if(isset($_SESSION['logged']) && $_SESSION['logged'] == true): ?>
                    <?php if (!$wishlistButtons[$event['eventNumber']]): ?>
                        <!-- Affiche le bouton "Ajouter aux Favoris" si l'événement n'est pas dans la wishlist -->
                        <a href="/wishlist/add/<?php echo $event['eventNumber']; ?>" class="bg-blue-900 text-white hover:bg-yellow-500 hover:text-blue-900 transition px-5 py-2 rounded-md cursor-pointer inline-block mt-4">Ajouter aux Favoris</a>
                    <?php else: ?>
                        <!-- Affiche le bouton "Enlever des Favoris" si l'événement est dans la wishlist -->
                        <a href="/wishlist/delete/<?php echo $event['eventNumber']; ?>" class="bg-red-900 text-white hover:bg-blue-500 hover:text-white transition px-5 py-2 rounded-md cursor-pointer inline-block mt-4">Enlever des Favoris</a>
                    <?php endif; ?>
                    Boutons pour ajouter ou supprimer des participants
                    <?php if (!$eventParticipants[$event['eventNumber']]): ?>
                        <!-- Affiche le bouton "Ajouter participant" si l'utilisateur n'est pas dans la liste des participants -->
                        <a href="/event/add-participant/<?php echo $event['eventNumber']; ?>" class="bg-green-500 text-white hover:bg-green-700 px-5 py-2 rounded-md cursor-pointer inline-block mt-4">Participer</a>
                    <?php else: ?>
                        <!-- Affiche le bouton "Retirer participant" si l'utilisateur est dans la liste des participants -->
                        <a href="/event/remove-participant/<?php echo $event['eventNumber']; ?>" class="bg-red-500 text-white hover:bg-red-700 px-5 py-2 rounded-md cursor-pointer inline-block mt-4">Ne plus participer</a>
                    <?php endif; ?>
                <?php else: ?>
                    <a href="/login"><button class="bg-blue-900 text-white hover:bg-yellow-500 hover:text-blue-900 transition px-8 py-2 rounded-md cursor-pointer inline-block mt-4">Se connecter pour participer</button></a>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
<div class="container mx-auto">
    <a href="/events/prevp" class="bg-blue-900 text-white hover:bg-yellow-500 hover:text-blue-900 transition px-8 py-2 rounded-md cursor-pointer inline-block mt-4">Page précédente</a>
    <a href="/events/nextp" class="bg-blue-900 text-white hover:bg-yellow-500 hover:text-blue-900 transition px-8 py-2 rounded-md cursor-pointer inline-block mt-4">Page suivante</a>
</div>
</div>


</body>
</html>
