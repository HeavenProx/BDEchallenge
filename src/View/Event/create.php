<!-- src/View/Event/create.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un évènement</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
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
</head>
<body>
    <h2 class="text-2xl font-bold mb-4">Ajouter évènement</h2>

    <form action="/event/register" method="post" class="max-w-md mx-auto p-8 bg-white rounded-lg shadow-md">
        <label for="name" class="block mb-2 text-blue-900">Nom :</label>
        <input type="text" id="name" name="name" required class="text-blue-900 w-full px-4 py-2 mb-4 border rounded-md">

        <label for="category" class="block mb-2 text-blue-900">Catégorie :</label>
        <select id="category" name="category" class="text-blue-900 w-full px-4 py-2 mb-4 border rounded-md">
            <option value="Soiree">Soirée</option>
            <option value="Concert">Concert</option>
            <option value="Cinema">Cinéma</option>
        </select>

        <label for="description" class="block mb-2 text-blue-900">Description :</label>
        <input type="text" id="description" name="description" required class="text-blue-900 w-full px-4 py-2 mb-4 border rounded-md">

        <label for="eventDate" class="block mb-2 text-blue-900">Date :</label>
        <input type="text" id="eventDate" name="eventDate" required class="text-blue-900 w-full px-4 py-2 mb-4 border rounded-md">

        <label for="location" class="block mb-2 text-blue-900">Location :</label>
        <input type="text" id="location" name="location" required class="text-blue-900 w-full px-4 py-2 mb-4 border rounded-md">

        <button type="submit" class="bg-yellow-500 text-blue-900 px-6 py-3 rounded-md cursor-pointer hover:bg-yellow-400">Ajouter</button>
    </form>
</body>
</html>
