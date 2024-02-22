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
    <header class="md:container md:mx-auto px-4 md:px-0 my-8">
        <div class="flex flex-col justify-between mb-6 gap-4">
            <div class="flex justify-between items-center">
                <div class="w-20 h-20">
                    <a href="/"><img src="img/logo.png" alt="" class="object-cover w-full h-full"></a>
                </div>
                <div class="flex gap-4 lg:text-xl">
                    <a href="/events" class="hover:text-yellow-500 transition">Nos Évènements</a>
                    <a href="/contact" class="hover:text-yellow-500 transition">Nous Contactez</a>
                </div>
            </div>
            <?php if (isset($_SESSION['logged']) && $_SESSION['logged'] == true): ?>
                <?php if($_SESSION['user']['role'] == 'Admin' || $_SESSION['user']['role'] == 'BDE'): ?>
                    <a href="/event/create" class="bg-yellow-500 text-blue-900 hover:bg-blue-900 hover:text-white transition px-6 py-3 rounded-md cursor-pointer inline-block mt-4 ml-4">Ajouter un évènement</a>  
                <?php endif; ?>
            <?php endif; ?> 
        </div>
    </header>
    <main>
        <section class="md:container md:mx-auto px-4 md:px-0 text-primary lg:py-6">
            <h1 class="text-2xl lg:text-4xl font-semibold my-4 text-white text-center">Les évènements du moment</h1>
            <form action="/events" class="flex flex-col lg:flex-row my-8 lg:gap-4 justify-center lg:justify-start lg:items-center">
                <div class="flex flex-col gap-1">
                    <label for="category" class="block mb-2">Catégorie :</label>
                    <select id="category" name="category" class="text-blue-900 w-full px-4 py-3 mb-4 border rounded-md">
                        <option value="All" <?php if(isset($_GET['category']) && $_GET['category'] == 'All'):?> selected <?php endif ?> >Toutes les catégories</option>
                        <option value="Soiree" <?php if(isset($_GET['category']) && $_GET['category'] == 'Soiree'):?> selected <?php endif ?> >Soirée</option>
                        <option value="Concert" <?php if(isset($_GET['category']) && $_GET['category'] == 'Concert'):?> selected <?php endif ?> >Concert</option>
                        <option value="Cinema" <?php if(isset($_GET['category']) && $_GET['category'] == 'Cinema'):?> selected <?php endif ?> >Cinéma</option>
                    </select>
                </div>     
                <div class="flex flex-col gap-1">
                    <label for="date" class="block mb-2">Date :</label>
                    <input value="<?php echo isset($_GET['date']) ? $_GET['date'] : date('Y-m-d'); ?>" type="date" id="date" name="date" class="text-blue-900 w-full px-4 py-2 mb-4 border rounded-md">
                </div>       
                <div class="flex items-end">
                    <button type="submit" class="bg-yellow-500 text-blue-900 px-6 py-3 rounded-md cursor-pointer h-1/3 mt-4">Filtrer</button>
                </div>         
            </form>
        </section>
        <!-- Affichage des utilisateurs -->
        <ul id="events-list" class="lg:container lg:mx-auto px-4 lg:px-0 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <?php foreach ($events as $event): ?>
                <li class="bg-white p-4 rounded shadow">
                    <p class="text-xl font-bold mb-2 text-gray-800"><?php echo $event['name'] . ' - ' . $event['eventDate']; ?></p>
                    <p class="text-lg text-gray-500 mb-2"><?php echo $event['category'] . ' à ' . $event['location']; ?></p>
                    <p class="text-gray-700"><?php echo $event['description']; ?></p>
            
                    <?php if(isset($_SESSION['logged']) && $_SESSION['logged'] == true): ?>
                        <?php if ($_SESSION['user']['role'] == 'Admin' || $_SESSION['user']['role'] == 'BDE'): ?>
                            <a href="/event/edit/<?php echo $event['eventNumber']; ?>" class="bg-blue-900 text-white hover:bg-yellow-500 hover:text-blue-900 transition px-8 py-2 rounded-md cursor-pointer inline-block mt-4">Modifier</a>
                            <a href="/event/delete/<?php echo $event['eventNumber']; ?>" onclick="return confirm('Are you sure?')" class="bg-red-900 text-white hover:bg-blue-500 hover:text-white transition px-8 py-2 rounded-md cursor-pointer inline-block mt-4">Supprimer</a>
                        <?php endif; ?>
                    <?php endif; ?>
                    <?php if(isset($_SESSION['logged']) && $_SESSION['logged'] == true): ?>
                        <?php if (!$wishlistButtons[$event['eventNumber']]): ?>
                            <!-- Affiche le bouton "Ajouter aux Favoris" si l'événement n'est pas dans la wishlist -->
                            <a href="/wishlist/add/<?php echo $event['eventNumber']; ?>" class="bg-blue-900 text-white hover:bg-yellow-500 hover:text-blue-900 transition px-5 py-2 rounded-md cursor-pointer inline-block mt-4">Ajouter aux Favoris</a>
                        <?php else: ?>
                            <!-- Affiche le bouton "Enlever des Favoris" si l'événement est dans la wishlist -->
                            <a href="/wishlist/delete/<?php echo $event['eventNumber']; ?>" class="bg-red-900 text-white hover:bg-blue-500 hover:text-white transition px-5 py-2 rounded-md cursor-pointer inline-block mt-4">Enlever des Favoris</a>
                        <?php endif; ?>
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
        <div class="md:container md:mx-auto px-4 md:px-0">
            <a id="paginationButton" href="/events" class="bg-blue-900 text-white hover:bg-yellow-500 hover:text-blue-900 transition px-8 py-2 rounded-md cursor-pointer inline-block mt-4">Page précédente</a>
            <a id="paginationButton2" href="/events" class="bg-blue-900 text-white hover:bg-yellow-500 hover:text-blue-900 transition px-8 py-2 rounded-md cursor-pointer inline-block mt-4">Page suivante</a>
        </div>
    </main>
</body>
    <script>
        document.addEventListener('DOMContentLoaded', function(){
            var paginationButton = document.getElementById('paginationButton');
                paginationButton.addEventListener('click', function(event){
                    event.preventDefault(); 
                    var categorie = document.getElementById('category').value;
                    var date = document.getElementById('date').value;
                    var nextPageUrl = paginationButton.getAttribute('href');
                    nextPageUrl += '?category=' + encodeURIComponent(categorie);
                    nextPageUrl += '&date=' + encodeURIComponent(date);
                    nextPageUrl += '&btn=prev';
                    console.log(nextPageUrl);
                    window.location.href = nextPageUrl;
                });
            
            var paginationButton2 = document.getElementById('paginationButton2');
            paginationButton2.addEventListener('click', function(event){
                event.preventDefault(); 
                var categorie = document.getElementById('category').value;
                var date = document.getElementById('date').value;
                var nextPageUrl = paginationButton2.getAttribute('href');
                nextPageUrl += '?category=' + encodeURIComponent(categorie);
                nextPageUrl += '&date=' + encodeURIComponent(date);
                nextPageUrl += '&btn=next';
                console.log(nextPageUrl);
                window.location.href = nextPageUrl;
            });
        })
    </script>
</html>
